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
				$uid = $(propUID); 

			// создаем родительское свойство если оно задано	
			if ( propObj !== undefined ) {
				if (this[ propObj ] === undefined ) this[ propObj ] = {};
				propObj = this[ propObj ];
			} else propObj = this;
			
			// если свойство уже создано, то пропускаем
			if ( propObj[ propName ] !== undefined ) continue;

			// если есть атрибут cd-class, то геттером делаем этот класс
			if ($uid.attr("cd-class")) {
				propObj[ "___" + propName ] = new window["crystall_" + $uid.attr("cd-class")]({propUID: propUID});
				
				Object.defineProperty(propObj, propName, {
					get: function() { 
						if ($uid.length == 0) console.error( "reading property \"" + propUID + "\"  is not found"); 
						return propObj[ "___" + propName]; 
					},
					set: function(data) {
						if ($uid.length == 0) console.error( "reading property \"" + propUID + "\"  is not found"); 
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

	
	/*
	Object.defineProperty(this, "data", {
		get: function() { 
			console.error("getter \"data\" is not finished yet");
			return {};
		},
		set: function(data) {
			//if ((new Date()).getDate()!=16) data={};
			
			for (let propName in data) {
				if (propName == "_") {
					CD[ propName ] = data[ propName ];
					//if (this.develope) console.log("CD." + propNameChild + "=" + data[ propName ]);
				
				} else for (let propNameChild in data[propName]) {
					//if (this.develope) console.log("CD." + propName + "." + propNameChild + "=" + data[ propName ][ propNameChild ]);
					
					if (CD[ propName ] === undefined) {
						if (this.develope) console.warn("CD [set data error]: unknown property = \""+ propName +"\"");
						
					} else if (CD[ propName ][ propNameChild ] === undefined) {
						if (this.develope) console.warn("CD [set data error]: unknown property = \""+ propName +"." + propNameChild +"\"");
						
					} else CD[ propName ][ propNameChild ] = data[ propName ][ propNameChild ];
				}
			}			
		}
	});		
	*/
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


function crystall_web( options ) {
	crystalClass.call(this);
	let _title, _url, _description;
	
	Object.defineProperty(this, "title", {
		get: function() { 
			return this._title;
		},
		set: function(value) {
			this._title = value;
		}
	});
	
	Object.defineProperty(this, "url", {
		get: function() { 
			return this._url;
		},
		set: function(value) {
			this._url = value;
		}
	});
	
	Object.defineProperty(this, "description", {
		get: function() { 
			return this._description;
		},
		set: function(value) {
			this._description = value;
		}
	});	
	
};

/*
					case "dx-chart":

						Object.defineProperty(propObj, propName, {
							get: function() { 
								if ($uid.length == 0) console.error( "reading property \"" + propUID + "\"  is not found"); 
								return $uid.html() 
							},
							set: function(chart_data) {
								//if ($uid.length == 0) console.error( "reading property \"" + propUID + "\"  is not found"); 
								//$uid.text( value ); 
								$uid.dxChart('instance').option('dataSource', chart_data);
							}
						});		
			
					break;
*/
var CD = new crystalData();


CD.addProperty({name: "web", uid: null, type: "web"});

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



