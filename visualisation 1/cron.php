<?php
mb_internal_encoding("utf-8");	

require_once("config.php");		



// ~~~~~~~~~~~~~~~~~~~~~~~		Технические константы
define("HTTP_HOST", SCHEME . "://" . DOMAIN);
if (ADMIN_ROUTE_URL != "") define("HTTP_HOST_ADMIN", HTTP_HOST . '/' . ADMIN_ROUTE_URL); else define("HTTP_HOST_ADMIN", HTTP_HOST);
define("HTTP_HOST_URLENCODE", urlencode(HTTP_HOST . '/'));
define("CURRENT_URL", SCHEME . '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$self_fn = str_ireplace('\\','/',__FILE__);
define("ROOT", str_ireplace( basename($self_fn ), "", $self_fn ));


// ~~~~~~~~~~~~~~~~~~~~~~~		Автозагрузка
function main_autoload($class_name) {
	$filenameCore = ROOT . CORE_PATH . 'classes/'.$class_name.'.php';
	$filename = ROOT . 'classes/'.$class_name.'.php';
	$filenameFolder = ROOT . "classes/{$class_name}/{$class_name}.php";
	
	if ($res = file_exists($filenameCore)) require_once($filenameCore); 
	elseif ($res = file_exists($filename)) require_once($filename); 
	elseif ($res = file_exists($filenameFolder)) require_once($filenameFolder); 
	else trigger_error("Не найден файл = {$filename}, {$filenameCore}, {$filenameFolder}", E_USER_WARNING);
};
spl_autoload_register('main_autoload');


// ~~~~~~~~~~~~~~~~~~~~~~~		Регистрация классов
$GLOBALS["SM"] = new iSmarty();
$GLOBALS["O"] = new stdClass();
$iEvent = new iEvent();
$iUser = new iUser();


$API = new API();



// ~~~~~~~~~~~~~~~~~~~~~~~		Регистрация классов компонентов
foreach (array_merge( glob(CORE_PATH . "component/*.php"), glob(CORE_PATH . "component/*/*.php"), glob("component/*.php"), glob("component/*/*.php")  ) as $filename) {
	require_once($filename);
	$info = pathinfo( $filename );
	if (!isset($GLOBALS[ $info["filename"] ])) $GLOBALS[ $info["filename"] ] = new $info["filename"];	
};

// ~~~~~~~~~~~~~~~~~~~~~~~		Разбор url
if (!isset($_REQUEST["route_url"])) {
	if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
		$_REQUEST["route_url"] = str_ireplace(HTTP_HOST, "", $_SERVER["HTTP_REFERER"]);
		// удаляем слеш в начале
		$_REQUEST["route_url"] = preg_replace('#^\W#', '', $_REQUEST["route_url"]);
	} else $_REQUEST["route_url"] = "";	
};

$_REQUEST["route_url"] = preg_replace('#^(\W+)#six', "", $_REQUEST["route_url"]);
$_REQUEST["route_url"] = preg_replace('#(\W+)$#six', "", $_REQUEST["route_url"]);


define("ROUTE_URL", $_REQUEST["route_url"]);


$temp = explode("/", $_REQUEST["route_url"]);

// language
//if (!isset($temp[0]) || empty($temp[0])) $lang = DEFAULT_LANG; else $lang = $temp[0];
// page url
$temp = $temp[ count($temp)-1 ];
$page_url = str_ireplace(ADMIN_ROUTE_URL, "", $temp);
define("PAGE_URL", $page_url);

session_write_close();

$max_sec_exec = 40;
$start = time();
iCronWatch::param_start("cron.php", "execution");



$iCron = new iCron();

// Устанавливаем время выполнения
$iCron->set_max_exec_time( $iCron->option->cron1->max_time_exec );

// Очищаем старые данные
$iCron->clean_old_data();

// Добавляем статьи в search и обновляем uid
$iCron->add_new_article_to_search();

// Добавляем новые статьи в коеффициенты
$iCron->add_new_article_to_koef();
exit();



// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~			Добавляем новые статьи в коеффициенты
iCronWatch::param_start("cron.php", "Adding new articles to koef");

