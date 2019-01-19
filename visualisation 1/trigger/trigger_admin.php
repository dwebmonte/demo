<?php

global $SM;






$data_cron_watch1 = iDB::rows("SELECT * FROM cron_watch_param ORDER BY `time` ASC LIMIT 0,7");
$data_cron_watch2 = iDB::rows("SELECT * FROM cron_watch_param ORDER BY `time` ASC LIMIT 7,7");

$SM->assign("data_cron_watch1", $data_cron_watch1);
$SM->assign("data_cron_watch2", $data_cron_watch2);



if (ROUTE_URL == "trends/cnbc") {

	$date_from = (isset($_REQUEST["from"])) ?  $_REQUEST["from"] : date('Y-m-d');
	
	
	$date_to = date("Y-m-d", strtotime($date_from . " +1 day"));
	//var_dump( $date_to );
	
	//$date_to = (isset($_REQUEST["to"])) ?  $_REQUEST["to"] : '2018-12-01';
	
	
	$min_koef = (isset($_REQUEST["min_koef"])) ?  $_REQUEST["min_koef"] : '0.4';
	$max_koef = (isset($_REQUEST["max_koef"])) ?  $_REQUEST["max_koef"] : '0.9';


	$SM->assign("from", $date_from);
	$SM->assign("to", $date_to);
	$SM->assign("min_koef", $min_koef);
	$SM->assign("max_koef", $max_koef);

	//if ($date_from >= $date_to) trigger_error("date_from more than date_to", E_USER_ERROR);

	$query = "
	SELECT K.id_1, K.id_2, '' as title_1, '' as title_2, K.koef FROM koef K
	WHERE 
	  koef>={$min_koef} AND koef<={$max_koef} AND
	  K.time_from >= '{$date_from}' AND K.time_to <= '{$date_to}' 
	";
	

	// AND A1.title NOT LIKE 'UPDATE %' AND A2.title NOT LIKE 'UPDATE %'

	$data_fetch = array();
	$data_koef = iDB::rows( $query );

	if (!is_null( $data_koef )) {
		// перебираем строки с коеффициентами
		foreach ($data_koef as $item_koef) {
			
			// перебираем сохраненные строки
			$id_was_found = false;
			foreach ($data_fetch as $key_fetch => $item_fetch) {
				if ( isset($item_fetch[ $item_koef->id_1 ]) || isset($item_fetch[ $item_koef->id_2 ]) ) {
					
					if ( isset($item_fetch[ $item_koef->id_1 ]) ) $data_fetch[ $key_fetch ][ $item_koef->id_1 ]["count"]++;
					else {
						$row_article = iDB::row("SELECT A.*, LOWER(SUBSTRING_INDEX(A.`text`,' ',200)) as text_300w, C0.title as category0, C1.title as category1, C2.title as category2 FROM article A LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) WHERE A.id={$item_koef->id_1}");
						
						$data_fetch[ $key_fetch ][ $item_koef->id_1 ] = array("article" => $row_article, "count" => 1);				
					};

					if ( isset($item_fetch[ $item_koef->id_2 ]) ) $data_fetch[ $key_fetch ][ $item_koef->id_2 ]["count"]++;
					else {
						$row_article = iDB::row("SELECT A.*, LOWER(SUBSTRING_INDEX(A.`text`,' ',200)) as text_300w, C0.title as category0, C1.title as category1, C2.title as category2 FROM article A LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) WHERE A.id={$item_koef->id_2}");
					
						$data_fetch[ $key_fetch ][ $item_koef->id_2 ] = array("article" => $row_article, "count" => 1);				
					};
					
					$id_was_found = true;
				};
			};
			
			// если не найдено
			if (!$id_was_found) {
				$new_item_fetch = array();
				
				$row_article = iDB::row("SELECT A.*, LOWER(SUBSTRING_INDEX(A.`text`,' ',200)) as text_300w, C0.title as category0, C1.title as category1, C2.title as category2 FROM article A LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) WHERE A.id={$item_koef->id_1}");
				$new_item_fetch[ $item_koef->id_1 ] = array("article" => $row_article, "count" => 1);
				
				$row_article = iDB::row("SELECT A.*, LOWER(SUBSTRING_INDEX(A.`text`,' ',200)) as text_300w, C0.title as category0, C1.title as category1, C2.title as category2 FROM article A LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) WHERE A.id={$item_koef->id_2}");
				$new_item_fetch[ $item_koef->id_2 ] = array("article" => $row_article, "count" => 1);
				
				$data_fetch[] = $new_item_fetch;
			};
			
		};
	} // else trigger_error("Not found foed with condition K.time_from >= '{$date_from}' AND K.time_to <= '{$date_to}'", E_USER_WARNING);



	function cmp($a, $b) {
		if (count($a) == count($b)) {
			return 0;
		}
		return (count($a) > count($b)) ? -1 : 1;
	};

	
	//echo "<pre>";	var_dump($data_fetch);	echo "</pre>";
	
	usort($data_fetch, "cmp");

	/*
	$data_fetch1 = array();
	// Убираем дубликаты
	foreach ($data_fetch as $key_block => $item_block) {
		foreach ($item_block as $key => $item) {
			$data_fetch1[$key_block][$item->uid]		
	
		};
	};
	*/
	$SM->assign('data_fetch', $data_fetch);
};






