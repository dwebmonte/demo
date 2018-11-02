<?php /* Smarty version 2.6.28, created on 2018-08-11 12:35:58
         compiled from b-login.tpl */ ?>
<!-- start postfilter file="b-login.tpl" -->
<!-- start prefilter file="b-login.tpl" -->
				 <form method="POST" role="form" id="login-form" class="login-form fade-in-effect" action="<?php echo @HTTP_HOST; ?>
/<?php echo @ADMIN_ROUTE_URL; ?>
"> 
					<div class="login-header">
						<a href="#" class="logo" style="color: white;text-transform: uppercase;font-size: 22px;font-family: arial;">
							<?php echo $this->_config[0]['vars']['loginHello']; ?>

						</a>
						<p>Введите логин и пароль для доступа к панели администратора</p>
					</div>					
	
					<div class="form-group">
						<label class="control-label" for="username">Логин</label>
						<input type="text" class="form-control input-dark" name="login" autocomplete="off" />
					</div>
	
					<div class="form-group">
					<label class="control-label" for="passwd">Пароль</label>  
						<input type="password" class="form-control input-dark" name="password" autocomplete="off" />
					</div>
	
					<div class="form-group">
						<button type="submit" class="btn btn-dark  btn-block text-left">
							<i class="fa-lock"></i>Войти
						</button>
					</div>
	
	
				</form>
<!-- end prefilter file="b-login.tpl" -->
<!-- end postfilter file="b-login.tpl" -->
