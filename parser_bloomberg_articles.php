<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$bloomberg = new bloomberg();
$bloomberg->log = true;

$bloomberg->parse_detail(5);




?>
