<?php /* Smarty version 2.6.28, created on 2018-11-21 12:05:50
         compiled from /var/www/html/visualisation+1/templates/admin/testing.tpl */ ?>
<!-- start postfilter file="/var/www/html/visualisation 1/templates/admin/testing.tpl" -->
<!-- start prefilter file="/var/www/html/visualisation 1/templates/admin/testing.tpl" -->
<div class="panel panel-default panel-border">
	<div class="panel-heading">Category recognition</div>
	<div class="panel-body">
		<form role="form" api-set="Recognition/Categories">
			<div class="form-group">
				<label>Enter your article text:</label>
				<textarea name="text" style="height: 200px;" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<label>Deep search:</label>
			<input name="deep_search" type="text" class="form-control" value="50" />
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-single pull-right" type="submit">Recognize category</button>
			</div>
		</form>			
	</div>
</div>



<div class="panel panel-default panel-border">
	<div class="panel-heading">Recognized categories</div>
	<div class="panel-body" id="recognized_categories_cnbc_wrapper">
		

	
	
	
	</div>
</div>

<div class="panel panel-default panel-border">
	<div class="panel-heading">Categories</div>
	<div class="panel-body" id="categories_cnbc_wrapper">
		

	
	
	
	</div>
</div>









<!-- end prefilter file="/var/www/html/visualisation 1/templates/admin/testing.tpl" -->
<!-- end postfilter file="/var/www/html/visualisation 1/templates/admin/testing.tpl" -->
