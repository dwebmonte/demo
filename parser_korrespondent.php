<?php
	
require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");	
	

	
$korrespondent = new korrespondent();
$korrespondent->parse_last();
$korrespondent->parse_detail(15);
unset( $korrespondent );	
	

$output = array(
	"parsed_count" => iDB::value("SELECT COUNT(id) FROM article_korr WHERE parsed=1"),
	"last_count" => iDB::value("SELECT COUNT(id) FROM article_korr WHERE parsed=0"),
	"first_time" => iDB::value("SELECT str_time FROM article_korr ORDER BY time_added ASC"),
	"last_time" => iDB::value("SELECT str_time FROM article_korr ORDER BY time_added DESC"),
);

header("HTTP/1.1 200 OK");
header("Content-Type: application/json");	
echo json_encode($output);