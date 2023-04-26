export const MODE_MONTH = 'month';
export const MODE_DAY = 'day';

export const MONTHS = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];
export const MONTHS_DECLINATED = ['ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince'];
export const DAYS = ['pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota', 'neděle'];

class CalendarMode {
	calendar;
	key;
	name;
	modeUpKey;

	constructor(calendar, key, name, up) {
		this.calendar = calendar;
		this.key = key;
		this.name = name;
		this.modeUpKey = up;
	}

	static formatDate(date) {
		return `${date.getDate()}. ${date.getMonth() + 1}. ${date.getFullYear()}`;
	}

	static formatDateLong(date) {
		return `${date.getDate()}. ${MONTHS_DECLINATED[date.getMonth()]}. ${date.getFullYear()}`;
	}

	static roundDateDay(date) {
		return new Date(date.getFullYear(), date.getMonth(), date.getDate());
	}

	static createElement(parent, tag, css = '', html = '') {
		const el = document.createElement(tag);
		el.className = css;
		el.innerHTML = html;
		parent.appendChild(el);
		return el;
	}

	getDescription() {}

	getDateNext(currentDay) {}

	getDatePrev(currentDay) {}

	render() {}
}

class ModeMonth extends CalendarMode {
	constructor(calendar) {
		super(calendar, MODE_MONTH, 'Měsíc');
	}

	roundDate(date) {
		const start = new Date(date);
		start.setDate(1);
		return CalendarMode.roundDateDay(start);
	}

	getDescription() {
		return `${MONTHS[this.calendar.currentDay.getMonth()]} ${this.calendar.currentDay.getFullYear()}`;
	}

	getDateNext(currentDay) {
		const nextMonth = new Date(currentDay);
		nextMonth.setMonth(currentDay.getMonth() + 1);
		return this.roundDate(nextMonth);
	}

	getDatePrev(currentDay) {
		const prevMonth = new Date(currentDay);
		prevMonth.setMonth(currentDay.getMonth() - 1);
		return this.roundDate(prevMonth);
	}

	render() {
		this.calendar.view.innerHTML = '';
		const view = CalendarMode.createElement(this.calendar.view, 'div', 'view-month');
		const lastDate = this.getDateNext(this.roundDate(this.calendar.currentDay));
		lastDate.setDate(0);
		const lastDay = lastDate.getDate();
		for (let day = 1; day <= lastDay; day++) {
			const date = new Date(this.calendar.currentDay);
			date.setDate(day);
			const slot = CalendarMode.createElement(view, 'div', 'slot-day border-bottom border-end', day);
			slot.addEventListener('click', () => this.calendar.setModeAndDay(MODE_DAY, date));
		}
	}
}

class ModeDay extends CalendarMode {
	constructor(calendar) {
		super(calendar, MODE_DAY, 'Den', MODE_MONTH);
	}

	roundDate(date) {
		return CalendarMode.roundDateDay(date);
	}

	getDescription() {
		return `${DAYS[(this.calendar.currentDay.getDay() + 6) % 7]}, ${CalendarMode.formatDateLong(this.calendar.currentDay)}`;
	}

	getDateNext(currentDay) {
		const nextDay = new Date(currentDay);
		nextDay.setDate(currentDay.getDate() + 1);
		return this.roundDate(nextDay);
	}

	getDatePrev(currentDay) {
		const prevDay = new Date(currentDay);
		prevDay.setDate(currentDay.getDate() - 1);
		return this.roundDate(prevDay);
	}

	formatSlotTime(time) {
		const hours = String(Math.floor(time));
		const minutes = String((time - hours) * 60);
		return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
	}

