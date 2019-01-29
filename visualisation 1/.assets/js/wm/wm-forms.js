"use strict";

function prepare_definition( dt_definition ) {
	for (let table_name in dt_definition) {
	
		if (dt_definition[ table_name ][ "entity" ] === undefined) {
			dt_definition[ table_name ][ "entity" ] = table_name;
		};
		
		// Language. Russian is default if undefined 
		if (dt_definition[ table_name ][ "language" ] === undefined) {
			dt_definition[ table_name ][ "language" ] = {"processing": "Подождите...", "search": "Поиск:", "lengthMenu": "Показать _MENU_ записей", "info": "Записи с _START_ до _END_ из _TOTAL_ записей", "infoEmpty": "Записи с 0 до 0 из 0 записей", "infoFiltered": "(отфильтровано из _MAX_ записей)", "infoPostFix": "", "loadingRecords": "Загрузка записей...", "zeroRecords": "Записи отсутствуют.", "emptyTable": "В таблице отсутствуют данные", "paginate": {"first": "Первая", "previous": "<<", "next": ">>", "last": "Последняя"}, "aria": {"sortAscending": ": активировать для сортировки столбца по возрастанию","sortDescending": ": активировать для сортировки столбца по убыванию"} };
		};

		
		if (dt_definition[ table_name ][ "rowUpdate" ] === undefined) {
			dt_definition[ table_name ][ "rowUpdate" ] = {add: {}, update: {}, remove: {}};
		};

		// обработка после инициализации
		if (dt_definition[ table_name ][ "initComplete" ] === undefined) {
			dt_definition[ table_name ][ "initComplete" ] = function(settings, json) {
				let html_after = `<div>
					<button type="button" class="dt-save btn btn-primary pull-right">Сохранить</button>
					</div>`;
					
				let html_before = `<div>
					<button type="button" class="dt-add-row btn btn-secondary pull-right">Добавить</button>
					</div>`;
					
				html_before = "";	
				this.after( html_after ).before( html_before );	
				
				this.find("th").each(function(i, elem) {
					let $el = $(elem);	 
					$el.html(  "<span>" + $el.html() + "</span>"  );	
				});
				
			};
		};
		
		

		if (dt_definition[ table_name ][ "rowId" ] === undefined) {
			dt_definition[ table_name ][ "rowId" ] = 'id';
		};

		if (dt_definition[ table_name ][ "ajax" ] === undefined) {
			dt_definition[ table_name ][ "ajax" ] = 'index.php?c=API&e=onRequest&do=DBSet&' + jQuery.param( {params: {get: true, entity: dt_definition[ table_name ][ "entity" ]}} );
		};
		
		
		// обработка созданной строки
		dt_definition[ table_name ][ "createdRow" ] = function( row, data, index ) {
			wm_update_script_cell( $(row) );
		};


		
		
		
		// определение столбцов
		let columnDefs = dt_definition[ table_name ][ "columnDefs" ];
		for (let col_id = 0; col_id < columnDefs.length; col_id++) {
			if ( columnDefs[ col_id ].targets === undefined ) columnDefs[ col_id ].targets = col_id;
			if ( columnDefs[ col_id ].title === undefined && columnDefs[ col_id ].name !== undefined ) columnDefs[ col_id ].title = columnDefs[ col_id ].name;
			if ( columnDefs[ col_id ].data === undefined && columnDefs[ col_id ].name !== undefined ) columnDefs[ col_id ].data = columnDefs[ col_id ].name;
		};
		dt_definition[ table_name ][ "columnDefs" ] = columnDefs;

	};
	
	
	
	return dt_definition;
};


dt_definition = prepare_definition( dt_definition );


