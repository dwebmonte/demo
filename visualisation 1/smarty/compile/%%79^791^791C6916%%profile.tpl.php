<?php /* Smarty version 2.6.28, created on 2018-11-05 13:17:12
         compiled from /var/www/html/visualisation+1/templates/profile.tpl */ ?>
<!-- start postfilter file="/var/www/html/visualisation 1/templates/profile.tpl" -->
<!-- start prefilter file="/var/www/html/visualisation 1/templates/profile.tpl" -->
<div class="panel panel-default panel-border wm_check_for_update">
	<div class="panel-heading">Личная информация</div>
	<div class="panel-body">
				
			
		<form class="form-horizontal" role="form" api-request="user/SetAccountInfo">
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo $this->_config[0]['vars']['username']; ?>
:</label>
				<div class="col-sm-9">
					<input type="text" name="name" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo $this->_config[0]['vars']['email']; ?>
:</label>
				<div class="col-sm-9">
					<input type="email" name="email" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo $this->_config[0]['vars']['password']; ?>
:</label>
				<div class="col-sm-9">
					<input type="text" name="password" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>			
			
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo $this->_config[0]['vars']['city']; ?>
:</label>
				<div class="col-sm-9">
					<input type="text" name="city" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php echo $this->_config[0]['vars']['country']; ?>
:</label>
				<div class="col-sm-9">
					<input type="text" name="country" class="form-control">
				</div>
			</div>
	
			
			
			<div class="form-group-separator"></div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-single pull-right">Сохранить</button>
			</div>

		</form>
			
			
			
			</div>
		</div>



<?php echo '
<script>
	$(document).ready(function()  {
		API.dataRequestOnLoad.unshift({name: "user/GetAccountInfo"});
	});
	
</script>
'; ?>



<!-- end prefilter file="/var/www/html/visualisation 1/templates/profile.tpl" -->
<!-- end postfilter file="/var/www/html/visualisation 1/templates/profile.tpl" -->
