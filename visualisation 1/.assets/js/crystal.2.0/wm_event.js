$(document).ready(function()  {
	
	// Добавление строчки таблицы
	$(document).on("click", ".wm_add_table", function(e) {
		let $this = $(this), $form = $this.closest("form");
		let DT = CD[ $form.attr("name") ];
 
		// прибавляем инкремент
		DT.last_index++;
	
		let row_insert = {DT_RowId: DT.last_index};
		//let row_insert = { };
		
		DT.fields.forEach(function (oField) {	
			if (oField.name == "id") row_insert[ oField.name ] = DT.last_index;
			else row_insert[ oField.name ] = null; });
	
		DT.obj.row.add( row_insert ).draw( 0 );
	});	
		
	// Выделение строки	
	$(document).on("click", "tr[role=row]", function(e) {
		if ($(e.target).is("td")) {
			let $this = $(this), $table = $this.closest("table");
			if ($this.hasClass("selected")) $this.removeClass("selected"); else $this.addClass("selected");
			
			// если есть какие-то выделенные строки
			if ($table.find("tr[role=row].selected:visible").length > 0) {
				$(".wm_btn_delete_table").removeAttr("disabled");
			} else {
				$(".wm_btn_delete_table").attr("disabled", true);
			};
			
		};
	});
	
	// Выделение всех строк
	$(document).on("dblclick", "tr[role=row]", function(e) {
		if ($(e.target).is("td")) {
			let $this = $(this), $table = $this.closest("table");
			
			// если есть какие-то выделенные строки
			if ($table.find("tr[role=row].selected:visible").length > 0) {
				$table.find("tr[role=row]:visible").removeClass("selected");
				$(".wm_btn_delete_table").attr("disabled", true);				
			} else {
				$table.find("tr[role=row]:visible").addClass("selected");
				$(".wm_btn_delete_table").removeAttr("disabled");
			};
			

		};
	});
		
	// Удаление строчки таблицы
	$(document).on("click", ".wm_btn_delete_table", function(e) {	
		let 
			$this = $(this), 
			$form = $this.closest("form"),
			formData = {}, 
			oName = $form.attr("name");
			
		// Удаляем строки из таблицы
		CD[oName].obj.row( "tr[role=row].selected" ).remove().draw();
		
		// кнопка удаления строк снова недостпная
		$(".wm_btn_delete_table").attr("disabled", true);
	});	

	
	// Удаление строчки таблицы
	$(document).on("click", ".wm_btn_delete_row_table", function(e) {	
		let 
			$this = $(this), 
			$form = $this.closest("form"),
			formData = {}, 
			oName = $form.attr("name");
			
		// Удаляем строки из таблицы
		CD[oName].obj.row( $this.closest("tr") ).remove().draw();

	});	
	
	// Отмена изменений
	$(document).on("click", ".wm_btn_cancel_table", function(e) {	
		let 
			$this = $(this), 
			$form = $this.closest("form"),
			oName = $form.attr("name"),
			DT = CD[oName];
			
		console.info( DT.data_prev );	
			
		DT.obj.clear().rows.add( DT.data_prev ).draw("page");
	});	
	
	// Сохранение формы
	$(document).on("submit", "form1", function(e) {
		let 
			$form = $(this), 
			oName = $form.attr("name"), 
			DT = CD[oName], 
			formData = {};
	
		if (CD.getItem( oName )  !== undefined) formData = CD.getItem( oName );								

	
		$form.serializeArray().forEach(function(item){ 
			
			// если это табличная строка
			let dataMatch = item.name.match(/^(.+?)\[(\d+)\]/); 
			if (dataMatch !== null) {
				let name = dataMatch[1], index = dataMatch[2];
				
				if (formData[ index ] === undefined) formData[ index ] = {};
				formData[ index ][ name ] = item.value;
			
			// если это простой элемент
			} else {
				formData[ item.name ] = item.value;
			};
		});		
		

		// если это таблица, то добавляем id к строкам
		if ($form.hasClass("dataTableForm")) {
			for (let row_id in formData) {
				formData[ row_id ][ "DT_RowId" ] = +row_id;
			};
		};	

		if ( $form.attr("api-save") ) {
			if ($form.attr("api-save") == "cd") CD.setItem( oName, formData);
			
			
			
			else {
			
			
			
				var regValue = /value\s*=\s*'([^']*?)'/i;
			
				for (obj_id in DT.obj.rows().data() ) {
					if (+obj_id == obj_id) {
						let oRow = DT.obj.rows().data()[ obj_id ];
						
						
						for (name in oRow) {
							let value = ( rowValue = regValue.exec(oRow[name]) ) ? rowValue[1] : oRow[ name ]; 

							console.log( name + "=" + value );
						};
						
						
					};
				};
			
				//console.info( DT.obj.rows().data() );
				
				// .rows().data()
			
				//api_request( $form.attr("api-save"), {  name: oName, data: DT.obj.rows().data()  });
				
				
			};
		};
		

	
		show_loading_bar({pct: 100, delay: 0.6});
		return false;
	});	


	// Детальное окно
	function format ( data ) {
		var 
			similar_id = "similar_" + data.id,
			table_similar_id = "table_similar_" + data.id,
			table_similar_title_id = "table_similar_title_" + data.id,
			table_similar_bool_id = "table_similar_bool_" + data.id,
			detail_id = "detail_" + data.id,
			html = "";		
		

		html += '<ul class="nav nav-tabs nav-tabs-justified">';
		html += '<li class="active"><a href="#'+detail_id+'" data-toggle="tab"><span>Detail information</span></a></li>';
		html += '<li><a href="#'+similar_id+'" data-toggle="tab"><span>Similar articles</span></a></li>';
		html += '</ul>';
		html += '<div class="tab-content">';
		html += '<div class="tab-pane active" id="'+detail_id+'"><div class="bottom_detail_block">'+ data.detail +'</div></div>';
		html += '<div class="tab-pane similar in_progress" id="'+similar_id+'">';
		html += '<h5>Search by text</h5>';
		html += '<table class="table similar_table" id="'+table_similar_id+'"><thead><tr><th>№</th><th>Title</th><th>Host</th><th>%</th><th>Updated</th></tr></thead><tbody></tbody></table>';
		html += '<h5>Search by title</h5>';
		html += '<table class="table similar_table" id="'+table_similar_title_id+'"><thead><tr><th>№</th><th>Title</th><th>Host</th><th>%</th><th>Updated</th></tr></thead><tbody></tbody></table>';
		html += '<h5>Search by first 100 words</h5>';
		html += '<table class="table similar_bool_table" id="'+table_similar_bool_id+'"><thead><tr><th>№</th><th>Title</th><th>Host</th><th>%</th><th>Updated</th></tr></thead><tbody></tbody></table>';
		html += '</div>';
		html += '</div>';	
	
	
		api_request("Article/Similar", {id: data.id}, function( state, action ) {
			
		
			if (state == "action" && action.do == "similar") {
				let html_row = "";
				
				action.data.similar.forEach(function (row) {
					html_row += "<tr><td>"+ row.id +"</td><td><a style='padding: 0 10px 0 0' href='"+ row.url +"' target='_blank'><i class='fa-external-link'></i></a>"+ row.title +"</td><td>"+ row.host +"</td><td>"+ row.percent +"</td><td>"+ row.time_added +"</td></tr>";
				});
				
				$('#' + table_similar_id + ' tbody').html( html_row );
				
				html_row = "";
				
				action.data.similar_bool.forEach(function (row) {
					html_row += "<tr><td>"+ row.id +"</td><td><a style='padding: 0 10px 0 0' href='"+ row.url +"' target='_blank'><i class='fa-external-link'></i></a>"+ row.title +"</td><td>"+ row.host +"</td><td>"+ row.percent +"</td><td>"+ row.time_added +"</td></tr>";
				});
				
				$('#' + table_similar_bool_id + ' tbody').html( html_row );
				
				html_row = "";
				
				action.data.similar_title.forEach(function (row) {
					html_row += "<tr><td>"+ row.id +"</td><td><a style='padding: 0 10px 0 0' href='"+ row.url +"' target='_blank'><i class='fa-external-link'></i></a>"+ row.title +"</td><td>"+ row.host +"</td><td>"+ row.percent +"</td><td>"+ row.time_added +"</td></tr>";
				});
				
				$('#' + table_similar_title_id + ' tbody').html( html_row );				
				
				
				
				
				
				$('#' + similar_id).removeClass("in_progress");
				
			};
			
			
		});
	
		//return "<div class='bottom_detail_block'>"+ d.detail +"</div>";
		return html;
	};
	
    $(document).on('click', 'td.details-control', function () {
		let $this = $(this), $form = $this.closest("form"), table_data = WM.dt[ $form.attr("name") ];	
	
        var tr = $(this).closest('tr');
        var row = table_data.obj.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });	
	


	$(document).on("click", ".iswitch", function(e) {
		$(this).next(".iswitchValue").val( +$(this).prop('checked') );
	});	
	
	
});



