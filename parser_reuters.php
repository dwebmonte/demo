<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$reuters = new reuters();
$reuters->parse_main();
$reuters->parse_finance();
$reuters->parse_finance_last();
$reuters->parse_detail( 20 );
unset( $reuters );

?>