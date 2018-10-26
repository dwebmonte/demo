<?php
function smarty_prefilter_prefilter_2_0($source, &$smarty)  {

	// Выборка кода внутри 	{modules_conf}
	if (preg_match_all('#\{modules_conf\}(.+?)\{/modules_conf\}#suix',$source,$sub_module,PREG_SET_ORDER)) {
		$content_modules_filename = ROOT_SMARTY_CONFIG.'modules.conf';
		$content_modules = file_get_contents($content_modules_filename);
		
		foreach ($sub_module as $key_module=>$item_module) {
			
			// Выборка названия секции и тела секции
			if (!preg_match_all('#\[ ([^]]+?) \] ([^[]+) #suix',$item_module[1],$sub_sections,PREG_SET_ORDER)) trigger_error('Achtung 1', E_USER_ERROR);
			foreach ($sub_sections as $key_section=>$item_section) {
				$section_name = trim($item_section[1]);
				$section_body = trim($item_section[2]);			
					
				if (strpos($content_modules, "[{$section_name}]")===false) {
					$content_modules .= "\r\n[{$section_name}]\r\n{$section_body}";
					file_put_contents($content_modules_filename,$content_modules);
				};
			};
			$source = str_ireplace($item_module[0],'',$source);
		};
	}
	

	return $source;
};