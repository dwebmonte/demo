"use strict";

function CD() {
	var json_change = {};
	
	this.getValue = function(prop) {
		return localStorage[ prop ];
	};	
	
	this.getItem = function(prop) {
		return CDJSON[ prop ];
		// if (localStorage[ prop ] != undefined) return JSON.parse(localStorage[ prop ]); else return undefined;
	};	
	
	this.deleteItem = function(prop, row_id) {
		if (typeof row_id  != "array") row_id = [row_id];
		
		row_id.forEach(function (id) { delete CDJSON[ prop ][ row_id ]; });
	
		$.ajax({ url: 'controller.php', type:'POST', data:{json: JSON.stringify( row_id ), prop: prop, do: "cd delete rows" }, dataType: "json",
			success:function( res ){
				if (res.success !== undefined) { 
					//json_change = {};
					
				};
			}
		});	

	};
	
	this.setItem = function(prop, value) {
		CDJSON[ prop ] = value;
		// if(typeof value == 'object') localStorage[ prop ] = JSON.stringify( value ); else localStorage[ prop ] = value;
		
		let sendObj = {};	sendObj[ prop ] = CDJSON[ prop ];
		
		$.ajax({ url: 'controller.php', type:'POST', data:{json: JSON.stringify( sendObj ), do: "cd save" }, dataType: "json",
			success:function( res ){
				if (res.success !== undefined) { 
					//json_change = {};
					
				};
			}
		});		
	};
	
};


var CD = new CD();

function crPage() {
	Object.defineProperty(this, "title", {
		get: function() { return $(".cd_page_title").html()},
		set: function(value) { $(".cd_page_title").html( value ) }
	});

	Object.defineProperty(this, "description", {
		get: function() { return $(".cd_page_description").html()},
		set: function(value) { $(".cd_page_description").html( value ) }
	});

};






















