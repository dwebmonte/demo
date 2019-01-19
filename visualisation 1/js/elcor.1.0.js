// pageInfo

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

	