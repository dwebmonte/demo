<div class="panel panel-default panel-border">
	<div class="panel-heading">Cron status</div>
	<div class="panel-body">
		<div class="col-sm-6">
			<ul class="list-group list-group-minimal">
				{foreach from=$data_cron_watch1 item=item}
					<li class="list-group-item">
						<span class="badge badge-roundless badge-success">{$item->time}</span>
						{$item->cron} ({$item->param})
					</li>
				{/foreach}
			</ul>
		</div>				
		<div class="col-sm-6">
			<ul class="list-group list-group-minimal">
				{foreach from=$data_cron_watch2 item=item}
					<li class="list-group-item">
						<span class="badge badge-roundless badge-success">{$item->time}</span>
						{$item->cron} ({$item->param})
					</li>
				{/foreach}			</ul>
		</div>				
	</div>
</div>