<?php

// Отображаем текущие логи временных отметок выполнения
define('CRON_LOG_TIME', 1 << 0);
define('CRON_SQL_RES', 1 << 1);

define('CRON_LOG_ALL', CRON_LOG_TIME | CRON_SQL_RES);

class iCron {
	public $option;
	public $log = CRON_LOG_ALL;
	
	
	private $max_exec_time = null;
	private $start_time_exec = null;
	private $break_exceeded_time = false;


	
	
	
	
	
	
	
	public function __call($method, $parameters) {
		// Информация о результатах работы крона
		
		if ($this->log & CRON_LOG_TIME) trigger_error("Method \"{$method}\" started at " . gmdate("H:i:s"));
		if ($this->log & CRON_SQL_RES) {
			$res = iDB::update("UPDATE cron_method_res SET `value`=NULL, `time_start`=UTC_TIMESTAMP(), time_end=NULL WHERE `method`=" . iS::sq( $method ));
			if (!$res) iDB::insert("INSERT INTO cron_method_res (`method`, `time_start`) VALUES(". iS::sq($method) .", UTC_TIMESTAMP())");
		};
	
	
	
		// Проверяем на лимиты по времени
		
		if (!is_null($this->start_time_exec) && time() - $this->start_time_exec >= $this->max_exec_time) {
			if ($this->log & CRON_LOG_TIME) trigger_error("Method \"{$method}\" stopped at " . gmdate("H:i:s"). ". Time limit is exceeded", E_USER_WARNING);
			
			if ($this->log & CRON_SQL_RES) {
				iDB::update("UPDATE cron_method_res SET `value`=NULL, `error`='Time limit is exceeded', `time_start`=UTC_TIMESTAMP(), time_end=NULL WHERE `method`=" . iS::sq( $method ));
			};
			
			
			return false;
		};
		
		
	
		$cron_res = '""';
		$cron_error = 'NULL';
	
		switch ($method) {
		
			// Очищаем старые данные
			case "clean_old_data":
			
				// search
				iDB::exec("DELETE FROM `search` WHERE id NOT IN (SELECT id FROM article)");
				
				// article_cat
				iDB::exec($query = "DELETE FROM article_cat WHERE article_id IN ( SELECT id FROM article WHERE `time_added` < NOW() - INTERVAL {$this->option->article_life_sec})");
				
				// koef
				iDB::exec($query = "DELETE FROM koef WHERE `id_1` IN (SELECT id FROM article WHERE `time_added` < NOW() - INTERVAL {$this->option->article_life_sec})");
				iDB::exec($query = "DELETE FROM koef WHERE `id_2` IN (SELECT id FROM article WHERE `time_added` < NOW() - INTERVAL {$this->option->article_life_sec})");
				
				// article
				iDB::exec($query = "DELETE FROM article WHERE `time_added` < NOW() - INTERVAL {$this->option->article_life_sec}");	
				
				// log
				iDB::exec($query = "DELETE FROM log WHERE `time` < NOW() - INTERVAL {$this->option->article_life_sec}");						
				
			break;
			
			// Добавляем статьи в search и обновляем uid
			case "add_new_article_to_search":
				
				iDB::insert("
					INSERT IGNORE INTO `search` (id, title, `text_300w`, `md5`)
					SELECT * FROM (
						SELECT id, title, LOWER(SUBSTRING_INDEX(`text`,' ',300)) as text_300w, md5(A.url) FROM article A WHERE A.parsed=1 AND A.`text`!='' AND id NOT IN (SELECT id FROM `search`) LIMIT {$this->option->add_new_article_to_search_count}
					) a
				");
				$cron_res = mysqli_affected_rows(iDB::$rs);

				
				iDB::exec("UPDATE article SET uid=MD5(CONCAT(SUBSTRING_INDEX(url, '/', 3), '-', title)) WHERE uid=''");
			break;
			
			// Добавляем новые статьи в коеффициенты
			case "add_new_article_to_koef":
			
			
			
			break;
		
			default: trigger_error("Achtung", E_USER_ERROR);
		};

		// Информация о результатах работы крона
		
		if ($this->log & CRON_LOG_TIME) trigger_error("Method \"{$method}\" finished at " . gmdate("H:i:s"));
		if ($this->log & CRON_SQL_RES) {
			iDB::update("UPDATE cron_method_res SET `error`={$cron_error}, `time_end`=UTC_TIMESTAMP(), `value`={$cron_res} WHERE `method`=" . iS::sq( $method ));
		};
		
	}	
	
	
	
	

	
	
	
	
	




	
	
	function set_max_exec_time( $max_exec_time, $break_exceeded_time = true ) {
		$this->max_exec_time = $max_exec_time;
		$this->break_exceeded_time = $break_exceeded_time;
		
		$this->start_time_exec = time();
		if ($this->log & CRON_LOG_TIME) trigger_error("Cron is started at " . gmdate("H:i:s", $this->start_time_exec));
	}
	
	
	


	function __construct() {
		$this->option = new stdClass();
		
		
		
		$data_options = iDB::rows("SELECT `name`, `parent_name`, `value`, `type` FROM cron_option WHERE enabled=1");
		if (is_array($data_options)) {
			foreach ($data_options as $item_option) {
				switch ($item_option->type) {
					case "int": $item_option->value = (int) $item_option->value; break;
					case "float": $item_option->value = (float) $item_option->value; break;
					case "string": $item_option->value = (string) $item_option->value; break;
					trigger_error( "Error type=\"{$item_option->type}\"", E_USER_ERROR );
				};
				
				if (empty($item_option->parent_name)) {
					$name = $item_option->name;
					$this->option->$name = $item_option->value;
				} else {
					$name = $item_option->name;
					$parent_name = $item_option->parent_name;
					
					if (!isset($this->option->$parent_name)) $this->option->$parent_name = new stdClass();
					$this->option->$parent_name->$name = $item_option->value;
				};
			};
		};
	
	
	}

}