"use strict";

function crDataTable( options ) {
	
	this.fields = options.fields;
	this.obj;
	this.uid = "dataTable_" + options.name;
	this.last_index = options.last_index;
	
	if (!options.name) console.error("name is not defined in datatable");
	
	let 
		name = options.name,
		$uid = $("#" + this.uid);
	
	
	// console.log("uid=\""+this.uid+"\" length=" + $uid.length);
	
	// создаем uid если его нет
	if ($uid.length == 0) {
		let htmlTable = "<table id='"+ this.uid +"' class='table table-bordered table-striped' ></table>";
		

		// оборачиваем в панель
		if (options.title != "") {
			htmlTable = '<div class="panel panel-default panel-border wm_check_for_update"><div class="panel-heading">'+ options.title +'</div><div class="panel-body">' + htmlTable +'</div></div>';
		} else {
			htmlTable = '<div class="panel panel-default panel-border wm_check_for_update"><div class="panel-body">' + htmlTable +'</div></div>';
		};

		
		
		$( htmlTable ).prependTo( WM.uidWorkArea );
		$uid = $("#" + this.uid);
	} else {
		console.error("uid=\""+this.uid+"\" length=" + $uid.length);
	
	};
	
	// console.log("datatable \""+ name +"\" on uid=\""+ uid +"\" was created");			
		
	// создаем таблицу
	let html = "";
	
	for (let field_id = 0; field_id < options.fields.length; field_id++) {
		if (options.fields[field_id].title === undefined) options.fields[field_id].title = ""; 

		if ( options.fields[field_id].format == "_del" ) html = '<th><input type="checkbox" class="cbr wm_delete_all_rows_check"></th>';
		else html += "<th><span>" + options.fields[field_id].title + "</span></th>";

		/*
		let prop_td = "";
		
		if ( options.dt_fields[field_id].width ) prop_td = "asd: 12;width: " + options.dt_fields[field_id].width +";";
		
		if ( options.fields[field_id].format == "_del" ) html = '<th><input type="checkbox" class="cbr wm_delete_all_rows_check"></th>';
		else html += "<th><div style='"+ prop_td +"'>" + options.fields[field_id].title + "</div></th>";
		*/
	};

	
	
	
	
	let form_wrap_attr = "id='"+ options.name +"' dfdf=123 name='"+ options.name +"' class='dataTableForm'";
	
	//console.info( options );
	
	if ( options.api_load ) form_wrap_attr += " api-load=\""+ options.api_load + "\"";
	if ( options.api_save ) form_wrap_attr += " api-save=\""+ options.api_save + "\"";
	
	
	$uid.append( "<thead><tr>" + html + "</tr></thead>" ).wrap( "<form " + form_wrap_attr + ">");	
	
	
	// преобразовываем данные в html
	//action.data = html_action_data( action.fields, action.data );
	
	// добавить данные
	
	WM.dt[ name ][ "obj" ] = $uid.DataTable({
		//stateSave: true,
		responsive: true,
		columns: options.dt_fields,
		//data: action.data,
		pageLength: 10,

		language: {
			"processing": "Подождите...",
			"search": "Поиск:",
			"lengthMenu": "Показать _MENU_ записей",
			"info": "Записи с _START_ до _END_ из _TOTAL_ записей",
			"infoEmpty": "Записи с 0 до 0 из 0 записей",
			"infoFiltered": "(отфильтровано из _MAX_ записей)",
			"infoPostFix": "",
			"loadingRecords": "Загрузка записей...",
			"zeroRecords": "Записи отсутствуют.",
			"emptyTable": "В таблице отсутствуют данные",
			"paginate": {"first": "Первая", "previous": "<<", "next": ">>", "last": "Последняя"},
			"aria": {"sortAscending": ": активировать для сортировки столбца по возрастанию","sortDescending": ": активировать для сортировки столбца по убыванию"			}
		},
		createdRow: function (row, data, dataIndex) {	update_plugin( $(row) );	},									
		initComplete: function(settings, json) {
			
			if (options.read_only === undefined || !options.read_only) {
				let html_after = "", html_before = "";
				html_after = '<div style="text-align:right">' + 
					'<button type="button" class="wm_btn_delete_table btn btn-red pull-left" disabled>Удалить</button>' + 
					'<button type="button" class="wm_btn_cancel_table btn" disabled>Отмена</button>' + 
					'<button type="submit" class="btn btn-primary">Сохранить</button>' +
					'</div>';
					
				html_before = '<div style="text-align:right">' + 
					'<button type="button" class="wm_add_table btn btn-success">Добавить</button>' + 
					'</div>';
					
				$uid.after( html_after ).before( html_before );				
			};
			
		}


	});	
	this.obj = WM.dt[ name ][ "obj" ];
	
};