"use strict";

var iCore = {};
console.info( iCoreData );

$(document).ready(function()  {




	for (let comName in iCoreData) {
		if (iCoreData[comName]["data"] === undefined) iCoreData[comName]["data"] = [];
		
		let comClass = iCoreData[comName]["class"];
		
		if (comClass === undefined || comClass == "data") {
			iCore[ comName ] = iCoreData[comName];
		} else {
			iCore[ comName ] = new window[ comClass ](  iCoreData[comName]  );
		};
	};


	// Назначаем переменным idata

	$("[idata-text], [idata-html], [idata-val]").each(function(i, elem) {
		
		let $el = $(elem);	 

		if ( $el.attr("idata-text") ) {
			let comName = $el.attr("idata-text").split(".")[0], comVarName = $el.attr("idata-text").split(".")[1];
			
			let comValue = undefined;
			
			if ( iCore[ comName ] === undefined ) console.error(`iCore[" `+ comName + `"] is undefined`);
			
			if ( iCore[ comName ][ comVarName ] ) comValue = iCore[ comName ][ comVarName ];
			else if ( iCore[ comName ].data[ comVarName ] ) comValue = iCore[ comName ].data[ comVarName ];
			
			if ( comValue !== undefined ) $el.text( comValue ); else console.warn( "idata \"" + comName + "\".\"" + comVarName +" \" is undefined" );
		};

	});
	
});	

function iLeftMenu( obj ) {
	var oData, currentPage;
	
	
	
	Object.defineProperty(this, "data", {
		get: function() {
			return this.oData;
		},
		set: function( data ) {
			this.oData = data;	
			
			let html = "", activeClass = "", subClass = "", currentPage = undefined;
			let currentURL = window.location.hostname + window.location.pathname.replace(/\/+$/, "").replace('%20', ' ');
			
			this.oData.forEach(function (item1, index1) {
				if (item1.url === undefined) item1.url = "";
				if (item1.url != "") item1.url = iCore.server.domain + "/" + item1.url; else item1.url = iCore.server.domain;
				
				item1.icon = (item1.icon !== undefined) ? "<i class='" + item1.icon + "'></i>" : "";
				
				if (item1.title === undefined) item1.icon = item1.url;
				
				
				
				activeClass = (currentURL === item1.url || ( item1.url !== iCore.server.domain && currentURL.indexOf( item1.url + "/" ) === 0 ) ) ? "active" : "";
				if (activeClass === "active") iCore.currentPage = item1;	
				
				if (item1.items !== undefined) {
					if (activeClass == "active") subClass = "has-sub expanded"; else subClass = "has-sub collapsed";
				} else subClass = "";
				
				html = html + "<li class='"+ activeClass +" "+ subClass +"'><a href='" + iCore.server.scheme + '://' +  item1.url + "'>" + item1.icon + "<span class='title'>" + item1.title + "</span></a>";
				
				// внутренне меню 2 уровня
				if (item1.items !== undefined) {
					if (activeClass == "active") html = html + "<ul style='display:block;'>"; else html = html + "<ul>";
					
					if ( item1.items[0] === undefined ) console.error("items для пункта меню \""+ item1.title +"\" должно быть массивом");
					
					item1.items.forEach(function (item2, index2) {

						if (item2.url === undefined) item2.url = "";
						if (item2.url != "") item2.url = iCore.server.domain + "/" + item2.url; else item2.url = iCore.server.domain;
						
						item2.icon = (item2.icon !== undefined) ? "<i class='" + item2.icon + "'></i>" : "";
						if (item2.title === undefined) item2.icon = item2.url;
						
						// activeClass =  (currentURL.indexOf( item2.url ) === 0) ? "active" : "";
						activeClass = (currentURL === item2.url || currentURL.indexOf( item2.url + "/" ) === 0 ) ? "active" : "";
						if (activeClass === "active") {
							iCore.currentPage = item2;
							iCore.currentPage.parent = item1;
						};
						
						subClass = "";						
						
						html = html + "<li class='"+ activeClass +" "+ subClass +"'><a href='" + iCore.server.scheme + '://' +  item2.url + "'>" + item2.icon + "<span class='title'>" + item2.title + "</span></a>";
						html = html + "</li>";	
					
					});
					html = html + "</ul>";
				};
				html = html + "</li>";
			});
			
			if ( $("#main-menu").length != 1) console.error("#main-menu length = " + $("#main-menu").length); else $("#main-menu").html( html );			
			
			
			setup_sidebar_menu();
		}	
	});	
	
	
	this.data = obj.data;
};
	
	
	
	

	
	
	
	
	
	

	
	
	
	
	