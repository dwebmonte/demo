<?php

global $SM;


iDB::exec("INSERT IGNORE INTO `search` (article_id, title, `text`) SELECT id, title, `text` FROM article");

if (isset($_REQUEST["cnbc_cat"])) {
	$cnbc = new cnbc2();

	//iDB::exec("TRUNCATE cnbc_category");
	//$cnbc->sitemap_category();

	//$res = true;
	//while ($res) {	$res = $cnbc->expand_category();};

	

	//iDB::exec("UPDATE cnbc_category SET parsed=0");
	//$res = true;
	//while ($res) {	$res = $cnbc->define_max_page();};
	
	// UPDATE `cnbc_article` SET parsed=10 WHERE url LIKE "https://www.cnbc.com/video/%"
	$res = true;
	//for ($i = 0; $i < 50; $i++) $cnbc->parse_articles_from_category(); 
	$length = isset($_REQUEST["length"]) ? $_REQUEST["length"] : 50;
	
	//$cnbc->parse_article($length); 

	if (isset($_REQUEST["show"])) {
	
	
		$query = "
			SELECT C.id, C.title, COUNT(AC.category_id) FROM `cnbc_article_cat` AC 
			LEFT JOIN cnbc_article A ON (A.id=AC.article_id)
			LEFT JOIN cnbc_category C ON (C.id=AC.category_id)
			WHERE A.`parsed`=1 GROUP BY AC.category_id
			ORDER BY COUNT(AC.category_id) DESC";	
		$data = iDB::rows( $query );
		echo "<pre>";
		
		var_dump("parsed=" . iDB::value("SELECT COUNT(*) FROM `cnbc_article` WHERE parsed=1"));
		var_dump("last=" . iDB::value("SELECT COUNT(*) FROM `cnbc_article` WHERE parsed=0"));
		var_dump($data);
		echo "</pre>";
	};
	exit();
};