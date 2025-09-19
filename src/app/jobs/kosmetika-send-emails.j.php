<?php

	$public_url = $this->z->core->url('#objednani');
	$admin_url = $this->z->core->url('admin');
	$from_address = $this->z->calendar->from_address;
	$admin_email = $this->z->calendar->notify_email;

	// send creation notification emails
	$created = CalendarReservationModel::select($this->z->db, 'view_calendar_reservations', 'calendar_reservation_creation_notification_sent = 0');
	foreach ($created as $reservation) {
		//send email to customer
		$summary = $this->z->calendar->getReservationSummary($reservation);
		$body = "<div>
	<h3>Přijali jsme vaši rezervaci</h3>
	<br/>
	$summary
	<br/>
	<p>Vaši rezervaci můžete změnit nebo zrušit na našich <a href=\"$public_url\">stránkách</a>.</p>
	<p>Budeme se na vás těšit.</p>
	<p>KOSMETIKA TERKA</p>
</div>";
		$this->z->emails->sendHtmlBody($reservation->val('email'), $this->z->emails->getEmailSubject('Nová rezervace'), $body, $from_address);

		echo "Sent email to {$reservation->val('email')}" . PHP_EOL;

		//send email to admin
		if (empty($admin_email)) {
			echo "No email address was set up for admin calendar notifications!" . PHP_EOL;
		} else {
			if ($reservation->val('email') !== $admin_email) {
				$body = "<div>
	<h3>Zákazník vytvořil novou rezervaci</h3>
	<br/>
	<div>Jméno: <strong>{$reservation->val('name')}</strong></div>
	<div>Email: <a href=\"mailto:{$reservation->val('email')}\">{$reservation->val('email')}</a></div>
	<div>Telefon: {$reservation->val('phone')}</div>
	$summary
	<br/>
	<p>Rezervace lze změnit nebo zrušit v administraci na <a href=\"$admin_url\">stránkách</a>.</p>
	<p>Karel</p>
</div>";
				$this->z->emails->sendHtmlBody($admin_email, $this->z->emails->getEmailSubject('Nová rezervace'), $body, $from_address);

				echo "Sent email to $admin_email" . PHP_EOL;
			}
		}

		$reservation->set('calendar_reservation_creation_notification_sent', 1);
		$reservation->save();
	}

	if (empty($admin_email)) {
		$admin_email = $this->z->emails->from_address;
	}

	// send incoming notification email
	$tomorrow = new DateTime();
	$tomorrow->add(new DateInterval("PT12H"));

	$incoming = CalendarReservationModel::select(
		$this->z->db,
		'view_calendar_reservations',
		'calendar_reservation_incoming_notification_sent = 0 and calendar_reservation_start < ?',
		null,
		null,
		[z::mysqlDatetime($tomorrow)],
		[PDO::PARAM_STR]
	);

	$this->dbg(count($incoming));

	foreach ($incoming as $reservation) {
		//send email to customer
		$summary = $this->z->calendar->getReservationSummary($reservation);
		$body = "<div>
	<h3>Termín vaší rezervace se blíží</h3>
	<br/>
	$summary
	<br/>
	<p>Vaši rezervaci můžete změnit nebo zrušit na našich <a href=\"$public_url\">stránkách</a>.</p>
	<p>V případě dotazů se nám můžete ozvat na mail <a href=\"mailto:{$admin_email}\">{$admin_email}</a> nebo zavolat na číslo +420 605 743 494.</p>
	<p>Budeme se na vás těšit.</p>
	<p>KOSMETIKA TERKA</p>
</div>";
		$this->z->emails->sendHtmlBody($reservation->val('email'), $this->z->emails->getEmailSubject('Termín vaší rezervace se blíží'), $body, $from_address);

		echo "Sent email to {$reservation->val('email')}" . PHP_EOL;

		$reservation->set('calendar_reservation_incoming_notification_sent', 1);
		$reservation->save();
	}
