<?php
	
class API extends coreAPI{	
	

	function onRequest($do = null, $params = null, $call_method = null) {
		global $SM;
		
		$oRes = true; $oData = null;
		
		list( $do, $params, $paramForm, $res_parent ) = parent::onRequest($do, $params, $call_method);	

		
		switch ($do) {
		
		
		
		
/*
	
		$data_market = iDB::rows("SELECT exchange_code as exchange, name as market FROM market WHERE `enabled`=1 ORDER BY `update_order` DESC, `time`, `id` LIMIT {$count_update}");

		$start = time();
		foreach ( $data_market as $row) {
			$row_ticker = $this->get_ticker($row->exchange, $row->market);
			
			// Если скрипт выполняется больше положенного, то прерываем его
			if (!is_null($max_sec_exec) && (time() - $start - 1 >= $max_sec_exec)) {
				trigger_error( "API Update/Exchange -- Script was stopped. Time limit is over {$max_sec_exec} sec.", E_USER_WARNING);
				break;
			};
		};
		trigger_error( 'API Update/Exchange -- Time execution: '.round(microtime(true) - $start, 4).' sec.');	
*/


			case stristr($do, "Article/Categories/Join"):
				$start = time();
				$max_sec_exec = 60;
				$limit_article = 1;
		
				for ($level = 0; $level <= 2; $level++) {
					// перебираем статьи
					$data_article = iDB::rows("SELECT id, `text` FROM article WHERE category_id{$level} IS NULL AND `parsed`=1 AND `text`!='' ORDER BY time_added DESC  LIMIT {$limit_article}");
					foreach ($data_article as $key_article => $item_article) {
						
						
					
						// делаем выборку подходящих категорий
						$query = '
						INSERT IGNORE INTO article_cat (article_id, `level`, category_id, `count`, `sum`, `avg`)
						
						SELECT '. $item_article->id .', '. $level .',  cat_id, COUNT(category_id) `count`, SUM(koef) `sum`, AVG(koef) `avg` FROM 
						(SELECT A.title as article_title , C.id as cat_id, C.title as category_title, C.id as category_id, MATCH (A.`text`) AGAINST ('.iS::sq($item_article->text) .') koef FROM `cnbc_article` A LEFT JOIN cnbc_article_cat AC ON (AC.article_id=A.id) LEFT JOIN cnbc_category C ON (C.id=AC.category_id)
						WHERE C.`level`='.$level.'
						GROUP BY A.id 
						ORDER BY koef DESC 
						LIMIT 100) S
						GROUP BY category_id ORDER BY SUM(koef) DESC LIMIT 3';					
						
						iDB::exec($query);
						
						$category_id = iDB::value("SELECT category_id FROM article_cat WHERE article_id={$item_article->id} AND `level`={$level} ORDER BY `sum` DESC");
						if (is_null($category_id)) $category_id = 0;
						
						iDB::update("UPDATE article SET `time`=`time`, category_id{$level}={$category_id} WHERE id={$item_article->id}");
						
						/*
						// Если скрипт выполняется больше положенного, то прерываем его
						if (!is_null($max_sec_exec) && (time() - $start - 1 >= $max_sec_exec)) {
							trigger_error( "Article/Categories/Join -- Script was stopped. Time limit is over {$max_sec_exec} sec.", E_USER_WARNING);
							break;
						};
						*/
						
					};
				};
				trigger_error( 'API Update/Exchange -- Time execution: '.round(microtime(true) - $start, 4).' sec.');
		
			break;	
			
			// Список распознанных статей по категориям для Marketrealist
			case stristr($do, "Get/Category/Articles/Marketrealist1"):
				$category_uid = iS::sq(str_ireplace("cat", "", $paramForm["category_id"]));
				
				$data_articles = iDB::rows("
				SELECT A.*, LOWER(SUBSTRING_INDEX(`text`,' ',200)) as text_300w FROM article A
				LEFT JOIN marketrealist_article_cat MAC ON (A.marketrealist_article_close_id=MAC.article_id)
				LEFT JOIN marketrealist_category MC ON (MAC.category_id=MC.id)
				WHERE MC.uid={$category_uid}				
				ORDER BY time_added DESC LIMIT 100");
				$html = "";
				
				if (!is_null($data_articles)) {
					foreach ($data_articles as $key => $item) {
						$data_url = parse_url( $item->url );
					
					
						$html .= '<h5 style="border-bottom: 1px solid #e6e6e6;padding-bottom: 8px;margin-bottom: 12px;"> <a href="'. $item->url .'" target="_blank" style="display: block;width: 100%;color: black;">
						'. $item->title. '</a><span style="padding-left: 0px;" class="time">'. $item->time_added. '</span><span style="float: right;font-size: 10px;color: green;">'. str_ireplace("www.", "", $data_url["host"]) .'</span>
												</h5>';
				
					};
				};
				
				$this->jqueryHTML("#panel_articles_by_category", $html);
			break;			
			
			
			
			// Список статей из базы знаний по категориям для Marketrealist			
			case stristr($do, "Get/Category/Articles/Marketrealist"):
				$category_uid = iS::sq(str_ireplace("cat", "", $paramForm["category_id"]));
				
				$data_articles = iDB::rows("
					SELECT MA.published, MA.title, MAC.`level`, LOWER(SUBSTRING_INDEX(`text`,' ',200)) as text_300w FROM marketrealist_article MA LEFT JOIN marketrealist_article_cat MAC ON (MA.id=MAC.article_id) LEFT JOIN marketrealist_category MC ON (MAC.category_id=MC.id)
					WHERE MC.uid={$category_uid} LIMIT 100");
				
				$html = "";
				
				if (!is_null($data_articles)) {
					foreach ($data_articles as $key => $item) {		
					
						$html .= '<h5 style="border-bottom: 1px solid #e6e6e6;padding-bottom: 8px;margin-bottom: 12px;"> <a href="#" style="display: block;width: 100%;color: black;">
						'. $item->title. '</a><span style="padding-left: 0px;" class="time">'. $item->published. '</span><span style="float: right;font-size: 10px;color: green;">'. $item->level .'</span>
												</h5>';
				
					};
				};
				
				$this->jqueryHTML("#panel_articles_by_category", $html);
			break;			
			
			
			// Список статей из базы знаний по категориям для cnbc.com			
			case stristr($do, "Get/Category/Articles"):
				$category_id = (int) str_ireplace("cat", "", $paramForm["category_id"]);
				$level = iDB::value("SELECT `level` FROM cnbc_category WHERE id={$category_id}");
				
				$data_articles = iDB::rows("SELECT *, LOWER(SUBSTRING_INDEX(`text`,' ',200)) as text_300w FROM article WHERE category_id{$level} = {$category_id} GROUP BY uid ORDER BY time_added DESC LIMIT 100");
				$html = "";
				
				if (!is_null($data_articles)) {
					foreach ($data_articles as $key => $item) {
						$data_url = parse_url( $item->url );
					
					
						$html .= '<h5 style="border-bottom: 1px solid #e6e6e6;padding-bottom: 8px;margin-bottom: 12px;"> <a href="'. $item->url .'" target="_blank" style="display: block;width: 100%;color: black;">
						'. $item->title. '</a><span style="padding-left: 0px;" class="time">'. $item->time_added. '</span><span style="float: right;font-size: 10px;color: green;">'. str_ireplace("www.", "", $data_url["host"]) .'</span>
												</h5>';
				
					};
				};
				
				$this->jqueryHTML("#panel_articles_by_category", $html);
			break;
			
			
			
			
			case stristr($do, "Recognition/Categories"):
				$deep_search = $paramForm["deep_search"];
				$search_word = $paramForm["text"];
		
				$query = 'SELECT category_title, COUNT(category_id) `count`, SUM(koef) `sum`, AVG(koef) `avg`, STD(koef) `std` FROM 
				(SELECT A.title as article_title , C.title as category_title, C.id as category_id, MATCH (A.`text`) AGAINST ('.iS::sq($search_word) .') koef FROM `cnbc_article` A LEFT JOIN cnbc_article_cat AC ON (AC.article_id=A.id) LEFT JOIN cnbc_category C ON (C.id=AC.category_id)
				WHERE C.`level`>0
				GROUP BY A.id 
				ORDER BY koef DESC 
				LIMIT '. $deep_search .') S
				GROUP BY category_id ORDER BY SUM(koef) DESC';		
				
				exit();
		
				$data = iDB::rows($query);
				$this->dtSetData("recognized_categories_cnbc", $data);
			break;
			
			case stristr($do, "get/cnbc_category"):
				$query = "
					SELECT C.id, C.title, CP.title as `parent_title`, C.`level`, COUNT(C.id) `count` FROM cnbc_category C
					LEFT JOIN cnbc_article_cat AC ON (AC.category_id=C.id)
					LEFT JOIN cnbc_category CP ON (CP.id=C.parent_id)
					WHERE C.`level`>0
					GROUP BY AC.category_id
					ORDER BY `count` DESC";
					
				$data = iDB::rows_assoc( $query );	
					
				if (is_null($data)) $data = array();
				
				echo json_encode(array("data" => $data));
				exit();					
			break;
			case stristr($do, "Article/Similar"):
			
				$data_similar = $data_similar_bool = array();
				
				$article_id = $params["id"];
				$max_percent = 35;
				
				$row_search_article = iDB::row("SELECT * FROM article WHERE id={$article_id}");
				$search_word = $row_search_article->text;

				// обычный режим
				$query = '
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($search_word) .' ) koef
				FROM `search` S LEFT JOIN `article` A ON (S.id=A.id)

				WHERE MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($search_word) .'  ) > 0
				ORDER BY MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($search_word) .'  ) DESC
				LIMIT 7';
			
			
				$data_article = iDB::rows($query);				

				foreach ($data_article as $key => $item) {
					if ($key == 0) $max_koef = $item->koef;
					$percent = $data_article[$key]->percent = ceil(100 * ($item->koef / $max_koef));
					if ($percent < $max_percent) break;
					
					$item->url = str_ireplace(
						array(
							"https://www.benzinga.comhttps://www.benzinga.com/", 
							"https://www.cnbc.comhttps://www.cnbc.com/",
							"https://www.benzinga.comhttps://www.benzinga.com/",
							"https://www.reuters.com//www.reuters.com",
							"https://www.marketwatch.comhttps//www.marketwatch.com/",
						),
						array(
							"https://www.benzinga.com/", 
							"https://www.cnbc.com/",
							"https://www.benzinga.com/",
							"https://www.reuters.com/",
							"https//www.marketwatch.com/",
						),
						$item->url
					);					
					
					
					$data_similar[ $item->title ] = array(
						"id" => $item->id,
						"title" => $item->title,
						"url" => $item->url,
						"time_added" => $item->time_added,
						"percent" => $percent,
						"host" => parse_url($item->url, PHP_URL_HOST)
					);
				};			

				
				// обычный режим с заголовками
				$query = '
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($row_search_article->title) .' ) koef
				FROM `search` S LEFT JOIN `article` A ON (S.id=A.id)

				WHERE MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($row_search_article->title) .'  ) > 0
				ORDER BY MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($row_search_article->title) .'  ) DESC
				LIMIT 7';				
			
				$data_article = iDB::rows($query);				

				foreach ($data_article as $key => $item) {
					if ($key == 0) $max_koef = $item->koef;
					$percent = $data_article[$key]->percent = ceil(100 * ($item->koef / $max_koef));
					if ($percent < $max_percent) break;
					
					$item->url = str_ireplace(
						array(
							"https://www.benzinga.comhttps://www.benzinga.com/", 
							"https://www.cnbc.comhttps://www.cnbc.com/",
							"https://www.benzinga.comhttps://www.benzinga.com/",
							"https://www.reuters.com//www.reuters.com",
							"https://www.marketwatch.comhttps//www.marketwatch.com/",
						),
						array(
							"https://www.benzinga.com/", 
							"https://www.cnbc.com/",
							"https://www.benzinga.com/",
							"https://www.reuters.com/",
							"https//www.marketwatch.com/",
						),
						$item->url
					);					
					
					
					$data_similar_title[ $item->title ] = array(
						"id" => $item->id,
						"title" => $item->title,
						"url" => $item->url,
						"time_added" => $item->time_added,
						"percent" => $percent,
						"host" => parse_url($item->url, PHP_URL_HOST)
					);
				};					
				
				// boolean режим
				/*
				$query = '
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($search_word) .' IN BOOLEAN MODE) koef
				FROM `search` S LEFT JOIN `article` A ON (S.id=A.id)

				WHERE MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($search_word) .'  IN BOOLEAN MODE) > 0
				ORDER BY MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($search_word) .'  IN BOOLEAN MODE) DESC
				LIMIT 5';				
				*/
				
				$query = '
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text_300w`) AGAINST ('.iS::sq($search_word) .' ) koef
				FROM `search` S LEFT JOIN `article` A ON (S.id=A.id)

				WHERE MATCH (S.`title`, S.`text_300w`) AGAINST (SUBSTRING_INDEX('.iS::sq($search_word) .', " ", 100)  ) > 0
				ORDER BY MATCH (S.`title`, S.`text_300w`) AGAINST (SUBSTRING_INDEX('.iS::sq($search_word) .', " ", 100)  ) DESC
				LIMIT 7';				
				
			
				$data_article = iDB::rows($query);				

				foreach ($data_article as $key => $item) {
					if ($key == 0) $max_koef = $item->koef;
					$percent = $data_article[$key]->percent = ceil(100 * ($item->koef / $max_koef));
					if ($percent < $max_percent) break;
					
					$item->url = str_ireplace(
						array(
							"https://www.benzinga.comhttps://www.benzinga.com/", 
							"https://www.cnbc.comhttps://www.cnbc.com/",
							"https://www.benzinga.comhttps://www.benzinga.com/",
							"https://www.reuters.com//www.reuters.com",
							"https://www.marketwatch.comhttps//www.marketwatch.com/",
						),
						array(
							"https://www.benzinga.com/", 
							"https://www.cnbc.com/",
							"https://www.benzinga.com/",
							"https://www.reuters.com/",
							"https//www.marketwatch.com/",
						),
						$item->url
					);				
					
					$data_similar_bool[ $item->title ] = array(
						"id" => $item->id,
						"title" => $item->title,
						"url" => $item->url,
						"time_added" => $item->time_added,
						"percent" => $percent,
						"host" => parse_url($item->url, PHP_URL_HOST)
					);
				};			
				
				
				$this->output["action"][] = array("do" => "similar", "data" => array("similar" => array_values($data_similar), "similar_title" => array_values($data_similar_title), "similar_bool" => array_values($data_similar_bool) ));
				//$this->output["action"][] = array("do" => "similar", "data" => array("similar" => $data_similar, "similar_bool" => $data_similar_bool ));
			
			
			
			break;
		
		
		
		
		
		
		
		
			case stristr($do, "Articles/AddCustom"):
				iDB::insertSQL("article", array(
					"title" => $paramForm["title"],
					"text" => $paramForm["text"],
					"url" => "user_article_url",
					"md5" => md5(time()),
					"parsed" => 1
				));
				iDB::exec("INSERT IGNORE INTO `search` (article_id, title, `text`) SELECT id, title, `text` FROM article");
		
				trigger_error("Article was added --\"" . $paramForm["title"] . "\"", E_USER_NOTICE);
		
		

			case stristr($do, "GetArticles"):
				$data = array();
				
				// Блоки
				$data_block = array();
				$data_group_block = iDB::rows("SELECT * FROM block WHERE `url` LIKE ". iS::sq("%{$paramForm["site"]}%") ." GROUP BY `name`");
				
				if (is_array($data_group_block )) {
					foreach ($data_group_block as $item_block) {
						$last_block_id = iDB::value("SELECT id FROM block WHERE `name`=". iS::sq($item_block->name) ." AND `url` LIKE ". iS::sq("%{$paramForm["site"]}%") ." ORDER BY `time` DESC");
					
						$data_block[] = array(
							"block_id" => $last_block_id,
							"name" => $item_block->name,
							"time" => $item_block->time,
							"items" => iDB::rows("SELECT A.id, A.title, A.url FROM block_item BI LEFT JOIN article A ON (A.id=BI.article_id) WHERE BI.block_id={$last_block_id} ORDER BY BI.id")
						);
						
					};

					$this->output["action"][] = array("do" => "block", "data" => $data_block );
				};
				
				
				$data_article = iDB::rows("SELECT id, marketrealist_article_close_id, title, url, md5, `text`, sub_title, `category`, key_point, inner_url, parsed, str_time, related, tags, tags2, time_added, response, UNIX_TIMESTAMP(`time`) as `time` FROM article  WHERE parsed=1 AND url LIKE ". iS::sq("%{$paramForm["site"]}%") ." ORDER BY `id` DESC LIMIT 1000");
				if (!is_null($data_article)) {
					foreach ($data_article as $key => $item) {
						$item->url = str_replace(
							array(
								"https://www.benzinga.comhttps://www.benzinga.com/", 
								"https://www.cnbc.comhttps://www.cnbc.com/",
								"https://www.benzinga.comhttps://www.benzinga.com/",
								"https://www.reuters.com//www.reuters.com",
							),
							array(
								"https://www.benzinga.com/", 
								"https://www.cnbc.com/",
								"https://www.benzinga.com/",
								"https://www.reuters.com/",
							),
							$item->url
						);
						
						
						
						
						
						
						$item_data = array(
							"id" => $item->id,
							"title" => array("text" => $item->title, "url" => $item->url),
						);
						//$item_data["time"] =  (!empty($item->str_time)) ? $item->str_time : date("H:i:s, d.m", $item->time);
						$item_data["time"] =  date("H:i:s, d.m", $item->time);
						
						
						//$item_data["categories"] = iDB::rows("SELECT C.title FROM marketrealist_article_cat AC LEFT JOIN marketrealist_category C ON (C.id=AC.category_id) WHERE AC.article_id={$item->marketrealist_article_close_id} ORDER BY AC.`level`");
						//if (!is_null($item_data["categories"])) $item_data["categories"] = implode($item_data["categories"], " / ");
						
						
						$item_data["detail"] = "<dl>";
						
						if (!empty($item->category)) $item_data["detail"] .= "<dt>category: </dt><dd>{$item->category}</dd>";
						if (!empty($item->str_time)) $item_data["detail"] .= "<dt>str time: </dt><dd>{$item->str_time}</dd>";
					
					
						if (!empty($item->key_point)) {
							$item->key_point = unserialize($item->key_point);
							
							$item_data["detail"] .= "<dt>key point: </dt><dd>";
							foreach ($item->key_point as $item_tag) {
								$item_data["detail"] .= "<p>{$item_tag}</p>";
							};
							$item_data["detail"] .= "</dd>";
						};						
					
						if (!empty($item->tags)) {
							$item->tags = unserialize($item->tags);
							
							$item_data["detail"] .= "<dt>tags: </dt><dd>";
							foreach ($item->tags as $item_tag) {
								$item_data["detail"] .= "<a style='margin-right: 5px;' target='_blank' href='{$item_tag["url"]}' class='label label-primary'>{$item_tag["title"]}</a>";
							};
							$item_data["detail"] .= "</dd>";
							
						};
						
						if (!empty($item->tags2)) {
							$item->tags2 = unserialize($item->tags2);
							
							$item_data["detail"] .= "<dt>tags 2: </dt><dd>";
							foreach ($item->tags2 as $item_tag) {
								$item_data["detail"] .= "<a style='margin-right: 5px;' target='_blank' href='{$item_tag["url"]}' class='label label-secondary'>{$item_tag["title"]}</a>";
							};
							$item_data["detail"] .= "</dd>";
						};

						
						if (!empty($item->inner_url)) {
							$item->inner_url = unserialize($item->inner_url);
							
							$item_data["detail"] .= "<dt>inner url: </dt><dd>";
							foreach ($item->inner_url as $item_tag) {
								$item_data["detail"] .= '<div><a style="padding: 0 10px 0 0 " href="'. $item_tag["url"] .'" target="_blank"><i class="fa-external-link"></i></a>'. $item_tag["title"] .'</div>';
							};
							$item_data["detail"] .= "</dd>";
						};						
						
						if (!empty($item->related)) {
							$item->related = unserialize($item->related);
							
							
							$item_data["detail"] .= "<dt>related: </dt><dd>";
							foreach ($item->related as $item_tag) {
								if (empty($item_tag)) continue;
								if (!isset($item_tag["url"]) && count($item_tag) > 0) {
									foreach ($item_tag as $item_tag1) {
										$item_data["detail"] .= '<div><a style="padding: 0 10px 0 0 " href="'. $item_tag1["url"] .'" target="_blank"><i class="fa-external-link"></i></a>'. $item_tag1["title"] .'</div>';
									};
								} else {
									$item_data["detail"] .= '<div><a style="padding: 0 10px 0 0 " href="'. $item_tag["url"] .'" target="_blank"><i class="fa-external-link"></i></a>'. $item_tag["title"] .'</div>';
								};
							};
							$item_data["detail"] .= "</dd>";
							
						};
						
						
						$item_data["detail"] .= "</dl>";
						$item_data["detail"] .= "<div class='well well-sm'>{$item->text}</div>";
						
						//<div class="label label-secondary">Secondary</div>
						
						$data[] = $item_data;
					
					};
				};

				$this->dtSetData("article", $data);			
				$this->jqueryRemoveClass(".panel", "wm_check_for_update");		
				//echo json_encode(array("data" => $data));
				//exit();		
			break;
		
		
			case stristr($do, "GetLogs"):
				$data = array();
				
				$data = iDB::rows_assoc("SELECT id, title, url, http_code, total_time, connect_time, size_download, speed_download, res, UNIX_TIMESTAMP(`time`) as `time` FROM log WHERE url LIKE ". iS::sq("%{$paramForm["site"]}%") ." ORDER BY id DESC LIMIT 500");
				if (!is_null($data)) {
					foreach ($data as $key => $item) {
						$item["url"] = str_replace(
							array(
								"https://www.benzinga.comhttps://www.benzinga.com/", 
								"https://www.cnbc.comhttps://www.cnbc.com/",
								"https://www.benzinga.comhttps://www.benzinga.com/",
								"https://www.reuters.com//www.reuters.com",
								"https://www.zacks.comhttps://www.zacks.com/",
							),
							array(
								"https://www.benzinga.com/", 
								"https://www.cnbc.com/",
								"https://www.benzinga.com/",
								"https://www.reuters.com/",
								"https://www.zacks.com/",
							),
							$item["url"]
						);
					
					
					
						$data[$key]["title"] = array("text" => $item["title"], "url" => $item["url"]);
						$data[$key]["time"] = date("H:i:s, d.m", $item["time"]);
						$data[$key]["domain"] = str_ireplace('www.', '', parse_url($item["url"], PHP_URL_HOST));
					};
				} else $data = array();
				
				$this->dtSetData("log", $data);			
				$this->jqueryRemoveClass(".panel", "wm_check_for_update");				
				//echo json_encode(array("data" => $data));
				//exit();		
			break;		
		
		
			case stristr($do, "GetProxy"):
				$data = array();
				
				$data = iDB::rows_assoc("SELECT *, UNIX_TIMESTAMP(`time`) as `time`, CONCAT(proxy, ':', port) proxy FROM proxy ORDER BY `time` LIMIT 100");
				if (!is_null($data)) {
					foreach ($data as $key => $item) {
						$data[$key]["time"] = date("H:i:s, d.m", $item["time"]);
					};
				} else $data = array();
				
				echo json_encode(array("data" => $data));
				exit();		
			break;		
		 
		 
		 
			// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		 
		 
			case stristr($do, "Article/Update/FT"):
				$repeat = isset($paramForm["repeat"]) ? $paramForm["repeat"] : 60;
				$data_article = iDB::rows("SELECT id, text_300w 
					FROM `search` WHERE (ft_300w IS NULL OR ft_300w=0) AND text_300w!='' LIMIT {$repeat}");
				
				if (is_null($data_article)) trigger_error("All articles were updated by koef FT");
				else {
					foreach ($data_article as $row_article) {
						//var_dump($row_article->id);
						
						$query = "
							SELECT
							  MATCH(text_300w) AGAINST (". iS::sq($row_article->text_300w) .") ft_300w 
							FROM `search`
							WHERE id={$row_article->id}";
						$row_koef = iDB::row($query);	
					
					//var_dump($row_article->text_300, $row_koef->ft_300w);
					
						$query = "
						UPDATE `search` S SET
							ft_300w = {$row_koef->ft_300w} 
						WHERE S.id={$row_article->id}";
						
						iDB::update( $query );
					};
				};
				
				if (isset($_REQUEST["show"]) && !is_null($data_article)) {
					$count_updated = iDB::value("SELECT COUNT(id) FROM `search` WHERE  !(ft_300w IS NULL OR ft_300w=0) ");
					$count_last = iDB::value("SELECT COUNT(id) FROM `search` WHERE  (ft_300w IS NULL OR ft_300w=0) AND text_300w!=''");
					
					trigger_error("API Article/Update/FT -- Updated news = {$count_updated}, last news = {$count_last}");			
				} else {
					//exit();
				};			
			break;
			
			
			// Обновление таблицы коеффициентов
			case stristr($do, "Article/Update/Koef"):
				$repeat = isset($paramForm["repeat"]) ? $paramForm["repeat"] : 60;
				$min_percent = 0.2;
				
				
				$data_article = iDB::rows("SELECT id, text_300w, ft_300w 
					FROM `search` WHERE parsed_koef=0 AND ft_300w !=0 LIMIT {$repeat}");
					
				if (is_null($data_article)) trigger_error("All articles were updated by koef FT");
				else {
					$data_str_koef = array(
						//array("koef" => "ft_title", "field" => "title"),	
						//array("koef" => "ft_50w", "field" => "text_50w"),
						//array("koef" => "ft_100w", "field" => "text_100w"), 
						//array("koef" => "ft_150w", "field" => "text_150w"),
						//array("koef" => "ft_200w", "field" => "text_200w"),
						//5 => array("koef" => "ft_250w", "field" => "text_250w"),
						6 => array("koef" => "ft_300w", "field" => "text_300w"),
						//7 => array("koef" => "ft_400w", "field" => "text_400w"),
					);
				
					// перебираем статьи
					foreach ($data_article as $row_article) {
					
						// перебираем коеффициенты
						foreach ($data_str_koef as $koef_type => $item_str_koef) {
							$str_field = $item_str_koef["field"];
							$str_koef = $item_str_koef["koef"];
						
							$query = "
								INSERT IGNORE INTO `koef` (id_1, id_2, koef, koef_type)
								SELECT {$row_article->id}, S.id, MATCH (S.`{$str_field}`) AGAINST (". iS::sq($row_article->$str_field) .") / {$row_article->$str_koef} percent, '{$koef_type}' FROM `search` S
								WHERE S.id != {$row_article->id} AND (MATCH (S.`{$str_field}`) AGAINST (". iS::sq($row_article->$str_field) .")  / {$row_article->$str_koef}) >= {$min_percent}
							";
							
							iDB::exec( $query );
						};
						iDB::exec("UPDATE `search` SET parsed_koef=1 WHERE id={$row_article->id}");
					};
					
					
				};
		
		
				$count_updated = iDB::value("SELECT COUNT(id) FROM `search` WHERE parsed_koef!=0 AND ft_300w !=0");
				$count_last = iDB::value("SELECT COUNT(id) FROM `search` WHERE parsed_koef=0 AND ft_300w !=0");
					
				trigger_error("API Article/Update/Koef -- Updated news = {$count_updated}, last news = {$count_last}");			
		
			break;			
			
			
			
			
			
			
			
			
			
			
			case stristr($do, "article/at_work"):		
				if ($this->loginned()) {
			
			
					if (isset($paramForm["article_id"])) {
						$article_id = iS::n( $paramForm["article_id"] );
						
						$user_id_at_work = iDB::value("SELECT user_id_at_work FROM article WHERE id={$article_id}");
						
						// Если статья не в работе, то стартуем ее
						if (is_null($user_id_at_work)) {
							iDB::update("UPDATE article SET `time`=`time`, user_id_at_work={$_SESSION["user"]["id"]} WHERE id={$article_id}");
							iDB::insertSQL("article_work_stat", array("article_id" => $article_id, "user_id" => $_SESSION["user"]["id"], "state" => 1, "time" => gmdate("Y-m-d H:i:s"), "ip" => $_SERVER["REMOTE_ADDR"]));
							
							trigger_error("You started work on the article!");
							$this->output["action"][] = array("do" => "state", "res" => true, "article_id" => $article_id);
						// Если статья в работе другим пользователем
						} elseif ($user_id_at_work != $_SESSION["user"]["id"]) {
							trigger_error("You cannot start working on this article. Another writer is already working on it!", E_USER_WARNING);
							
						// Если статья в работе, то завершаем ее
						} else {
							iDB::update("UPDATE article SET `time`=`time`, user_id_at_work=NULL WHERE id={$article_id}");
							iDB::insertSQL("article_work_stat", array("article_id" => $article_id, "user_id" => $_SESSION["user"]["id"], "state" => 0, "time" => gmdate("Y-m-d H:i:s"), "ip" => $_SERVER["REMOTE_ADDR"]));
							
							trigger_error("You have completed the article!");
							$this->output["action"][] = array("do" => "state", "res" => false, "article_id" => $article_id);
						};

						
						
					} else trigger_error("article_id is not defined", E_USER_ERROR);
				} else trigger_error("Access denied -- You must login!", E_USER_ERROR);
			break;			
			
			
			// выход из системы
			case stristr($do, "User/Logout"):		
				unset($_SESSION["user"]);
				$this->output["action"][] = array("do" => "href", "href" => "");
			break;			
			
			// вход в систему
			case "login":
				$row_user = iDB::row("SELECT * FROM `user` WHERE `email`=". iS::sq($paramForm["login"]) ." AND `password`=".  iS::sq($paramForm["password"]));
				if (is_null($row_user)) {
					$row_user = iDB::row("SELECT * FROM `user` WHERE `email`=". iS::sq($paramForm["login"]));
					if (is_null($row_user)) trigger_error("Login failed - There is no user with this email", E_USER_ERROR); else trigger_error("Login failed - You entered the wrong password", E_USER_ERROR);	
				} else {
					$_SESSION["user"] = (array) $row_user;
					$this->output["action"][] = array("do" => "href", "href" => "");
				};
			break;

			
			case "get_lang": 
				if (!isset($_COOKIE['lang'])) setcookie('lang', $oData = DEFAULT_LANG); 
				else $oData = $_COOKIE['lang']; 
			break;
			case "lang":
			case "set_lang":	
				setcookie('lang', $params["value"]);
				
				$SM->config_load("notice.conf", $params["value"]);
				$SM->config_load("text.conf", $params["value"]);				
			break;
			
			
			default: 
				if (!$res_parent) $this->output["error"][1001] = array($do);
			break;

		};
		
		$this->output["data"] = $oData;
		$this->output["res"] = $oRes;
		return $this->prepare_output( $this->output );
		
		
		
	}


	
	function __construct() {
		parent::__construct();		

		$this->lang = isset($_REQUEST["lang"]) ? $_REQUEST["lang"] : DEFAULT_LANG;
	}


	function __destruct() {
		parent::__destruct();
	}






}