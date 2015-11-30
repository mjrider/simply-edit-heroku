<?php
require_once  __DIR__ . '/vendor/autoload.php';

use Sabre\DAV\Client;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;

use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Memory as CacheStore;

$webdav = getenv('webdavendpoint');
if ( isset($webdav) && $webdav ) {
	$webdav = getenv('webdavendpoint');
} else {
	echo "Endpoint missing\n";
	var_dump($_ENV);
	exit(1);
}

$url = new \arc\url\Url( $webdav );

$baseuri = clone $url;
$baseuri->path = '/';
unset($baseuri->user);
unset($baseuri->pass);
unset($baseuri->path);


$settings = [
	'baseUri'  => (string)$baseuri,
	'userName' => (string)$url->user,
	'password' => (string)$url->pass,
];

try {
	error_log('settings:'.json_encode($settings));
	$client = new Client($settings);
	error_log('path:'.json_encode($url->path));
	$webdavadapter = new WebDAVAdapter($client,$url->path);

	// Create the cache store
	$cacheStore = new CacheStore();

	// Decorate the adapter
	$adapter = new CachedAdapter($webdavadapter, $cacheStore);

	$flysystem = new Filesystem($adapter);

	$contents = $flysystem->listContents('/');
} catch (Exception $e){
}
return $flysystem;

