// pageInfo


//console.info( elCorazone, window.location );


// console.log( window.location.hostname + window.location.pathname.replace(/\/+$/, "") );




// menu





// left menu
if (elCorazone.com.leftMenu) {
	let html = "", activeClass = "", subClass = "";
	let currentURL = window.location.hostname + window.location.pathname.replace(/\/+$/, "");
	
	elCorazone.com.leftMenu.data.forEach(function (item1, index) {
		if (item1.url === undefined) item1.url = "#";
		if (item1.icon === undefined) item1.icon = "linecons-star";
		if (item1.title === undefined) item1.icon = item1.url;
		
		activeClass =  (item1.url === currentURL || elCorazone.server.domain + item1.url === currentURL) ? "active " : "";
		
		html = html + "<li class='"+ activeClass +" "+ subClass +"'><a href='" + item1.url + "'><i class='" + item1.icon + "'></i><span class='title'>" + item1.icon + "</span></a></li>";
	});
	
	
	if ( $("#main-menu").length != 1) console.error("#main-menu length = " + $("#main-menu").length); else $("#main-menu").html( html );
};


/*
if (elCor.com.pageInfo) {
	if (elCor.com.pageInfo.title) $("title").text( elCor.com.pageInfo.title ); else console.warn("elCor.com.pageInfo - title is not defined");
	if (elCor.com.pageInfo.header) $("h1.title").text( elCor.com.pageInfo.header ); else console.warn("elCor.com.pageInfo - header is not defined");
	if (elCor.com.pageInfo.description) $("p.description").text( elCor.com.pageInfo.description ); else console.warn("elCor.com.pageInfo - description is not defined");
} else console.warn("elCor.com.pageInfo is not defined");
	
// sessionUser

if (elCor.com.sessionUser) {
	if (elCor.com.sessionUser.shortName) $("[data-elcor=sessionUser\\.shortName]").text( elCor.com.sessionUser.shortName ); else console.warn("elCor.com.sessionUser - shortName is not defined");
	if (elCor.com.sessionUser.roleName) $("[data-elcor=sessionUser\\.roleName]").text( elCor.com.sessionUser.roleName ); else console.warn("elCor.com.sessionUser - roleName is not defined");
} else console.warn("elCor.com.sessionUser is not defined");

*/