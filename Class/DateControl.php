<?php

/**
* This class sets the parameters for the current calendar. It accepts a month and year as arguments to create a custom calendar, or no arguments for a current month of the current year calendar.
*/

class DateControl {

	public $firstDom;
	public $firstWdom;
	public $month;
	public $year;

	public $weekdays = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

	public $months = array(
		'1'  => 'January',
		'2'  => 'February',
		'3'  => 'March',
		'4'  => 'April',
		'5'  => 'May',
		'6'  => 'June',
		'7'  => 'July',
		'8'  => 'August',
		'9'  => 'September',
		'10' => 'October',
		'11' => 'November',
		'12' => 'December'
		);

	public $monthStart;
	public $dayCount;
	public $range;
	
	function __construct($date = null) {

		date_default_timezone_set('America/New_York');
		$date = ($date ? $date : getdate());
		$this->month     = $date['mon'];
		$this->year      = $date['year'];
		$this->firstDom  = getdate(mktime(0,0,0, $this->month, 1, $this->year))['mday'];
		$this->firstWdom = array_search(getdate(mktime(0,0,0, $this->month, 1, $this->year))['weekday'], $this->weekdays);
		$this->dayCount = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
		$this->range = range(date('Y'), date('Y') + 10);
	}

	public function getMonth() {
		foreach ($this->months as $month => $value) {
			if ($this->month == $month) {
				return $value;
			}
		}
	}
}
