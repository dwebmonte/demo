<?php
	
	
function api_login_by_email($paramForm, &$oAPI) {
	
	if (!isset($paramForm["password"]) || empty($paramForm["password"])) coreAPI::error("Не введен пароль");
	elseif (!isset($paramForm["email"]) || empty($paramForm["email"])) coreAPI::error("Не введен email");
	else {	
		$row_user = iDB::row($query = "SELECT * FROM ". DB_PREFIX . "user WHERE `email`=". iS::sq($paramForm["email"]) ." AND `password`=". iS::sq($paramForm["password"]));
		
		// проверка логина и пароля
		if (is_null($row_user)) {
			
			$login = iDB::value($query = "SELECT * FROM ". DB_PREFIX . "user WHERE `email`=". iS::sq($paramForm["email"]));
			if (is_null($login)) coreAPI::error("Такой email не зарегистрирован");
			else coreAPI::error("Неправильный пароль");
			
		} else {
			$_SESSION["user"]["id"] = $row_user->id;
			$_SESSION["user"]["name"] = $row_user->name;
			$_SESSION["user"]["email"] = $row_user->email;
			$_SESSION["user"]["role"] = $row_user->role;
		
			$oAPI->output["action"][] = array("do" => "href", "href" => "");
		};
	};
	
};	