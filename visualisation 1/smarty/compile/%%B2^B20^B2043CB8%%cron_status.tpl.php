<?php /* Smarty version 2.6.28, created on 2019-02-08 10:59:51
         compiled from Z:/home/aleney/www/aggnews.tickeron.com/visualisation+1/templates/cron_status.tpl */ ?>
<!-- start postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/cron_status.tpl" -->
<!-- start prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/cron_status.tpl" -->
<div class="panel panel-default panel-border">
	<div class="panel-heading">Cron status</div>
	<div class="panel-body">
		<div class="col-sm-6">
			<ul class="list-group list-group-minimal">
				<?php $_from = $this->_tpl_vars['data_cron_watch1'];if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<li class="list-group-item">
						<span class="badge badge-roundless badge-success"><?php echo $this->_tpl_vars['item']->time; ?>
</span>
						<?php echo $this->_tpl_vars['item']->cron; ?>
 (<?php echo $this->_tpl_vars['item']->param; ?>
)
					</li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>				
		<div class="col-sm-6">
			<ul class="list-group list-group-minimal">
				<?php $_from = $this->_tpl_vars['data_cron_watch2'];if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<li class="list-group-item">
						<span class="badge badge-roundless badge-success"><?php echo $this->_tpl_vars['item']->time; ?>
</span>
						<?php echo $this->_tpl_vars['item']->cron; ?>
 (<?php echo $this->_tpl_vars['item']->param; ?>
)
					</li>
				<?php endforeach; endif; unset($_from); ?>			</ul>
		</div>				
	</div>
</div>
<!-- end prefilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/cron_status.tpl" -->
<!-- end postfilter file="Z:/home/aleney/www/aggnews.tickeron.com/visualisation 1/templates/cron_status.tpl" -->
