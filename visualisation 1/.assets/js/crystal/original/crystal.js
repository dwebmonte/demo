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
	$.ajax({ url: 'json/cron.php', dataType: "json",
		success:function(data_action){
			load_data_action( data_action );	
			
			//console.info ( CD.meter1.reactive_power_a );
			//console.info ( CD.meter1.current_voltage_live );
		}
	});


	/*
	$.ajax({ url: 'json/document.json', dataType: "json",
		success:function(data_action){
			load_data_action( data_action );	
		}
	});
	*/

	$("#cron_tick").bind("click", function(e) {
		console.log("tick");
		
		
		
		
	/*	
	// Realtime Network Stats
	var i = 0,
		rns_values = [130,150],
		rns2_values = [39,50],
		chart_data = [];
	
	for(i=0; i<=100; i++) {
		chart_data.push({ id: i, x1: between(rns_values[0], rns_values[1]), x2: between(rns2_values[0], rns2_values[1])});
	}		
		
	$('.realtime-network-stats').dxChart('instance').option('dataSource', chart_data);	
	*/
	//return false;	
		
		
		// загружаем обновленные данные
		$.ajax({ url: 'json/cron.php', dataType: "json",
			success:function(data_action){
				load_data_action( data_action );	
			}
		});	
		return false;
	});
	
	
	$(".signalization_switcher").bind("click", function(e) {
		let $this = $(this);
		if ($this.hasClass("on")) {
			$this.removeClass("on").addClass("off"); 
			$this.find("img").attr("src", "img/switch_off.png");
		} else {
			$this.removeClass("off").addClass("on");
			$this.find("img").attr("src", "img/switch_on.png");
		};
	});
	
	
});

/*

var scheme = {
	meter_1: new meter(1),
	meter_2: new meter(2),
	
	
};


console.info( ( scheme.meter_1.toJSON()) );

scheme.meter_1.current_amperage_a = "current_amperage_a 1";
scheme.meter_2.current_amperage_a = "current_amperage_a 2";


});
*/





			
			/*
			$uid.find(".td_value").fadeOut(300,"swing", function() {
				for (let row_id =0; row_id < data.length; row_id++) {				
					$uid.find("tbody")
					.find("tr").eq(row_id)
					.find("td").eq( action.col_id )
					.html("<span class='td_value'>" + data[row_id] + "</span>");
				};
			});
			*/
