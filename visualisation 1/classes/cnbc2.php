<?php
	
// SELECT FROM_UNIXTIME(UNIX_TIMESTAMP("2018-08-08T10:24:32-0400")-4*60*60)	
	
class cnbc2 extends iParser {
	public $domain = "https://www.cnbc.com";	
	
	
	// Главная страница
	function parse_main() {		
		$this->cache = false;
	
		$content = $this->load($page_url = "https://www.cnbc.com");
		

		if (!empty($content)) {
			$J = str_get_html($content);
			
			
			foreach ($J->find(".tabContents", 0)->find("li") as $li) {
				if( !isset( $li->find("a", 0)->href ) ) continue;
			
				$title = trim($li->find("a", 0)->plaintext);
				$url = $li->find("a", 0)->href;
				
				$json["top0"][] = array("title" => $title, "url" => $url);
			};
			
			
			foreach ($J->find("#pipeline_secondary", 0)->find("li") as $li) {
				if( !isset( $li->find(".headline a", 0)->href ) ) continue;
				
				$title = trim($li->find(".headline a", 0)->plaintext);
				$url = $li->find(".headline a", 0)->href;

				$json["top2"][] = array("title" => $title, "url" => $url);
			};		


			
			
			
			
			
			foreach ($J->find("#pipeline_default", 0)->find("li") as $li) {
				if( !isset( $li->find(".headline a", 0)->href ) ) {
					if( isset( $li->find(".headline-overlay", 0)->href )  ) {
						$title = trim($li->find(".headline-overlay .headline", 0)->plaintext);
						$url = $li->find(".headline-overlay", 0)->href;
					} else continue;
				} else {
					$title = trim($li->find(".headline a", 0)->plaintext);
					$url = $li->find(".headline a", 0)->href;
				};
				
				$json["top3"][] = array("title" => $title, "url" => $url);
			};				
			
			
			// новости по категориям
			foreach ($J->find("#topic_town_container", 0)->find("section") as $section) {
				$cat_title = $section->find("h4 a", 0)->plaintext;
				foreach ($section->find(".headline") as $headline) {
					$title = trim($headline->find("a", 0)->plaintext);
					$url = $headline->find("a", 0)->href;	

					$json[$cat_title][] = array("title" => $title, "url" => $url);
				};
			};

			
			// var_dump($json);
			$this->add_json($json, $page_url);

			$J->clear(); 
			unset($J);
			
			
			
			iDB::updateSQL("log", array("title" => "start page", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "start page", "res" => 0), "id={$this->log_insert_id}");
		};
		
	}
	
	function parse_category( $page_url, $page=1 ) {
		$this->cache = false;
		
		$page_url .= '?page=' . $page;
		
		$category_title = str_ireplace('https://www.cnbc.com/', '', $page_url);
		$category_title = str_ireplace('/', '', $category_title);
	
		$content = $this->load($page_url);
		if (!empty($content)) {
			$J = str_get_html($content);
			$date = gmdate("c");	
		
			$header_title = trim($J->find(".header_title", 0)->plaintext);
		
			if ($J->find(".stories_assetlist", 0)) {
				foreach ($J->find(".stories_assetlist", 0)->find("li") as $li) {
					if( !isset( $li->find(".headline a", 0)->href ) ) continue;
				
					$title = trim($li->find(".headline a", 0)->plaintext);
					$url = $li->find(".headline a", 0)->href;
					
					$this->add_article( array("url" => $url, "title" => $title, "category" => $header_title ) );
				}	
			} else trigger_error("Achtung in {$page_url}", E_USER_WARNING);
			
			if ( $J->find("#feature") ) {
				$json = array();
				foreach ($J->find("#feature", 0)->find(".headline") as $headline) {
					if( !isset( $headline->find("a", 0)->href ) ) continue;
				
					$title = trim($headline->find("a", 0)->plaintext);
					$url = $headline->find("a", 0)->href;
					
					$json["top"][] = array("title" => $title, "url" => $url);
					
					$this->add_article( array("url" => $url, "title" => $title, "category" => $header_title ) );
				};	
				$this->add_json($json, $page_url);
			};
			
			
			
			
			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => $category_title, "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => $category_title, "res" => 0), "id={$this->log_insert_id}");
		};
	}	

	
	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = false;
		$this->use_proxy = false;
				
		$data_article = iDB::rows("SELECT id, url, title FROM article WHERE parsed=0 AND url LIKE 'https://www.cnbc.com%' ORDER BY id LIMIT {$max_count}");
		
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
	
	
			$oArticle->url = str_ireplace('https://www.cnbc.comhttps://www.cnbc.com/', 'https://www.cnbc.com/', $oArticle->url);

	
			$content = $this->load( $oArticle->url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true);
			

				
				// время
				if ($el = $J->find(".datestamp", 0)) $json["str_time"] = $el->datetime;
			
				// ключевые моменты
				if ($el = $J->find("#article_deck ul")) {
					foreach ($J->find("#article_deck ul li") as $item) $json["key_point"][] = trim($item->plaintext);
				};

