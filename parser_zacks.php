<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");
iCronWatch::param("zacks.com", "exec", 1);



$zacks = new zacks();
$zacks->parse_main();
$zacks->parse_articles();
$zacks->parse_detail( 5 );
unset( $zacks );

?>
