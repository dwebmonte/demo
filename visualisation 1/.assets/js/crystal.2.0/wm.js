"use strict";

var CDP = undefined;
var CDJSON = undefined;
var WM = {
	uidWorkArea: "#workArea",
	basePath: "/crm/datadriver",
	dt: {},
	get baseUrl() {let url = new Url(); console.info(url);},
	get url() {let url = new Url(); return url.path;},	
	get pageUrl() {let url = new Url(); return url.path.replace(this.basePath, "");},	
	
	
	
	loadAction: function() {	
		// очищаем рабочую область
		//$(this.uidWorkArea).html("");
	
	
		// собираем все action
		let dataAction = [];
		if (CDP.action) dataAction = dataAction.concat( CDP.action );
		if (CDP.page[ WM.pageUrl ] && CDP.page[ WM.pageUrl ]["action"]) dataAction = dataAction.concat( CDP.page[ WM.pageUrl ]["action"] );
		
		//console.info( dataAction );
		for (let action_id = 0; action_id < dataAction.length; action_id++) {
			let action = dataAction[ action_id ], $uid = $(action.uid);
			
			// if ( action.uid && $(action.uid).length == 0 ) {console.warn("action uid not found =\"" + action.uid + "\""); 	continue;			};

			
			switch (action.do) {
				case "cd":
					action.data.forEach(function (item, index, array) {
						if (item.o !== undefined) {
							if (CD[item.o] === undefined) CD[item.o] = new window[item.c]();
							CD[item.o][item.p] = item.v;
						} else {
							CD[item.p] = item.v;
						};
					});
				break;						
				case "ac": 	$uid.addClass( action.param[0] ); 	break;
				case "rc": 	$uid.removeClass( action.param[0] ); 	break;
				case "ah": 	$uid.addClass( "hidden" ); 	break;
				case "rh": 	$uid.removeClass( "hidden" ); 	break;
				case "leftMenu":				
					if (!$('#main-menu').hasClass("filled")) {
						let htmlMenu = "";
						for (let item_id in action.items) {
							let item = action.items[ item_id ], itemClass = item.class, itemUrl = WM.basePath + item.url;
							if (itemClass === undefined) itemClass = "";
							
							if (itemUrl == WM.url) itemClass += " active";
							
							
							// htmlMenu += '<li class="'+itemClass+'"><a class="wm_link" href="'+ itemUrl+'"><i class="'+item.icon+'"></i><span class="title">'+item.title+'</span>	</a>	</li>';  
							htmlMenu += '<li class="'+itemClass+'"><a class="" href="'+ itemUrl+'"><i class="'+item.icon+'"></i><span class="title">'+item.title+'</span>	</a>	</li>';
						};
						$('#main-menu').html( htmlMenu );
					};
				break;				
				case "datatable": 
					WM.dt[ action.name ] = action;
					
					// создаем таблицу если ее нет
					CD[ action.name ] = new crDataTable( action );
				break;
				default: console.error("Unknown action do=\"" + action.do + "\"");
			}		
			
			
		};					
		// loadFromFromLocal();			



	} 	
};
	
	
$(document).ready(function()  {
	$.ajax({ url: 'controller.php', data: {do: "load data"}, dataType: "json", 
		success:function( res ){
			if (res.success !== undefined) {
				CDP = res.CDP;
				
				WM.basePath = CDP.config.basePath;
				
				CDJSON = res.CD;
				WM.loadAction();
			};
		}
	});	
			
	var location = window.history.location || window.location;

	$(document).on("click", "#main-menu a.wm_link", function(e) {
		$('#main-menu').find("li.active").removeClass("active");
		$(this).parent("li").addClass("active");
	});
	
	$(document).on("click", "a.wm_link", function(e) {
		let $this = $(this);
		
		history.pushState(null, null, $this.attr("href"));

		WM.loadAction();
		
		return false;
	});
	
	$(window).on('popstate', function(e) {
		WM.loadAction();
	});	
	
		
});	
