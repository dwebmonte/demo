"use strict";
function crystalClass() {
	this.infoShowSetVar = false;
	
	this.setObjData = function( data ) {
		for (let propName in data) {
			if (propName == "_") {
				CD[ propName ] = data[ propName ];
				if (this.infoShowSetVar) console.log("CD." + propNameChild + "=" + data[ propName ]);
			
			} else for (let propNameChild in data[propName]) {
				if (this.infoShowSetVar) console.log("CD." + propName + "." + propNameChild + "=" + data[ propName ][ propNameChild ]);
				
				if (CD[ propName ] === undefined) {
					if (this.infoShowSetVar) console.warn("CD [set data error]: unknown property = \""+ propName +"\"");
					
				} else if (CD[ propName ][ propNameChild ] === undefined) {
					if (this.infoShowSetVar) console.warn("CD [set data error]: unknown property = \""+ propName +"." + propNameChild +"\"");
					
				} else CD[ propName ][ propNameChild ] = data[ propName ][ propNameChild ];
			}
		}			
	};
}

function crystalData() {
	crystalClass.call(this);
	
	this.addProperty = function( propData ) {
		if (!Array.isArray(propData)) propData = [propData];
		
		// перебираем все свойства
		for (let prop_id = 0; prop_id < propData.length; prop_id++) {
			let 
				propName = propData[ prop_id ].name, 
				propUID = propData[ prop_id ].uid, 
				propObj = propData[ prop_id ].obj,
				propClass = propData[ prop_id ].class,
				$uid = $(propUID); 

			if (propUID !== null && $uid.length == 0) console.error( "accessor property \"" + propUID + "\"  is not found"); 				
				
			// создаем родительское свойство если оно задано	
			if ( propObj !== undefined ) {
				if (this[ propObj ] === undefined ) this[ propObj ] = {};
				propObj = this[ propObj ];
			} else propObj = this;
			
			// если свойство уже создано, то пропускаем
			if ( propObj[ propName ] !== undefined ) continue;

			// определяем класс
			if (propClass === undefined && $uid.attr("cd-class")) propClass = $uid.attr("cd-class"); 
			
			// если есть атрибут cd-class, то геттером делаем этот класс
			if (propClass !== undefined) {
				propObj[ "___" + propName ] = new window["crystall_" + propClass]({propUID: propUID});
				
				Object.defineProperty(propObj, propName, {
					get: function() { 
						return propObj[ "___" + propName]; 
					},
					set: function(data) {
						if (data !== null && typeof data === 'object') {
							for (let propSubName in data) {
							
								// console.info( data[ propSubName ] );
							
								propObj[ "___" + propName ][ propSubName ] = data[ propSubName ];
							};
						} else {
							propObj[ "___" + propName ] = data;
						};
						
					}						
				});

			// если это простой элемент	
			} else {
				
				
				Object.defineProperty(propObj, propName, {
					get: function() { 
						if ($uid.length == 0) console.error( "reading property \"" + propUID + "\"  is not found"); 
						return $uid.html() 
					},
					set: function(value) {
						if ($uid.length == 0) console.error( "reading property \"" + propUID + "\"  is not found"); 
						$uid.text( value ); 
					}
				});		
				
			};
		};
	};
	
	
	
	this.addPropertyAttr = function( propData ) {
		if (!Array.isArray(propData)) propData = [propData];
		//console.info( propData );
		
		for (let prop_id = 0; prop_id < propData.length; prop_id++) {
			let 
				propUID = propData[prop_id].uid, 
				attrName = propData[prop_id].attr,
				propObj = propData[ prop_id ].obj,
				O = this;
			
			if (propUID=== undefined) propUID = "";

			// перебираем все элементы с нужным атрибутом
			$(propUID + "["+ attrName + "]").each(function(i, elem) {
				let $el = $(elem), attrValue = $el.attr(attrName);
				
				if (O.develope) console.log("getter \""+attrValue+"\" defined for property=\""+ propObj +"\"");
					
				O.addProperty ({
					obj: propObj, 
					name: attrValue,
					uid: propUID + "["+ attrName + "="+ attrValue +"]",
				});
			});		
		};
	};


};


function crystall_dxChart( options ) {
	crystalClass.call(this);
	
	let propUID = options.propUID, $uid = $(propUID);
	if ($uid.length == 0) console.error( "element \"" + propUID + "\"  is not found"); 
	
	
	// let created = false;

	
	Object.defineProperty(this, "data", {
		get: function() { 
			return $uid.dxChart('instance').option('dataSource');
		},
		set: function(chart_data) {
			$uid.dxChart('instance').option('dataSource', chart_data);
		}
	});
	
};


function crystall_site( options ) {
	//crystalClass.call(this);
	this._url = new Url();
	
	//this._url.path = "/asd/asd";
	this._url.query.a = [1, 2, 3];

	Object.defineProperty(this, "title", {
		get: function() { return this._title },
		set: function(value) {
			this._title = value;
			$("title, .title").html( this._title );
		}
	});
	
	Object.defineProperty(this, "url", {
		get: function() { return this._url},
		set: function(value) {
			this._url = value;
		}
	});
	
	Object.defineProperty(this, "description", {
		get: function() { return this._description },
		set: function(value) {
			this._description = value;
			$(".description").html( this._description );
		}
	});	
	
};


var CD = new crystalData();


CD.addProperty({name: "site", uid: null, class: "site"});
CD.web.title = "title";
CD.web.description = "description";



//console.info(CD.web.url);

//CD.web.url.path = "/dfdfdf";
//CD.web.url ( CD.web.url );


$(document).ready(function()  {


});


window.onstatechange = function( e ) {
	console.info( History.getState() );
	
};

/*
	Присвоить геттер name для элемента uid
	CD.addProperty({name: "reading", uid: "[cd-param=reading]"});
	
	Присвоить геттер name свойству obj для элемента uid
	CD.addProperty({obj: "meter1", name: "reading", uid: "[cd-meter=1][cd-param=reading]"});
	
*/



/*
	Присвоить геттер из всех значений элементов uid с атрибутом attr свойству obj
	- если не задано uid, то ориентируемся только на наличие атрибута attr. uid - только для уточнения (в большинстве случаев если задано obj)

CD.addProperty({obj: "meter1", name: "reading", uid: "[cd-meter=1][cd-param=reading]"});

CD.addPropertyAttr([
	{obj: "meter1", attr: "cd-param", uid: "[cd-meter=1]"}, 
	{obj: "meter2", attr: "cd-param", uid: "[cd-meter=2]"}
]);

*/



