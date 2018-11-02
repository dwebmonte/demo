<?php
	
class API extends coreAPI{	
	

	function onRequest($do = null, $params = null, $call_method = null) {
		global $SM;
		
		$oRes = true; $oData = null;
		
		list( $do, $params, $paramForm, $res_parent ) = parent::onRequest($do, $params, $call_method);	

		
		switch ($do) {
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
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($search_word) .' ) koef
				FROM `search` S LEFT JOIN `article` A ON (S.article_id=A.id)

				WHERE S.table_id=0 AND MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($search_word) .'  ) > 0
				ORDER BY MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($search_word) .'  ) DESC
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
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($row_search_article->title) .' ) koef
				FROM `search` S LEFT JOIN `article` A ON (S.article_id=A.id)

				WHERE S.table_id=0 AND MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($row_search_article->title) .'  ) > 0
				ORDER BY MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($row_search_article->title) .'  ) DESC
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
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($search_word) .' IN BOOLEAN MODE) koef
				FROM `search` S LEFT JOIN `article` A ON (S.article_id=A.id)

				WHERE S.table_id=0 AND MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($search_word) .'  IN BOOLEAN MODE) > 0
				ORDER BY MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($search_word) .'  IN BOOLEAN MODE) DESC
				LIMIT 5';				
				*/
				
				$query = '
				SELECT A.id, A.title, A.url, IF(A.time_added="0000-00-00 00:00:00", A.`time`, A.time_added) time_added, MATCH (S.`title`, S.`text`) AGAINST ('.iS::sq($search_word) .' ) koef
				FROM `search` S LEFT JOIN `article` A ON (S.article_id=A.id)

				WHERE S.table_id=0 AND MATCH (S.`title`, S.`text`) AGAINST (SUBSTRING_INDEX('.iS::sq($search_word) .', " ", 100)  ) > 0
				ORDER BY MATCH (S.`title`, S.`text`) AGAINST (SUBSTRING_INDEX('.iS::sq($search_word) .', " ", 100)  ) DESC
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
				$data_group_block = iDB::rows("SELECT * FROM block WHERE `url` LIKE ". iS::sq("%{$paramForm["site"]}%") ." GROUP BY name");
				
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
				
				
				$data_article = iDB::rows("SELECT id, title, url, md5, `text`, sub_title, `category`, key_point, inner_url, parsed, str_time, related, tags, tags2, time_added, response, UNIX_TIMESTAMP(`time`) as `time` FROM article  WHERE parsed=1 AND url LIKE ". iS::sq("%{$paramForm["site"]}%") ." ORDER BY `id` DESC LIMIT 1000");
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
		
	
			
			
			
			case "login":
				$_SESSION["user"]["id"] = 1;
				$_SESSION["user"]["name"] = "Аноним";
				$_SESSION["user"]["email"] = "cron@aleney.net";
				
				$this->output["action"][] = array("do" => "href", "href" => "");

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