				// Удаляем ненужное
				if ($J->find(".flex_chart", 0)) foreach ($J->find(".flex_chart") as $item) $item->outertext = "";
				if ($J->find(".inline-player", 0)) foreach ($J->find(".inline-player") as $item) $item->outertext = "";
				if ($J->find(".inlineChart", 0)) foreach ($J->find(".inlineChart") as $item) $item->outertext = "";
				if ($J->find(".embed-container", 0)) foreach ($J->find(".embed-container") as $item) $item->outertext = "";
				
				
				
				
				// текст
				if (isset($J->find("#article_body", 0)->innertext)) {
					$json["text"] = preg_replace('#\s+#six', ' ', trim(strip_tags( $J->find("#article_body", 0)->innertext )));
				} elseif (isset($J->find(".unit .story_listicle_body", 0)->innertext)) { 
					$json["text"] = preg_replace('#\s+#six', ' ', trim(strip_tags( $J->find(".unit .story_listicle_body", 0)->innertext )));				
				} else trigger_error("Achtung in {$oArticle->url}", E_USER_WARNING);
			
				// внутренние ссылки
				foreach ($J->find("#article_body a") as $a) {
				
					// если это статья
					if (preg_match('#\/\d#six', $a->href)) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $a->href, "type" => "article");
					
