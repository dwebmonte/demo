<?php
class iObserver {
	public $article_life_sec = "7 day";
	public $log_life_sec = "7 day";
	
	
	
	function clean_old_data() {
	
		// article_cat
		iDB::exec($query = "DELETE FROM article_cat WHERE article_id IN ( SELECT id FROM article WHERE `time_added` < NOW() - INTERVAL {$this->article_life_sec})");
		
		// koef
		iDB::exec($query = "DELETE FROM koef WHERE `id_1` IN (SELECT id FROM article WHERE `time_added` < NOW() - INTERVAL {$this->article_life_sec})");
		iDB::exec($query = "DELETE FROM koef WHERE `id_2` IN (SELECT id FROM article WHERE `time_added` < NOW() - INTERVAL {$this->article_life_sec})");
		
		// article
		iDB::exec($query = "DELETE FROM article WHERE `time_added` < NOW() - INTERVAL {$this->article_life_sec}");	
		
		// log
		iDB::exec($query = "DELETE FROM log WHERE `time` < NOW() - INTERVAL {$this->article_life_sec}");		
	}
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}