<?php
	
class iCronWatch {
	static $row_cron_time;


	static function param($cron_name, $param_name, $value = null) {
		if (!is_null($value)) {
			$res = iDB::update("UPDATE cron_watch_param SET `value`=". iS::sq($value) .", `time`=UTC_TIMESTAMP() WHERE `cron`=" . iS::sq( $cron_name ) . " AND `param`=" . iS::sq( $param_name ));
			if (!$res) iDB::insert("INSERT INTO cron_watch_param (`cron`, `param`, `value`, `time`) VALUES(". iS::sq($cron_name) .", ". iS::sq($param_name) .", ". iS::sq($value) .", UTC_TIMESTAMP())");
		};
	}


	static function param_start($cron_name, $param_name) {
		self::$row_cron_time[ $cron_name ] [ $param_name ] = gmdate("Y-m-d H:i:s");
	}


	static function param_end($cron_name, $param_name, $value = null) {
		if (!isset(self::$row_cron_time[ $cron_name ] [ $param_name ])) trigger_error("Achtung 1", E_USER_ERROR);
		
		if (!is_null($value)) {
			$res = iDB::update("UPDATE cron_watch_param SET `value`=". iS::sq($value) .", `time`=UTC_TIMESTAMP(), time_start=". iS::sq(self::$row_cron_time[ $cron_name ] [ $param_name ]) ." WHERE `cron`=" . iS::sq( $cron_name ) . " AND `param`=" . iS::sq( $param_name ));
			if (!$res) iDB::insert("INSERT INTO cron_watch_param (`cron`, `param`, `value`, `time`, `time_start`) VALUES(". iS::sq($cron_name) .", ". iS::sq($param_name) .", ". iS::sq($value) .", UTC_TIMESTAMP(), ". iS::sq(self::$row_cron_time[ $cron_name ] [ $param_name ]) .")");
		};
	}








}