iDB::exec("UPDATE `search` S, `article` A SET S.time_added=A.time_added WHERE S.md5=A.md5 AND S.site_id=1");
iDB::exec("UPDATE `koef` K, `search` S SET time_from=time_added, time_to=time_added WHERE K.id_1=S.id");
iDB::exec("UPDATE `koef` K, `search` S SET time_from=LEAST(time_from, time_added), time_to=GREATEST(time_to, time_added) WHERE K.id_2=S.id");

$API->onRequest("Article/Update/FT", null, "local");
$API->onRequest("Article/Update/Koef", null, "local");

iCronWatch::param_end("cron.php", "Adding new articles to koef", 1);
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~			Распознаем категории в статьях




$limit_article = 1;

for ($level = 0; $level <= 2; $level++) {
	// перебираем статьи
	$data_article = iDB::rows("SELECT id, `text` FROM article WHERE category_id{$level} IS NULL AND `parsed`=1 AND `text`!='' ORDER BY time_added DESC  LIMIT {$limit_article}");
	if (is_null($data_article)) continue;
	
	foreach ($data_article as $key_article => $item_article) {
	
		// делаем выборку подходящих категорий
		$query = '
		INSERT IGNORE INTO article_cat (article_id, `level`, category_id, `count`, `sum`, `avg`)
		
		SELECT '. $item_article->id .', '. $level .',  cat_id, COUNT(category_id) `count`, SUM(koef) `sum`, AVG(koef) `avg` FROM 
		(SELECT A.title as article_title , C.id as cat_id, C.title as category_title, C.id as category_id, MATCH (A.`text`) AGAINST ('.iS::sq($item_article->text) .') koef FROM `cnbc_article` A LEFT JOIN cnbc_article_cat AC ON (AC.article_id=A.id) LEFT JOIN cnbc_category C ON (C.id=AC.category_id)
		WHERE C.`level`='.$level.'
		GROUP BY A.id 
		ORDER BY koef DESC 
		LIMIT 100) S
		GROUP BY category_id ORDER BY SUM(koef) DESC LIMIT 3';					
		
		iDB::exec($query);
		
		$category_id = iDB::value("SELECT category_id FROM article_cat WHERE article_id={$item_article->id} AND `level`={$level} ORDER BY `sum` DESC");
		if (is_null($category_id)) $category_id = 0;
		
		iDB::update("UPDATE article SET `time`=`time`, category_id{$level}={$category_id} WHERE id={$item_article->id}");
		
		
		// Если скрипт выполняется больше положенного, то прерываем его
		if (!is_null($max_sec_exec) && (time() - $start - 1 >= $max_sec_exec)) {
			trigger_error( "Article/Categories/Join -- Script was stopped. Time limit is over {$max_sec_exec} sec.", E_USER_WARNING);
			break;
		};
		
		
	};
};

$count_obr = iDB::value("SELECT COUNT(id) FROM article WHERE category_id0 IS NOT NULL AND `parsed`=1 AND `text`!=''");
$count_not_obr = iDB::value("SELECT COUNT(id) FROM article WHERE category_id0 IS NULL AND `parsed`=1 AND `text`!=''");

trigger_error( "API Update/Exchange -- obr = {$count_obr}, not obr = {$count_not_obr}");
trigger_error( 'API Update/Exchange -- Time execution: '.round(microtime(true) - $start, 4).' sec.');






// http://aleney.com/crm/news_aggregator/api/Article/Update/FT?show=1&repeat=5000
// http://aleney.com/crm/news_aggregator/api/Article/Update/Koef?show=1&repeat=5000


// https://aggnews.tickeron.com/api/Article/Update/FT?show=1&repeat=5000
// https://aggnews.tickeron.com/api/Article/Update/Koef?show=1&repeat=5000

iCronWatch::param_end("cron.php", "execution", "all tasks");

exit();


// ALTER TABLE `cron_watch_param` MODIFY COLUMN `time` DATETIME, ADD COLUMN `time_start` DATETIME AFTER `time`;
