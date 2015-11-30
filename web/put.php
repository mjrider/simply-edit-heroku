<?php
	$fs = require_once('/app/init.php');

	if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
		header("HTTP/1.1 403 Bad request");
		exit;
	}

	function checkTarget($target) {
		error_log("Target = ".$target."\n");
		return $target == "data/data.json";
	}

	$prefix = '/';

	$path = $_SERVER["REQUEST_URI"];
	$path = substr($path,strlen($prefix));


	if (!checkTarget($path)) {
		header("HTTP/1.1 404 Not found");
		exit;
	}

	/* PUT data comes in on the stdin stream */
	$putdata = fopen("php://input", "r");

	$fs->putStream($path, $putdata);

?>
