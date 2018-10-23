<?php
class korrespondent extends iParser {
	public $domain = "https://korrespondent.net";	
	
	
	
	// последние новости
	function parse_last() {
	
		$last_time = iDB::value("SELECT `value` FROM `options` WHERE name='last time for korrespondent'");
		if (empty( $last_time )) $last_time = time();
		$date = mb_strtolower(date('Y/F/d', $last_time));
		
		$page_url = "https://korrespondent.net/all/{$date}/print/";
	
		$this->cache = true;
	
		$content = $this->load($page_url);
		if (!empty($content)) {
			$J = str_get_html($content);
			$json = array();
			
			
			// Берем все url
			$data_url = array();
			
			if ($el = $J->find(".pagination_news", 0)) {
				foreach ($J->find(".pagination_news .pagination__item") as $oItem) {
					$url = $oItem->find("a", 0)->href;
					if (!empty($url)) $data_url[ $url ] = $url;
				};
			};
			
			// перебор всех страниц и получение сслок
			if (count($data_url) > 0) {
				foreach ($data_url as $url) {
					$content = $this->load($url);
					if (!empty($content)) {
						$J = str_get_html($content);

						foreach ($J->find(".article_short") as $oArticle) {
							
							$date_publish = $oArticle->find(".article__date", 0)->plaintext;
							$date_publish = explode("-", $date_publish);
							$date_publish = str_ireplace('&nbsp;', ' ', trim($date_publish[ count($date_publish)-1 ]));
							
							$json = array(
								"title" => $oArticle->find("h2 a", 0)->plaintext,
								"url" => $oArticle->find("h2 a", 0)->href,
								"category" => $oArticle->find(".article__rubric", 0)->plaintext,
								"str_time" => $date_publish,
							);
							$temp = explode(",", $date_publish);
							$json["time_added"] = date('Y-m-d', $last_time) . " " . $temp[1];

							$json["md5"] = md5( $json["url"] );
					
							iDB::insertSQL( "article_korr", $json );
						};
			
			
						$J->clear(); 
						unset($J);			
					}
				};
			};
			
			
			$last_time = strtotime("-1 day", $last_time);
			iDB::update("UPDATE `options` SET `value`='{$last_time}'  WHERE name='last time for korrespondent'");
		};	
	}
	
	
	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = true;
		$this->use_proxy = false;
				
		$data_article = iDB::rows("SELECT id, url, title FROM article_korr WHERE parsed=0 ORDER BY RAND() LIMIT {$max_count}");
		
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
	
			$content = $this->load( $oArticle->url );
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true );

				// Удаляем ненужное
				if ($J->find("iframe", 0)) foreach ($J->find("iframe") as $item) $item->outertext = "";				
				if ($J->find("em", 0)) foreach ($J->find("em") as $item) $item->outertext = "";				
				if ($J->find(".post-item__photo", 0)) foreach ($J->find(".post-item__photo") as $item) $item->outertext = "";				
				if ($J->find("script", 0)) foreach ($J->find("script") as $item) $item->outertext = "";				
				
				
				$json["text"] = trim( strip_tags($J->find(".post-item__text", 0)->innertext ));
				$json["text"] = preg_replace('#\s+#six', ' ', $json["text"]);
				
				$temp = explode(". Напомним,", $json["text"]);
				if (count($temp) > 1) $json["text"] = $temp[0] . ".";
				
				$temp = explode(". Ранее", $json["text"]);
				if (count($temp) > 1) $json["text"] = $temp[0] . ".";		
				
				$json["sub_title"] = trim( $J->find(".post-item__text h2", 0)->innertext );
				
				$json["response"] = $this->response;
				
				iDB::updateSQL("article_korr", $json, "id={$oArticle->id}");				
			};
		};
			
			

	}		
	
	
}