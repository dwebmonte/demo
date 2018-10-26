<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");


$benzinga = new benzinga();
$benzinga->parse_main();
$benzinga->parse_news( "news" );
$benzinga->parse_news( "best" );

unset( $benzinga );




?>