	render() {
		this.calendar.view.innerHTML = '';
		const view = CalendarMode.createElement(this.calendar.view, 'div', 'view-day');
		for (let time = this.calendar.minStartTime; time < this.calendar.maxEndTime; time = time + 1) {
			const slot = CalendarMode.createElement(view, 'div', 'slot d-flex flex-row border-bottom');
			const hour = CalendarMode.createElement(slot, 'div', 'slot-time p-2 text-center border-end', this.formatSlotTime(time));
			const minutes = CalendarMode.createElement(slot, 'div', 'slot-minutes flex-1 text-small muted ps-2');
			for (let minute = time, max = time + 1; minute < max; minute = minute + this.calendar.slotDuration) {
				const minuteSlot = CalendarMode.createElement(minutes, 'div', 'slot-body', this.formatSlotTime(minute));
				minuteSlot.style.height = `${this.calendar.slotHeightPx}px`;
			}
		}
	}
}

export default class Calendar {
	modes;
	dom;
	mode;
	currentDay;
	adminMode;
	reservations = null;

	minStartTime = 8;
	maxEndTime = 18;
	slotDuration = 0.25;
	slotHeightPx = 15;

	constructor(dom, admin = false, mode = MODE_MONTH, day = new Date()) {
		this.modes = [new ModeMonth(this), new ModeDay(this)];

		this.dom = dom;
		this.adminMode = admin;
		this.currentDay = day;

		this.dom.innerHTML =
			`<form class="calendar-menu mb-3 d-flex flex-row justify-content-center">
				<button type="button" class="up-button btn btn-primary">&nbsp;</button>
				<button type="button" class="prev-button btn btn-primary">&nbsp;</button>
				<div class="description d-flex flex-row align-items-center">
					<div class="date-desc"></div>
				</div>
				<button type="button" class="next-button btn btn-primary">&nbsp;</button>
			</form>
			<div class="calendar-view card">
			</div>`;

		this.upButton = this.dom.querySelector('.up-button');
		this.upButton.addEventListener('click', () => this.up());
		this.prevButton = this.dom.querySelector('.prev-button');
		this.prevButton.addEventListener('click', () => this.prev());
		this.nextButton = this.dom.querySelector('.next-button');
		this.nextButton.addEventListener('click', () => this.next());

		this.dateDesc = this.dom.querySelector('.date-desc');
		this.view = this.dom.querySelector('.calendar-view');

		this.setMode(mode);
	}

	setMode(modeKey) {
		this.setModeAndDay(modeKey, this.currentDay);
	}

	setCurrentDay(day) {
		this.setModeAndDay(this.mode.key, day);
	}

	setModeAndDay(modeKey, day) {
		this.today = CalendarMode.roundDateDay(new Date());
		this.mode = this.modes.find((m) => m.key === modeKey);
		this.currentDay = this.mode.roundDate(day);
		this.reload();
	}

	up() {
		if (this.mode.modeUpKey) this.setMode(this.mode.modeUpKey);
	}

	prev() {
		this.setCurrentDay(this.mode.getDatePrev(this.currentDay));
	}

	next() {
		this.setCurrentDay(this.mode.getDateNext(this.currentDay));
	}

	reload() {
		this.reservations = null;
		this.render();

		// api call here;
		setTimeout(
			() => {
				this.reservations = [];
				this.render();
			},
			1000
		)
	}

	render() {
		this.upButton.disabled = (this.mode.modeUpKey === undefined);
		this.prevButton.disabled = (this.mode.getDatePrev(this.currentDay) < this.mode.roundDate(this.today));
		this.dateDesc.innerText = this.mode.getDescription(this.currentDay);

		if (this.reservations === null) {
			const spinner = CalendarMode.createElement(
				this.view,
				'div',
				'loading d-flex align-items-center justify-items-center',
				`<div class="spinner-border text-warning my-5 m-auto p-5" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>`
			);
			return;
		}

		this.mode.render();
	}

	setVisibility(element, visible) {
		if (visible) {
			this.removeClass(element, 'd-none');
		} else {
			this.addClass(element, 'd-none');
		}
	}

	addClass(element, className) {
		if (!element.classList.contains(className)) element.classList.add(className);
	}

	removeClass(element, className) {
		element.classList.remove(className);
	}
}
