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
							<img src="{$smarty.session.user.image|default:"`$smarty.const.ASSETS_PATH`/images/user-4.png"}" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
							{* <span>{$smarty.session.user.login}&nbsp;<i class="fa-angle-down"></i></span> *}
							<span>{$smarty.session.user.name|default:"Admin"}&nbsp;(ID: {$smarty.session.user.id})&nbsp;<i class="fa-angle-down"></i></span>
						</a>
			
						<ul class="dropdown-menu user-profile-menu list-unstyled">
							<li><a href="{$smarty.const.HTTP_HOST}/{$smarty.const.ADMIN_ROUTE_URL}profile"><i class="fa-user"></i>Profile</a></li>
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
					
					{*
					<li>
						<a href="#" id="cron_tick">
							<i class="fa-comments-o"></i>
						</a>
					</li>					
					*}
					
				</ul>
