<?php /* Smarty version 2.6.28, created on 2018-11-02 05:42:34
         compiled from Z:/home/aleney/www/crm/trend/templates/admin/logs.tpl */ ?>
<!-- start postfilter file="Z:/home/aleney/www/crm/trend/templates/admin/logs.tpl" -->
<!-- start prefilter file="Z:/home/aleney/www/crm/trend/templates/admin/logs.tpl" -->
<ul class="nav nav-tabs nav-tabs-justified">
	<li class="active">
		<a href="#tab_benzinga" data-toggle="tab" data-site="benzinga.com">
			<span class="visible-xs"><i class="fa-home"></i></span>
			<span class="hidden-xs">benzinga.com</span>
		</a>
	</li>
	<li>
		<a href="#tab_benzinga" data-toggle="tab" data-site="reuters.com">
			<span class="visible-xs"><i class="fa-user"></i></span>
			<span class="hidden-xs">reuters.com</span>
		</a>
	</li>
	<li>
		<a href="#tab_benzinga" data-toggle="tab" data-site="cnbc.com">
			<span class="visible-xs"><i class="fa-envelope-o"></i></span>
			<span class="hidden-xs">cnbc.com</span>
		</a>
	</li>
	<li>
		<a href="#tab_benzinga" data-toggle="tab" data-site="marketwatch.com">
			<span class="visible-xs"><i class="fa-cog"></i></span>
			<span class="hidden-xs">marketwatch.com</span>
		</a>
	</li>
	<li>
		<a href="#tab_benzinga" data-toggle="tab" data-site="zacks.com">
			<span class="visible-xs"><i class="fa-bell-o"></i></span>
			<span class="hidden-xs">zacks.com</span>
		</a>
	</li>
</ul>
		
<div class="tab-content">
	<div class="tab-pane active" id="tab_benzinga">

	
	
	</div>
	<div class="tab-pane" id="tab_reuters">
		
			
	</div>
	<div class="tab-pane" id="tab_cnbc">
		

	</div>
	
	<div class="tab-pane" id="settings-3">
			

	</div>
	
	<div class="tab-pane" id="inbox-3">
			

	</div>
</div>



<?php echo '
<script>

$(document).ready(function()  {
	API.dataRequestOnLoad.push( {name: "GetLogs", params: {site: "benzinga.com"} } );
})


	$("[data-toggle]").bind("click", function(e) {
		let $this = $(this);
		$(".panel").addClass("wm_check_for_update");
		console.log( $this.attr("data-site"));
		api_request( "GetLogs", {site: $this.attr("data-site")} );
	});

</script>
'; ?>

<!-- end prefilter file="Z:/home/aleney/www/crm/trend/templates/admin/logs.tpl" -->
<!-- end postfilter file="Z:/home/aleney/www/crm/trend/templates/admin/logs.tpl" -->
