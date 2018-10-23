<?php
// ('p[class=color-9 lheight16 marginbott5 x-normal]')	
	
class bloomberg extends iParser {
	public $domain = "https://www.bloomberg.com";	
	
	
	
	// Главная страница
	function parse_main($url = "https://www.bloomberg.com") {		
		$this->cache = false;
		$this->use_proxy = true;
	
		$this->update_proxy();
	
		$content = $this->load( $url );
		
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
			$date = date("c");
			
			// Top
			if ($el = $J->find(".single-story-module__info", 0)) {
				foreach ($el->find("a") as $key => $item) {
					$json["top"][] = array("title" => trim($item->plaintext), "url" => $this->domain . $item->href);		
				};
			};
			
			// under top
			if ($el = $J->find("#hub_story_package", 0)) {
				foreach ($el->find("article") as $key => $item) $json["top2"][] = array(
					
					"title" => trim($item->find("h3 a", 0)->plaintext), 
					"url" => $this->domain . $item->find("h3 a", 0)->href
				);						
			};
						
		
			foreach ($J->find(".story-package-module") as $key_section => $oSection) {
				if (!$oSection->find("h2", 0)) continue;
				$section_title = $oSection->find("h2", 0)->plaintext;
				
				
				foreach ($oSection->find("h3 a") as $key => $item) $json[ $section_title ][] = array("title" => trim($item->plaintext), "url" => $this->domain . $item->href);
			};
			
			
			$this->add_json($json, $url);
			
			
			$J->clear(); 
			unset($J);
		};
	}
	
	// markets
	function parse_markets() {		
		$this->cache = false;
		$this->use_proxy = true;

		$content = $this->load($page_url = "https://www.bloomberg.com/markets");
		
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
			$date = date("c");
			
			// Top
			if ($el = $J->find(".single-story-module__info", 0)) {
				foreach ($el->find("a") as $key => $item) $json["top"][] = array("title" => trim($item->plaintext), "url" => $this->domain . $item->href);		
			};
			
			// last
			if ($el = $J->find("#hub_story_list", 0)) {
				foreach ($el->find("article") as $key => $item) {
					if (!$item->find("a", 0)) continue;
					$json["last"][] = array("title" => trim($item->find("a", 0)->plaintext), "url" => $this->domain . $item->find("a", 0)->href);								
				};
			};
			
			// top2
			if ($el = $J->find("#4_up_with_heds", 0)) {
				foreach ($el->find("article") as $key => $item) $json["top2"][] = array(
					"title" => trim($item->find("h3 a", 0)->plaintext), 
					"url" => $this->domain . $item->find("h3 a", 0)->href
				);						
			};			
			
			// top3 с фото
			if ($el = $J->find("#4_up_with_images", 0)) {
				foreach ($el->find("article") as $key => $item) $json["top3"][] = array(
					"title" => trim($item->find("h3 a", 0)->plaintext), 
					"url" => $this->domain . $item->find("h3 a", 0)->href
				);						
			};				
			
			// top4 без фото
			if ($el = $J->find("#_up_with_heds_1", 0)) {
				foreach ($el->find("article") as $key => $item) $json["top4"][] = array(
					"title" => trim($item->find("h3 a", 0)->plaintext), 
					"url" => $this->domain . $item->find("h3 a", 0)->href
				);						
			};				
			
			// нижний список
			if ($el = $J->find("#crypto", 0)) {
				foreach ($el->find("article") as $key => $item) $json["crypto"][] = array(
					"title" => trim($item->find("h3 a", 0)->plaintext), 
					"url" => $this->domain . $item->find("h3 a", 0)->href
				);						
			};				
			
			// нижний список
			if ($el = $J->find("#hub_story_list_1", 0)) {
				foreach ($el->find("article") as $key => $item) {
				if (!$item->find("a", 0)) continue;
					$json["bottom_list"][] = array(
						"title" => trim($item->find("a", 0)->plaintext), 
						"url" => $this->domain . $item->find("a", 0)->href
					);						
				};
			};							

			$this->add_json($json, $page_url);
			
			$J->clear(); 
			unset($J);
		};
	}
	
	// tech
	function parse_tech() {
		$this->cache = false;
		$this->use_proxy = true;

		$content = $this->load($page_url = "https://www.bloomberg.com/technology");
		
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();

			
			// Top
			if ($el = $J->find(".single-story-module__info", 0)) {
				foreach ($el->find("a") as $key => $item) $json["top"][] = array("title" => trim($item->plaintext), "url" => $this->domain . $item->href);		
			};
			
			// top2
			if ($el = $J->find("#4_up_heds_and_deks", 0)) {
				foreach ($el->find("article") as $key => $item) $json["top2"][] = array(
					"title" => trim($item->find("h3 a", 0)->plaintext), 
					"url" => $this->domain . $item->find("h3 a", 0)->href
				);						
			};					
			
			// Global Tech News 
			if ($el = $J->find("#story_list_4", 0)) {
				foreach ($el->find("article") as $key => $item) {
					if (!$item->find("a", 0)) continue;
					$json["global"][] = array("title" => trim($item->find("a", 0)->plaintext), "url" => $this->domain . $item->find("a", 0)->href);								
				};
			};			
			
			// top3 с фото
			if ($el = $J->find("#4_up_images", 0)) {
				foreach ($el->find("article") as $key => $item) {
					if (!$item->find("h3 a")) continue;
					
					$json["top3"][] = array(
						"title" => trim($item->find("h3 a", 0)->plaintext), 
						"url" => $this->domain . $item->find("h3 a", 0)->href
					);						
				};
			};	
			
			// top4 с фото
			if ($el = $J->find("#3_up_with_images", 0)) {
				foreach ($el->find("article") as $key => $item) {
					if (!$item->find("h3 a")) continue;
					
					$json["top4"][] = array(
						"title" => trim($item->find("h3 a", 0)->plaintext), 
						"url" => $this->domain . $item->find("h3 a", 0)->href
					);						
				};
			};			
			
			
			// Парсим блоки с категриями
			foreach ($J->find(".story-package-module") as $oSection) {
				if (!$oSection->find("h2", 0)) continue;
			
				$section_title = $oSection->find("h2", 0)->plaintext;
				
				foreach ($oSection->find("article") as $key => $item) $json[ $section_title ][] = array(
					"title" => trim($item->find("h3 a", 0)->plaintext), 
					"url" => $this->domain . $item->find("h3 a", 0)->href
				);
			};

			
			$this->add_json($json, $page_url);
			
			$J->clear(); 
			unset($J);
		};	
	
	
	
	
	
	
	}
	
	// economics
	function parse_economics() {		
		$this->cache = false;
		$this->use_proxy = true;

		$content = $this->load($page_url = "https://www.bloomberg.com/markets/economics");
		
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
			$date = date("c");
			
			// Top
			if ($el = $J->find(".single-story-module__info", 0)) {
				foreach ($el->find("a") as $key => $item) $json["top"][] = array("title" => trim($item->plaintext), "url" => $this->domain . $item->href);		
			};			
			
			// top2
			if ($el = $J->find("#story_package", 0)) {
				foreach ($el->find("article") as $key => $item) {
					if (!$item->find("a", 0)) continue;
					$json["top2"][] = array(
						"title" => trim($item->find("a", 0)->plaintext), 
						"url" => $this->domain . $item->find("a", 0)->href
					);						
				};
			};				
			
			// top3
			if ($el = $J->find("#story_package_1", 0)) {
				foreach ($el->find("article") as $key => $item) {
					if (!$item->find("a", 0)) continue;
					$json["top3"][] = array(
						"title" => trim($item->find("a", 0)->plaintext), 
						"url" => $this->domain . $item->find("a", 0)->href
					);						
				};
			};				
			
			// bottom_list
			if ($el = $J->find("#hub_story_list_2", 0)) {
				foreach ($el->find("article") as $key => $item) {
					if (!$item->find("a", 0)) continue;
					$json["bottom_list"][] = array(
						"title" => trim($item->find("a", 0)->plaintext), 
						"url" => $this->domain . $item->find("a", 0)->href
					);						
				};
			};				


			$this->add_json($json, $page_url);
			
			
			$J->clear(); 
			unset($J);
		};
	}	
	
	
	
	
	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = false;
		$this->use_proxy = true;
		
		
		$data_article = iDB::rows("SELECT id, url FROM article WHERE parsed=0 AND url LIKE 'https://www.bloomberg.com%' ORDER BY id LIMIT {$max_count}");
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
		
			$oArticle->url = str_replace('https://www.bloomberg.comhttps://www.bloomberg.com', 'https://www.bloomberg.com', $oArticle->url);
		
			$content = $this->load( $oArticle->url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true);
			

				// категория
				if ($el = $J->find(".eyebrow-v2", 0)) $json["category"] = trim($el->plaintext);

				// заголовок
				if ($el = $J->find(".lede-text-v2__hed", 0)) {
					$json["title"] = trim($el->plaintext);
					if ($el = $J->find(".lede-text-v2__dek", 0)) $json["sub_title"] = trim($el->plaintext);
				} elseif ($el = $J->find(".lede-text-only__hed", 0)) {
					$json["title"] = trim($el->plaintext);
				};
				if ($el = $J->find(".article-timestamp", 0)) $json["str_time"] = trim(str_ireplace('EDT', '', $el->plaintext));
				
		
				// ключевые моменты статьи (вверху)
				if ($el = $J->find(".abstract-v2__item-text")) foreach ($el as $item) $json["key_point"][] = trim($item->plaintext);
				elseif ($el = $J->find(".lede-text-only__dek .lede-text-only__highlight")) foreach ($el as $item) $json["key_point"][] = trim($item->plaintext); 
				
				
				// Удаляем внизу текста ненужное
				if ($J->find(".fence-body .disclaimer", 0)) $J->find(".fence-body .disclaimer", 0)->outertext = "";
				if ($J->find(".fence-body .news-rsf-contact-author", 0)) $J->find(".fence-body .news-rsf-contact-author", 0)->outertext = "";
				if ($J->find(".fence-body .news-rsf-contact-editor", 0)) $J->find(".fence-body .news-rsf-contact-editor", 0)->outertext = "";
				if ($J->find(".fence-body .trashline", 0)) $J->find(".fence-body .trashline", 0)->outertext = "";
				
				// удаляем фото
				if ($J->find("figure")) foreach ($J->find("figure") as $item) $item->outertext = " ";

				
				// Удаляем левый блок перед записью текста
				if ($J->find(".middle-column .body-copy-v2 .left-column", 0)) $J->find(".middle-column .body-copy-v2 .left-column", 0)->outertext = "";
				
				if ($el = $J->find(".fence-body", 0)) {
					$text = trim($el->innertext);
					$json["text"] = trim(strip_tags( $text ));			
					
					
					// внутренние ссылки
					foreach ($J->find(".fence-body a") as $a) {
						// если это статья
						if (strpos($a->href, 'https://www.bloomberg.com/news') === 0) {
							if (!isset($this->CD[ md5($a->href) ])) {
								$this->CD[ md5($a->href) ][] = array("title" => $a->plaintext, "url" => $a->href, "parsed" => false);
							};
							$json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $a->href, "type" => "article");
						
						// компания
						} elseif (strpos($a->href, '/quote/') === 0) $json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $this->domain . $a->href, "type" => "company");
						
						// разное
						elseif (strpos($a->href, '/') === 0) $json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $this->domain . $a->href, "type" => "other");
						elseif (strpos($a->href, 'https://www.bloomberg.com') === 0) $json["inner_url"][] = array("title" => trim($a->plaintext), "url" => $a->href, "type" => "other");
						
					};
					
				};
				
				iDB::updateSQL("article", $json, "id={$oArticle->id}");
			};
			
			
		};
	}

	
	function __construct() {
		parent::__construct("json/bloomberg.json", "json/bloomberg_block.json", "json/bloomberg_article.json");
	
	}

	function __destruct() {
		parent::__destruct();
	}






}