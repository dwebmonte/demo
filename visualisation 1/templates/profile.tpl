<div class="panel panel-default panel-border wm_check_for_update">
	<div class="panel-heading">Личная информация</div>
	<div class="panel-body">
				
			
		<form class="form-horizontal" role="form" api-request="user/SetAccountInfo">
			<div class="form-group">
				<label class="col-sm-3 control-label">{#username#}:</label>
				<div class="col-sm-9">
					<input type="text" name="name" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label">{#email#}:</label>
				<div class="col-sm-9">
					<input type="email" name="email" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label">{#password#}:</label>
				<div class="col-sm-9">
					<input type="text" name="password" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>			
			
			<div class="form-group">
				<label class="col-sm-3 control-label">{#city#}:</label>
				<div class="col-sm-9">
					<input type="text" name="city" class="form-control">
				</div>
			</div>
			<div class="form-group-separator"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label">{#country#}:</label>
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



{literal}
<script>
	$(document).ready(function()  {
		API.dataRequestOnLoad.unshift({name: "user/GetAccountInfo"});
	});
	
</script>
{/literal}

