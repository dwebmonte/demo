 <?php
// ('p[class=color-9 lheight16 marginbott5 x-normal]')	

class zacks extends iParser {
	public $domain = "https://www.zacks.com";	
	
	
	
	// Главная страница
	function parse_main() {		
		$this->cache = false;
	
		$content = $this->load($page_url = "https://www.zacks.com/");
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
			
			// Топ новость
			$item = $J->find("#top_stories article a", 0);
			$json["top"][] = array("title" => trim($item->plaintext), "url" => $item->href);

			// Топ 2 - второй блок справа
			foreach ($J->find("#slider_wrapper", 0)->find("article") as $item) {
				$el = $item->find("a", 0);	if (!$el) continue;
				$json["top2"][] = array("title" => trim($el->plaintext), "url" => $el->href);
			};
			
			
			foreach ($J->find("#investment_ideas section") as $oSection) {
				$category_title = $oSection->find("h1", 0)->plaintext;
				
				foreach ($oSection->find("h1 a") as $oLink) {
					$title = $oLink->plaintext;
					$url = 'https:' . $oLink->href;
					
					if ($title == $category_title) continue;
					
					$json[$category_title][] = array("title" => $title, "url" => $url);
				};
			
			};
			
			
			$this->add_json($json, $page_url);
			
			$J->clear(); 
			unset($J);
			iDB::updateSQL("log", array("title" => "start page", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "start page", "res" => 0), "id={$this->log_insert_id}");
		};
	}
	
	function parse_articles() {
		$this->cache = false;
	
		$content = $this->load($page_url = "https://www.zacks.com/articles/index.php");
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();

			foreach ($J->find("#content .listitempage", 0)->find(".listitem") as $item) {
				$el = $item->find("h1 a", 0);	if (!$el) continue;

				$title = trim($el->plaintext);
				$url = $this->domain . $el->href;
				
				$this->add_article( array("url" => $url, "title" => $title) );
			};

			// последние статьи
			foreach ($J->find("#latest_topics", 0)->find("article") as $item) {
				$el = $item->find("a", 0);	if (!$el) continue;

				$title = trim($el->plaintext);
				$url = $this->domain . $el->href;
				
				$json["trand_article"][] = array("title" => $title, "url" => $url);
			};
			
			
			// популярные статьи
			foreach ($J->find("#popular_topics", 0)->find("article") as $item) {
				$el = $item->find("a", 0);	if (!$el) continue;

				$title = trim($el->plaintext);
				$url = $this->domain . $el->href;
				
				$json["popular_article"][] = array("title" => $title, "url" => $url);
			};			
			
			$this->add_json($json, $page_url);
			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => "articles", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "articles", "res" => 0), "id={$this->log_insert_id}");
		};
	
	
	
	
	
	}


	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = false;
		$this->use_proxy = false;
				
		$data_article = iDB::rows("SELECT id, url, title FROM article WHERE parsed=0 AND url LIKE 'https://www.zacks.com%' ORDER BY id LIMIT {$max_count}");
		
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
			$oArticle->url = str_replace('https://www.zacks.comhttps://www.zacks.com/', 'https://www.zacks.com/', $oArticle->url);
	
			$content = $this->load( $oArticle->url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true);
			
				if ($el = $J->find(".byline time", 0)) $json["str_time"] = $el->plaintext;
				if ($el = $J->find("#comtext", 0)) $json["text"] = trim($el->plaintext);
				if ($el = $J->find("#z2_more_from_zacks_category h1", 0)) $json["category"] = trim(str_ireplace('More from Zacks', '', $el->plaintext));
			
				$json["response"] = $this->response;
				iDB::updateSQL("article", $json, "id={$oArticle->id}");				
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 1), "id={$this->log_insert_id}");
			} else {
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 0), "id={$this->log_insert_id}");
				
				if ($this->response != 0) {
					iDB::updateSQL("article", array("parsed" => 2), "id={$oArticle->id}");
				};
			};
			
			
		};
	}	
	
	function __construct() {
		//unlink( ROOT . "json/zacks.json");
		//unlink( ROOT . "json/zacks_block.json");
		parent::__construct();
	
	}

	function __destruct() {
		parent::__destruct();
	}






}

