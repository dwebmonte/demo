<?
	
require_once("functions.php");	
	
class iParser {
	public $cache = false;
	public $use_proxy = false;
	
	public $proxy;
	public $log = false;
	public $log_insert_id = false;
	public $response = null;
	
	
	
	function file_url( $url) {
		$file_url = preg_replace("#https?\:\/\/#","", $url);
		return $file_url = "files/" . preg_replace("#\W#","-", $file_url) . ".html";
	}
	
	
	function load( $url_orig) {
		
		$url = real_https($url_orig, $this->domain);
		if ($url === false) return false;
		
		$file_url = $this->file_url($url);
		
		if ( ($this->cache && !isset($_REQUEST["new"])) && file_exists( $file_url ) ) return file_get_contents( $file_url );
		
		$path = str_ireplace(basename(__FILE__),'',__FILE__);
		$coockie=$path."cookie.txt";
		$userAgent='Mozilla/7.0 (Windows; U; Windows NT 5.1; en; rv:1.9.1.3) Gecko/20090824 Firefox/7.5.3';
		//$userAgent='Mozilla/5.0 (Linux; U; Android 2.3.5; ru-ru; Philips W632 Build/GRJ90) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
		
		
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HEADER, 1);	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
		curl_setopt($ch, CURLOPT_COOKIESESSION, true); 

		
		curl_setopt($ch, CURLOPT_REFERER, 'bloomberg.com'); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
		//curl_setopt($ch, CURLOPT_COOKIEJAR, $coockie);
		//curl_setopt($ch, CURLOPT_COOKIEFILE, $coockie);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		
		if ( $this->use_proxy ) {
			$row_proxy = iDB::row('SELECT id, CONCAT(`proxy`, ":", `port`) as `proxy`, `type` FROM proxy  WHERE `banned`=0 ORDER BY RAND() LIMIT 1');
			if(is_null($row_proxy)) return false;
				
			curl_setopt($ch, CURLOPT_PROXY, $row_proxy->proxy);
			
			
			if (strpos($row_proxy->type, "SOCKS4") !== false) curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
			elseif (strpos($row_proxy->type, "SOCKS5") !== false) curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
			else curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); 
		};

		
		
		$text = curl_exec($ch); 
		//$text = iconv("CP1251", "UTF-8",$text);
		
		$info = curl_getinfo($ch);
		
		$this->response = $info["http_code"];
		
		$this->log_insert_id = iDB::insertSQL("log", array(
			"url" => $info["url"],
			"http_code" => $info["http_code"],
			"total_time" => $info["total_time"],
			"connect_time" => $info["connect_time"],
			"size_download" => $info["size_download"],
			"speed_download" => $info["speed_download"],
		));

		
		// с прокси
		if ($this->use_proxy) {
			if ($info["http_code"] == 200) {
				if (strpos($text, 'Your usage has been flagged as a violation of our') !== false) {
					iDB::update("UPDATE `proxy` SET `banned`=`banned`+1, last_error={$info["http_code"]} WHERE id={$row_proxy->id}");

					$text = false;
					if ($this->log) {
						trigger_error("<b>parser proxy banned: </b> [{$row_proxy->proxy} {$row_proxy->type}] - {$url}", E_USER_WARNING);
						flush();
					};
				} else {
					iDB::update("UPDATE `proxy` SET `success`=`success`+1, last_error={$info["http_code"]} WHERE id={$row_proxy->id}");
				
					file_put_contents($file_url, $text);
					if ($this->log) {
						trigger_error("<b>parser proxy  success: </b> [{$row_proxy->proxy} {$row_proxy->type}] - {$url}", E_USER_NOTICE);
						flush();
					};
						
				};
			} else {
				iDB::update("UPDATE `proxy` SET `error`=`error`+1, last_error={$info["http_code"]} WHERE id={$row_proxy->id}");
				$text = false;
				if ($this->log) {
					trigger_error("<b>parser proxy  error: </b> [{$row_proxy->proxy} {$row_proxy->type}] -  respose curl code = {$info["http_code"]} for url = {$url}", E_USER_WARNING);
					flush();
				};
			};
			
		// без прокси	
		} else {
			if ($info["http_code"] == 200) {
				file_put_contents($file_url, $text);
				
				if ($this->log) {
				
					trigger_error("<b>parser success: </b>success - {$url}", E_USER_NOTICE);
					flush();
				};
					
			} else {
				$text = false;
				if ($this->log) {
					trigger_error("<b>parser error: </b> respose curl code = {$info["http_code"]} for url = {$url}", E_USER_WARNING);					
					flush();
				};
					

			};
		};
		
		curl_close($ch); 	
		return $text;
	}
	
	
	function clear_html( $content ) {
		// DOCTYPE
		$content = preg_replace('#<\!DOCTYPE [^>]+? >\s*#six', '', $content);
		// <head></head>
		$content = preg_replace('#<head [^>]*? >(.+?)</head>\s*#six', '', $content);
		// <!--  -->
		$content = preg_replace('#\s*<\!\-\- (.+?) \-\->\s*#six', '', $content);
		// <script></script>
		$content = preg_replace('#<script [^>]* >(.*?)</script>#six', '', $content);
		// <noscript></noscript>
		$content = preg_replace('#<noscript [^>]* >(.*?)</noscript>#six', '', $content);

		$content = preg_replace('#<(\w+)/>#six', '</$1>', $content);
		
		return html_entity_decode($content);
	}
	
	
	
	function add_json($json, $url) {
		foreach ($json as $block_name => $block) {
			
			
			
			// определяем block_id
			$md5_block = array( $block_name, $url );
			foreach ($block as $article) {
				if (!isset($article["url"])) {
				
					var_dump($block);
					trigger_error("url is not defined", E_USER_ERROR);
				};
				
				$md5_block[] = $article["url"];
				
			};
			$md5_block = md5( implode(" ", $md5_block) );
			$block_id = iDB::insertSQL("block", array("md5" => $md5_block, "name" => $block_name, "url" => $url));
			
			// добавляем статьи в блок
			if ($block_id != 0) {
				$data_article = array();
			
				foreach ($block as $article) {
					$data_article[] = array("block_id" => $block_id, "article_id" => $this->add_article($article));
				};
				
				iDB::insertDataSQL("block_item", $data_article);
			};
		};
	}
	
	function add_article($article) {
		$article["url"] = real_https(trim($article["url"]), $this->domain);
		$article["title"] = trim($article["title"]);
	
		$md5 = md5( $article["url"] );
		$article_id = iDB::value("SELECT id FROM article WHERE md5=" . iS::sq( $md5 ));
		
		if (is_null( $article_id )) {
			$article["md5"] = md5( $article["url"] );
			$article["time_added"] = date("c");
			$article_id = iDB::insertSQL( "article", $article );
		} else {
			iDB::update("UPDATE article SET title=". iS::sq($article["title"]) ." WHERE id={$article_id}");
		};		
		
		return $article_id;
	}
	
	function update_proxy() {
		$data_proxy = array();
		foreach (glob("classes/hidemyna.me/*.html") as $filename) {
			$J = file_get_html($filename);
			foreach ($J->find(".proxy__t tr") as $key => $item) {
				if ($key == 0) continue;
				
				$proxy = trim($item->find("td", 0)->plaintext);
				$port = trim($item->find("td", 1)->plaintext);
				$country = trim(str_replace('&nbsp;', '', $item->find("td", 2)->plaintext));
				$type = trim($item->find("td", 4)->plaintext);
				
				$data_proxy[] = array("proxy" => $proxy, "port" => $port, "country" => $country, "type" => $type);
			};
			unlink( $filename );
			
		};
		if (count($data_proxy)>0) iDB::insertDataSQL("proxy", $data_proxy);
	}
	
	
	
	function __construct( ) {
		if (!file_exists(ROOT . "classes/proxy.json")) file_put_contents(ROOT . "classes/proxy.json", json_encode(array()));
		$this->proxy = json_decode(file_get_contents( ROOT . "classes/proxy.json" ), true);		
		
		
		//iDB::exec("TRUNCATE article");		iDB::exec("TRUNCATE block");		iDB::exec("TRUNCATE block_item");
		
	}
	
	function __destruct() {
		file_put_contents(ROOT . "classes/proxy.json", json_encode( $this->proxy ));	
	}
	
	
	
	
	
	
};