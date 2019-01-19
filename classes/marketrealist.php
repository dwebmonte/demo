<?php
	
class marketrealist {
	public $cache = true;


	
	
	
	
	
	
	function load_article( $category_uid, $limit = 500, $from = 0 ) {
		$data_category = $data_article_cat = array();
		
		$data = $this->load( $category_uid, $limit, $from );
		if ($data === false || count($data) == 0) return false;
		

		
		foreach ($data as $key_block => $item_block) {

			// Заносим категории
			
			$data_category_curr = array();
			
			foreach ($item_block->category as $key_category => $item_category) {
				$data_category_curr[] = $data_category[] = array(
					"id" => $item_category->wpid,
					"description" => $item_category->description,
					"title" => $item_category->name,
					"slug" => $item_category->slug,
					"parent_uid" => isset($item_category->parent) ? $item_category->parent : "",
					"uid" => $item_category->id,
					"level" => isset($item_category->lvl) ? $item_category->lvl : 0,
				);
			};
			
			
			// Обрабатываем статьи
			foreach ($item_block->posts as $key_post => $item_post) {
				$data_article[] = array(
					"id" => $item_post->wpid,
					"title" => $item_post->title,
					"excerpt" => strip_tags($item_post->excerpt),
					"text" => $item_post->content,
					"published" => $item_post->published_date,
				);
				
				// Добавляем связи статей и категорий
				foreach ($data_category_curr as $key_category_curr => $item_category_curr) {
					$data_article_cat[] = array(
						"article_id" => $item_post->wpid,
						"category_id" => $item_category_curr["id"],
						"level" => $key_category_curr
					);
				};
			
			};
			
			if (count($data_article) > 0) iDB::insertDataSQL( "marketrealist_article", $data_article );			
			
		};

		
		if (count($data_category) > 0) iDB::insertDataSQL( "marketrealist_category", $data_category );			
		if (count($data_article_cat) > 0) iDB::insertDataSQL( "marketrealist_article_cat", $data_article_cat );			

		return count($data);
	}	
	
	
	
	
	
	
	function load_category( $category_uid, $limit = 500, $from = 0 ) {
		$data_category = array();
		
		$data = $this->load( $category_uid, $limit, $from );
		if ($data === false) return false;
		
		$count_data = count($data);
		trigger_error("data count for uid=\"{$category_uid}\" = {$count_data}");
		
		foreach ($data as $key_block => $item_block) {
		
			foreach ($item_block->category as $key_category => $item_category) {
				$data_category[] = array(
					"id" => $item_category->wpid,
					"description" => $item_category->description,
					"title" => $item_category->name,
					"slug" => $item_category->slug,
					"parent_uid" => isset($item_category->parent) ? $item_category->parent : "",
					"uid" => $item_category->id,
					"level" => isset($item_category->lvl) ? $item_category->lvl : 0,
				);
				
			};
		};

		
		if (count($data_category) > 0) iDB::insertDataSQL( "marketrealist_category", $data_category );			
		iDB::update("UPDATE marketrealist_category SET `updated`=1 WHERE uid=" . iS::sq($category_uid));
	}
	
	

	function load( $category_uid, $limit = 500, $from = 0) {
		$url = 'https://api.marketrealist.com/api/serie-category/'. $category_uid .'?limit='. $limit .'&skip='. $from;		
		
		$file_url = $this->file_url($url);
		
		if ( ($this->cache && !isset($_REQUEST["new"])) && file_exists( $file_url ) ) {
			$text =  file_get_contents( $file_url ); 
		} else {
			$text =  file_get_contents( $url );
			//exit();
		};

		
		if ($text !== false) {
			file_put_contents($file_url, $text);
			$data = json_decode($text);
			if (count($data) == 0) $data = false;
		} else {
			$data = false;
			trigger_error("<b>parser error: </b> respose curl code = {$info["http_code"]} for url = {$url}", E_USER_WARNING);					
			flush();
		};
		

		return $data;
	}


	private function file_url( $url) {
		$file_url = preg_replace("#https?\:\/\/#","", $url);
		return $file_url = "files/api.marketrealist.com/" . preg_replace("#\W#","-", $file_url) . ".html";
	}



}











?>