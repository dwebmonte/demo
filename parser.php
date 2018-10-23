<?php
	
require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");	

$site = null;
if (isset($_REQUEST["site"])) $site = $_REQUEST["site"];
elseif (isset($_REQUEST["domain"])) $site = $_REQUEST["domain"];
elseif (isset($_REQUEST[0])) $site = $_REQUEST[0];

if (is_null($site)) trigger_error("site is not defined", E_USER_ERROR);

$type = "all";
if (isset($_REQUEST["type"])) $type = $_REQUEST["type"];
elseif (isset($_REQUEST[1])) $type = $_REQUEST[1];

$count = 50;
if (isset($_REQUEST["count"])) $count = $_REQUEST["count"];
elseif (isset($_REQUEST[2])) $count = $_REQUEST[2];



$rt = new rt();
//for ($page = 0; $page <= 10; $page++) $rt->parse_last($page);

$rt->parse_detail(30);
unset( $rt );	
exit();

if ( stristr($site, "cnbc") && ($type == "all" || $type == "start") ) {
	$cnbc = new cnbc();
	$cnbc->parse_main();

	$page = 1;
	
	$cnbc->parse_category( "https://www.cnbc.com/finance/", $page); 
	$cnbc->parse_category( "https://www.cnbc.com/economy/", $page );
	$cnbc->parse_category( "https://www.cnbc.com/make-it/", $page );
	$cnbc->parse_category( "https://www.cnbc.com/the-fintech-effect/", $page );
	$cnbc->parse_category( "https://www.cnbc.com/editors-picks-world/", $page );
	$cnbc->parse_category( "https://www.cnbc.com/technology/", $page );
	$cnbc->parse_category( "https://www.cnbc.com/investing/", $page );
	unset( $cnbc );		
	//var_dump($site, "page");
};

if ( stristr($site, "cnbc") && ($type == "all" || $type == "page") ) {
	$cnbc = new cnbc();
	$cnbc->parse_detail( $count ); 
	unset( $cnbc );	
	//var_dump($site, "article", $count);	
};
	
