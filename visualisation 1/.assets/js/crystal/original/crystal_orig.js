$(document).ready(function()  {


function cristalInput() {
	
	
	
};

var cristall = {
	setItem: function(crv_attr, value) {
		let attr_name = "[cr-var="+ crv_attr +"]";
		let $obj = $(attr_name);		if ($obj.length == 0) console.error(attr_name +" is not found");
		
		if ($obj.is("input")) {
			$obj.val( value );
		} else {
			$obj.html( value );
		};
	},
	setItemIndex: function(crv_attr, index, value) {
		let attr_name = "[cr-var="+ crv_attr +"]:eq("+index+")";
		let $obj = $(attr_name);		if ($obj.length == 0) console.error(attr_name +" is not found");
		
		if ($obj.is("input")) {
			$obj.val( value );
		} else {
			$obj.html( value );
		};
	},	
	getItem: function(name) {
		let attr_name = "[cr-var="+ crv_attr +"]"; 
		let $obj = $(attr_name);		if ($obj.length == 0) console.error(attr_name +" is not found");
		
		if ($obj.is("input")) {
			return $obj.val();
		
		} else {
			$obj.html();
		
		};
	},
	getItemIndex: function(name, index) {
		let attr_name = "[cr-var="+ crv_attr +"]:eq("+index+")"; 
		let $obj = $(attr_name);		if ($obj.length == 0) console.error(attr_name +" is not found");
		
		if ($obj.is("input")) {
			return $obj.val();
		
		} else {
			$obj.html();
		
		};
	},
};

/*
Object.defineProperties(o, {
    "b": { get: function () { return this.a + 1; } },
    "c": { set: function (x) { this.a = x / 2; } }
});
*/

/*
function meter1() {
	get : function () {return 1245}
	
	
};
*/

function meter( meter_id ) {
	let _meter_id = meter_id;
	Object.defineProperty(this, "current_amperage_a", {
		get: function() { return $("[data-param=current_amperage_a_"+ _meter_id +"]").html() },
		set: function(value) {$("[data-param=current_amperage_a_"+ _meter_id +"]").text( value );}
	});
	Object.defineProperty(this, "current_amperage_b", {
		get: function() { return $("[data-param=current_amperage_b"+ _meter_id +"]").html() },
		set: function(value) {$("[data-param=current_amperage_b"+ _meter_id +"]").text( value );}
	});
	Object.defineProperty(this, "current_amperage_c", {
		get: function() { return $("[data-param=current_amperage_c"+ _meter_id +"]").html() },
		set: function(value) {$("[data-param=current_amperage_c"+ _meter_id +"]").text( value );}
	});
	Object.defineProperty(this, "current_voltage_a", {
		get: function() { return $("[data-param=current_voltage_a_"+ _meter_id +"]").html() },
		set: function(value) {$("[data-param=current_voltage_a_"+ _meter_id +"]").text( value );}
	});
	Object.defineProperty(this, "current_voltage_b", {
		get: function() { return $("[data-param=current_voltage_b"+ _meter_id +"]").html() },
		set: function(value) {$("[data-param=current_voltage_b"+ _meter_id +"]").text( value );}
	});
	Object.defineProperty(this, "current_voltage_c", {
		get: function() { return $("[data-param=current_voltage_c"+ _meter_id +"]").html() },
		set: function(value) {$("[data-param=current_voltage_c"+ _meter_id +"]").text( value );}
	});	
	
  function toJSON() {
    
	for (prop in this) {
	
	};
	return {
		current_voltage_c: this.current_voltage_c
    }
  }	
};



var scheme = {
	meter_1: new meter(1),
	meter_2: new meter(2),
	
	
};


console.info( ( scheme.meter_1.toJSON()) );

scheme.meter_1.current_amperage_a = "current_amperage_a 1";
scheme.meter_2.current_amperage_a = "current_amperage_a 2";


});