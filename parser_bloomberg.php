<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");



$bloomberg = new bloomberg();
$bloomberg->log = true;


$bloomberg->parse_main();
$bloomberg->parse_main("https://www.bloomberg.com/europe");

$bloomberg->parse_markets();
$bloomberg->parse_economics();
$bloomberg->parse_tech();


?>
