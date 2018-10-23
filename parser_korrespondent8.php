<?php
	
require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");	
	

	
$korrespondent = new korrespondent();
//$korrespondent->parse_last();
$korrespondent->parse_detail(20);
unset( $korrespondent );	
	

