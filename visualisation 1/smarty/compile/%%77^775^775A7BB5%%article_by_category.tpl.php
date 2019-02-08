<?php /* Smarty version 2.6.28, created on 2019-01-31 18:56:51
         compiled from Z:/home/aleney/www/aggnews.tickeron.com/visualisation+1/templates/article_by_category.tpl */ ?>
<!-- start postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/article_by_category.tpl" -->
<!-- start prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/article_by_category.tpl" -->

<div class="row">
	<div class="col-sm-4">
		<div class="panel panel-default panel-border" style="min-height: 400px;">
			<div class="panel-body">
				<div style="border-bottom: 1px solid #ccc;padding-bottom: 5px;margin-bottom: 5px;">
					<a href="#" id="open_all">Expand all</a>
					<a href="#" id="close_all" style="float: right;">Collapse all</a>
				</div>
				<div id="treeContainer"></div>		

			
			
			
			</div>
		</div>
	
		
	
	
	</div>
	<div class="col-sm-8">
		<div class="panel panel-default panel-border" id="panel_articles_by_category" style="min-height: 400px;">
			<div class="panel-body">
				

			
			
			
			</div>
		</div>	
	
	
	</div>	
	
</div>


<?php echo '
<script>
$(document).ready(function()  {
	$("#open_all").bind("click", function(e) {
		$("#treeContainer").jstree("open_all");
		return false;
	});

	$("#close_all").bind("click", function(e) {
		$("#treeContainer").jstree("close_all");
		return false;
	});
 

	$(\'#treeContainer\').jstree({ \'core\' : {
		\'data\' : '; ?>
<?php echo $this->_tpl_vars['json_cat']; ?>
 <?php echo '
	} });


	$("#treeContainer").bind("select_node.jstree", function(evt, data){
		$(\'#panel_articles_by_category\').addClass("wm_check_for_update");

		api_request("Get/Category/Articles", {category_id: data.node.id}, function( state, data ) {
			$(\'#panel_articles_by_category\').removeClass("wm_check_for_update");
		});

	});

});
</script>


'; ?>






<?php echo '
<style>
	.fa.fa-external-link {
		float: right;
	}	

.fa.fa-external-link span {
	padding-left: 5px;
	font-family: Arimo,"Helvetica Neue",Helvetica,Arial,sans-serif;
}	
	
	.panel-group > .panel {
		position: relative;
	}	


	.time {
		color: gray;
		font-size: 10px;
		padding-left: 10px;
	}
	
	.popover{
		max-width: 100%; /* Max Width of the popover (depending on the container!) */
	}	
	
	.fa-comment {
		padding-right: 5px;
		color: #65ae00;
		cursor: pointer;
	}	
	
	.panel-title .badge.badge-white {
		margin-right: 8px;
		font-size: 10px;
		position: relative;
		top: -2px;
		

	background-color: #fff;
	color: #333;
	-webkit-box-shadow: 0 0 0 1px #ddd;
	-moz-box-shadow: 0 0 0 1px #ddd;
	box-shadow: 0 0 0 1px #ddd;
		
	}	
</style>
'; ?>


<!-- end prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/article_by_category.tpl" -->
<!-- end postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/article_by_category.tpl" -->
