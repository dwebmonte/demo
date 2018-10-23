<?php /* Smarty version 2.6.28, created on 2017-04-07 23:38:08
         compiled from main.tpl */ ?>



<?php if (isset ( $_SESSION['user'] )): ?>
<div class="row">
			<div class="panel panel-default panel-border">
			<div class="panel-heading">Шаг 1: Загрузите ваше фото</div>
			<div class="panel-body">
				
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10 pp_wrapper" style="text-align: center">
						<input type="hidden" name="pic_file_name" class="pp_input" value="" />
						<button class="btn btn-purple btn-icon btn-icon-standalone btn-lg pp_btn"  id="plupload_browser_1" style="margin: 0px;">
							<i class="fa-image"></i>
							<span>Загрузить фото</span>
						</button>
						
						<p style="padding-top: 10px;" class="bg-primary1" id="upload_info">Нажмите на кнопку, чтобы загрузить ваше фото на картины интерьеров</p>
					</div>
					<div class="col-sm-1">
						
					
					</div>
				</div>	
				
			</div>
		</div>
	
</div>
<?php else: ?>
<div class="row">
		<div class="panel panel-default panel-border">
		<div class="panel-heading">Шаг 1: Залогиньтесь, чтобы загрузить свои фотографии на картины интерьеров</div>
		<div class="panel-body">
			
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-10 pp_wrapper" style="text-align: center">
					<div id="uLogin" data-ulogin="display=panel;optional=first_name,last_name,photo,photo_big,email,nickname,bdate,sex,phone,city,country,network,profile,uid,identity,manual,verified_email;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=http%3A%2F%2F<?php echo $_SERVER['HTTP_HOST']; ?>
%2Fproject%2Finterier-413648%2F"></div>	
				</div>
				<div class="col-sm-1"></div>
			</div>	
			
		</div>
	</div>
	
</div>





<?php endif; ?>







<div class="row">

		<div class="panel panel-default panel-border">
			<div class="panel-heading">Шаг 2: Установите параметры</div>
			<div class="panel-body">
				

				<form enctype="multipart/form-data" method="POST" class="validate" role="form" novalidate="novalidate" id="load_data_form">
					<div class="col-md-6">
					
						<label for="field-5" class="control-label">Категория интерьера</label>
						<div  class="form-group">
							<select class="form-control" autocomplete="off" name="category_id">
								<?php $_from = $this->_tpl_vars['data_category'];if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key_cat'] => $this->_tpl_vars['item_cat']):
?>
									<option class='' value='<?php echo $this->_tpl_vars['item_cat']->id; ?>
'><?php echo $this->_tpl_vars['item_cat']->title; ?>
</option>
								<?php endforeach; endif; unset($_from); ?>
							</select>		
						</div>	
					
					</div>
					
					<div class="col-md-3">
						<label for="field-5" class="control-label">Введите длину картины в см</label>
						<div  class="form-group">
							<input type="text" name="width" id="field-5" data-validate="required" value="1000" class="form-control required" placeholder="" data-message-required="Введите ширину картины" value="<?php if (( isset ( $_REQUEST['width'] ) && ! empty ( $_REQUEST['width'] ) )): ?><?php echo $_REQUEST['width']; ?>
<?php endif; ?>"/>
						</div>
					</div>
					
					<div class="col-md-3">
						<!--!
						<label for="field-5" class="control-label">&nbsp;&nbsp;&nbsp;</label>
						<div  class="form-group">
							<button type="submit" id="start_show" class="btn btn-success btn-lg">Начать просмотр</button>
						</div>
						-->
					</div>
					
					
				</form>	
			
			
			
			</div>
		</div>



</div>



<div class="row" style="padding-bottom: 15px;">
	<!--!
	<div class="col-sm-1">
		<a class="jCarouselLite_prev fa fa-chevron-left" href="#"></a>
	</div>
	
	<div class="col-sm-10">
		<div class="jCarouselLite" style="width:100%">
            <ul></ul>			
		</div>
	</div>

	<div class="col-sm-1">
		<a class="jCarouselLite_next fa fa-chevron-right" href="#"></a>
	</div>
	-->

	<div class="col-sm-12">
		<div class="jCarouselLite" style="width:100%">
            <ul></ul>			
		</div>
	</div>



</div>








<div class="row">
	<div class="col-md-1">
		<a href="#" id="prev_bg" class="fa fa-chevron-left" style="font-size: 32px; margin: 150px 0px 0px;"></a>
	</div>
	<div class="col-md-10 canvas_area"  style="min-height: 500px;">
		<canvas id='example' style="margin: 0px auto; display: block;">Обновите браузер</canvas>
	</div>
	<div class="col-md-1">
		<a href="#" id="next_bg" class="fa fa-chevron-right" style="font-size: 32px; margin: 150px 0px 0px;"></a>
	</div>
</div>











<div class="row">
	<div class="col-md-12 info_bar"></div>

</div>




<div class="row">
	<div class="col-md-12" style="text-align: center; padding-top: 50px;">
		<?php if (isset ( $_SESSION['user'] )): ?>
			<form id="save_form" method="POST" action=""> 
				<input type="hidden" value="" name="post">
				<button class="btn btn-purple btn-lg" type="submit" id="save_image">Сохранить</button>
				
				<?php if ($_SESSION['user']['allowed'] == 0): ?>
					<button class="btn btn-success btn-lg" type="button" id="save_image" data-ajax-e='ajax_payment_form' data-ajax-c="iInterier">Сохранить без водяных знаков</button>
					<!-- <a class='btn btn-secondary btn-lg btn-icon icon-left' href='#' data-ajax-e='ajax_payment_form' data-ajax-c="iInterier" data-ajax-param='"entity":"interier_category"'>Добавить</a> -->
				<?php endif; ?>		
			</form>
		<?php endif; ?>
	</div>
</div>

<script>
<?php echo $this->_tpl_vars['js_data_image']; ?>
;
</script>