<?php
include('Log.php');

define("MMF_OAUTH_CONSUMER_KEY", "<put your app key here>");
define("MMF_OAUTH_CONSUMER_SECRET", "<put your app secret here>");

define("MMF_OAUTH_ACCESS_TOKEN", "<put your oauth access token here>");
define("MMF_OAUTH_ACCESS_TOKEN_SECRET", "<put your oauth token secret here>");

// Where to dump the files too...
// Must be writable by the user running the php
// (apache is likely)
$backupDir = "/dir/to/save/workouts";


// log file used by the code, again must be writable
// by whoever is running the code
$log = &Log::singleton("file", "/path/to/log/php.log");


// Set up how much to log
$mask = Log::UPTO(PEAR_LOG_DEBUG);
$log->setMask($mask);

?>
