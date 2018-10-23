<?php
// ('p[class=color-9 lheight16 marginbott5 x-normal]')	
	
class benzinga extends iParser {
	public $domain = "https://www.benzinga.com";	
	
	
	
	// Главная страница
	function parse_main() {		
		$this->cache = false;
	
		$content = $this->load($page_url = "https://www.benzinga.com");
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
			
			// Топ 1
			$top_block = $J->find(".view-bz3-homepage-featured .views-row-last", 0);
			
			$url = $this->domain . $top_block->find(".views-field-title  a",0)->href;
			$title = $top_block->find(".views-field-title a",0)->innertext;
			
			$json["top1"][] = array("title" => $title, "url" => $url);
			
			
			// Топ 2
			foreach ($J->find("div[class=view view-bz3-homepage-featured view-id-bz3_homepage_featured view-display-id-block_2 view-dom-id-2]", 0)->find(".views-field-title") as $item) {
				$url = $this->domain . $item->find("a", 0)->href;
				$title = $item->find("a", 0)->innertext;
				
				$json["top2"][] = array("title" => $title, "url" => $url);
			};
			
			// Headline
			foreach ($J->find("div[class=panel-pane pane-views pane-bz3-homepage-best-of-benzinga] .view-content .views-row") as $item) {
				if (!$el = $item->find(".views-field-title a", 0)) continue;
				
				$json["headline"][] = array("title" => $el->plaintext, "url" => $this->domain . $el->href);
			};
			
			$this->add_json($json, $page_url);
			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => "start page", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "start page", "res" => 0), "id={$this->log_insert_id}");
		};
	}
	

	
	// новости - https://www.benzinga.com/news, 
	// бестселлеры - https://www.benzinga.com/best-of-benzinga
	function parse_news( $type = "news" ) {
		$this->cache = false;
	
		if ($type == "news") $page_url = "https://www.benzinga.com/news?page=0";
		elseif ($type == "best") $page_url = "https://www.benzinga.com/best-of-benzinga"; 
	
		$content = $this->load( $page_url );
		
		//echo $content; exit();
		
		if (!empty($content)) {
			$J = str_get_html($content);
			
			$date = date("c");
			$data_json = array("best" => array());
			foreach ($J->find(".benzinga-articles ul", 0)->find("li") as $li) {
				if( !isset( $li->find("h3 a", 0)->href ) ) continue;
				
				$json = array();
				
				$json["url"] = $this->domain . $li->find("h3 a", 0)->href;
				$json["md5"] = md5( $json["url"] );
				$json["title"] = $li->find("h3 a", 0)->plaintext;				
				$json["str_time"] = $li->find(".date", 0)->plaintext;				
				//$sub = preg_split('#\W+#six', "2018 Aug 01, 4:45pm");
				//$json["time"] = date( "c", strtotime($str = $sub[0] . "-" . $sub[1] . "-" . $sub[2] . $sub[3] . ":" . $sub[4]));
				//$json["text"] = trim( str_replace('...', '', $li->find("div div", 0)->plaintext ));			
		
				// tags
				$json["tags"] = array();
				foreach ($li->find(".tags a") as $a) {
					$json["tags"][ $a->plaintext ] = array(
						"url" => $this->domain . $a->href,
						"title" => $a->plaintext
					);
				};			

				$data_json["best"][] = $json;
			};
			$this->add_json($data_json, $page_url);
			
			$J->clear(); 
			unset($J);
			iDB::updateSQL("log", array("title" => $type, "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => $type, "res" => 0), "id={$this->log_insert_id}");
		};
	}
	
	
	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = false;
		$this->use_proxy = false;
				
		$data_article = iDB::rows("SELECT id, url, title FROM article WHERE parsed=0 AND url LIKE 'https://www.benzinga.com%' ORDER BY id LIMIT {$max_count}");
		
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
			$oArticle->url = str_replace('https://www.benzinga.comhttps://www.benzinga.com/', 'https://www.benzinga.com/', $oArticle->url);
	
			$content = $this->load( $oArticle->url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true, "related" => array( "under" => array(), "left" => array() ));
			

				// Удаляем ненужное
				if ($J->find(".article-extra", 0)) foreach ($J->find(".article-extra") as $item) $item->outertext = "";				
				
				
				if ($el = $J->find(".article-date-wrap .date", 0)) $json["str_time"] = trim($el->plaintext);
				if ($oText = $J->find(".article-content-body-only", 0)) {
					
					
					
					
					// Related links (2) - обязательно перед $json["text"] = $oText->innertext;
					if ($J->find(".article-more-stories", 0)) {
						foreach ($J->find(".article-more-stories .views-row") as $oRow) {
							$oLink = $oRow->find("a", 0);
							if (strpos($oLink->href, '/') !== 0) continue;
							
							$json["related"]["under"][] = array("url" => $this->domain . $oLink->href, "title" => trim($oLink->plaintext));
						
						};
						$J->find(".article-more-stories", 0)->outertext = "";
					};					
					
					$json["text"] = $oText->innertext;

					
					// tags 2
					if ($J->find(".article-taxonomy-bottom", 0)) {
						foreach ($J->find(".article-taxonomy-bottom a") as $oLink) {
							$json["tags2"][] = array("url" => $this->domain . $oLink->href, "title" => trim($oLink->plaintext));
						};
					};					
					
					
					foreach ($J->find(".article-related-left") as $oBlock) {
						$item_related = array();
						if ( $oLink = $oBlock->find(".title a", 0) ) 
							$item_related = array("title" => $oLink->plaintext, "url" => $this->domain . trim($oLink->href));
						
						foreach ($oBlock->find(".article") as $oBlock) {
							
							$oLink = $oBlock->find("a", 0);
							if (strpos($oLink->href, '/') !== 0) continue;
						
							$item_related["items"][] = array("title" => $oLink->plaintext, "url" => $this->domain . $oLink->href);
						};
						
						$json["related"]["left"][] = $item_related;
					};
					
					
					
					$json["text"] = trim(strip_tags($json["text"]));
				};
				
				// внутренние ссылки
				foreach ($J->find(".article-content-body-only a") as $a) {
				
					// если это stock
					if (strpos($a->href, 'https://www.benzinga.com/stock') === 0) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $a->href, "type" => "stock");
					
					// статья
					} elseif (strpos($a->href, 'https://www.benzinga.com') === 0) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $a->href, "type" => "article");
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
	

	
	function __construct() {
		parent::__construct("json/benzinga.json", "json/benzinga_block.json");
	
	}

	function __destruct() {
		parent::__destruct();
	}






}