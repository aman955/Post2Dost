<?php
require 'config.php';

isset($_SESSION['id']) ? '' : header('location:index.php');

if ( $_GET['userid'] == $_SESSION['id'] ) {
	$conn->raw_query("DELETE FROM events WHERE id = '$_GET[postid]'");
}
header('location:home.php');