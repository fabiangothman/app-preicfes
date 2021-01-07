<?php
	$connection = mysqli_connect($host, $bdUser, $bdPassword);
	if (!$connection){
	    die("Database Connection Failed" . mysqli_error($connection));
	}
	$select_db = mysqli_select_db($connection, $database);
	if (!$select_db){
	    die("Database Selection Failed" . mysqli_error($connection));
	}
?>