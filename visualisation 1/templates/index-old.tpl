<!DOCTYPE html>	
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="webmonte.net" />
	<title>Загрузка контента</title>

	<!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic"> -->
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/fonts/linecons/css/linecons.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/bootstrap.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-core.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-forms.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-components.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-skins.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/custom.css?v={$smarty.now}">
	<link rel="shortcut icon" href='{#favicon#}' type="image/x-icon">

	
	<link rel="stylesheet" href="{$smarty.const.HTTP_HOST}/css/admin.css?v={$smarty.now}">
	
	<script src="{$smarty.const.ASSETS_PATH}/js/jquery-1.11.1.min.js"></script>

	
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
{literal}
	<style>

	</style>
{/literal}
</head>

<!-- <body class="page-body settings-pane-open"> -->
<body class="page-body">


	{*  {include file="admin/b-settings-pane.tpl"}  *}
	<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
		<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
		<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
		<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
		<div class="sidebar-menu toggle-others fixed {if isset($smarty.cookies.menu_view) && $smarty.cookies.menu_view == 'collapsed'}collapsed{/if}">
			<div class="sidebar-menu-inner fixed">
				<header class="logo-env">
					<!-- logo -->
					<div class="logo">
						<a href="{$smarty.const.HTTP_HOST}/{$smarty.const.ADMIN_ROUTE_URL}" class="logo-expanded" style="color: white;font-size: 24px;position: relative;top: -9px;">							{#siteName#}						</a>
						<a href="{$smarty.const.HTTP_HOST}/{$smarty.const.ADMIN_ROUTE_URL}" class="logo-collapsed" style="color: white;font-size: 20px;position: relative;top: 4px;">							CRM						</a>
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
							<img src="{$smarty.const.ASSETS_PATH}/images/user-4.png" class="img-circle img-corona" alt="user-pic" width="60" height="60">
							<span><strong idata-text="sessionUser.short_name"></strong><label idata-text="sessionUser.access"></label></span>
						</a>
					</div>
				</section>
				
				
				<ul id="main-menu" class="main-menu"></ul>
			</div>
		</div>
		<div class="main-content">
			<nav style="" class="navbar user-info-navbar"  role="navigation"><!-- User Info, Notifications and Menu Bar -->
				{include file="admin/b-user-info.tpl"}
			</nav>
			
			<div class="page-title">
				<div class="title-env">
					<h1 class="title"></h1>
					<p class="description"></p>
				</div>
				<div class="breadcrumb-env">
					<ol class="breadcrumb bc-1" >
						<li><a href="http://{$smarty.const.DOMAIN}"><i class="fa-home"></i><span class="title">Dashboard</span></a></li>

			<!--
					<li><a href="ui-panels.html">UI Elements</a></li>
					<li class="active"><strong>Panels</strong></li>
			-->
					</ol>
				</div>
			</div>
			

			
			{* <div class="row"><div class="col-sm-12">{include file="admin/widget.tpl"}</div></div> *}
			<div id="workArea" style="min-height: 500px" cid="workArea">
				{include file=$template_page}
			</div>
			
			{include file="admin/b-footer.tpl"}
		</div>
	</div>
	
	

	

	<script src="{$smarty.const.ASSETS_PATH}/js/history/history.min.js?v={$smarty.now}"></script>

	<!-- Bottom Scripts -->
	<script src="{$smarty.const.ASSETS_PATH}/js/bootstrap.min.js"></script>
	<!-- <script src="{$smarty.const.ASSETS_PATH}/js/jquery.cookie.js"></script> -->
	
	<script src="{$smarty.const.ASSETS_PATH}/js/TweenMax.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/resizeable.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/joinable.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-api.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-toggles.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-widgets.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-custom.js"></script>

	
	<script src="{$smarty.const.ASSETS_PATH}/js/datepicker/bootstrap-datepicker.js"></script>

	
	<!--
	<script src="{$smarty.const.ASSETS_PATH}/js/datatables/js/jquery.dataTables.min.js"></script> 
	<script src="{$smarty.const.ASSETS_PATH}/js/datatables/dataTables.bootstrap.js"></script>
	-->
	<script src="https://cdn.datatables.net/v/bs/jqc-1.12.4/dt-1.10.18/af-2.3.0/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
	
<!--
	<script src="{$smarty.const.ASSETS_PATH}/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/datatables/tabletools/dataTables.tableTools.min.js"></script>	
-->


	
	<script src="{$smarty.const.ASSETS_PATH}/js/url.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/toastr/toastr.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/jquery-validate/jquery.validate.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/inputmask/jquery.inputmask.bundle.js"></script>
	
	<!-- dropzone  -->
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/js/dropzone/css/dropzone.css">
	<script src="{$smarty.const.ASSETS_PATH}/js/dropzone/dropzone.min.js"></script>
	
	
	<!-- crystal.2.0  -->
	<!-- 
	<script src="{$smarty.const.ASSETS_PATH}/js/crystal.2.0/crData.js?v={$smarty.now}"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/crystal.2.0/crDataTable.js?v={$smarty.now}"></script>	
	<script src="{$smarty.const.ASSETS_PATH}/js/crystal.2.0/wm_event.js?v={$smarty.now}"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/crystal.2.0/wm.js?v={$smarty.now}"></script>
	
	<script src="{$smarty.const.ASSETS_PATH}/js/crystal.2.0/api.js?v={$smarty.now}"></script> 
	-->
	<script src="{$smarty.const.ASSETS_PATH}/js/wm/api.js?v={$smarty.now}"></script>
	

	<!-- devexpress  -->
	<script src="{$smarty.const.ASSETS_PATH}/js/devexpress-web-14.1/js/globalize.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/devexpress-web-14.1/js/dx.chartjs.js"></script>	
	
	<!-- admin_scripts  -->
	<script src="{$smarty.const.HTTP_HOST}/js/admin_scripts.js?v={$smarty.now}"></script>	

	
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
	
	
	<script> var iCoreData = {$iCoreData}; </script>
	
	<script src="{$smarty.const.ASSETS_PATH}/js/iCore/iHTML-1.0.js?v={$smarty.now}"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/iCore/iDataTable-1.0.js?v={$smarty.now}"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/iCore/iCore-1.0.js?v={$smarty.now}"></script>
	
	
</body>
</html>
