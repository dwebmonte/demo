<?php
// ('p[class=color-9 lheight16 marginbott5 x-normal]')	
	
class reuters extends iParser {
	public $domain = "https://www.reuters.com";	
	
	
	
	// Главная страница
	function parse_main() {		
		$this->cache = false;
	
		$content = $this->load($page_url = "https://www.reuters.com");
		
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
			
			// Top
			if ($el = $J->find(".story-title a", 0)) { $json["top"][] = array("title" => trim($el->plaintext), "url" => $this->domain . $el->href);};		
			
			
			// Top 2
			foreach ($J->find("#hp-top-news-top article") as $key => $item) {
				$json["top2"][] = array("title" => trim($item->find("a", 0)->plaintext), "url" => $this->domain . $item->find("a", 0)->href);		
			};

			// Wire
			foreach ($J->find("#hp-wire article") as $key => $item) {
				$json["wire"][] = array("title" => trim($item->find("a", 0)->plaintext), "url" => $this->domain . $item->find("a", 0)->href);		
			};			
			 
			// Top 3
			foreach ($J->find("#hp-top-news-low article") as $key => $item) {
				$json["top3"][] = array("title" => trim($item->find(".story-content a", 0)->plaintext), "url" => $this->domain . $item->find(".story-content a", 0)->href);		
			};				 
			
			// Top по категориям
			foreach ($J->find("#rcs-mainContentBottom .module-news-headline-row") as $key => $section) {
				$cat_title = trim($section->find(".module-heading a", 0)->plaintext);
				foreach ($section->find("article") as $key => $item) {
					$json[ $cat_title ][] = array("title" => trim($item->find(".story-content a", 0)->plaintext), "url" => $this->domain . $item->find(".story-content a", 0)->href);		
				};			
			};				 
			
			$this->add_json($json, $page_url);
			
			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => "start page", "res" => 1), "id={$this->log_insert_id}");
		};
		iDB::updateSQL("log", array("title" => "start page", "res" => 0), "id={$this->log_insert_id}");
	}

	
	// Страница финансов
	function parse_finance() {		
		$this->cache = false;
		
		$content = $this->load($page_url = "https://www.reuters.com/finance");
		
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
		
			
			// Top
			if ($el = $J->find("#topStory h2 a", 0)) { $json["top"][] = array("title" => trim($el->plaintext), "url" => $this->domain . $el->href);};		
			
			
			// Top 2
			foreach ($J->find("#latestHeadlines ul li") as $key => $item) {
				$json["top2"][] = array("title" => trim($item->find("a", 0)->plaintext), "url" => $this->domain . $item->find("a", 0)->href);		
			};

			// Top 3
			foreach ($J->find("#moreSectionNews .feature") as $key => $item) {
				$json["top3"][] = array("title" => trim($item->find("a", 0)->plaintext), "url" => $this->domain . $item->find("a", 0)->href);		
			};				 
			
			$this->add_json($json, $page_url);
			
			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => "finance", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "finance", "res" => 0), "id={$this->log_insert_id}");
		};
	}	
	
	// Последние новости финансов
	function parse_finance_last() {		
		$this->cache = false;
		
		$content = $this->load($page_url = "https://www.reuters.com/news/archive/businessNews?view=page");
		
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();

			foreach ($J->find(".news-headline-list  article") as $key => $item) {
				$json = array("title" => trim($item->find(".story-content a", 0)->plaintext), "url" => $this->domain . $item->find(".story-content a", 0)->href, "parsed" => false);
				$this->add_article( array("url" => $json["url"], "title" => $json["title"]) );
			};				 
			
			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => "business news", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "business news", "res" => 0), "id={$this->log_insert_id}");
		};
	}	
	

	
	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = false;
		
		$data_article = iDB::rows("SELECT id, title, url FROM article WHERE parsed=0 AND url LIKE 'https://www.reuters.com%' ORDER BY id LIMIT {$max_count}");
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
		
			$oArticle->url = str_replace('https://www.reuters.com//www.reuters.com', 'https://www.reuters.com', $oArticle->url);
		
			$content = $this->load( $oArticle->url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true);
			
			
				if ($el = $J->find(".ArticleHeader_date", 0)) {
					$temp = explode("/", $el->plaintext);
					$json["str_time"] = $temp[0] . '/' . $temp[1];
					
					
				};
				if ($el = $J->find(".ArticleHeader_channel a", 0)) $json["category"] = $el->plaintext;
				
			
				//$json["title"] = $J->find(".ArticleHeader_headline", 0)->plaintext;
				
				// удаляем все ненужное
				
				$J->find(".PrimaryAsset_container", 0)->innertext = "";
				$J->find(".Image_container", 0)->innertext = "";
				$J->find(".StandardArticleBody_trustBadgeContainer", 0)->innertext = "";
				$J->find(".Attribution_container", 0)->innertext = "";

				
				$json["text"] = $J->find(".StandardArticleBody_body", 0)->plaintext;
				
				$json["response"] = $this->response;
				iDB::updateSQL("article", $json, "id={$oArticle->id}");
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 1), "id={$this->log_insert_id}");
			} else {
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 0), "id={$this->log_insert_id}");
			};
		};
	}
	
	
	
	
	
	function __construct() {
		//@unlink( ROOT . "json/reuters.json");
		//@unlink( ROOT . "json/reuters_block.json");
		
		parent::__construct("json/reuters.json", "json/reuters_block.json", "json/reuters_article.json");
	
	}

	function __destruct() {
		parent::__destruct();
	}






}
