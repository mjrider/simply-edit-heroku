<?php

	error_log('Inside put handler',4);

	$fs = require_once('/app/init.php');

	if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
		header("HTTP/1.1 403 Bad request");
	} else {
		$prefix = '/';
	
		$path = $_SERVER['REQUEST_URI'];
		$path = substr($path, strlen($prefix));

		error_log("Target = {$path}\n");
		if ($path !== 'data/data.json') {
			header('HTTP/1.1 404 Not found');
		} else {
			/* PUT data comes in on the stdin stream */
			$putdata = fopen("php://input", "r");
			$fs->putStream($path, $putdata);
		}
	}

	exit;