// загружаем сохраненные данные из форм
function loadDataToForm(oName, formData) {	
	let 
		$form = $("form[name="+ oName + "]"),
		DT = CD[oName], 
		data = [], 
		row_id = 0;

	if ($form.length == 0) {
		console.warn("Unknown form name = " + oName);
		return false;
	};

	//console.log("form[name="+ oName +"] start");
	data = [];
	//console.info( data );

	// перебираем строки
	for (let id in formData) {
		// если это табличная строка
		
		//console.info(formData[id]);
		if (+id == id && typeof formData[id] == "object") {
			//console.info(data);
			
			data[ row_id ] = {id: id};
			//console.log("id=" + id);
			//console.info(data);
		
		
			// обновляем автоинкремент
			if (+id > DT.last_index) DT.last_index = +id;
			// перебираем все элементы этой строки
			for (let name in formData[id]) data[ row_id ][name] = formData[id][name];	
			
			row_id++;
		// если это обычная форма	
		} else {
			$form.find("[name="+ id +"]").val( formData[id] )
		};
	};
	if (DT !== undefined) {
		//console.info( data );
	
		//data = html_action_data( DT.fields, data );			
		// наполняем таблицу
		DT.obj.clear().rows.add( data ).draw();	
	};
};



function update_plugin( $root = document ) {
	
	
	$root.find("[data-mask]").each(function(i, el)	{
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
	

	$root.find(".dropzone_wrapper").dropzone({
		$obj: $(this),
		url: 'upload-file.php',
		paramName: "dropzone_file", // The name that will be used to transfer the file
		maxFilesize: 20, // MB
		params: {a: 1, b: 2},
		//addRemoveLinks: true,
		
		success: function(file, response) {
			$(this.element).css("background-image", "url("+ response.image_url + ")")
				.next(".dropzoneValue").val( response.image_url );
		},		
		
	});	

}


$(document).ready(function()  {



})