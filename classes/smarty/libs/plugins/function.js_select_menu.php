<?php




function smarty_function_js_select_menu($params, &$smarty) {
	if (VERSION>=104) trigger_error('[nuova] Smarty plugin stable_size is deprecated for this version', E_USER_ERROR);

$class = isset($params['class']) ? $params['class'] : 'selected';

echo '
<script>
	$(document).ready(function(){
		url = location.href.replace("http://"+document.domain,"");
		url = url.split("/");

		$("ul.menu > li").each(function() {
			$ul = $(this).parent("ul");
			href = $(this).find("a").attr("href");
			if (href!==undefined) {
				href = href.replace("http://"+document.domain,"");
				var current_url = "";	
				for (var i = 0; i < url.length; i++) {
					if (i>1) current_url = current_url+"/"+url[i]; else current_url = current_url+url[i];
					if (href==current_url || href=="/"+current_url) $(this).addClass("'.$class.'");
				};			
			};
		});
	});
</script>
';

}



?>
