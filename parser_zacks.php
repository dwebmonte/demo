<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$zacks = new zacks();
$zacks->parse_main();
$zacks->parse_articles();
$zacks->parse_detail( 5 );
unset( $zacks );

?>
