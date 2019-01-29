function iDataTable( obj ) {
	var oData;
	
	Object.defineProperty(this, "data", {
		get: function() {
			return this.oData;
		},
		set: function( data ) {
			var oData;
			// создание таблицы
			if ( this.oData === undefined) {
				
				this.oData = oData = data;
				
				// объект для создания dataTable
				let dtDefinition = oData.data;
				if (dtDefinition.columnDefs === undefined) console.error("columnDefs is not defined");
				 	
				// если задана data, то наполняем dataKeys именами полей	
				if (dtDefinition.data ) {
					var dataKeys = [];
					for (currentKey in dtDefinition.data[0]) { dataKeys.push( currentKey ) };
				};
					
				dtDefinition.columnDefs.forEach(function (item, index) {
					if ( item.targets === undefined) dtDefinition.columnDefs[ index ].targets = index;
					
					if ( item.data === undefined && item.name === undefined && dataKeys) {
						item.data = item.name = dataKeys[ index ];
					
					} else {
						if ( item.data === undefined) dtDefinition.columnDefs[ index ].data = item.name;
						if ( item.name === undefined) dtDefinition.columnDefs[ index ].name = item.data;
					};

					// render
					if ( item.render ) {
						if ( item.render.indexOf("return ") === -1)  item.render = window[ item.render ];
						else item.render = new Function('data', 'type', 'row', 'meta', item.render);
					};
					
				});	
				
				
				// язык
				if ( dtDefinition.language === undefined || dtDefinition.language === "ru" )	dtDefinition.language = {"processing": "Подождите...", "search": "Поиск:", "lengthMenu": "Показать _MENU_ записей", "info": "Записи с _START_ до _END_ из _TOTAL_ записей", "infoEmpty": "Записи с 0 до 0 из 0 записей", "infoFiltered": "(отфильтровано из _MAX_ записей)", "infoPostFix": "", "loadingRecords": "Загрузка записей...", "zeroRecords": "Записи отсутствуют.", "emptyTable": "В таблице отсутствуют данные", "paginate": {"first": "Первая", "previous": "<<", "next": ">>", "last": "Последняя"}, "aria": {"sortAscending": ": активировать для сортировки столбца по возрастанию","sortDescending": ": активировать для сортировки столбца по убыванию"} };
				else if ( dtDefinition.language === "en" ) delete dtDefinition.language;
				
				//console.info( dtDefinition );
			
				// формируем html вывод
				let html = "";
				if ( oData.title ) {
					html = 
						`<div class='panel panel-default panel-border'>
							<div class='panel-heading'>${oData.title}</div>
							<div class='panel-body'><table iuid="${data.name}" class="table responsive"></table></div>
						</div>`;			
				} else {
					html = 
						`<div class='panel panel-default panel-border'>
							<div class='panel-body'><table iuid="${data.name}" class="table responsive"></table></div>
						</div>`;				
				};
			
				
				// выбираем метод вставки и идентификатор вставки
				
				if ( oData.append ) $( html ).appendTo( oData.append );
				else if ( oData.prepend ) $( html ).prependTo( oData.prepend );
				else if ( oData.html ) $( oData.html ).html( html );
				else $( html ).appendTo("[cid=workArea]");
				
				$("table[iuid="+ data.name +"]").dataTable( dtDefinition );
			
			
			
				
			} else {
				console.error("iDataTable is already exist");
			
			
			};
			
				
			
			
			
		}
	})
	//console.info( obj );
	this.data = obj;
};