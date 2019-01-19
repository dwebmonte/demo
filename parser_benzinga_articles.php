<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");
iCronWatch::param("benzinga.com detail", "exec", 1);



$benzinga = new benzinga();
$benzinga->parse_detail( 10 );

unset( $benzinga );




?>
