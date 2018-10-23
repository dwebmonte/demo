 <?php
// ('p[class=color-9 lheight16 marginbott5 x-normal]')	
	
class marketwatch extends iParser {
	public $domain = "https://www.marketwatch.com";	
	
	
	
	// Главная страница
	function parse_main() {		
		$this->cache = false;

	
		$content = $this->load($page_url = "https://www.marketwatch.com");
		if (!empty($content)) {
			$J = str_get_html($content);

			// Топ новость
			$oHeader = $J->find(".curated1 .article__headline a", 0);
			
			$title = trim($oHeader->plaintext);
			$url = $this->domain . $oHeader->href;
			
			$json["top"][] = array("title" => $title, "url" => $url);
			
			// Топ 2 - второй блок справа
			foreach ($J->find(".curated1 li .list--bullets", 1)->find("a") as $a) {
				$title = trim($a->plaintext);
				$url = $this->domain . $a->href;

				$json["top2"][] = array("title" => $title, "url" => $url);
			};
			
			
			$this->add_json($json, $page_url);
			
			$J->clear(); 
			unset($J);
			iDB::updateSQL("log", array("title" => "start page", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "start page", "res" => 0), "id={$this->log_insert_id}");
		};
	}
	
	function parse_page($page_url) {
		$this->cache = false;
	
		$content = $this->load($page_url);
		if (!empty($content)) {
			$J = str_get_html($content);

			foreach ($J->find(".foreverblock .viewport", 0)->find("li") as $item) {
				$el = $item->find("h4 a", 0);	if (!$el) continue;

				$title = trim($el->plaintext);
				$url = $this->domain . $el->href;
				
				$this->add_article( array("url" => $url, "title" => $title) );
			};

			
			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => "last news", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "last news", "res" => 0), "id={$this->log_insert_id}");
		};
	
	
	
	
	
	}



	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = true;
		$this->use_proxy = false;
				
		$data_article = iDB::rows("SELECT id, url, title FROM article WHERE parsed=0 AND url LIKE 'https://www.marketwatch.com%' ORDER BY id LIMIT {$max_count}");
		
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
			$oArticle->url = str_replace('https://www.marketwatch.comhttps://www.marketwatch.com/', 'https://www.marketwatch.com/', $oArticle->url);
			
			if (strpos($oArticle->url, 'https://www.marketwatch.com/') !== 0) {
				iDB::exec("DELETE FROM article WHERE id={$oArticle->id}");
				continue;
			};
	
			$content = $this->load( $oArticle->url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true);
			

			
				// related_topics !!! обзяательно до удаления ненужного мусора
				if ($el = $J->find(".related_topics ul", 0)) {
					foreach ($el->find("li") as $item) {
						$a = $item->find("a", 0);
						
						$json["related"][] = array("title" => $a->plaintext, "url" => $this->domain . $a->href);
				
					};
				};
				
				// Удаляем ненужное
				if ($J->find(".inset", 0)) foreach ($J->find(".inset") as $item) $item->outertext = "";				
				if ($el = $J->find("#signUpForm", 0)) $el->outertext = "";				
				if ($el = $J->find("#author-commentPromo", 0)) $el->outertext = "";
				if ($el = $J->find("#comment-promo", 0)) $el->outertext = "";
				
				
				if ($el = $J->find(".sa-captivate-box", 0))  foreach ($J->find(".sa-captivate-box") as $item) $item->outertext = "";	
				if ($el = $J->find(".related_topics", 0)) foreach ($J->find(".related_topics") as $item) $item->outertext = "";	

				
				if ($el = $J->find("#article-headline", 0)) $json["title"] = trim($el->plaintext);
				if ($el = $J->find("#article-subhead", 0)) $json["sub_title"] = trim($el->plaintext);
				if ($el = $J->find("#published-timestamp span", 0)) $json["str_time"] = trim($el->plaintext);
				
				
				
				//$json["text"] = preg_replace('#\s+#six', ' ', trim(strip_tags( $J->find("#article-body", 0)->innertext )));
				$json["text"] =  preg_replace('#\s+#six', ' ', trim($J->find("#article-body", 0)->plaintext));
				
				
				// внутренние ссылки
				foreach ($J->find("#article-body a") as $a) {
				
					// если это статья
					if (strpos($a->href, '/story') === 0) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $this->domain . $a->href, "type" => "article");
					
					// компания
					} elseif (strpos($a->href, '/investing') === 0) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $this->domain . $a->href, "type" => "company");

					// другое	
					} elseif (strpos($a->href, '/') === 0) {
						$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $this->domain . $a->href, "type" => "other");
						
					};
					
				};				
				
				$json["response"] = $this->response;
				iDB::updateSQL("article", $json, "id={$oArticle->id}");
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 1), "id={$this->log_insert_id}");
			} else {
				iDB::updateSQL("article", array("response" => $this->response, "parsed" => 2), "id={$oArticle->id}");
				iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 0), "id={$this->log_insert_id}");
			};
			
			
		};
	}		
	
	
	
	function __construct() {
		parent::__construct("json/marketwatch.json", "json/marketwatch_block.json");
	
	}

	function __destruct() {
		parent::__destruct();
	}






}