if (ROUTE_URL == "trends/marketrealist") {

	$date_from = (isset($_REQUEST["from"])) ?  $_REQUEST["from"] : date('Y-m-d');
	
	
	$date_to = date("Y-m-d", strtotime($date_from . " +1 day"));
	//var_dump( $date_to );
	
	//$date_to = (isset($_REQUEST["to"])) ?  $_REQUEST["to"] : '2018-12-01';
	
	
	$min_koef = (isset($_REQUEST["min_koef"])) ?  $_REQUEST["min_koef"] : '0.4';
	$max_koef = (isset($_REQUEST["max_koef"])) ?  $_REQUEST["max_koef"] : '0.9';


	$SM->assign("from", $date_from);
	$SM->assign("to", $date_to);
	$SM->assign("min_koef", $min_koef);
	$SM->assign("max_koef", $max_koef);

	//if ($date_from >= $date_to) trigger_error("date_from more than date_to", E_USER_ERROR);

	$query = "
	SELECT K.id_1, K.id_2, '' as title_1, '' as title_2, K.koef FROM koef K
	WHERE 
	  koef>={$min_koef} AND koef<={$max_koef} AND
	  K.time_from >= '{$date_from}' AND K.time_to <= '{$date_to}' 
	";
	

	// AND A1.title NOT LIKE 'UPDATE %' AND A2.title NOT LIKE 'UPDATE %'

	$data_fetch = array();
	$data_koef = iDB::rows( $query );

	if (!is_null( $data_koef )) {
		// перебираем строки с коеффициентами
		foreach ($data_koef as $item_koef) {
			
			// перебираем сохраненные строки
			$id_was_found = false;
			foreach ($data_fetch as $key_fetch => $item_fetch) {
				if ( isset($item_fetch[ $item_koef->id_1 ]) || isset($item_fetch[ $item_koef->id_2 ]) ) {
					
					if ( isset($item_fetch[ $item_koef->id_1 ]) ) $data_fetch[ $key_fetch ][ $item_koef->id_1 ]["count"]++;
					else {
						$row_article = iDB::row("SELECT A.*, `text` as text_300w, C0.title as category0, C1.title as category1, C2.title as category2 FROM article A 
						LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  
						LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  
						LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) 
						WHERE A.id={$item_koef->id_1}");
						
						if (!is_null($row_article->marketrealist_article_close_id)) {
							$row_article->categories = iDB::line("SELECT A.`level`, C.title FROM marketrealist_article_cat A LEFT JOIN marketrealist_category C ON (C.id=A.category_id) WHERE article_id={$row_article->marketrealist_article_close_id} ORDER BY A.`level`");
							if (!is_null($row_article->categories)) $row_article->categories = implode('&nbsp;/&nbsp;', $row_article->categories);
						} else $row_article->categories = null;
						
						$data_fetch[ $key_fetch ][ $item_koef->id_1 ] = array("article" => $row_article, "count" => 1);				
					};

					if ( isset($item_fetch[ $item_koef->id_2 ]) ) $data_fetch[ $key_fetch ][ $item_koef->id_2 ]["count"]++;
					else {
						$row_article = iDB::row("SELECT A.*, `text` as text_300w, C0.title as category0, C1.title as category1, C2.title as category2	FROM article A 
						LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  
						LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  
						LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) 
						WHERE A.id={$item_koef->id_2}");

						if (!is_null($row_article->marketrealist_article_close_id)) {
							$row_article->categories = iDB::line("SELECT A.`level`, C.title FROM marketrealist_article_cat A LEFT JOIN marketrealist_category C ON (C.id=A.category_id) WHERE article_id={$row_article->marketrealist_article_close_id} ORDER BY A.`level`");
							if (!is_null($row_article->categories)) $row_article->categories = implode('&nbsp;/&nbsp;', $row_article->categories);
						} else $row_article->categories = null;						
						
						$data_fetch[ $key_fetch ][ $item_koef->id_2 ] = array("article" => $row_article, "count" => 1);				
					};
					
					$id_was_found = true;
				};
			};
			
			// если не найдено
			if (!$id_was_found) {
				$new_item_fetch = array();
				
				// LOWER(SUBSTRING_INDEX(A.`text`,' ',200)) as text_300w
				$row_article = iDB::row("SELECT A.*, `text` as text_300w, C0.title as category0, C1.title as category1, C2.title as category2 FROM article A 
				LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  
				LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  
				LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) 
				WHERE A.id={$item_koef->id_1}");
				
				if (!is_null($row_article->marketrealist_article_close_id)) {
					$row_article->categories = iDB::line("SELECT A.`level`, C.title FROM marketrealist_article_cat A LEFT JOIN marketrealist_category C ON (C.id=A.category_id) WHERE article_id={$row_article->marketrealist_article_close_id} ORDER BY A.`level`");
					if (!is_null($row_article->categories)) $row_article->categories = implode('&nbsp;/&nbsp;', $row_article->categories);
				} else $row_article->categories = null;
				
				$new_item_fetch[ $item_koef->id_1 ] = array("article" => $row_article, "count" => 1);
				
				$row_article = iDB::row("SELECT A.*, `text` as text_300w, C0.title as category0, C1.title as category1, C2.title as category2 FROM article A 
				LEFT JOIN cnbc_category C0 ON (C0.id=A.category_id0)  
				LEFT JOIN cnbc_category C1 ON (C1.id=A.category_id1)  
				LEFT JOIN cnbc_category C2 ON (C2.id=A.category_id2) 
				WHERE A.id={$item_koef->id_2}");
				
				if (!is_null($row_article->marketrealist_article_close_id)) {
					$row_article->categories = iDB::line("SELECT A.`level`, C.title FROM marketrealist_article_cat A LEFT JOIN marketrealist_category C ON (C.id=A.category_id) WHERE article_id={$row_article->marketrealist_article_close_id} ORDER BY A.`level`");
					if (!is_null($row_article->categories)) $row_article->categories = implode('&nbsp;/&nbsp;', $row_article->categories);
				} else $row_article->categories = null;				
				
				$new_item_fetch[ $item_koef->id_2 ] = array("article" => $row_article, "count" => 1);
				
				$data_fetch[] = $new_item_fetch;
			};
			
		};
	} // else trigger_error("Not found foed with condition K.time_from >= '{$date_from}' AND K.time_to <= '{$date_to}'", E_USER_WARNING);



	function cmp($a, $b) {
		if (count($a) == count($b)) {
			return 0;
		}
		return (count($a) > count($b)) ? -1 : 1;
	};

	
	//echo "<pre>";	var_dump($data_fetch);	echo "</pre>";
	
	usort($data_fetch, "cmp");

	/*
	$data_fetch1 = array();
	// Убираем дубликаты
	foreach ($data_fetch as $key_block => $item_block) {
		foreach ($item_block as $key => $item) {
			$data_fetch1[$key_block][$item->uid]		
	
		};
	};
	*/
	$SM->assign('data_fetch', $data_fetch);
};

/*
	Определяем категории для дерева категорий
*/



if (ROUTE_URL == "articles-by-category/cnbc") {
	$json_cat = array();


	$level = 0;

	for ($level = 0; $level <= 2; $level++) {
		$query = "
			SELECT C.id, C.title, C.parent_id, COUNT(A.id) count_article FROM cnbc_category C
			LEFT JOIN (SELECT * FROM article GROUP BY uid) A ON (A.category_id{$level}=C.id)
			WHERE C.`level`={$level}
			GROUP BY C.id
			ORDER BY C.title	
		";
		
		$data_cat = iDB::rows( $query );
		foreach ($data_cat as $key_cat => $item_cat) {
			
			if ($level ==0) $json_cat[] = array("id" => "cat{$item_cat->id}", "parent" => "#", "text" => $item_cat->title . " ({$item_cat->count_article})");
			else $json_cat[] = array("id" => "cat{$item_cat->id}", "parent" => "cat{$item_cat->parent_id}", "text" => $item_cat->title . " ({$item_cat->count_article})");
		};
	};

	$SM->assign("json_cat", json_encode($json_cat));
};



if (ROUTE_URL == "articles-by-category/marketrealist" || ROUTE_URL == "articles-by-category/marketrealist1") {
	$json_cat = array();


	$level = 0;

if (ROUTE_URL == "articles-by-category/marketrealist") {	
	$query = "
		SELECT C.uid as id, C.title, C.parent_uid as parent_id, COUNT(C.id) as count_article FROM marketrealist_category C 
		LEFT JOIN marketrealist_article_cat  MAC ON (MAC.category_id=C.id)
		GROUP BY C.id
		ORDER BY C.title	
	";		
} else {
	$query = "
		SELECT C.uid as id, C.title, C.parent_uid as parent_id, 0 as count_article FROM marketrealist_category C 
		ORDER BY C.title	
	";			
};
	$data_cat = iDB::rows( $query );
	foreach ($data_cat as $key_cat => $item_cat) {
		if ($item_cat->parent_id == "") $json_cat[] = array("id" => "cat{$item_cat->id}", "parent" => "#", "text" => $item_cat->title . "&nbsp;({$item_cat->count_article})");
		else $json_cat[] = array("id" => "cat{$item_cat->id}", "parent" => "cat{$item_cat->parent_id}", "text" => $item_cat->title . "&nbsp;({$item_cat->count_article})");
	};
	
	/*
	echo "<pre>";
	var_dump($json_cat);
	echo "</pre>";
	exit();
	*/
	
	$SM->assign("json_cat", json_encode($json_cat));
};


if (isset($_REQUEST["cnbc_cat"])) {
	session_write_close();
	
	$cnbc = new cnbc2();

	
	
	
	
	// for ($i = 0; $i < 200; $i++) $cnbc->parse_articles_from_category(); 	exit();	
	
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
	$length = isset($_REQUEST["length"]) ? $_REQUEST["length"] : 100;
	
	$cnbc->parse_article($length); 

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









// Definition page


/*
$elCor = array( "com" => array() );

$elCor["com"]["pageInfo"] = array("title" => "Dashboard", "header" => "Dashboard header", "description" => "Dashboard description");
$elCor["com"]["sessionUser"] = array("shortName" => "John Smith", "roleName" => "administrator");	

$SM->assign("elCor", json_encode($elCor));
*/

$iCoreData = array();
$iCoreData[] = array(
	"name" => "server",
	"data" => array(
		"scheme" => SCHEME, 
		"domain" => DOMAIN
	),
);

$iCoreData[] = array(
	"class" => "iLeftMenu",
	"name" => "leftMenu",
	
	
/*
		<item url="/" icon="fa-cogs">System</item>
		<item url="/trends" icon="fa-globe">Trends</item>
		<item url="/articles-by-category" icon="fa-sitemap">News by categories</item>
		<item url="/articles" icon="fa-newspaper-o">Articles</item>
		<item url="/logs" icon="fa-tasks">Logs</item>
		<item url="/proxy" icon="fa-cloud-download">Proxy</item>
		<item url="/testing" icon="fa-cubes">Categories</item>
		<item url="/testing-related" icon="fa-random">Related articles</item>
*/
	
	
	
	"data" => array(
		array("title" => "System", "url" => "", "icon" => "fa-cogs"),
		array("title" => "Trends", "url" => "trends", "icon" => "fa-globe", "items" =>
			array(
				array("title" => "cnbc.com", "url" => "trends/cnbc"),
				array("title" => "marketrealist.com", "url" => "trends/marketrealist"),
			)
		),
		array("title" => "News by categories", "url" => "articles-by-category", "icon" => "fa-sitemap", "items" =>
			array(
				array("title" => "cnbc.com", "url" => "articles-by-category/cnbc"),
				array("title" => "marketrealist.com", "url" => "articles-by-category/marketrealist1"),
				array("title" => "marketrealist.com (KB)", "url" => "articles-by-category/marketrealist"),
			)
		),
		array("title" => "Articles", "url" => "articles", "icon" => "fa-newspaper-o"),
		array("title" => "Logs", "url" => "logs", "icon" => "fa-tasks"),
		array("title" => "Proxy", "url" => "proxy", "icon" => "fa-cloud-download"),
		array("title" => "Categories", "url" => "testing", "icon" => "fa-cubes"),
		array("title" => "Related articles", "url" => "testing-related", "icon" => "fa-random"),		
	)
);



$SM->assign("iCoreData", json_encode($iCoreData));







