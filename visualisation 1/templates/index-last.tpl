<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Xenon Boostrap Admin Panel" />
	<meta name="author" content="" />

	<title>Xenon - Dashboard</title>

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/fonts/linecons/css/linecons.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/fonts/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/bootstrap.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-core.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-forms.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-components.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/xenon-skins.css">
	<link rel="stylesheet" href="{$smarty.const.ASSETS_PATH}/css/custom.css">

	<script src="{$smarty.const.ASSETS_PATH}/js/jquery-1.11.1.min.js"></script>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>
<body class="page-body">

	<div class="settings-pane">
			
		<a href="#" data-toggle="settings-pane" data-animate="true">&times;</a>
		
		<div class="settings-pane-inner">
			
			<div class="row">
				
				<div class="col-md-4">
					
					<div class="user-info">
						
						<div class="user-image">
							<a href="extra-profile.html">
								<img src="{$smarty.const.ASSETS_PATH}/images/user-2.png" class="img-responsive img-circle" />
							</a>
						</div>
						
						<div class="user-details">
							
							<h3>
								<a href="extra-profile.html">John Smith</a>
								
								<!-- Available statuses: is-online, is-idle, is-busy and is-offline -->
								<span class="user-status is-online"></span>
							</h3>
							
							<p class="user-title">Web Developer</p>
							
							<div class="user-links">
								<a href="extra-profile.html" class="btn btn-primary">Edit Profile</a>
								<a href="extra-profile.html" class="btn btn-success">Upgrade</a>
							</div>
							
						</div>
						
					</div>
					
				</div>
				
				<div class="col-md-8 link-blocks-env">
					
					<div class="links-block left-sep">
						<h4>
							<span>Notifications</span>
						</h4>
						
						<ul class="list-unstyled">
							<li>
								<input type="checkbox" class="cbr cbr-primary" checked="checked" id="sp-chk1" />
								<label for="sp-chk1">Messages</label>
							</li>
							<li>
								<input type="checkbox" class="cbr cbr-primary" checked="checked" id="sp-chk2" />
								<label for="sp-chk2">Events</label>
							</li>
							<li>
								<input type="checkbox" class="cbr cbr-primary" checked="checked" id="sp-chk3" />
								<label for="sp-chk3">Updates</label>
							</li>
							<li>
								<input type="checkbox" class="cbr cbr-primary" checked="checked" id="sp-chk4" />
								<label for="sp-chk4">Server Uptime</label>
							</li>
						</ul>
					</div>
					
					<div class="links-block left-sep">
						<h4>
							<a href="#">
								<span>Help Desk</span>
							</a>
						</h4>
						
						<ul class="list-unstyled">
							<li>
								<a href="#">
									<i class="fa-angle-right"></i>
									Support Center
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa-angle-right"></i>
									Submit a Ticket
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa-angle-right"></i>
									Domains Protocol
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa-angle-right"></i>
									Terms of Service
								</a>
							</li>
						</ul>
					</div>
					
				</div>
				
			</div>
		
		</div>
		
	</div>
	
	<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
			
		<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
		<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
		<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
		<div class="sidebar-menu toggle-others fixed">
		
			<div class="sidebar-menu-inner">
				
				<header class="logo-env">
		
					<!-- logo -->
					<div class="logo">
						<a href="dashboard-1.html" class="logo-expanded">
							<img src="{$smarty.const.ASSETS_PATH}/images/logo@2x.png" width="80" alt="" />
						</a>
		
						<a href="dashboard-1.html" class="logo-collapsed">
							<img src="{$smarty.const.ASSETS_PATH}/images/logo-collapsed@2x.png" width="40" alt="" />
						</a>
					</div>
		
					<!-- This will toggle the mobile menu and will be visible only on mobile devices -->
					<div class="mobile-menu-toggle visible-xs">
						<a href="#" data-toggle="user-info-menu">
							<i class="fa-bell-o"></i>
							<span class="badge badge-success">7</span>
						</a>
		
						<a href="#" data-toggle="mobile-menu">
							<i class="fa-bars"></i>
						</a>
					</div>
		
					<!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
					<div class="settings-icon">
						<a href="#" data-toggle="settings-pane" data-animate="true">
							<i class="linecons-cog"></i>
						</a>
					</div>
		
					
				</header>
				
				
				<section class="sidebar-user-info">
					<div class="sidebar-user-info-inner">
						<a href="#" class="user-profile">
							<img src="{$smarty.const.ASSETS_PATH}/images/user-4.png" class="img-circle img-corona" alt="user-pic" width="60" height="60">

							<span>
								<strong idata-text="sessionUser.short_name">John Smith</strong>
								<label idata-text="sessionUser.access">Page admin</label>
							</span>
						</a>

						
						{*
						<ul class="user-links list-unstyled">
							<li class="active">
								<a href="extra-profile.html" title="Edit profile">
									<i class="linecons-user"></i>
									Edit profile
								</a>
							</li>
							<li>
								<a href="mailbox-main.html" title="Mailbox">
									<i class="linecons-mail"></i>
									Mailbox
								</a>
							</li>
							<li class="logout-link">
								<a href="extra-login.html" title="Log out">
									<i class="fa-power-off"></i>
								</a>
							</li>
						</ul>
						*}
					</div>
				</section>				
				
						
				<ul id="main-menu" class="main-menu"></ul>
				
			</div>
		
		</div>
	
		<div class="main-content">
					
			<nav class="navbar user-info-navbar"  role="navigation"><!-- User Info, Notifications and Menu Bar -->
			
				<!-- Left links for user info navbar -->
				<ul class="user-info-menu left-links list-inline list-unstyled">
			
					<li class="hidden-sm hidden-xs">
						<a href="#" data-toggle="sidebar">
							<i class="fa-bars"></i>
						</a>
					</li>
			
					{include file="admin2/language-message1.tpl"}
			
					{include file="admin2/language-message2.tpl"}
			
					{* {include file="admin2/language-switcher.tpl"} *}
				</ul>
			
			
				<!-- Right links for user info navbar -->
				<ul class="user-info-menu right-links list-inline list-unstyled">
							<li class="search-form"><!-- You can add "always-visible" to show make the search input visible -->
			
						<form name="userinfo_search_form" method="get" action="extra-search.html">
							<input type="text" name="s" class="form-control search-field" placeholder="Type to search..." />
			
							<button type="submit" class="btn btn-link">
								<i class="linecons-search"></i>
							</button>
						</form>
			
					</li>
			
					<li class="dropdown user-profile">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="{$smarty.const.ASSETS_PATH}/images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
							<span>
								John Smith
								<i class="fa-angle-down"></i>
							</span>
						</a>
			
						<ul class="dropdown-menu user-profile-menu list-unstyled">
							<li>
								<a href="#edit-profile">
									<i class="fa-edit"></i>
									New Post
								</a>
							</li>
							<li>
								<a href="#settings">
									<i class="fa-wrench"></i>
									Settings
								</a>
							</li>
							<li>
								<a href="#profile">
									<i class="fa-user"></i>
									Profile
								</a>
							</li>
							<li>
								<a href="#help">
									<i class="fa-info"></i>
									Help
								</a>
							</li>
							<li class="last">
								<a href="extra-lockscreen.html">
									<i class="fa-lock"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>
			
					<li>
						<a href="#" data-toggle="chat">
							<i class="fa-comments-o"></i>
						</a>
					</li>
			
				</ul>
			
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
			
			<!-- Main Footer -->
			<!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
			<!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
			<!-- Or class "fixed" to  always fix the footer to the end of page -->
			<footer class="main-footer sticky footer-type-1">
				
				<div class="footer-inner">
				
					<!-- Add your copyright text here -->
					<div class="footer-text">
						&copy; 2019 <strong>Xenon</strong> All rights reserved
						
					</div>
					
					
					<!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
					<div class="go-up">	
						<a href="#" rel="go-top">
							<i class="fa-angle-up"></i>
						</a>
						
					</div>
					
				</div>
				
			</footer>
		</div>
	
		{*  {include file="admin2/chat.tpl"}  *}
	</div>
	
	{*  {include file="admin2/footer-sticked-chat.tpl"}  *}
	
	
	<!-- Page Loading Overlay -->
	<div class="page-loading-overlay"><div class="loader-2"></div></div>

	<!-- Datatables -->
	<script src="{$smarty.const.ASSETS_PATH}/js/datatables/datatables.min-arrange.js"></script>	
	
	<!-- Bottom Scripts -->
	<script src="{$smarty.const.ASSETS_PATH}/js/bootstrap.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/TweenMax.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/resizeable.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/joinable.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-api.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-toggles.js"></script>

	<!-- Imported scripts on this page -->
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-widgets.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/devexpress-web-14.1/js/globalize.min.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/devexpress-web-14.1/js/dx.chartjs.js"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/toastr/toastr.min.js"></script>



	<!-- Plugins -->
	<script src="{$smarty.const.ASSETS_PATH}/js/datepicker/bootstrap-datepicker.js"></script>
	
	<!-- JavaScripts initializations and stuff -->
	<script src="{$smarty.const.ASSETS_PATH}/js/xenon-custom.js"></script>



	
	<!-- Project scripts -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>	

		
	
	<!-- iCore scripts -->
	<script> var iCoreData = {$iCoreData}; </script>
	<script src="{$smarty.const.ASSETS_PATH}/js/wm/api.js?v={$smarty.now}"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/iCore/iHTML-1.0.js?v={$smarty.now}"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/iCore/iDataTable-1.0.js?v={$smarty.now}"></script>
	<script src="{$smarty.const.ASSETS_PATH}/js/iCore/iCore-1.0.js?v={$smarty.now}"></script>	
	

	
</body>
</html>