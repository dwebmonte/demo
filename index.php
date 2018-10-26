<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$article_id = 74;
$search_word = iDB::value("SELECT `text` FROM article WHERE id={$article_id}");
$boolean_mode = 'IN BOOLEAN MODE';
$boolean_mode = '';

$data_article = iDB::rows($query = "
SELECT *, MATCH (`title`, `text`) AGAINST (". iS::sq($search_word) ." {$boolean_mode}) koef
FROM `search`
WHERE MATCH (`title`, `text`) AGAINST (". iS::sq($search_word) ."  {$boolean_mode}) > 0
ORDER BY MATCH (`title`, `text`) AGAINST (". iS::sq($search_word) ."  {$boolean_mode}) DESC
");

foreach ($data_article as $key => $item) {
	if ($key == 0) $max_koef = $item->koef;
	$data_article[$key]->percent = ceil(100 * ($item->koef / $max_koef));
	
};

var_dump( $query, $data_article );


$data_article = iDB::rows("SELECT id, `title`, `text` FROM article WHERE parsed=1 AND TRIM(`text`)!='' AND TRIM(`title`)!=''");

$data_insert = array();
foreach ($data_article as $key => $item) {
	if (is_null(iDB::value("SELECT id FROM `search` WHERE article_id={$item->id}"))) {
		$data_insert[] = array("article_id" => $item->id, "title" => mb_strtolower( $item->title ), "text" => mb_strtolower( $item->text ));
	};
};

if (count($data_insert) > 0) iDB::insertDataSQL("search", $data_insert);





exit();

$reuters = new reuters();
$reuters->parse_main();
$reuters->parse_finance();
$reuters->parse_finance_last();
$reuters->parse_detail();

//$bloomberg->parse_markets();
//$bloomberg->parse_economics();



exit();








$cnbc = new cnbc();
$cnbc->parse_category( "https://www.cnbc.com/finance/" ); 
$cnbc->parse_category( "https://www.cnbc.com/economy/" );
$cnbc->parse_category( "https://www.cnbc.com/make-it/" );
$cnbc->parse_category( "https://www.cnbc.com/the-fintech-effect/" );
$cnbc->parse_category( "https://www.cnbc.com/editors-picks-world/" );
$cnbc->parse_category( "https://www.cnbc.com/technology/" );
$cnbc->parse_category( "https://www.cnbc.com/investing/" );
$cnbc->parse_main();
unset( $cnbc );



$zacks = new zacks();
$zacks->parse_articles();
$zacks->parse_main();
unset( $zacks );

$benzinga = new benzinga();
$benzinga->parse_main();
$benzinga->parse_news( "news" );
$benzinga->parse_news( "best" );
unset( $benzinga );

$cnbc = new cnbc();
$cnbc->parse_category( "https://www.cnbc.com/finance/" ); 
$cnbc->parse_category( "https://www.cnbc.com/economy/" );
$cnbc->parse_category( "https://www.cnbc.com/make-it/" );
$cnbc->parse_category( "https://www.cnbc.com/the-fintech-effect/" );
$cnbc->parse_category( "https://www.cnbc.com/editors-picks-world/" );
$cnbc->parse_category( "https://www.cnbc.com/technology/" );
$cnbc->parse_category( "https://www.cnbc.com/investing/" );
$cnbc->parse_main();
unset( $cnbc );

$marketwatch = new marketwatch();
$marketwatch->parse_main();
$marketwatch->parse_page("https://www.marketwatch.com/newsviewer");
unset( $marketwatch );








echo "</pre>";



exit();

foreach ($J->find(".benzinga-articles ul")->find("li") as $li) {
	var_dump($li);
	exit();
};














var_dump(array_splice($data, 10,20));
// var_dump($data);
exit();

$content = html_entity_decode($content, ENT_QUOTES, "UTF-8");
//$content = htmLawed($content, $config);

$dom = new DOMDocument();
$dom->loadHTML( $content );
var_dump($data);
exit();
//echo $content ;exit();

$xml = simplexml_load_string($content);
var_dump($xml);

exit();



exit();


// Заголовок
if (preg_match('#<h1 \s+ id="title">(.+?)</h1>#six', $text, $sub)) {
	$oData["title"] = trim($sub[1]);
};

// Время
if (preg_match('#<span \s+ class="date">(.+?)</span>#six', $text, $sub)) {
	$oData["str_title"] = trim($sub[1]);
};

if (preg_match('#<div \s+ class="article\-content\-body\-only">(.+?)</div>#six', $text, $sub)) {
	$article_text = trim( $sub[1] );
};


// Related links
if (preg_match('#(.+)  <p><em>Related \s+ Links\:</em></p>   (.+)#six', $article_text, $sub)) {
	
	
	if (preg_match_all('# <p><a \s+ href="(.+?)">(.+?)</a></p> #six', $sub[2], $sub1, PREG_SET_ORDER)) {
		
		// Убираем из статьи все что ниже related
		$article_text = $sub[1];
		
		
		$oData["related_link"] = array();
		
		foreach ($sub1 as $key => $item) {
			$oData["related_link"][] = array("title" => strip_tags($item[1]), "url" => strip_tags($item[2]));
		};
		
	} else trigger_error("Achtung in {$url}", E_USER_WARNING);
};


// Related - блоки слева
if (preg_match_all('# <div \s+ class="title">Related (.+?) </div>   (.+?)  </div> \s+ </div> #six', $text, $sub_block_rel, PREG_SET_ORDER)) {
	//var_dump($sub_block_rel);
	foreach ($sub_block_rel as $block) {
		// $row_rel = array("link" => array());
	
		var_dump( $block[1] );
	
		// Если есть название и ссылка на объект
		//if (preg_match('##six'))
	
		
		// Собираем ссылки
		if (preg_match_all('#<a \s+ href="(.+?)">(.+?)</a>#six', $block[2], $sub_link_rel, PREG_SET_ORDER)) {
			foreach ($sub_link_rel as  $item_link_rel) {
				$row_rel["link"][] = array("title" => strip_tags($item_link_rel[2]), "url" => "https://www.benzinga.com" . strip_tags($item_link_rel[1]));
			};
		} else trigger_error("Achtung in {$url}", E_USER_WARNING); 
		
		var_dump( $row_rel );
	};
};




//var_dump($article_text);
//var_dump($oData);
exit();
echo $SM->display("index.tpl");



/*
	В новости мы не забираем
	- автора
	
	
	
	
*/
