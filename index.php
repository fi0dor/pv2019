<?php

	require_once "config/constants.php"; 

	if (MODE === "DEVELOPMENT") {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	require_once "autoload.php"; 
	require_once "core/init.php";

	$create_Dispatcher = new Dispatcher();
	$create_Dispatcher->dispatch();

?>