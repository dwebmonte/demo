<?php
$data = array(
	"dt_user" => array(
		"class" => "iDataTable",
		"title" => "User management",
		"language" => "en",
		"append" => "#test_page_wrapper",
		"data" => array(
			"columnDefs" => array(
				array("title" => "Name", "name" => "short_name"),
				array("title" => "Access", "name" => "access"),
				array("title" => "Email (login)", "name" => "email"),
				array("title" => "Password", "name" => "password"),
				//array("title" => "", "name" => "cell_opt", "render" => 'return `<a href="#" onclick=\'$("#win_user_add").modal("show", {backdrop: "fade"}); return false;\'>Elit</a>&nbsp;<a href="">Delete</a>`'),
			),
			"data" => iDB::rows("SELECT short_name, access, email, password, 1 as cell_opt  FROM user")
		)
	)	
);


// 



	if (isset($_SESSION["user"]) && $_SESSION["user"]["access"] == "admin") {
		$data["leftMenu"] = array(
			"class" => "iLeftMenu",
			"data" => array(
				array("title" => "System", "url" => "cron_status", "icon" => "fa-cogs"),
				array("title" => "Trends", "url" => "", "icon" => "fa-globe", "items" =>
					array(
						array("title" => "cnbc.com", "url" => ""),
						array("title" => "marketrealist.com", "url" => "trends-marketrealist"),
					)
				),
				array("title" => "News by categories", "url" => "articles-by-category", "icon" => "fa-sitemap", "items" =>
					array(
						array("title" => "cnbc.com", "url" => "articles-by-category/cnbc"),
						array("title" => "marketrealist.com", "url" => "articles-by-category/marketrealist1"),
						array("title" => "marketrealist.com (KB)", "url" => "articles-by-category/marketrealist"),
					)
				),
				array("title" => "Articles", "url" => "articles", "icon" => "fa-newspaper-o"),
				array("title" => "Logs", "url" => "logs", "icon" => "fa-tasks"),
				array("title" => "Proxy", "url" => "proxy", "icon" => "fa-cloud-download"),
				array("title" => "Categories", "url" => "testing", "icon" => "fa-cubes"),
				array("title" => "Related articles", "url" => "testing-related", "icon" => "fa-random"),		
				array("title" => "Users", "url" => "test", "icon" => "fa-user"),		
			)
		);
	} else {
		$data["leftMenu"] = array(
			"class" => "iLeftMenu",
			"data" => array(
				array("title" => "Trends", "url" => "", "icon" => "fa-globe", "items" =>
					array(
						array("title" => "cnbc.com", "url" => ""),
						array("title" => "marketrealist.com", "url" => "trends-marketrealist"),
					)
				),
				array("title" => "News by categories", "url" => "articles-by-category", "icon" => "fa-sitemap", "items" =>
					array(
						array("title" => "cnbc.com", "url" => "articles-by-category/cnbc"),
						array("title" => "marketrealist.com", "url" => "articles-by-category/marketrealist1"),
						array("title" => "marketrealist.com (KB)", "url" => "articles-by-category/marketrealist"),
					)
				),
				array("title" => "Articles", "url" => "articles", "icon" => "fa-newspaper-o"),
			)
		);
	}


	/*
		$data["leftMenu"] = array(
			"class" => "iLeftMenu",
			"data" => array(
				array("title" => "System", "url" => "cron_status", "icon" => "fa-cogs"),
				array("title" => "Trends", "url" => "", "icon" => "fa-globe", "items" =>
					array(
						array("title" => "cnbc.com", "url" => ""),
						array("title" => "marketrealist.com", "url" => "trends-marketrealist"),
					)
				),
				array("title" => "News by categories", "url" => "articles-by-category", "icon" => "fa-sitemap", "items" =>
					array(
						array("title" => "cnbc.com", "url" => "articles-by-category/cnbc"),
						array("title" => "marketrealist.com", "url" => "articles-by-category/marketrealist1"),
						array("title" => "marketrealist.com (KB)", "url" => "articles-by-category/marketrealist"),
					)
				),
				array("title" => "Articles", "url" => "articles", "icon" => "fa-newspaper-o"),
				array("title" => "Logs", "url" => "logs", "icon" => "fa-tasks"),
				array("title" => "Proxy", "url" => "proxy", "icon" => "fa-cloud-download"),
				array("title" => "Categories", "url" => "testing", "icon" => "fa-cubes"),
				array("title" => "Related articles", "url" => "testing-related", "icon" => "fa-random"),		
				array("title" => "Users", "url" => "test", "icon" => "fa-user"),		
			)
		);
*/