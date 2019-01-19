<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");
iCronWatch::param("cnbc.com detail", "exec", 1);


$cnbc = new cnbc();

$cnbc->parse_detail( 20 ); 




unset( $cnbc );




?>
