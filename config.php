<?php

require_once 'includes/meekrodb.2.1.class.php';
require_once 'includes/log.class.php';
require_once 'includes/ducksboardPush.class.php';
require_once 'includes/fileCache.class.php';

const API_KEY = "IXqrll3ck2LEWvTbjnQamqW2wMW1DTRvJhaaOmLUpfa8sRvue8"; // Get this from Ducksboard's widgets
const DEBUG_MODE = 1; // 1 to enable verbose logging

// # Database credentials
DB::$user = 'root';
DB::$password = 'thames2215';
DB::$dbName = 'redmine_default';
DB::$encoding = 'utf8';

if (DEBUG_MODE) {
	Log::debugMode();
	DB::debugMode(); // echo out each SQL command being run, and the runtime
}

// # Instantiate cache class (dependes on log class)
$fCache = new fileCache;

// # Base array for reports with records for ppl not listed in the queries
$user1 = array('name' => 'Lisandro Peralta', 'resolved' => 0, 'status' => 'grey');
$user2 = array('name' => 'Gastón De Mársico', 'resolved' => 0, 'status' => 'grey');
$user3 = array('name' => 'David Bank', 'resolved' => 0, 'status' => 'grey');
$base_arr = array($user1,$user2,$user3);
