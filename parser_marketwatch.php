<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");
iCronWatch::param("marketwatch.com", "exec", 1);


$marketwatch = new marketwatch();
$marketwatch->parse_main();
$marketwatch->parse_page("https://www.marketwatch.com/newsviewer");
$marketwatch->parse_detail( 5 );
unset( $marketwatch );




?>
