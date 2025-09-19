<?php

require_once __DIR__ . '/../models/calendar_reservation.m.php';

class calendarModule extends zModule {

	public array $depends_on = ['db', 'resources', 'forms', 'i18n', 'emails'];

	public $notify_email;
	public $from_address;
	public $allow_weekends = true;
	public $day_start_time = 8;
	public $day_end_time = 20;
	public $slot_duration = 0.25;

	public function onEnabled() {
		$this->notify_email = $this->getConfigValue('notify_email');
		$this->from_address = $this->getConfigValue('from_address');
		$this->allow_weekends = $this->getConfigValue('allow_weekends', $this->allow_weekends);
		$this->day_start_time = $this->getConfigValue('day_start_time', $this->day_start_time);
		$this->day_end_time = $this->getConfigValue('day_end_time', $this->day_end_time);
		$this->slot_duration = $this->getConfigValue('slot_duration', $this->slot_duration);
	}

	public function onBeforeRender() {
		$this->z->core->includeCSS('resources/calendar/calendar.css', 'head');
		$this->z->core->includeCSS('resources/calendar/calendar.css', 'admin.head');
		$this->z->core->includeCSS('resources/calendar/calendar-responsive.css', 'head');
		$this->z->core->includeCSS('resources/calendar/calendar-responsive.css', 'admin.head');
	}

	public function renderCalendar($name = 'calendar-main', $admin = false) {
		?>
			<div id="<?=$name?>" class="calendar">
				<div class="placeholder-wave mb-3">
					<span class="placeholder placeholder-lg col-4"></span>
				</div>
				<div class="card">
					<div class="spinner-border text-warning my-5 mx-auto p-5" role="status">
						<span class="visually-hidden">Nahrávám...</span>
					</div>
				</div>
			</div>
			<script type="module" defer>
				import {Calendar, CalendarSettings} from '/resources/calendar/calendar.js?<?=$this->z->core->app_version?>';
				const calendarSettings = new CalendarSettings();
				calendarSettings.admin = <?=$admin ? 'true' : 'false'?>;
				calendarSettings.allowWeekends = <?=$this->allow_weekends ? 'true' : 'false'?>;
				calendarSettings.minStartTime = <?=$this->day_start_time?>;
				calendarSettings.maxEndTime = <?=$this->day_end_time?>;
				calendarSettings.slotDuration = <?=$this->slot_duration?>;
				const calendar = new Calendar(document.getElementById('<?=$name?>'), calendarSettings);
			</script>
		<?php
	}

	/**
	 * @param $from
	 * @param $to
	 * @return CalendarReservationModel[]
	 */
	function loadReservations(DateTime $from, DateTime $to): array {
		$is_admin = $this->z->admin->isAdmin();
		return CalendarReservationModel::select(
			$this->z->db,
			$is_admin ? 'view_calendar_reservations' : 'calendar_reservation',
			'calendar_reservation_end > ? and calendar_reservation_start < ?',
			'calendar_reservation_start',
			null,
			[z::mysqlDatetime($from), z::mysqlDatetime($to)],
			[PDO::PARAM_STR, PDO::PARAM_STR]
		);
	}

	function loadReservationsJson(DateTime $from, DateTime $to): array {
		$reservations = $this->loadReservations($from, $to);
		$is_admin = $this->z->admin->isAdmin();
		if (!$is_admin) {
			$user_id = $this->z->auth->isAuth() ? $this->z->auth->user->ival('user_id') : 0;
			if ($user_id) {
				foreach ($reservations as $reservation) {
					if ($reservation->ival('calendar_reservation_user_id') === $user_id) {
						$reservation->set('email', $this->z->auth->user->val('user_email'));
					}
				}
			}
		}

		return zModel::toJson($reservations);
	}

	function loadReservationById($id): ?CalendarReservationModel {
		$res = new CalendarReservationModel($this->z->db, $id);
		return $res->is_loaded ? $res : null;
	}

