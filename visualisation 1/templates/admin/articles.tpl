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

	

	<!--
		<table class="table responsive" id="block_table">
			<thead>
				<tr>	
					<th>Block</th>
					<th>Title</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	-->
	
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



{literal}
<script>
	

var func = function(state, action) {
	if (state == "action" && action.do == "block") {
		let html_row = "";
		
		action.data.forEach(function (row) {
			let block_name = row.name;
			let block_time = row.time;
			row.items.forEach(function (item) {
			html_row += "<tr><td>"+ block_name +"</td><td><a style='padding: 0 10px 0 0' href='"+ item.url +"' target='_blank'><i class='fa-external-link'></i></a>"+ item.title +"</td><td>"+ block_time +"</td></tr>";	
			});
		});
		
		$('#block_table tbody').html( html_row );
	};

	
};

$(document).ready(function()  {
	API.dataRequestOnLoad.push( {name: "GetArticles", params: {site: "benzinga.com"}} );
})


	$("[data-toggle]").bind("click", function(e) {
		let $this = $(this);
		$(".panel").addClass("wm_check_for_update");
		console.log( $this.attr("data-site"));
		api_request( "GetArticles", {site: $this.attr("data-site")});
	});

</script>
{/literal}