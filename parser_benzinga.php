<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");
iCronWatch::param("benzinga.com list", "exec", 1);


$benzinga = new benzinga();
$benzinga->parse_main();



$benzinga->parse_news( "news" );
$benzinga->parse_news( "best" );

unset( $benzinga );




?>