	function deleteReservationById($id) {
		$res = new CalendarReservationModel($this->z->db, $id);
		if (!$res->is_loaded) return;
		if ($res->ival('calendar_reservation_user_id') !== $this->z->auth->user->ival('user_id') && !$this->z->admin->isAdmin()) {
			throw new Exception("Access Forbidden!");
		}
		$res->delete();
	}

	function conflictsExists(DateTime $start, DateTime $end, int $exclude = null): bool {
		$conflicting = $this->loadReservations($start, $end);

		foreach ($conflicting as $reservation) {
			if ($exclude !== null && $reservation->ival('calendar_reservation_id') === $exclude) {
				continue;
			}
			return true;
		}

		return false;
	}

	function getHours(DateTime $dt) {
		$hours = (int)$dt->format("H");
		$minutes = (int)$dt->format("i");
		return $hours + ($minutes / 60);
	}

	function timeWithinBounds(DateTime $start, DateTime $end): bool {
		if ($start == null || $end == null) return false;
		$startH = $this->getHours($start);
		$endH = $this->getHours($end);
		return ($startH >= $this->day_start_time) && ($endH <= $this->day_end_time);
	}

	function saveReservation(?int $id, int $user_id, DateTime $start, int $service_id, int $duration, bool $whole_day, ?string $note) {
		$isAdmin = $this->z->admin->isAdmin();

		if ($user_id !== $this->z->auth->user->ival('user_id') && !$isAdmin) {
			throw new Exception($this->z->core->t("Access Forbidden!"));
		}

		if ($whole_day && !$isAdmin) {
			throw new Exception($this->z->core->t("Only admin can reserve whole day!"));
		}

		if (!$this->allow_weekends) {
			$dayOfWeek = intval($start->format('w'));
			if ($dayOfWeek < 1 || $dayOfWeek > 5) {
				throw new Exception($this->z->core->t("Invalid day!"));
			}
		}

		if ($whole_day) {
			$start->setTime(0,0);
		}
		$end = clone $start;
		$end = $end->add(new DateInterval($whole_day ? "P{$duration}D" : "PT{$duration}M"));

		if ($this->conflictsExists($start, $end, $id)) {
			throw new Exception($this->z->core->t("Conflict Exists!"));
		}

		if (!($whole_day || $this->timeWithinBounds($start, $end))) {
			throw new Exception($this->z->core->t("Time out of bounds!"));
		}

		$res = null;
		if ($id) {
			$res = $this->loadReservationById($id);
		}
		if (!$res) {
			$res = new CalendarReservationModel($this->z->db);
		}
		$res->set('calendar_reservation_user_id', $user_id);
		$res->set('calendar_reservation_start', z::mysqlDatetime($start));
		$res->set('calendar_reservation_cosmetic_service_id', $service_id);
		$res->set('calendar_reservation_duration', $duration);
		$res->set('calendar_reservation_whole_day', $whole_day);
		$res->set('calendar_reservation_note', $note);

		$res->save();
		return $res;
	}

	function saveReservationJson(int $user_id, object $res): CalendarReservationModel {
		$start = z::parseDatetime($res->start);
		return $this->saveReservation(
			$res->id ?? null,
			$user_id,
			$start,
			$res->cosmetic_service_id ?? 0,
			$res->duration ?? 1,
			$res->whole_day ?? 0,
			$res->note ?? null
		);
	}

	function getReservationSummary(CalendarReservationModel $reservation, $admin = false): string {
		$units = $reservation->bval('calendar_reservation_whole_day') ? 'dní' : 'minut';
		return "<div>
			<div>Datum: {$this->z->core->formatDatetime($reservation->dtval('calendar_reservation_start'))}</div>
			<div>Procedura: {$reservation->val('service')}</div>
			<div>Trvání: {$reservation->ival('calendar_reservation_duration')} $units</div>
			<div>Poznámka: {$reservation->val('calendar_reservation_note')}</div>
		</div>";
	}
}
