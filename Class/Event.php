<?php

/**
* 
*/
class Event {

	public $events;
	public $daily;

	function __construct($conn, $date = null) {

			$this->events = $conn->raw_query("SELECT events.id, title, date, body, is_private, user_id FROM events RIGHT JOIN users ON user_id = users.id WHERE is_private = 1 OR user_id = $_SESSION[id]");

			$this->daily = $conn->raw_query("SELECT events.id, title, date, body, is_private, user_id FROM events RIGHT JOIN users ON user_id = users.id WHERE is_private = 1 OR user_id = $_SESSION[id] AND date = '$date'");
		}

	public function set($conn, $date) {
		$conn->prepared_query("INSERT INTO events (title, date, body, is_private, user_id) VALUES(:title, :date, :body, :is_private, :user_id)", array(
			'title'  	  => $_POST['title'],
			'date'   	  => $date,
			'body' => $_POST['description'],
			'is_private'  => ( isset($_POST['is_private']) ? 1 : 0),
			'user_id'     => $_SESSION['id']
			));
		header("location:home.php?year=$_GET[year]&month=$_GET[month]");
	}
}