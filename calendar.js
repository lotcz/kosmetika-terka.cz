export const MODE_MONTH = 'month';
export const MODE_WEEK = 'week';
export const MODE_DAY = 'day';

export const MONTHS = ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'];
export const MONTHS_DECLINATED = ['ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince'];

class CalendarMode {
	key;
	name;
	modeUpKey;

	constructor(key, name, up) {
		this.key = key;
		this.name = name;
		this.modeUpKey = up;
	}

	formatDate(date) {
		return `${date.getDate()}. ${date.getMonth() + 1}. ${date.getFullYear()}`;
	}

	formatDateLong(date) {
		return `${date.getDate()}. ${MONTHS_DECLINATED[date.getMonth()]}. ${date.getFullYear()}`;
	}

	roundDate(date) {
		return new Date(date.getFullYear(), date.getMonth(), date.getDate());
	}

	getDescription(currentDay) {}

	getDateNext(currentDay) {}

	getDatePrev(currentDay) {}
}

class ModeMonth extends CalendarMode {
	constructor() {
		super(MODE_MONTH, 'Měsíc');
	}

	getDescription(currentDay) {
		return `${MONTHS[currentDay.getMonth()]} ${currentDay.getFullYear()}`;
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
}

class ModeWeek extends CalendarMode {
	constructor() {
		super(MODE_WEEK, 'Týden', MODE_MONTH);
	}

	getDescription(currentDay) {
		const startOfWeek = new Date(currentDay);
		const dayOffset = (currentDay.getDay() + 6) % 7; 
		startOfWeek.setDate(currentDay.getDate() - dayOffset);
		const endOfWeek = new Date(startOfWeek);
		endOfWeek.setDate(startOfWeek.getDate() + 6);
		return `${this.formatDate(startOfWeek)} - ${this.formatDate(endOfWeek)}`;
	}

	getDateNext(currentDay) {
		const nextWeek = new Date(currentDay);
		nextWeek.setDate(currentDay.getDate() + 7);
		return this.roundDate(nextWeek);
	}

	getDatePrev(currentDay) {
		const prevWeek = new Date(currentDay);
		prevWeek.setDate(currentDay.getDate() - 7);
		return this.roundDate(prevWeek);
	}
}

class ModeDay extends CalendarMode {
	constructor() {
		super(MODE_DAY, 'Den', MODE_WEEK);
	}
	
	getDescription(currentDay) {
		return this.formatDateLong(currentDay);
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
}

export const MODES = [new ModeMonth(), new ModeWeek(), new ModeDay()];

export default class Calendar {

	dom;
	mode;
	currentDay;
	adminMode;
	reservations = null;

	constructor(dom, admin = false, mode = MODE_DAY, day = new Date()) {
		this.dom = dom;
		this.adminMode = admin;
		this.currentDay = day;
		this.today = new Date(day.getFullYear(), day.getMonth(), day.getDate());
		
		this.dom.innerHTML = 
			`<form class="calendar-menu mb-3 d-flex flex-row justify-content-center">
				<button type="button" class="up-button btn btn-primary">&nbsp;</button>
				<button type="button" class="prev-button btn btn-primary">&nbsp;</button>
				<div class="description d-flex flex-row align-items-center">
					<div class="mode-name"></div>:&nbsp;
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

		this.modeName = this.dom.querySelector('.mode-name');
		this.dateDesc = this.dom.querySelector('.date-desc');
		this.view = this.dom.querySelector('.calendar-view');

		this.setMode(mode);
	}

	setMode(modeKey) {
		this.mode = MODES.find((m) => m.key === modeKey);
		this.reload();
	}

	setCurrentDay(day) {
		this.currentDay = day;
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
	}

	render() {
		this.upButton.disabled = (this.mode.modeUpKey === undefined);
		this.prevButton.disabled = (this.mode.getDatePrev(this.currentDay) < this.today);
		this.modeName.innerText = this.mode.name;
		this.dateDesc.innerText = this.mode.getDescription(this.currentDay);

		this.view.innerHTML = this.currentDay.toISOString() + ' / ' + this.today.toISOString();
		return;
		if (this.reservations === null) {
			this.view.innerHTML = 
				`<div class="spinner-border text-warning my-5 mx-auto p-5" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>`;
			return;
		}
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
