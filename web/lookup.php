<?php
	error_log('inside lookup.php',4);
	$fs = require_once('/app/init.php');

	$prefix = '/';

	$path = $_SERVER['REQUEST_URI'];
	$path = substr($path, strlen($prefix));

	// force webroot
	chdir('/app/web/');

	if(file_exists($path) === false) {
		$exists = $fs->has($path);

		if($exists === true) {
			$mimetype = $fs->getMimetype($path);
			// mime header
			header('Content-type: '.$mimetype);
			$stream = $fs->readStream($path);
			fpassthru($stream);
		} else {
			header('HTTP/1.1 404 Not found');
			echo "404\n";
		}
	}
