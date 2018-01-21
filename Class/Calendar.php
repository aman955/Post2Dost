<?php

/**
* Generates a calendar based on information provided from a DateControl object.
*/

abstract class Builder {

	public static function create($date, $conn) {

		echo '<table>';
		foreach ($date->weekdays as $key => $value) {
			echo '<th>' . $value . '</th>'; 
		}
		echo '<tr>';
		for ($i=0; $i < $date->firstWdom; $i++) { 
			echo '<td></td>';
		}

		for ($j = $date->firstWdom + 1, $i = 1; $i < $date->dayCount + 1; $i++, $j++) { 
			$iteration = getdate(mktime(0,0,0,$date->month, $i, $date->year));
			$parsed    = date('Y-m-d', strtotime("$iteration"));
			if ( $conn->raw_query("SELECT id FROM events WHERE date = '$parsed' ") == true ) {
		  		echo "<td class='scheduled'><a href='event.php?day=$i&month=$date->month&year=$date->year'>" . $i . "</a></td>";
		  	} else {
		 		echo "<td><a href='event.php?day=$i&month=$date->month&year=$date->year'>" . $i . "</a></td>";
			}
		  	if ($j >= 7) {
		  		echo "</tr><tr>";
		  		$j = 0;
		  	}
		}
		echo '</table>';
	}
}
