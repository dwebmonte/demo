<?php
function smarty_function_stable_size($params, &$smarty) {
	if (VERSION>=104) trigger_error('[nuova] Smarty plugin stable_size is deprecated for this version', E_USER_ERROR);
	echo "
<script>
document.ready=function (){
if(document.body.scrollHeight<=document.documentElement.clientHeight){
document.body.style.position='absolute';
document.body.style.width=document.documentElement.clientWidth+17 + 'px';
document.body.style.left=-17 + 'px';
}
}
window.onresize=function (){
if(document.body.scrollHeight<=document.documentElement.clientHeight){
document.body.style.position='absolute';
document.body.style.width=document.documentElement.clientWidth+17 + 'px';
document.body.style.left=-17 + 'px';
}
}
</script>	
	
	";
}



?>
