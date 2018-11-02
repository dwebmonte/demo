{literal}
<style>
.tabs-vertical-env .nav.tabs-vertical li > a {
	background-color: #2c2e2f;
	color: #979898;
}

.tabs-vertical-env .nav.tabs-vertical li.active > a {
	color: black;
	background-color: #f8f8f8;
}

.tabs-vertical-env .tab-content {
	background: #2c2e2f;
}
.link-blocks-env1 label {
	color: #363636;
}
</style>
{/literal}
	<div class="settings-pane">
			
		<a href="#" data-toggle="settings-pane" data-animate="true">
			&times;
		</a>
		
		<div class="settings-pane-inner">
			
			<div class="row">
				
				<div class="col-md-4">
					
					<div class="user-info">
						
						<div class="user-image">
							<a href="#">
								<img src="{$smarty.session.user.image|default:"`$smarty.const.ASSETS_PATH`/images/user-2.png"}" class="img-responsive img-circle" />
							</a>
						</div>
						
						<div class="user-details">
							
							<h3>
								<a href="#">{$smarty.session.user.name}</a>
								
								<!-- Available statuses: is-online, is-idle, is-busy and is-offline -->
								<span class="user-status is-online"></span>
							</h3>
							
							<p class="user-title" style="padding: 0px 0px 0px 2px;">Администратор</p>
							
							<div class="user-links">
								<a href="#" class="btn btn-primary">Перейти в профиль</a>
							<!-- <a href="#" class="btn btn-success">Upgrade</a> -->
							</div>
							
						</div>
						
					</div>
					
				</div>
				
				<div class="col-md-8 link-blocks-env1">
					

					<div class="tabs-vertical-env">

	<ul class="nav tabs-vertical">
		<li class="active"><a href="#v-home" data-toggle="tab">Общая</a></li>
		<li><a href="#v-profile" data-toggle="tab">Адрес</a></li>
		<li><a href="#v-settings" data-toggle="tab">Пароль</a></li>
	</ul>
	
	<div class="tab-content" style="background: #f8f8f8;color: black">
		<div class="tab-pane active" id="v-home">
			<form class="form wm_localform" role="form" name="settings">
				
				<div class="form-group">
					<label>логин пользователя в базе личного кабинета</label>
					<input type="text" value="" name="login" class="form-control">
				</div>
				<div class="form-group-separator"></div>
				<!--
				<div class="form-group">
					<label>пароль пользователя</label>
					<input type="text" value="" name="password" class="form-control">
				</div>
				<div class="form-group-separator"></div>
				-->
				
				
				<div class="form-group">
					<label>имя пользователя</label>
					<input type="text" value="" name="first_name" class="form-control">
				</div>	
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<label>фамилия пользователя</label>
					<input type="text" value="" name="second_name" class="form-control">
				</div>	
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<label>отчество пользователя</label>
					<input type="text" value="" name="patronymic" class="form-control">
				</div>	
				<div class="form-group-separator"></div>

				<div class="form-group">
					<label>электронный адрес пользователя</label>
					<input type="text" value="" name="email" class="form-control">
				</div>	
				<div class="form-group-separator"></div>

				<div class="form-group">
					<label>номер телефона пользователя</label>
					<input type="text" value="" name="phone" class="form-control">
				</div>	
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-single pull-right">Сохранить</button>
				</div>	
			</form>



	</div>
	
		<div class="tab-pane" id="v-profile">
			
			<form class="form wm_localform" role="form" name="settings">
				<!--
				<div class="form-group">
					<label>двухбуквенный код страны в формате ISO 3166-1</label>
					<input type="text" value="" name="country" class="form-control">
				</div>
				<div class="form-group-separator"></div>
				-->
				
				<div class="form-group">
					<label>область</label>
					<input type="text" value="" name="area" class="form-control">
				</div>
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<label>город</label>
					<input type="text" value="" name="city" class="form-control">
				</div>	
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<label>адрес</label>
					<input type="text" value="" name="address" class="form-control">
				</div>	
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<label>почтовый индекс</label>
					<input type="text" value="" name="postcode" class="form-control">
				</div>	
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-single pull-right">Сохранить</button>
				</div>	
			</form>

			
			
		</div>
		

		<div class="tab-pane" id="v-settings">
			<form class="form wm_localform" role="form" id="change-password-form">
				<div class="form-group">
					<label>Введите новый пароль</label>
					<input type="text" value="" name="new_password" class="form-control">
				</div>
				<div class="form-group-separator"></div>
				
				<div class="form-group">
					<label>Повторите пароль еще раз</label>
					<input type="text" value="" name="password_repeat" class="form-control">
				</div>	
				<div class="form-group-separator"></div>
				
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-single pull-right">Сохранить</button>
				</div>	
			</form>


		</div>

	</div>
	
</div>
					
					
					
					
					
				</div>
				
			</div>
		
		</div>
		
	</div>