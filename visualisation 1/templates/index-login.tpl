<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="webmonte.net" />

	<title>Войти в панель управления</title>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/bootstrap.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-core.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-forms.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-components.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-skins.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/custom.css">
	<link rel="shortcut icon" href='{#favicon#}' type="image/x-icon">

	
	<link rel="stylesheet" href="{$smarty.const.HTTP_HOST}/css/base_admin.css">
	
	<script src="{$smarty.const.ASSETS_PATH}/js/jquery-1.11.1.min.js"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

{literal}
<style>
	.login-page {
		padding-top: 120px;
	
	}
</style>
{/literal}
</head>

<body class="page-body login-page">

	
	<div class="login-container">
	
		<div class="row">
	
			<div class="col-sm-6">
				{literal}
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						// Reveal Login form
						setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);
						$("form#login .form-group:has(.form-control):first .form-control").focus();
					});
				</script>
				{/literal}
				<!-- Errors container -->
				<div class="errors-container">
					{if isset($smarty.request.wrong)}<div class="alert alert-danger">Введенные логин или пароль указаны неверно</div>{/if}
				</div>
	
				<!-- Add class "fade-in-effect" for login form effect -->

				 <form method="POST" role="form" id="login-form" class="login-form fade-in-effect" api-set="login"> 
					<div class="login-header">
						<a href="#" class="logo" style="color: white;text-transform: uppercase;font-size: 22px;font-family: arial;">
							Welcome to the control panel!
						</a>
						<p>Enter username and password to access the admin panel</p>
					</div>					
	
					<div class="form-group">
						<label class="control-label" for="username">Username</label>
						<input type="text" class="form-control input-dark" name="login" autocomplete="off" />
					</div>
	
					<div class="form-group">
					<label class="control-label" for="passwd">Password</label>  
						<input type="password" class="form-control input-dark" name="password" autocomplete="off" />
					</div>
	
					<div class="form-group">
						<button type="submit" class="btn btn-dark  btn-block text-left">
							<i class="fa-lock"></i>Login
						</button>
					</div>
	
	
				</form>

			</div>
		</div>
	</div>


	<script src="{$smarty.const.ASSETS_PATH}/js/TweenMax.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-api.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-custom.js"></script>	
	<script src="{$smarty.const.ASSETS_PATH}/js/bootstrap.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/toastr/toastr.min.js"></script>
	
	<!-- <script src="{$smarty.const.ASSETS_PATH}/js/crystal.2.0/api.js?v={$smarty.now}"></script> -->
	
	<script src="{$smarty.const.ASSETS_PATH}/js/wm/api.js?v={$smarty.now}"></script>
	
	

	
	

</body>
</html>
