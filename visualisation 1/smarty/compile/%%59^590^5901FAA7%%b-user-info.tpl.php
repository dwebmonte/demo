<?php /* Smarty version 2.6.28, created on 2018-11-30 18:24:28
         compiled from admin/b-user-info.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin/b-user-info.tpl', 20, false),)), $this); ?>
<!-- start postfilter file="admin/b-user-info.tpl" -->
<!-- start prefilter file="admin/b-user-info.tpl" -->
				<ul class="user-info-menu right-links list-inline list-unstyled">
				
				<!-- You can add "always-visible" to show make the search input visible -->
				<!--
					<li class="search-form">
			
						<form name="userinfo_search_form" method="get" action="extra-search.html">
							<input type="text" name="s" class="form-control search-field" placeholder="Type to search..." />
			
							<button type="submit" class="btn btn-link">
								<i class="linecons-search"></i>
							</button>
						</form>
					</li>
			-->
			
					<li class="dropdown user-profile">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php echo ((is_array($_tmp=@$_SESSION['user']['image'])) ? $this->_run_mod_handler('default', true, $_tmp, (@ASSETS_PATH)."/images/user-4.png") : smarty_modifier_default($_tmp, (@ASSETS_PATH)."/images/user-4.png")); ?>
" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
														<span><?php echo ((is_array($_tmp=@$_SESSION['user']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Admin') : smarty_modifier_default($_tmp, 'Admin')); ?>
&nbsp;(ID: <?php echo $_SESSION['user']['id']; ?>
)&nbsp;<i class="fa-angle-down"></i></span>
						</a>
			
						<ul class="dropdown-menu user-profile-menu list-unstyled">
							<li><a href="<?php echo @HTTP_HOST; ?>
/<?php echo @ADMIN_ROUTE_URL; ?>
profile"><i class="fa-user"></i>Profile</a></li>
							<li class="last"><a  api-href="user/logout" href="#"><i class="fa-lock"></i>Exit</a></li>						
<!--							
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
							
-->
						</ul>
					</li>
					
										
				</ul>

<!-- end prefilter file="admin/b-user-info.tpl" -->
<!-- end postfilter file="admin/b-user-info.tpl" -->
