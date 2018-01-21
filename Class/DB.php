<?php

/**
*  Database connection and methods utilizing that connection.
*/


class DB
{
	private $db;
	
	function __construct($host, $dbname, $user, $password) {
		return $this->db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
	}

	public function prepared_query($query, $bindings) {
		$stmt = $this->db->prepare($query);
		$stmt->execute($bindings);
		return ( $stmt->rowCount() > 0 ? true : false);
	}

	public function sign_in($username, $password) {
		$result = $this->db->query("SELECT id FROM users WHERE username = '$username' AND password = '$password'");
		return $result->fetch();
	}

	public function raw_query($query) {
		$result = $this->db->query($query);
		return $result->fetchAll(PDO::FETCH_OBJ);
	}
}