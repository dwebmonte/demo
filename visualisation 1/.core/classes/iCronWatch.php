<?php
	
class iCronWatch {

	static function param($cron_name, $param_name, $value = null) {
		if (!is_null($value)) {
			$res = iDB::update("UPDATE cron_watch_param SET `value`=". iS::sq($value) .", `time`=UTC_TIMESTAMP() WHERE `cron`=" . iS::sq( $cron_name ) . " AND `param`=" . iS::sq( $param_name ));
			if (!$res) iDB::insert("INSERT INTO cron_watch_param (`cron`, `param`, `value`, `time`) VALUES(". iS::sq($cron_name) .", ". iS::sq($param_name) .", ". iS::sq($value) .", UTC_TIMESTAMP())");
		};
	
	}












}