<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$benzinga = new benzinga();
$benzinga->parse_detail( 10 );

unset( $benzinga );




?>
