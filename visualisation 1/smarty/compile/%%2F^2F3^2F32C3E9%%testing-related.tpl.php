<?php /* Smarty version 2.6.28, created on 2018-11-14 18:33:53
         compiled from /var/www/html/visualisation+1/templates/admin/testing-related.tpl */ ?>
<!-- start postfilter file="/var/www/html/visualisation 1/templates/admin/testing-related.tpl" -->
<!-- start prefilter file="/var/www/html/visualisation 1/templates/admin/testing-related.tpl" -->
<div class="panel panel-default panel-border">
	<div class="panel-heading">User articles</div>
	<div class="panel-body" id="user_article_wrapper">
		

	
	
	
	</div>
</div>
	
<div class="panel panel-default panel-border">
	<div class="panel-heading">Add article</div>
	<div class="panel-body" id="user_article_wrapper">
		<form role="form" api-set="Articles/AddCustom">
			<input type="hidden" name="site" value="user_article_url" />
			
			<div class="form-group">
				<label>Title:</label>
				<input name="title" type="text" class="form-control" value="" />
			</div>		
		
			<div class="form-group">
				<label>Article text:</label>
				<textarea name="text" style="height: 300px;" class="form-control"></textarea>
			</div>

			<div class="form-group">
				<button class="btn btn-primary btn-single pull-right" type="submit">Add Article</button>
			</div>
		</form>		

	
	
	
	</div>
</div>	
		
		
<?php echo '
<script>
	

var func = function(state, action) {
	if (state == "action" && action.do == "block") {
		let html_row = "";
		
		action.data.forEach(function (row) {
			let block_name = row.name;
			let block_time = row.time;
			row.items.forEach(function (item) {
			html_row += "<tr><td>"+ block_name +"</td><td><a style=\'padding: 0 10px 0 0\' href=\'"+ item.url +"\' target=\'_blank\'><i class=\'fa-external-link\'></i></a>"+ item.title +"</td><td>"+ block_time +"</td></tr>";	
			});
		});
		
		$(\'#block_table tbody\').html( html_row );
	};

	
};

$(document).ready(function()  {
	API.dataRequestOnLoad.push( {name: "GetArticles", params: {site: "user_article_url"}} );
})


</script>
'; ?>

<!-- end prefilter file="/var/www/html/visualisation 1/templates/admin/testing-related.tpl" -->
<!-- end postfilter file="/var/www/html/visualisation 1/templates/admin/testing-related.tpl" -->
