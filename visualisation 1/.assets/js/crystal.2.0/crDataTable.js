"use strict";


function render_cell_input( data, type, row, meta ) {
	if (type == "display") {
		if (data == null) data = "";
		return "<input type='text' class='form-control dt-input' dt-col='"+ meta.col +"' dt-row='"+ meta.row +"' value='"+ data + "' />";
	} else return data;
};

function render_cell_email( data, type, row, meta ) {
	if (type == "display") {
		if (data == null) data = "";
		return "<input type='email'  class='form-control dt-input' dt-col='"+ meta.col +"' dt-row='"+ meta.row +"' value='"+ data + "' />";
	} else return data;
};








function crDataTable( options ) {

	// this.data_prev = [];
	this.options = options;
	this.fields = options.fields;
	this.obj;
	this.uid = "dataTable_" + options.name;
	this.last_index = options.last_index;
	
	if (!options.name) console.error("name is not defined in datatable");
	
	let name = options.name; 
	
	var $uid = $("#" + this.uid);
		
		
		

	// создаем uid если его нет
	if ($uid.length == 0) {
		let htmlTable = "<table id='"+ this.uid +"' class='table table-bordered table-striped' ></table>";
		

		// оборачиваем в панель
		if (options.panel) {
			if (options.title != "") {
				htmlTable = '<div class="panel panel-default panel-border wm_check_for_update"><div class="panel-heading">'+ options.title +'</div><div class="panel-body">' + htmlTable +'</div></div>';
			} else {
				htmlTable = '<div class="panel panel-default panel-border wm_check_for_update"><div class="panel-body">' + htmlTable +'</div></div>';
			};
		};
		// добавляем таблицу
		if (options.parent) $( htmlTable ).prependTo( options.parent ); else $( htmlTable ).prependTo( WM.uidWorkArea );
		$uid = $("#" + this.uid);
	} else {
		console.error("uid=\""+this.uid+"\" length=" + $uid.length);
	
	};
	

	
	
	// атрибуты формы
	let form_wrap_attr = "id='"+ options.name +"' name='"+ options.name +"' class='dataTableForm'";
	if ( options.api_get ) form_wrap_attr += " api-get=\""+ options.api_get + "\"";
	if ( options.api_set ) form_wrap_attr += " api-set=\""+ options.api_set + "\"";
	
	$uid.wrap( "<form " + form_wrap_attr + ">");	
	
	
	// делаем строку render как функцию
	options.columnDefs.forEach(function (oColumn, index) { if ( oColumn.render ) options.columnDefs[ index ].render = window[  oColumn.render ];	});
	

	let tOptions = {
		responsive: true,
		pageLength: 10,
		columnDefs: options.columnDefs,		
		language: {"processing": "Подождите...", "search": "Поиск:", "lengthMenu": "Показать _MENU_ записей", "info": "Записи с _START_ до _END_ из _TOTAL_ записей", "infoEmpty": "Записи с 0 до 0 из 0 записей", "infoFiltered": "(отфильтровано из _MAX_ записей)", "infoPostFix": "", "loadingRecords": "Загрузка записей...", "zeroRecords": "Записи отсутствуют.", "emptyTable": "В таблице отсутствуют данные", "paginate": {"first": "Первая", "previous": "<<", "next": ">>", "last": "Последняя"}, "aria": {"sortAscending": ": активировать для сортировки столбца по возрастанию","sortDescending": ": активировать для сортировки столбца по убыванию"} },
		//createdRow: function (row, data, dataIndex) {	update_plugin( $(row) );	},									
		initComplete: function(settings, json) {
			var api = this.api();
		
			if (options.read_only === undefined || !options.read_only) {
				let html_after = "", html_before = "";
				html_after = '<div styte="text-align: right">' + 
					'<button type="button" class="wm_btn_delete_table btn btn-red pull-left" disabled>Удалить</button>' + 
//					'<button type="button" class="wm_btn_cancel_table btn">Отмена</button>' + 
					'<button type="submit" class="btn btn-primary pull-right">Сохранить</button>' +
					'</div>';
					
				html_before = '<div>' + 
					'<button type="button" class="wm_add_table btn btn-success pull-right">Добавить</button>' + 
					'</div>';
					
				$uid.after( html_after ).before( html_before );				
			};
			
			
			// автоинкремент
			// console.log("initComplete");
			
			if (options.autoinc) {
				let max_id = 0;
				
				for (let obj_id in api.rows().data() ) {
					if (+obj_id == obj_id) {
						let oRow = api.rows().data()[ obj_id ];
						if (oRow.id !== undefined && +oRow.id > max_id) max_id = +oRow.id;
						
						//oTable.data_prev.push( Object.assign(oRow) );
					};
				};			
				// if (max_id != 0) oTable.last_index = max_id;
			};			 
			
			$uid.closest(".panel").removeClass("wm_check_for_update");
			
			
		}
	};	
	
	// general
	tOptions.stateSave = (options.stateSave !== undefined) ? options.stateSave : false;
	tOptions.paging = (options.paging !== undefined) ? options.paging : true;
	tOptions.searching = (options.searching !== undefined) ? options.searching : true;
	tOptions.info = (options.info !== undefined) ? options.info : true;
	
	
	
	// scrollY
	if (options.scrollY !== undefined) {	
		tOptions.deferRender = true;
		tOptions.scrollY = options.scrollY;
		tOptions.scrollCollapse = true;
		tOptions.scroller = true;
	};
	

	// api_get
	if (options.api_get) {
		let params = {table: options.name, fields: []};
		
		options.columnDefs.forEach(function (oColumn, index) { if ( oColumn.data ) params.fields.push( oColumn.data );	});	
	
		tOptions.ajax = 'index.php?c=API&e=onRequest&do='+ options.api_get +'&' + jQuery.param( {params: params} );
	};
	
	// autoinc
	if (options.autoinc) {
		tOptions.DT_RowId = 'id';
		tOptions.order = [[ 0, 'desc' ]];
	};
	
	this.obj = WM.dt[ name ][ "obj" ] = $uid.DataTable( tOptions );	

	
	console.info( options );
	
	// dt-input event 
	$("#" + this.uid).on("change", ".dt-input", function(e) {
		let 
			$this = $(this), 
			$form = $this.closest("form"),
			oName = $form.attr("name"),
			DT = CD[oName];
		
		
		DT.obj.cell( $(this).closest("td") ).data( $this.val() );
	});
	
	
	
};