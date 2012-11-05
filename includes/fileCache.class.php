<?php

class fileCache {

	public function __construct() {
		define("CACHE_DIR",__DIR__."/../cache/");
		clearstatcache();
		if (!is_dir(CACHE_DIR)) {
			Log::e("Creating cache directory in ".CACHE_DIR,Log::DEBUG_FLAG);
			mkdir(CACHE_DIR, 0775);
		}
	}

	public function check($filename, $data) {
		$cache = (is_file(CACHE_DIR.$filename)) ? unserialize(file_get_contents(CACHE_DIR.$filename)) : "" ;
		
		if ($cache==$data) {
			Log::e("Data already cached",Log::DEBUG_FLAG);
			return true;
		} else {
			Log::e("Data inserted in file cache",Log::DEBUG_FLAG);
			file_put_contents(CACHE_DIR.$filename, serialize($data)); 
			return false;
		}
	}
}