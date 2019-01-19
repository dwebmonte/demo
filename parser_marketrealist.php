<?php
	session_write_close();
	
	require_once("classes/constants.php");
	iCronWatch::param("marketrealist.com", "exec", 1);

	
	
	
$data_article = iDB::rows("SELECT id, LOWER(SUBSTRING_INDEX(`text`,' ',400)) as text FROM article WHERE marketrealist_article_close_id IS NULL ORDER BY id DESC LIMIT 1000");	
foreach ($data_article as $key => $item) {
	$query = "SELECT A.id, MATCH (strip_text) AGAINST (". iS::sq($item->text) .") koef FROM marketrealist_article A ORDER BY koef DESC LIMIT 1";
	$row_compare = iDB::row( $query );
	if (!is_null($row_compare)) iDB::exec("UPDATE article SET `time`=`time`, marketrealist_article_close_id={$row_compare->id} WHERE id={$item->id}");
};




	/*
	
		Обновляем поле strip_text
		
	
	*/
	
	
	
	$data_article = iDB::rows("SELECT * FROM marketrealist_article WHERE strip_text IS NULL ORDER BY id LIMIT 15000");
	if (is_null($data_article)) exit();
	
	
	foreach ($data_article as $key => $item) {
		iDB::update("UPDATE marketrealist_article SET strip_text=". iS::sq(trim(strip_tags($item->text))) ." WHERE id={$item->id}");
	};
	
	
	iCronWatch::param("marketrealist.com", "count articles stripped", iS::n(iDB::value("SELECT COUNT(id) FROM marketrealist_article WHERE strip_text IS NOT NULL")));
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	$parser = new marketrealist();

	for ($counter_exec = 1; $counter_exec <= 30; $counter_exec++) {
	
		// Ищем категорию по которой будем собирать статьи
		$row_category = iDB::row("SELECT id, updated_to_page, uid FROM marketrealist_category WHERE updated=0 ORDER BY id LIMIT 1");
		if (is_null($row_category)) {
			$row_category = new stdClass();
			$row_category->id = 0;
			$row_category->uid = '5982b1af854ed801007f72ea';
			$row_category->updated_to_page = 0;
		};
		

		$count_obr = $parser->load_article( $row_category->uid, $limit = 50, $from = $row_category->updated_to_page);
		$row_category->updated_to_page = iS::n($row_category->updated_to_page + $count_obr);
			
		if ($count_obr > 0) 	iDB::update("UPDATE marketrealist_category SET updated_to_page={$row_category->updated_to_page} WHERE id={$row_category->id}");
		else iDB::update("UPDATE marketrealist_category SET updated=1, updated_to_page={$row_category->updated_to_page} WHERE id={$row_category->id}");


		iCronWatch::param("marketrealist.com", "last updated page", $row_category->updated_to_page);
		iCronWatch::param("marketrealist.com", "count categories updated", iS::n(iDB::value("SELECT COUNT(id) FROM marketrealist_category WHERE updated=1")));
		iCronWatch::param("marketrealist.com", "count categories", iS::n(iDB::value("SELECT COUNT(id) FROM marketrealist_category")));
		iCronWatch::param("marketrealist.com", "count articles", iS::n(iDB::value("SELECT COUNT(id) FROM marketrealist_article")));
		
	
	};
	*/

	
	exit();
?>
