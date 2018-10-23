<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$marketwatch = new marketwatch();
$marketwatch->parse_main();
$marketwatch->parse_page("https://www.marketwatch.com/newsviewer");
$marketwatch->parse_detail( 5 );
unset( $marketwatch );




?>
