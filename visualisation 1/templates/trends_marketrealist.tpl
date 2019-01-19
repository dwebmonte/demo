<div class="row">
	<form role="form" method="POST" action="" id="awerer">
			 	
		<div class="form-group  col-sm-4">
			<label>Date:</label>

			<div class="input-group">
				<input type="text" class="form-control datepicker"  name="from" data-format="yyyy-mm-dd" data-start-date="2018-11-29" value="{$from}">
				<div class="input-group-addon"><a href="#"><i class="linecons-calendar"></i></a></div>
			</div>			
		</div>

		{*
		<div class="form-group  col-sm-3">
			<label>Date to:</label>
			
			<div class="input-group">
				<input type="text" class="form-control datepicker"  name="to" data-format="yyyy-mm-dd" data-start-date="2018-11-30" value="{$to}" >
				<div class="input-group-addon"><a href="#"><i class="linecons-calendar"></i></a></div>
			</div>			
		</div>
		*}
		
		<div class="form-group  col-sm-4">
			<label>Similarity coefficient:</label>
			
			<select class="form-control" name="min_koef">
				<option value="0.3" {if $min_koef == 0.3}selected{/if}>30% (min)</option>
				<option value="0.4" {if $min_koef == 0.4}selected{/if}>40%</option>
				<option value="0.5" {if $min_koef == 0.5}selected{/if}>50% (normal)</option>
				<option value="0.6" {if $min_koef == 0.6}selected{/if}>60%</option>
				<option value="0.7" {if $min_koef == 0.7}selected{/if}>70% (high)</option>
			</select>
		</div>
		
		<div class="form-group col-sm-12">
			<button type="submit" class="btn btn-primary btn-single pull-right">Show trends</button>
		</div>
				
	</form>
</div>

{literal}
<script>
$(document).ready(function()  {
	$("#awerer").bind("submit", function(e) {
		console.log("1212");
		
		return true;

	});

});
</script>
{/literal}




<!--
<div class="panel-group" id="accordion-test-2">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2">
					Collapsible Group Item #1
				</a>
			</h4>
		</div>
		<div id="collapseOne-2" class="panel-collapse collapse in">
			<div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseTwo-2" class="collapsed">
					Collapsible Group Item #2
				</a>
			</h4>
		</div>
		<div id="collapseTwo-2" class="panel-collapse collapse">
			<div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseThree-2" class="collapsed">
					Collapsible Group Item #3
				</a>
			</h4>
		</div>
		<div id="collapseThree-2" class="panel-collapse collapse">
			<div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
			</div>
		</div>
	</div>
</div>
-->

{literal}
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
{/literal}












<div class="panel-group" id="accordion-test">
{foreach from=$data_fetch key=key_block item=item_block}
	<div class="panel panel-default">
		{foreach from=$item_block item=item key=key name=news}
			{if $smarty.foreach.news.index==0}
				<div class="panel-heading">
					<h4 class="panel-title" >
						<a data-toggle="collapse" data-parent="#accordion-test" href="#collapseThree-{$key_block}" class="collapsed">
						<span class="badge badge-white">{$smarty.foreach.news.total}</span>
						{$item.article->title}
						</a>
					</h4>
					<div class="label label-success label_category">{$item.article->categories}</div>
					
					
				</div>
			{/if}
		{/foreach}
		<div id="collapseThree-{$key_block}" class="panel-collapse collapse">
			<div class="panel-body">
				{foreach from=$item_block item=item key=key name=news}
					<h5> 
					
							<i class="fa-comment popover-secondary copy_article" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{$item.article->text_300w}" data-original-title="{$item.article->title}"></i>

							{if is_null($item.article->user_id_at_work)}
								<a href="#" data-article-id="{$item.article->id}" api-href="article/at_work" api-param='"article_id":"{$item.article->id}"' {literal} api-handler='if (state == "action" && data.do == "state") { console.log(data.res); let $i = $(".in_work[data-article-id="+ data.article_id +"] > i"); if (!data.res) $i.removeClass("fa-bell").addClass("fa-bell-o"); else $i.removeClass("fa-bell-o").addClass("fa-bell"); }' {/literal} class="in_work"><i class="fa-bell-o"></i></a>
							{elseif $item.article->user_id_at_work == $smarty.session.user.id}
								<a href="#" data-article-id="{$item.article->id}" api-href="article/at_work" api-param='"article_id":"{$item.article->id}"' {literal} api-handler='if (state == "action" && data.do == "state") { console.log(data.res); let $i = $(".in_work[data-article-id="+ data.article_id +"] > i"); if (!data.res) $i.removeClass("fa-bell").addClass("fa-bell-o"); else $i.removeClass("fa-bell-o").addClass("fa-bell"); }' {/literal} class="in_work"><i class="fa-bell"></i></a>
							{else}
								<i class="fa-bell-slash out_work"></i>
							{/if}							
							
							
							<a class="" href="{$item.article->url}" target="_blank">{$item.article->title}</a>
							<span class="time">{$item.article->time_added}</span>
							<span class="label label-success label_category_litte">{$item.article->categories}</span>
							
							{*
							<a class="fa fa-external-link" href="{$item.article->url}" target="_blank">
								<span>{$item.article->url|url}</span>
							</a>
							*}

					</h5>
				{/foreach}
			</div>
		</div>
	</div>
{/foreach}
</div>





{*
{foreach from=$data_fetch item=item_block}
<div class="block_news">
	{foreach from=$item_block item=item key=key name=news}
		<div class="item_news">
			{if $smarty.foreach.news.index==0}
				<h3><a class="fa fa-external-link" href="{$item.article->url}" target="_blank"></a>{$item.article->title}</h3>
				<div class="label label-success label_category">{$item.article->category}</div>
			{else}
				<h5><a class="fa fa-external-link" href="{$item.article->url}" target="_blank"></a>{$item.article->title}</h5>
			{/if}

		</div>
	{/foreach}
</div>
{/foreach}
*}