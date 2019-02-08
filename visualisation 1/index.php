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



iEvent::fire("onDefinePage");


if (!is_null(iUser::user_id())) {
	$O->smarty_template_index = ROOT . "templates/index404.tpl";
	$O->smarty_template_page = ROOT . "templates/404.tpl";

	
	
	// Поиск страницы
	$CDP = json_decode(file_get_contents("json/CDP.json"));
	
	//var_dump(ROUTE_URL, $CDP->page);	exit();
	
	foreach ($CDP->page as $url => $oPage) {
		if ($url != '/' . ROUTE_URL) continue;
		
		$O->smarty_template_index = ROOT . "templates/" . $oPage->{"template-index"};
		$O->smarty_template_page = ROOT . "templates/" . $oPage->{"template-page"};
		
	};
	
};



if (!isset( $O->smarty_template_index )) {
	$O->smarty_template_index = ROOT . "templates/index-login.tpl";
	$O->smarty_template_page = ROOT . "templates/home.tpl";
};


$SM->assign("template_index", $O->smarty_template_index);
$SM->assign("template_page", $O->smarty_template_page);


/*
if ($_SERVER["REMOTE_ADDR"] != "46.118.126.167") {
echo $SM->display(ROOT . "templates/under_reconstruction.tpl");
exit();
};
*/


define("IS_ADMIN", true);
$O->trigger = "trigger_admin.php";
$SM->assign("O", $O);


$API = new API();
$SM->assign("API", $API);


// Direct call by API
if (stripos($_REQUEST["route_url"], "api/") === 0) {
	header('Content-Type: application/json');
	
	
	
	$_REQUEST["params"] = $_REQUEST;
	//$_REQUEST["c"] = "API";	
	//$_REQUEST["e"] = "onRequest";
	$_REQUEST["do"] = str_ireplace("api/", "", $_REQUEST["route_url"]);

	$obj = new API();
	$obj->onRequest( );	
	
	exit();
};



$iData = new iData();

// Direct call by GATE
if (stripos($_REQUEST["route_url"], "gate/") === 0) {
	
	
	
	
	exit();
	
	header('Content-Type: application/json');
	
	$_REQUEST["params"] = $_REQUEST;
	//$_REQUEST["c"] = "API";	
	//$_REQUEST["e"] = "onRequest";
	$_REQUEST["do"] = str_ireplace("gate/", "", $_REQUEST["route_url"]);

	$obj = new API();
	$obj->onRequest( );	
	
	exit();
};

// echo "<pre>";		var_dump($_REQUEST); var_dump($_FILES);		echo "</pre>";				exit();
$data = array("c" => "iComDataTable", "e" => "onAddDataTable", "id" => 1, "uid" => "admin");

// if (iEvent::check_for_ajax_test( $data )) {
if (iEvent::check_for_ajax(  )) {
	
	
} else {
	iEvent::fire("onStart");
	require_once( "trigger/" . $O->trigger );
	
	//var_dump($O->smarty_template_index);
	
	echo $SM->display($O->smarty_template_index);
 	//exit();
};