					// компания
					} elseif (strpos($a->href, '//www.cnbc.com/quotes') === 0) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => 'https:' . $a->href, "type" => "company");

					// другое	
					} elseif (strpos($a->href, '/') === 0) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $a->href, "type" => "other");
						
					};
					
				};				
				
				$json["response"] = $this->response;
				iDB::updateSQL("article", $json, "id={$oArticle->id}");				
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 1), "id={$this->log_insert_id}");
			} else {
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 0), "id={$this->log_insert_id}");
			};
			
			
		};
	}	
	
	
	
	
	
	
	
	function sitemap_category() {
		
		// берем категории из sitemap
		$content = $this->load($page_url = "https://www.cnbc.com/site-map");
		if (!empty($content)) {
			$J = str_get_html($content);
			
			$data_category = array();
			foreach ($J->find(".story ul") as $oBlock ) {
				$title_category = $oBlock->find("h2 a", 0)->plaintext;
				$url_category = "https:" . $oBlock->find("h2 a", 0)->href;
				
				iDB::insertSQL("cnbc_category", array(
					"title" => $title_category,
					"url" => $url_category,
					"md5" => md5($url_category),
					)
				);
			};
			
			$J->clear(); 
			unset($J);
		} else {
			trigger_error("Empty content for url=&laquo;{$page_url}&raquo;", E_USER_WARNING);
		};	
		
	}
	
	// ищет и добавляет вложенные категории для заданной категории
	function expand_category($category_id = null) {
		if (is_null($category_id)) {
			$row_cat = iDB::row("SELECT * FROM cnbc_category WHERE parsed=0 ORDER BY id");
		} else {
			$row_cat = iDB::row("SELECT * FROM cnbc_category WHERE id={$category_id}");
		};
	
		if (is_null($row_cat)) return false;
		
		$content = $this->load($page_url = $row_cat ->url);
		if (!empty($content)) {
			$J = str_get_html($content);
			if (!$J) {
				trigger_error("Empty J for url=&laquo;{$page_url}&raquo;", E_USER_WARNING);
				iDB::update("UPDATE cnbc_category SET parsed=3 WHERE id={$row_cat->id}");
				return true;
			};
			

			foreach ($J->find("#pageHeadNav ul li") as $oItem) {	
				$item_category = array(
					"title" => $oItem->find("a", 0)->plaintext,
					"url" => $this->domain . $oItem->find("a", 0)->href,
					"parent_id" => $row_cat->id,
					"level" => $row_cat->level+1
				);
				
				$item_category["md5"] = md5( $item_category["url"] );
				iDB::insertSQL("cnbc_category", $item_category);
			};

			
			iDB::update("UPDATE cnbc_category SET parsed=1 WHERE id={$row_cat->id}");
			
			$J->clear(); 
			unset($J);
		} else {
			trigger_error("Empty content for url=&laquo;{$page_url}&raquo;", E_USER_WARNING);
			iDB::update("UPDATE cnbc_category SET parsed=2 WHERE id={$row_cat->id}");
		};			
	
		return true;
	}
	
	function define_max_page($category_id = null) {
		if (is_null($category_id)) {
			$row_cat = iDB::row("SELECT * FROM cnbc_category WHERE parsed=0 ORDER BY id");
		} else {
			$row_cat = iDB::row("SELECT * FROM cnbc_category WHERE id={$category_id}");
		};
	
		if (is_null($row_cat)) return false;
		
		$content = $this->load($page_url = $row_cat ->url);
		if (!empty($content)) {
			$J = str_get_html($content);
			if (!$J) {
				trigger_error("Empty J for url=&laquo;{$page_url}&raquo;", E_USER_WARNING);
				iDB::update("UPDATE cnbc_category SET parsed=3 WHERE id={$row_cat->id}");
				return true;
			};
			
			if ($J->find("#pagination .lastLink")) {
				$href = trim($J->find("#pagination .lastLink", 0)->href);
				preg_match('#(\d+)$#six', $href, $sub);
				$max_page = $sub[1];
				
				iDB::update("UPDATE cnbc_category SET `page`=0, max_page={$max_page} WHERE id={$row_cat->id}");
			};
			
			iDB::update("UPDATE cnbc_category SET parsed=1 WHERE id={$row_cat->id}");
			
			$J->clear(); 
			unset($J);
		} else {
			trigger_error("Empty content for url=&laquo;{$page_url}&raquo;", E_USER_WARNING);
			iDB::update("UPDATE cnbc_category SET parsed=2 WHERE id={$row_cat->id}");
		};			
	
		return true;	
	}
	
	function parse_articles_from_category( $category_id = null ) {
		if (is_null($category_id)) {
			$row_cat = iDB::row("SELECT * FROM cnbc_category WHERE max_page>0 AND `page` < max_page ORDER BY id");
		} else {
			$row_cat = iDB::row("SELECT * FROM cnbc_category WHERE id={$category_id}");
		};
	
		if (is_null($row_cat)) return false;
		
		$page = $row_cat->page + 1;
		
		$page_url = $row_cat->url . '?page=' . $page;
		
		$content = $this->load($page_url);
		if (!empty($content)) {
			$J = str_get_html($content);
			if (!$J) {
				trigger_error("Empty J for url=&laquo;{$page_url}&raquo;", E_USER_WARNING);
				return true;
			};			
			
			if ($J->find(".stories_assetlist", 0)) {
				foreach ($J->find(".stories_assetlist", 0)->find("li") as $li) {
					if( !isset( $li->find(".headline a", 0)->href ) ) continue;
				
					$title = trim($li->find(".headline a", 0)->plaintext);
					$url = $this->domain . $li->find(".headline a", 0)->href;
					
					$article_id = iDB::insertSQL("cnbc_article", array("title" => $title, "url" => $url, "md5" => md5($url)));
					if ($article_id == 0) $article_id = iDB::value("SELECT id FROM cnbc_article WHERE md5=" . iS::sq(md5($url)));
					
					iDB::insertSQL("cnbc_article_cat", array("article_id" => $article_id, "category_id" => $row_cat->id));
				}	
			} else trigger_error("Achtung in {$page_url}", E_USER_WARNING);
			
			
			
			iDB::update("UPDATE cnbc_category SET `page`=`page`+1 WHERE id={$row_cat->id}");
			
			$J->clear(); 
			unset($J);
		} else {
			trigger_error("Empty content for url=&laquo;{$page_url}&raquo;", E_USER_WARNING);
		};			
	
		return true;
	}	
	
	// парсинг статей
	function parse_article($max_count = 1) {
				
		$data_article = iDB::rows("SELECT id, url, title FROM cnbc_article WHERE parsed=0 ORDER BY RAND() LIMIT {$max_count}");
		
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
			$page_url = $oArticle->url = str_ireplace('https://www.cnbc.comhttps://www.cnbc.com/', 'https://www.cnbc.com/', $oArticle->url);
	
			$content = $this->load( $page_url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => 1);
			
				// Удаляем ненужное
				if ($J->find(".flex_chart", 0)) foreach ($J->find(".flex_chart") as $item) $item->outertext = "";
				if ($J->find(".inline-player", 0)) foreach ($J->find(".inline-player") as $item) $item->outertext = "";
				if ($J->find(".inlineChart", 0)) foreach ($J->find(".inlineChart") as $item) $item->outertext = "";
				if ($J->find(".embed-container", 0)) foreach ($J->find(".embed-container") as $item) $item->outertext = "";
				
				// время
				if ($el = $J->find(".datestamp", 0)) {
					$json["published"] = $el->datetime;
					if (strpos($json["published"], 'T') !== false) $json["published"] = date("Y-m-d H:i:s", strtotime('2018-11-12T19:00:53-0500'));
				};
				
				// текст
				if (isset($J->find("#article_body", 0)->innertext)) {
					$json["text"] = preg_replace('#\s+#six', ' ', trim(strip_tags( $J->find("#article_body", 0)->innertext )));
				} elseif (isset($J->find(".unit .story_listicle_body", 0)->innertext)) { 
					$json["text"] = preg_replace('#\s+#six', ' ', trim(strip_tags( $J->find(".unit .story_listicle_body", 0)->innertext )));				
				} else trigger_error("Achtung in {$oArticle->url}", E_USER_WARNING);	
				
				$json["response"] = $this->response;
				iDB::updateSQL("cnbc_article", $json, "id={$oArticle->id}");				
				$J->clear(); 
				unset($J);
			} else {
				trigger_error("Empty content for url=&laquo;{$page_url}&raquo;, server response = &laquo;{$this->response}&raquo;", E_USER_WARNING);
			};			
		};
		return true;
	}		
	
	
	
	function __construct() {
		parent::__construct("json/cnbc.json", "json/cnbc_block.json");
	}


	function __destruct() {
		parent::__destruct();
	}






}