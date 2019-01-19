<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");
iCronWatch::param("cnbc.com list", "exec", 1);






$cnbc = new cnbc();
$cnbc->parse_main();




$cnbc->parse_category( "https://www.cnbc.com/finance/" ); 
$cnbc->parse_category( "https://www.cnbc.com/economy/" );
$cnbc->parse_category( "https://www.cnbc.com/make-it/" );
$cnbc->parse_category( "https://www.cnbc.com/the-fintech-effect/" );
$cnbc->parse_category( "https://www.cnbc.com/editors-picks-world/" );
$cnbc->parse_category( "https://www.cnbc.com/technology/" );
$cnbc->parse_category( "https://www.cnbc.com/investing/" );



unset( $cnbc );




?>
