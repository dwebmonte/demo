<?php /* Smarty version 2.6.28, created on 2018-11-16 18:23:51
         compiled from /var/www/html/visualisation+1/templates/home.tpl */ ?>
<!-- start postfilter file="/var/www/html/visualisation 1/templates/home.tpl" -->
<!-- start prefilter file="/var/www/html/visualisation 1/templates/home.tpl" -->
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
		<a href="#tab_benzinga" data-toggle="tab" data-site="benzinga.com">
			<span class="visible-xs"><i class="fa-cog"></i></span>
			<span class="hidden-xs">Settings</span>
		</a>
	</li>
	<li>
		<a href="#tab_benzinga" data-toggle="tab">
			<span class="visible-xs"><i class="fa-bell-o"></i></span>
			<span class="hidden-xs">Inbox</span>
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

<!-- end prefilter file="/var/www/html/visualisation 1/templates/home.tpl" -->
<!-- end postfilter file="/var/www/html/visualisation 1/templates/home.tpl" -->
