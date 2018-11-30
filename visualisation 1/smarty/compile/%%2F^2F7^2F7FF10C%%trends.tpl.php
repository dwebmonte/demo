<?php /* Smarty version 2.6.28, created on 2018-11-30 18:24:28
         compiled from Z:/home/aleney/www/crm/news_aggregator/templates/trends.tpl */ ?>
<!-- start postfilter file="Z:/home/aleney/www/crm/news_aggregator/templates/trends.tpl" -->
<!-- start prefilter file="Z:/home/aleney/www/crm/news_aggregator/templates/trends.tpl" -->
<div class="row">
	<form role="form" method="POST" action="" id="awerer">
				
		<div class="form-group  col-sm-3">
			<label>Date from:</label>

			<div class="input-group">
				<input type="text" class="form-control datepicker"  name="from" data-format="yyyy-mm-dd" data-start-date="2018-11-29" value="<?php echo $this->_tpl_vars['from']; ?>
">
				<div class="input-group-addon"><a href="#"><i class="linecons-calendar"></i></a></div>
			</div>			
		</div>

		<div class="form-group  col-sm-3">
			<label>Date to:</label>
			
			<div class="input-group">
				<input type="text" class="form-control datepicker"  name="to" data-format="yyyy-mm-dd" data-start-date="2018-11-30" value="<?php echo $this->_tpl_vars['to']; ?>
" >
				<div class="input-group-addon"><a href="#"><i class="linecons-calendar"></i></a></div>
			</div>			
		</div>
		
		<div class="form-group  col-sm-3">
			<label>Similarity coefficient:</label>
			
			<select class="form-control" name="min_koef">
				<option value="0.3" <?php if ($this->_tpl_vars['min_koef'] == 0.3): ?>selected<?php endif; ?>>30% (min)</option>
				<option value="0.4" <?php if ($this->_tpl_vars['min_koef'] == 0.4): ?>selected<?php endif; ?>>40%</option>
				<option value="0.5" <?php if ($this->_tpl_vars['min_koef'] == 0.5): ?>selected<?php endif; ?>>50% (normal)</option>
				<option value="0.6" <?php if ($this->_tpl_vars['min_koef'] == 0.6): ?>selected<?php endif; ?>>60%</option>
				<option value="0.7" <?php if ($this->_tpl_vars['min_koef'] == 0.7): ?>selected<?php endif; ?>>70% (high)</option>
			</select>
		</div>
		
		<div class="form-group col-sm-12">
			<button type="submit" class="btn btn-primary btn-single pull-right">Show trends</button>
		</div>
				
	</form>
</div>

<?php echo '
<script>
$(document).ready(function()  {
	$("#awerer").bind("submit", function(e) {
		console.log("1212");
		
		return true;

	});

});
</script>
'; ?>





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


<div class="panel-group" id="accordion-test">
<?php $_from = $this->_tpl_vars['data_fetch'];if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_block'] => $this->_tpl_vars['item_block']):
?>
	<div class="panel panel-default">
		<?php $_from = $this->_tpl_vars['item_block'];if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['news'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['news']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['news']['iteration']++;
?>
			<?php if (($this->_foreach['news']['iteration']-1) == 0): ?>
				<div class="panel-heading">
					<h4 class="panel-title" >
						<a data-toggle="collapse" data-parent="#accordion-test" href="#collapseThree-<?php echo $this->_tpl_vars['key_block']; ?>
" class="collapsed">
						<span class="badge badge-white"><?php echo $this->_foreach['news']['total']; ?>
</span>
						<?php echo $this->_tpl_vars['item']['article']->title; ?>

						</a>
					</h4>
					<div class="label label-success label_category"><?php echo $this->_tpl_vars['item']['article']->category0; ?>
&nbsp;/&nbsp;<?php echo $this->_tpl_vars['item']['article']->category1; ?>
&nbsp;/&nbsp;<?php echo $this->_tpl_vars['item']['article']->category2; ?>
</div>
					
					
				</div>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<div id="collapseThree-<?php echo $this->_tpl_vars['key_block']; ?>
" class="panel-collapse collapse">
			<div class="panel-body">
				<?php $_from = $this->_tpl_vars['item_block'];if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['news'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['news']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['news']['iteration']++;
?>
					<h5> 
					
							<i class="fa-comment popover-secondary" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $this->_tpl_vars['item']['article']->text_300w; ?>
" data-original-title="<?php echo $this->_tpl_vars['item']['article']->title; ?>
"></i>
							<a class="" href="<?php echo $this->_tpl_vars['item']['article']->url; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['article']->title; ?>
</a>
							<span class="time"><?php echo $this->_tpl_vars['item']['article']->time_added; ?>
</span>
							<span class="label label-success label_category_litte">
								<?php echo $this->_tpl_vars['item']['article']->category0; ?>
&nbsp;/&nbsp;<?php echo $this->_tpl_vars['item']['article']->category1; ?>
&nbsp;/&nbsp;<?php echo $this->_tpl_vars['item']['article']->category2; ?>

							</span>
							
							
					</h5>
				<?php endforeach; endif; unset($_from); ?>
			</div>
		</div>
	</div>
<?php endforeach; endif; unset($_from); ?>
</div>





<!-- end prefilter file="Z:/home/aleney/www/crm/news_aggregator/templates/trends.tpl" -->
<!-- end postfilter file="Z:/home/aleney/www/crm/news_aggregator/templates/trends.tpl" -->
