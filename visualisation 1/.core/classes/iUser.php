<?php
/*
	onBeforeAdminLogin( $row_user_admin)
	onAfterAdminLogin( $row_user_admin)
	onAdminLogout
	onErrorAdminLogin
*/
class iUser extends iEvent{
	public $row_user = null;
	public $row_user_admin = null;

	function __construct() {
		parent::__construct();
	}
	
	
	function onDefinePage() {
		global $SM;	
	
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~								Выход из системы пользователя
		if (isset($_REQUEST["logout"])) {
			if (iEvent::fire("onUserLogout")) {
				unset($_SESSION["user"]); 
				header("Location: " . HTTP_HOST);
			};
		};
	
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~								Выход из системы администратора
		if (isset($_REQUEST["logout-admin"])) {
			if (iEvent::fire("onAdminLogout")) {
				unset($_SESSION["user_admin"]); 
				header("Location: " . HTTP_HOST . "/" . ADMIN_ROUTE_URL);
			};
		};

		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~								Вход в систему администратора
		if (isset($_REQUEST["page"]) && $_REQUEST["page"] == "admin_login") {
			$this->admin_login();
		};	

		
		/*
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~								Первый заход в систему после логина
		if (isset($_SESSION["user_admin"]["login_successful"])) {
			unset( $_SESSION["user_admin"]["login_successful"] );
			$this::fire("onAfterAdminLogin", $this->row_user);
		};
		*/
		
		// Заносим переменные в Smarty
		//if ( defined("DB_HOST") && isset($_SESSION["user_admin"]["id"]) && is_null($this->row_user_admin) ) $this->row_user_admin = iDB::row("SELECT * FROM `admin_users` WHERE id={$_SESSION["user_admin"]["id"]}");
		if ( defined("DB_HOST") && isset($_SESSION["user"]["id"]) && is_null($this->row_user) ) $this->row_user = iDB::row("SELECT * FROM `user` WHERE id={$_SESSION["user"]["id"]}");
		
		$SM->assign("row_user_admin", $this->row_user_admin);
		$SM->assign("row_user", $this->row_user);
		
	}
	
	function onUserLogout() {
		return true;
	}
	
	function onAdminLogout() {
		return true;
	}

	function admin_login() {
		$this->row_user_admin = iDB::row($query = "SELECT * FROM admin_users WHERE `login`=". iS::rsq("username") ." AND `password`=". iS::rsq("passwd"));
		
		if (!is_null($this->row_user_admin)) {
			$_SESSION["user_admin"] = array("login" => 1, "id" => $this->row_user_admin->id, "role" => $this->row_user_admin->role, "name" => $this->row_user_admin->name);
			
			$this::fire("onBeforeAdminLogin", $this->row_user_admin);
			// header("Location: " . HTTP_HOST . "/" . ADMIN_ROUTE_URL);
			$this::fire("onAfterAdminLogin", $this->row_user_admin);
		} else {
			$this::fire("onErrorAdminLogin");
		};

	
	}

	static function admin_user_id() {
		return isset($_SESSION["user_admin"]["id"]) ? $_SESSION["user_admin"]["id"] : null;
	}

	static function user_id() {
		return isset($_SESSION["user"]["id"]) ? $_SESSION["user"]["id"] : null;
	}
	
	static function admin_user_role() {
		if (!DEVELOPE) {
			if ( isset($_SESSION["user_admin"]["role"]) ) return $_SESSION["user_admin"]["role"]; else return '0';
		} elseif (!is_null(self::admin_user_id())) {
			return iDB::value("SELECT`role` FROM " . DB_PREFIX . "users WHERE `id`=". self::admin_user_id());
		}
		else return '0';
	
	}

	static function access() {
		
		
		if (!DEVELOPE) {
			if ( isset($_SESSION["user_admin"]["role"]) ) return $_SESSION["user_admin"]["role"]; else return '0';
		} elseif (!is_null(self::admin_user_id())) {
			return iDB::value("SELECT`role` FROM " . DB_PREFIX . "users WHERE `id`=". self::admin_user_id());
		}
		else return '0';
	
	}





	function onLogin() {
		if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "json") {
			$data = json_decode( file_get_contents("json/CDP.json") );
			
			$data_user = $data->users;
			$login = $_REQUEST["login"];
			$password = $_REQUEST["password"];
			
			
			if (isset($data_user->{$login})){
				$row_user = $data_user->{$login};
				if ($row_user->password == $password) {
				
 				
					$_SESSION["user_admin"] = array(
						"login" => 1, 
						"id" => $row_user->id, 
						"access" => $row_user->access,  
						"name" => $row_user->name
					);			
				
					$this::fire("onBeforeAdminLogin", $row_user);
					echo json_encode(array("res" => true));  
					exit();
				};
			};
			
			
			$this::fire("onErrorAdminLogin");
			echo json_encode(array("res" => false));
			exit();
		} else trigger_error("Achtung!!!!!!!!!!!!", E_USER_ERROR);

	
/*
	
		$this->row_user_admin = iDB::row($query = "SELECT * FROM admin_users WHERE `login`=". iS::rsq("username") ." AND `password`=". iS::rsq("passwd"));
		
		if (!is_null($this->row_user_admin)) {
			$_SESSION["user_admin"] = array("login" => 1, "id" => $this->row_user_admin->id, "role" => $this->row_user_admin->role, "name" => $this->row_user_admin->name);
			
			$this::fire("onBeforeAdminLogin", $this->row_user_admin);
			// header("Location: " . HTTP_HOST . "/" . ADMIN_ROUTE_URL);
			$this::fire("onAfterAdminLogin", $this->row_user_admin);
		} else {
			$this::fire("onErrorAdminLogin");
		};
		
*/
	
	}




}