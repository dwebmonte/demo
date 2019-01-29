"use strict";

var toastrOpt = {
	"closeButton": true,
	"debug": false,
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "5000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
};	


var API = {
	dataRequestOnLoad: [],
	ratio: {},
	
	sendRequestOnLoad: function() {
		this.dataRequestOnLoad.forEach(function (request) {
			api_request( request.name, request.params, request.callbackFunc );
		});
	},
	
	addQueue: function(name, params, callbackFunc) {
		this.dataRequestOnLoad.unshift({name: name, params: params, callbackFunc: callbackFunc});
	}
};






function api_request(request, params, callbackFunc) {
	hide_loading_bar();	show_loading_bar({pct: 80, delay: 2});
	
	let send_data = {c: "API", e: "onRequest", type: "json", do: request, params: params };
	

	$.ajax({ url: 'index.php', type:'POST', data:send_data, dataType: "json",
		success:function( res ){
			show_loading_bar({pct: 100, delay: 0.5});	
			
			if (typeof callbackFunc === "function") callbackFunc( "start", res );

			
			res.action.forEach(function (action) {
				// console.info( action );
				
				switch (action.do) {
					case "error": toastr.error(action.description, action.title, toastrOpt); break;
					case "success": toastr.success(action.description, action.title, toastrOpt); break;
					case "info": toastr.info(action.description, action.title, toastrOpt); break;
					case "warning": toastr.warning(action.description, action.title, toastrOpt); break;
					case "href": window.location.href = action.href;	break;	
					case '$uid.func':
						$( action.uid )[ action.func ](action.value);
						if ( $( action.uid ).length == 0) console.warn("API error", "not found element this uid=\""+ action.uid  +"\"");  
					break;
					
					case 'dtSetData': 
						//loadDataToForm(action.uid, action.data);					
						
						
						let DT = $( action.uid ).DataTable();
						DT.clear().rows.add( action.data ).draw();
					break;
					
					default: console.log("API notice: unknown action do=\""+ action.do  +"\"");
				};
				
				if (typeof callbackFunc === "function") callbackFunc( "action", action );


				
			});
			

			// notices
			if(res.errors)		res.errors.forEach(function (oNotice) 		{	toastr.error(oNotice.text, oNotice.title, toastrOpt); 		});
			if(res.warnings) 	res.warnings.forEach(function (oNotice) 	{	toastr.warning(oNotice.text, oNotice.title, toastrOpt);	});
			if(res.notices) 	res.notices.forEach(function (oNotice) 	{	toastr.success(oNotice.text, oNotice.title, toastrOpt);	});
			
			if (typeof callbackFunc === "function") callbackFunc( "end", res );

		}
	});	
};



$(document).ready(function()  {


	$(document).on("submit", "form[api-set]", function(e) {
		let 
			$form = $(this), 
			oName = $form.attr("name");	
	
		if (!$form.hasClass("dataTableForm")) {
		
			api_request($form.attr("api-set"), { data: $(this).serializeArray() });		
	
		} else {
		
			let 
				DT = CD[oName],
				data = [];		

				for (let obj_id in DT.obj.rows().data() ) {
					if (+obj_id == obj_id) {
						let oRow = DT.obj.rows().data()[ obj_id ];
						delete oRow.DT_RowId;
						
						data.push( oRow );
					};
				};		
			
			api_request($form.attr("api-set"), {table: oName, data: data});	
			
		};
		
		return false;
	});
		
	
	API.sendRequestOnLoad();	
});		