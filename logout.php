<?php

 require 'config.php';

 session_start();
 unset($_SESSION['userdata']);
 session_destroy();
 header("Location:index.php");

?>