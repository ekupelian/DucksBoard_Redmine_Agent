<?php
class Log {
	const DEBUG_FLAG = "DebugMe";
	private static $debug = 0;

	public static function debugMode() {
		self::$debug = 1;
		self::e("## Debug Mode ON ##",self::DEBUG_FLAG);
	}

	public static function e($msg,$lvl="") {
		$log_str = ($lvl) ? "[DEBUG]" : "[ERROR]" ;
		$log_str .= " ".date('Y-m-d H:i:s')."::".$msg;
		
		if ($lvl=="") {
			echo $log_str."\n";
		} elseif (self::$debug && $lvl==self::DEBUG_FLAG) {
			echo $log_str."\n";
		}
	}
}
