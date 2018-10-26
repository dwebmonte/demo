<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$cnbc = new cnbc();

$cnbc->parse_detail( 20 ); 


unset( $cnbc );




?>
