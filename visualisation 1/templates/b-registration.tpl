

<form  id="registration-form" class="login-form fade-in-effect frm_register" style="display: none" action="">
	<div class="login-header">
		<a href="#" class="logo" style="color: white;text-transform: uppercase;font-size: 22px;font-family: arial;">
			Открыть счет
		</a>
		<p>Введите регистрационную информацию о себе</p>
	</div>	
	
	<div class="form-group">
		<label class="control-label" for="username">Имя</label>
		<input type="text" class="form-control input-dark" name="first_name" autocomplete="off" />
	</div>	
	
	<div class="form-group">
		<label class="control-label" for="username">Фамилия</label>
		<input type="text" class="form-control input-dark" name="second_name" autocomplete="off" />
	</div>	
	
	<div class="form-group">
		<label class="control-label" for="username">Электронная почта</label>
		<input type="text" class="form-control input-dark" name="email" autocomplete="off" />
	</div>		

	<div class="form-group">
		{include file="b-select-country.tpl"}
	</div>
	
	<div class="form-group">
		<label class="control-label" for="username">Телефон</label>
		<input value="380" type="text" class="form-control input-dark" name="phone" autocomplete="off" />
	</div>	
	
	<div class="form-group">
		<label class="control-label" for="username">Пароль</label>
		<input type="password" class="form-control input-dark" name="password" autocomplete="off" />
	</div>
	
	<div class="form-group">
		<label class="control-label" for="username">Повторите пароль</label>
		<input type="password" class="form-control input-dark" name="password_repeat" autocomplete="off" />
	</div>	

	<div class="form-group">
		<button type="submit" class="btn btn-dark  btn-block text-left">
			<i class="fa-lock"></i>Открыть счет
		</button>
	</div>

	<div class="login-footer">
		<a href="#" class="login-form-show" style="color: white">Я уже зарегистрирован</a>
		<a href="#" class="restore-password-show" style="float: right">Забыли пароль?</a>

		<div class="info-links">
		<!-- <a href="#">ToS</a> -->
		<a href="#">Privacy Policy</a> 
		
		</div>
	</div>
</form>

