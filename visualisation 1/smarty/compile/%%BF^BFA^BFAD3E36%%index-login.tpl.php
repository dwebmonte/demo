<?php /* Smarty version 2.6.28, created on 2019-02-08 10:55:33
         compiled from Z:/home/aleney/www/aggnews.tickeron.com/visualisation+1/templates/index-login.tpl */ ?>
<!-- start postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index-login.tpl" -->
<!-- start prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index-login.tpl" -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="webmonte.net" />

	<title>Welcome to the control panel!</title>
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arimo:400,700,400italic"> -->
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/xenon-core.css">
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/xenon-forms.css">
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/xenon-components.css">
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/xenon-skins.css">
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/custom.css">
	<link rel="shortcut icon" href='<?php echo $this->_config[0]['vars']['favicon']; ?>
' type="image/x-icon">

	
	<link rel="stylesheet" href="<?php echo @HTTP_HOST; ?>
/css/base_admin.css">
	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/jquery-1.11.1.min.js"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

<?php echo '
<style>
	.login-page {
		padding-top: 120px;
	
	}
</style>
'; ?>

</head>

<body class="page-body login-page">

	
	<div class="login-container">
	
		<div class="row">
	
			<div class="col-sm-6">
				<?php echo '
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						// Reveal Login form
						setTimeout(function(){ $(".fade-in-effect").addClass(\'in\'); }, 1);
						$("form#login .form-group:has(.form-control):first .form-control").focus();
					});
				</script>
				'; ?>

				<!-- Errors container -->
				<div class="errors-container">
					<?php if (isset ( $_REQUEST['wrong'] )): ?><div class="alert alert-danger">Введенные логин или пароль указаны неверно</div><?php endif; ?>
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


	<script src="<?php echo @ASSETS_PATH; ?>
/js/TweenMax.min.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/xenon-api.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/xenon-custom.js"></script>	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/bootstrap.min.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/toastr/toastr.min.js"></script>
	
	<!-- <script src="<?php echo @ASSETS_PATH; ?>
/js/crystal.2.0/api.js?v=<?php echo time(); ?>
"></script> -->
	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/wm/api.js?v=<?php echo time(); ?>
"></script>
	
	

	
	

</body>
</html>

<!-- end prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index-login.tpl" -->
<!-- end postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index-login.tpl" -->
