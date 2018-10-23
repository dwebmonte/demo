 <?php
// ('p[class=color-9 lheight16 marginbott5 x-normal]')	

class seekingalpha extends iParser {
	public $domain = "https://seekingalpha.com";	
	
	
	
	// Главная страница
	function parse_main() {		
		$this->cache = true;
	
		$content = $this->load("https://www.marketwatch.com");
		if (!empty($content)) {
			$J = str_get_html($content);
			$date = gmdate("c");

			// Топ новость
			$oHeader = $J->find(".curated1 .article__headline a", 0);
			
			$title = trim($oHeader->plaintext);
			$url = $this->domain . $oHeader->href;
			
			$this->CDB["top"][ $date ][] = md5($url);
			if (!isset($this->CD[ md5($url) ])) $this->CD[ md5($url) ] = array("title" => $title, "url" => $url, "time" => $date, "parsed" => false);			


			// Топ 2 - второй блок справа
			foreach ($J->find(".curated1 li .list--bullets", 1)->find("a") as $a) {
				$title = trim($a->plaintext);
				$url = $this->domain . $a->href;

				$this->CDB["top2"][ $date ][] = md5($url);
				if (!isset($this->CD[ md5($url) ])) $this->CD[ md5($url) ] = array("title" => $title, "url" => $url, "time" => $date, "parsed" => false);			
			};
			
			
			// var_dump($title, $url);
			
			$J->clear(); 
			unset($J);
		};
	}
	
	function parse_page($url) {
		$this->cache = true;
	
		$content = $this->load($url);
		if (!empty($content)) {
			$J = str_get_html($content);
			$date = gmdate("c");


			foreach ($J->find("#articles-list", 0)->find("li") as $item) {
				$el = $item->find(".a-title", 0);	if (!$el) continue;

				$title = trim($el->plaintext);
				$url = $this->domain . $el->href;
				
				var_dump($title, $url);
				
				// if (!isset($this->CD[ md5($url) ])) $this->CD[ md5($url) ] = array("title" => $title, "url" => $url, "time" => $date, "parsed" => false);			
			};

			
			$J->clear(); 
			unset($J);
		};	
	
	
	
	
	
	}



	
	function __construct() {
		unlink( ROOT . "json/marketwatch.json");
		unlink( ROOT . "json/marketwatch_block.json");
		parent::__construct("json/marketwatch.json", "json/marketwatch_block.json");
	
	}

	function __destruct() {
		parent::__destruct();
	}






}