$(document).ready(function() {
	
	// инициализация dataTable	
    if (dt_definition !== undefined) {
		for (let table_name in dt_definition) {
			if ( $( "table[dt-name="+ table_name +"]" ).length > 0) {
				$( "table[dt-name="+ table_name +"]" ).DataTable( dt_definition[ table_name ] );
			};
		};
	};
	
	/*
	function format ( obj ) {
		return `
			<form>
				<h3>New form</h3>
				<table class="table responsive table-bordered table-striped" dt-name="detail_example_${obj.id}"></table>		
			</form>`;
	}	
	

    $('.dataTables_wrapper').on('click', 'td.details-control', function () {
		let 
			$this = $(this), 
			$DT = $this.closest(".dataTable"),
			//table_id = $DT.attr("dt-name"),
			DT = $DT.DataTable();
			//row_id = DT.row( $this.closest("tr") ).id();        
		
		var tr = $this.closest('tr');
        var row = DT.row( tr );
 
        if ( row.child.isShown() ) {
			console.log("close detail");
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
			
			dt_definition[ "detail_example" ].data = row.data().items;
			
			console.info( dt_definition[ "detail_example" ].data );
			
			$("[dt-name=detail_example_"+ row.data().id +"]").DataTable( dt_definition[ "detail_example" ] );
			
            tr.addClass('shown');
        }
    });	
	*/
	
	
	
	// добавление
	$(".dataTables_wrapper").on("click", ".dt-add-row", function(e) {
		let 
			$this = $(this), 
			$DT = $this.closest(".dataTables_wrapper").find(".dataTable"), 
			table_id = $DT.attr("dt-name"),
			DT = $DT.DataTable(),
			max_row_id = 1;
			
			if ( DT.column(0).data().length > 0 ) max_row_id = Math.max.apply(null, DT.column(0).data())+1;

		
			let row_insert = {};
			dt_definition[ table_id ].columnDefs.forEach(function (oField) {	
				if ( oField.name == "id")  row_insert[ oField.name ] = max_row_id; 
				else row_insert[ oField.name ] = ""; 
			});
			
			DT.row.add( row_insert ).draw(  );
	
	
			dt_definition[ table_id ].rowUpdate.add[ max_row_id ] = true;
	
			// сортируем, чтобы показать первую строку
			DT.order( [ 0, 'desc' ] )	.draw();			
			
			
	});

	// сохранение таблицы
	$(".dataTables_wrapper").on("click", ".dt-save", function(e) {
		let 
			$this = $(this), 
			$DT = $this.closest(".dataTables_wrapper").find(".dataTable"), 
			table_id = $DT.attr("dt-name"),
			DT = $DT.DataTable(),
			rowUpdate = dt_definition[ table_id ].rowUpdate;
		
			//console.log("save table for table_id=" + table_id);

			
			
			// проверяем если не было изменений
			if (jQuery.isEmptyObject(rowUpdate.add) && jQuery.isEmptyObject(rowUpdate.update) && jQuery.isEmptyObject(rowUpdate.remove)) {
				toastr.success("Данные этой таблицы не менялись", "Нет изменений", toastrOpt);
			} else {
				let params = {"entity": dt_definition[ table_id ].entity};
				
				//console.info( rowUpdate );
				
				// добавленные данные
				if (!jQuery.isEmptyObject(rowUpdate.add)) {
					params.post = [];
					
					for (let row_id in rowUpdate.add) {
						let row_data = DT.row( '#' + row_id ).data();
						//console.info( '#' + row_id, row_data );
						params.post.unshift( row_data );
					}
				};
				
				// отредактированные данные
				if (!jQuery.isEmptyObject(rowUpdate.update)) {
					params.put = [];
				
					for (let row_id in rowUpdate.update) {
						let row_data = DT.row( '#' + row_id ).data();
						params.put.unshift( row_data );
					};
					
				};
				
				// удаленные данные
				if (!jQuery.isEmptyObject(rowUpdate.remove)) {
					params.remove = [];
				
					for (let row_id in rowUpdate.remove) {
						params.remove.unshift( row_id );
					}
				};	
				
				//if (params.post && params.post.length == 0) delete params.post;
				//if (params.put && params.put.length == 0) delete params.put;
				//if (params.remove && params.remove.length == 0) delete params.remove;
				
				//if (!jQuery.isEmptyObject(rowUpdate.remove)) console.info( rowUpdate.remove );
				function update_res_after_save( event, res ) {
					// console.info( event, res );
				};
				
				
				api_request("DBSet", params, update_res_after_save); 
				
				
				
				// console.info( params );
			
			};
			
			
			
	});	
	
	// изменение данных
	$(".dataTable").on("change", ".form-control", function(e) {
		let 
			$this = $(this), 
			$DT = $this.closest(".dataTable"),
			table_id = $DT.attr("dt-name"),
			DT = $DT.DataTable(),
			row_id = DT.row( $this.closest("tr") ).id();
		
		// отмечаем строку отредактированной
		if ( dt_definition[ table_id ].rowUpdate.add[ row_id ] === undefined)
			dt_definition[ table_id ].rowUpdate.update[ row_id ] = true;
		
		// записываем значение в таблицу
		DT.cell( $this.closest("td") ).data( $this.val() );
	});	
	
	// выделение строки
	/*
	$('.dataTable').on( 'click', 'tr', function () {
		let 
			$this = $(this), 
			DT = $this.closest(".dataTable").DataTable(),
			$DT_wrapper = $this.closest(".dataTables_wrapper");		
		
		$this.toggleClass('selected');
		
		// если есть какие-то выделенные строки, то показываем кнопку удаления
		if ( DT.rows('.selected').data().length > 0 ) $DT_wrapper.find(".dt-remove-row").removeAttr("disabled"); else $DT_wrapper.find(".dt-remove-row").attr("disabled", true);
	});
	*/
	
	// удаление строк
	$(".dataTables_wrapper").on("click", ".dt-remove-rows", function(e) {
		let 
			$this = $(this), 
			$DT_wrapper = $this.closest(".dataTables_wrapper"),
			$DT = $DT_wrapper.find(".dataTable"), 
			table_id = $DT.attr("dt-name"),
			DT = $DT.DataTable();
	
		// перебираем все выделенные строки
		DT.rows('.selected').eq(0).each( function ( index ) {
			let row_id = DT.row(index).id();

			if ( dt_definition[ table_id ].rowUpdate.add[ row_id ] ) delete dt_definition[ table_id ].rowUpdate.add[ row_id ];
			else {
				dt_definition[ table_id ].rowUpdate.remove[ row_id ] = true;
				if ( dt_definition[ table_id ].rowUpdate.update[ row_id ] ) delete dt_definition[ table_id ].rowUpdate.update[ row_id ];
			};
		});			
		
		// удаляем все выделенные строки
		DT.rows('.selected').remove().draw( false );
		
		$DT_wrapper.find(".dt-remove-row").attr("disabled", true);
	});
	
	// удаление строки
	$(".dataTables_wrapper").on("click", ".dt-remove-icon-row", function(e) {
		let 
			$this = $(this), 
			$DT = $this.closest(".dataTable"), 
			$tr = $this.closest("tr"), 
			table_id = $DT.attr("dt-name"),
			DT = $DT.DataTable();
			
		let row_id = DT.row( $tr ).id();

		
		if ( dt_definition[ table_id ].rowUpdate.add[ row_id ] ) delete dt_definition[ table_id ].rowUpdate.add[ row_id ];
		else {
			dt_definition[ table_id ].rowUpdate.remove[ row_id ] = true;
			if ( dt_definition[ table_id ].rowUpdate.update[ row_id ] ) delete dt_definition[ table_id ].rowUpdate.update[ row_id ];
		};		
		//dt_definition[ table_id ].rowUpdate.remove[ row_id ] = true;
		
		DT.row( $tr ).remove().draw( false );
	});	 

	 
	 
} );

