global_ajax_data = {};

 AL3 = {
	sys_data: undefined,
	ajax_mode: 0,
	ajax_loader_url: "",
	ajax_start: function() {
		if (AL3.ajax_mode == 1) {
			console.warn("ajax has been already started");
			return false;
		} else {
			AL3.ajax_mode = 1;		
			show_loading_bar(90);
			AL3.sys_data = undefined;
			return true;
		};	
	},
	ajax_stop: function() {

		AL3.ajax_mode = 0;
		//show_loading_bar(100);
		hide_loading_bar();
	},
	
	
	handler: {
		// Информационное сообщение
		info: function(item_data) {
			if (item_data.expire === undefined) expire = 300000; else expire = item_data.expire*1;
			if (item_data.title === undefined) item_data.title = null;
			
			switch (item_data.type) {
				case "info":			toastr.success( item_data.html, item_data.title,  {"timeOut": expire, "closeButton": true});	break;		
				case "error":			toastr.error( item_data.html, item_data.title,  {"timeOut": expire, "closeButton": true});	break;		
				case "warning":	toastr.warning( item_data.html, item_data.title,  {"timeOut": expire, "closeButton": true});	break;		
				default: 				toastr.info( item_data.html, item_data.title,  {"timeOut": expire, "closeButton": true});	break;	
			};			
		},
		// console
		console: function(item_data) {
			console.info(item_data.html);
		}			
		
		
		
		
		
	},
	handler_event_after: {
		
		
		
		
		
		
	},
	
	// Обработчик результатов
	handle: function(data, close_modal_win) {
		if ( data.data !== undefined && data.data.length === undefined) console.error("Возвращаемый параметр data не массив!");
		
		for (i=0; i<data.data.length; i++) {
			if (data.data[i] == undefined) continue;
			item_data = data.data[i];

			
			if (item_data.uid !== undefined) {
				$uid = $(item_data.uid);
				if ($uid.length == 0) console.error("Не найден элемент для вставки ajax, uid='"+item_data.uid+"'");						
			};


			
			// Встроенный метод обработки результатов
			if (  typeof AL3.handler[ item_data.action ] === 'function' ) {
				AL3.handler[ item_data.action ](item_data);
				continue;
			};
			
			
			if (close_modal_win === undefined || close_modal_win === 1) { 
				if ($("#modal-bootstrap").is(":visible") && item_data.action !== 'modal_window') jQuery('#modal-bootstrap').modal('hide');
			};
			
			// Выбираем действие в зависимости от action
			switch (item_data.action) {
				case 'replace':				$uid.replaceWith(item_data.html);							break;			
				case "append":			$uid.append(  item_data.html  );								break;
				case "prepend":			$uid.prepend(  item_data.html  );							break;
				case "prepend_html":	$uid.prepend(  $(item_data.html).html()  );				break;
				case "text":				$uid.text(  item_data.html  );									break;
				case "html":				$uid.html(  item_data.html  );									break;
				case "class":				$uid.addClass(  item_data.class, item_data.html  );							break;
				case "removeClass":		$uid.removeClass(  item_data.html  );						break;
				case "attr":					$uid.attr(  item_data.attr, item_data.html  );							break;
				case "removeAttr":		$uid.removeAttr(  item_data.html  );						break;
				
				
				
				
				case "sys_data":			AL3.sys_data = item_data;										break;
				case "redirect": 			document.location.href = item_data.html;					break;
				case 'modal_window':
					//console.info("modal_window");
					
					 //style="width: 96%"
					
					//$('#modal-bootstrap .modal-dialog').
					
					if (jQuery('#modal-bootstrap').length == 0) {
						console.error("Вы забыли вставить участок окна с #modal-bootstrap в код");
						
					} else {
						jQuery('#modal-bootstrap').modal('show', {backdrop: true});
						jQuery('#modal-bootstrap .modal-content').html( item_data.html );							
						if (global_ajax_data !== undefined && global_ajax_data.is_admin && window.iAP!==undefined) iAP.update_attr($("#modal-bootstrap .modal-body"));		
						if (item_data.title) $('.modal-header .modal-title').html( item_data.title  );
						
						
						$("[data-mask]").each(function(i, el)
						{
							var $this = $(el),
								mask = $this.data('mask').toString(),
								opts = {
									numericInput: attrDefault($this, 'numeric', false),
									radixPoint: attrDefault($this, 'radixPoint', ''),
									rightAlign: attrDefault($this, 'numericAlign', 'left') == 'right'
								},
								placeholder = attrDefault($this, 'placeholder', ''),
								is_regex = attrDefault($this, 'isRegex', '');

							if(placeholder.length)
							{
								opts[placeholder] = placeholder;
							}

							switch(mask.toLowerCase())
							{
								case "phone":
									mask = "(999) 999-9999";
									break;

								case "currency":
								case "rcurrency":

									var sign = attrDefault($this, 'sign', '$');;

									mask = "999,999,999.99";

									if($this.data('mask').toLowerCase() == 'rcurrency')
									{
										mask += ' ' + sign;
									}
									else
									{
										mask = sign + ' ' + mask;
									}

									opts.numericInput = true;
									opts.rightAlignNumerics = false;
									opts.radixPoint = '.';
									break;

								case "email":
									mask = 'Regex';
									opts.regex = "[a-zA-Z0-9._%-]+@[a-zA-Z0-9-]+\\.[a-zA-Z]{2,4}";
									break;

								case "fdecimal":
									mask = 'decimal';
									$.extend(opts, {
										autoGroup		: true,
										groupSize		: 3,
										radixPoint		: attrDefault($this, 'rad', '.'),
										groupSeparator	: attrDefault($this, 'dec', ',')
									});
							}

							if(is_regex)
							{
								opts.regex = mask;
								mask = 'Regex';
							}

							$this.inputmask(mask, opts);
						});						
						
						
					};
				break;							
				
				default: console.error("Неизвестный action для ajax = '"+item_data.action+"'");	
			};


		};	
	
	},
	
	send_obj: function($obj) {	
		//if (!AL3.ajax_start()) return false;

		
		
		AL3.ajax_start();
		
		
		if ( $obj.attr("data-ajax-c") ) ajax_class = $obj.attr("data-ajax-c"); else ajax_class = $obj.closest("[data-ajax-c]").attr("data-ajax-c");
		// if (ajax_class === undefined) console.error("Не найден ajax class у события " + $obj.attr("data-ajax-e"));
	
		
		var ajax_event = $obj.attr("data-ajax-e");		
		var send_data = {c: ajax_class, e: ajax_event};
		
		
		if ($obj.is("form")) send_data.form = $obj.serialize();
		else send_data.data = $obj.data();			
		
		
		//jQuery('#modal-bootstrap').modal('hide');
		
		
		
		$.ajax({ url: AL3.ajax_loader_url, type:'POST', data:send_data, dataType: "html",
			success:function(data){
				if (data!='' && data!='null') { 
					data = jQuery.parseJSON(data);		
					AL3.handle(data);
				};
				
				
				
				AL3.ajax_stop();
				// Встроенный метод обработки event
				if (  typeof AL3.handler_event_after[ ajax_event ] === 'function' ) {
					AL3.handler_event_after[ ajax_event ](item_data);
				};				
				

				
			
				
				
				
			}/*,
			error: function( jqXHR, textStatus, errorThrown ) {
				console.error( jqXHR, textStatus, errorThrown );
				return 0;
			}
			*/
		});		
	},
	

	
};













	$(document).on('click', 'button[data-ajax-e]:not(.disabled), a[data-ajax-e]:not(.disabled)', function() {
		AL3.send_obj($(this));
		return false;
	});
	
	$(document).on('submit', 'form[data-ajax-e]:not(.disabled)', function() {
		AL3.send_obj($(this));
		return false;
	});

	
	// Закрытие модального окна после сохранения
	/*
	$(document).on("submit", ".modal-body form", function(e) {
		jQuery('#modal-bootstrap').modal('hide');							
	});	
	*/