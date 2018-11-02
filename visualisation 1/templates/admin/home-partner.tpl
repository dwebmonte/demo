<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Посещения</h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped" id="example-4">
			<thead>
				<tr>
					<th>№</th>
					<th>Партнер</th>
					<th>url</th>
					<th>Действие</th>
					<th>Время</th>
				</tr>
			</thead>
		 
			<tfoot>
				<tr>
					<th>№</th>
					<th>Партнер</th>
					<th>Url</th>
					<th>Действие</th>
					<th>Время</th>
				</tr>
			</tfoot>
		 
			<tbody>
				{foreach from=$data_json key=key item=item}
				<tr>
					<td>{$key+1}</td>
					<td>{$item->partner_id}</td>
					<td>{$item->url}</td>
					<td>{$item->action}</td>
					<td>{$item->time|date:1}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		
	</div>
</div>				
			
			
			
			
	{literal}
	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$("#example-4").dataTable({
		});
	});
	</script>	
	
	{/literal}
			