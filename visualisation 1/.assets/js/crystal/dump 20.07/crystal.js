"use strict";


function load_data_action( data_action ) {
	for (let action_id in data_action) {
		let action = data_action[action_id];
		
		if (action.crid !== undefined) {
			let $uid = $("[cr-id=" + action.crid + "]");
			if ( $uid.length == 0) console.warn("Unknown crid=\""+ action.crid +"\"");
		};
		
		// console.log( action.do );
		switch (action.do) {
		
		
		// присваиваем CD данные
		case "cd":
			CD.setObjData( action.data );
			//CD = action.data;
		break;
		case "value":
			if ($uid.is("input")) {
				$uid.val( action.value );
			} else {
				$uid.html( action.value );
			};		
		break;
		// обновить столбец uid
		case "update_col_data":
			if (action.col_id == undefined) console.error("col_id is not defined");
			var data = action.data;

			for (let row_id =0; row_id < data.length; row_id++) {				
				$uid.find("tbody").find("tr").eq(row_id).find("td").eq( action.col_id ).html( data[row_id] );
			};
		break;

		
		
		// добавить столбцы
		case "add_cols_data":
			var data = action.data, html = [];
			for (let col_id =0; col_id < data.length; col_id++) {
				for (let row_id =0; row_id < data[col_id].length; row_id++) {
					if (html[row_id] == undefined) html[row_id] = [];
					
					html[row_id][col_id] = "<td>" + data[col_id][row_id] + "</td>";
				};
			};
			for (let row_id =0; row_id < html.length; row_id++) html[row_id] = "<tr>" + html[row_id].join("") + "</tr>";
			$uid.find("tbody").html( html.join("") );	
				
				

				/*
				for (let row_id =0; row_id < data.length; row_id++) {
					html += "<tr>";
					for (let col_id =0; col_id < data[row_id].length-1; col_id++) {
						html += "<td>" + data[row_id][col_id] + "</td>";;
					};
					html += "</tr>";
				};
				$uid.find("tbody").html( html );
				*/
				
			break;

		
			default: console.error("Unknown action do=\""+ action.do +"\"");
		}
	};	
	
	
};



$(document).ready(function()  {




});

