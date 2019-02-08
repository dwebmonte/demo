<?php /* Smarty version 2.6.28, created on 2019-02-08 12:01:39
         compiled from Z:/home/aleney/www/aggnews.tickeron.com/visualisation+1/templates/index.tpl */ ?>
<!-- start postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index.tpl" -->
<!-- start prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index.tpl" -->
<!DOCTYPE html>	
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="webmonte.net" />
	<title>Загрузка контента</title>

	<!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic"> -->
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/css/fonts/linecons/css/linecons.css">
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
/css/custom.css?v=<?php echo time(); ?>
">
	<link rel="shortcut icon" href='<?php echo $this->_config[0]['vars']['favicon']; ?>
' type="image/x-icon">

	
	<link rel="stylesheet" href="<?php echo @HTTP_HOST; ?>
/css/admin.css?v=<?php echo time(); ?>
">
	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/jquery-1.11.1.min.js"></script>

	
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
<?php echo '
	<style>

	</style>
'; ?>

</head>

<!-- <body class="page-body settings-pane-open"> -->
<body class="page-body">


		<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
		<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
		<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
		<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
		<div class="sidebar-menu toggle-others fixed <?php if (isset ( $_COOKIE['menu_view'] ) && $_COOKIE['menu_view'] == 'collapsed'): ?>collapsed<?php endif; ?>">
			<div class="sidebar-menu-inner fixed">
				<header class="logo-env">
					<!-- logo -->
					<div class="logo">
						<a href="<?php echo @HTTP_HOST; ?>
/<?php echo @ADMIN_ROUTE_URL; ?>
" class="logo-expanded" style="color: white;font-size: 24px;position: relative;top: -9px;">							<?php echo $this->_config[0]['vars']['siteName']; ?>
						</a>
						<a href="<?php echo @HTTP_HOST; ?>
/<?php echo @ADMIN_ROUTE_URL; ?>
" class="logo-collapsed" style="color: white;font-size: 20px;position: relative;top: 4px;">							CRM						</a>
					</div>
					<!-- This will toggle the mobile menu and will be visible only on mobile devices -->

					<!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
					<!--
					<div class="settings-icon">
						<a href="#" data-toggle="settings-pane" data-animate="true">
							<i class="linecons-cog"></i>
						</a>
					</div>
					-->
				</header>
				
				
				<section class="sidebar-user-info">
					<div class="sidebar-user-info-inner">
						<a href="#" class="user-profile">
							<img src="<?php echo @ASSETS_PATH; ?>
/images/user-4.png" class="img-circle img-corona" alt="user-pic" width="60" height="60">
							<span><strong idata-text="sessionUser.short_name"></strong><label idata-text="sessionUser.access"></label></span>
						</a>
					</div>
				</section>
				
				
				<ul id="main-menu" class="main-menu"></ul>
			</div>
		</div>
		<div class="main-content">
			<nav style="" class="navbar user-info-navbar"  role="navigation"><!-- User Info, Notifications and Menu Bar -->
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/b-user-info.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</nav>
			
			<div class="page-title">
				<div class="title-env">
					<h1 class="title"></h1>
					<p class="description"></p>
				</div>
				<div class="breadcrumb-env">
					<ol class="breadcrumb bc-1" >
						<li><a href="http://<?php echo @DOMAIN; ?>
"><i class="fa-home"></i><span class="title">Home</span></a></li>
						<li class="active"><strong idata-text="currentPage.title"></strong></li>
					</ol>
				</div>
			</div>
			

			
						<div id="workArea" style="min-height: 500px" cid="workArea">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['template_page'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/b-footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
	</div>
	
	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/datatables/datatables.min-arrange.js"></script>	
	

	<script src="<?php echo @ASSETS_PATH; ?>
/js/history/history.min.js?v=<?php echo time(); ?>
"></script>

	<!-- Bottom Scripts -->
	<script src="<?php echo @ASSETS_PATH; ?>
/js/bootstrap.min.js"></script>
	<!-- <script src="<?php echo @ASSETS_PATH; ?>
/js/jquery.cookie.js"></script> -->
	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/TweenMax.min.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/resizeable.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/joinable.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/xenon-api.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/xenon-toggles.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo @ASSETS_PATH; ?>
/js/xenon-widgets.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/xenon-custom.js"></script>

	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/datepicker/bootstrap-datepicker.js"></script>

	
	<!--
	<script src="<?php echo @ASSETS_PATH; ?>
/js/datatables/js/jquery.dataTables.min.js"></script> 
	<script src="<?php echo @ASSETS_PATH; ?>
/js/datatables/dataTables.bootstrap.js"></script>
	-->
	
	
<!--
	<script src="<?php echo @ASSETS_PATH; ?>
/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/datatables/tabletools/dataTables.tableTools.min.js"></script>	
-->


	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/url.min.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/toastr/toastr.min.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/jquery-validate/jquery.validate.min.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/inputmask/jquery.inputmask.bundle.js"></script>
	
	<!-- dropzone  -->
	<link rel="stylesheet" href="<?php echo @ASSETS_PATH; ?>
/js/dropzone/css/dropzone.css">
	<script src="<?php echo @ASSETS_PATH; ?>
/js/dropzone/dropzone.min.js"></script>
	
	
	<!-- crystal.2.0  -->
	<!-- 
	<script src="<?php echo @ASSETS_PATH; ?>
/js/crystal.2.0/crData.js?v=<?php echo time(); ?>
"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/crystal.2.0/crDataTable.js?v=<?php echo time(); ?>
"></script>	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/crystal.2.0/wm_event.js?v=<?php echo time(); ?>
"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/crystal.2.0/wm.js?v=<?php echo time(); ?>
"></script>
	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/crystal.2.0/api.js?v=<?php echo time(); ?>
"></script> 
	-->

	

	<!-- devexpress  -->
	<script src="<?php echo @ASSETS_PATH; ?>
/js/devexpress-web-14.1/js/globalize.min.js"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/devexpress-web-14.1/js/dx.chartjs.js"></script>	
	
	<!-- admin_scripts  -->
	<script src="<?php echo @HTTP_HOST; ?>
/js/admin_scripts.js?v=<?php echo time(); ?>
"></script>	

	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>	
	
	
	

	
	
	<!-- (Ajax Modal)-->
	<div class="modal fade ajax_wrapper" id="modal-bootstrap">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

			</div>
		</div>
	</div>	
	
	<div class="page-loading-overlay"><div class="loader-2"></div></div>	
	
	
	<script> var iCoreData = <?php echo $this->_tpl_vars['iCoreData']; ?>
; </script>
	
	<script src="<?php echo @ASSETS_PATH; ?>
/js/wm/api.js?v=<?php echo time(); ?>
"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/iCore/iHTML-1.0.js?v=<?php echo time(); ?>
"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/iCore/iDataTable-1.0.js?v=<?php echo time(); ?>
"></script>
	<script src="<?php echo @ASSETS_PATH; ?>
/js/iCore/iCore-1.0.js?v=<?php echo time(); ?>
"></script>
	
	
</body>
</html>

<!-- end prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index.tpl" -->
<!-- end postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/index.tpl" -->
