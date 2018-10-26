<?php 
function smarty_prefilter_path($source, &$smarty)  {

	return iCompiler::magic_to_path($source);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	global $iSmarty;
	
	// JS
	if (preg_match_all('#src \s*  =  \s*  " \s* ([^"]+? \.js) \s* "#six',$source,$sub,PREG_SET_ORDER)) {
		//var_dump($sub); exit();
		foreach ($sub as $item) {
			
			$src = src($item[1],'js');
			$source = str_ireplace($item[0],"src='{$src}'",$source);
		};
	};

	// img
	if (preg_match_all('#<img [^>]+?  src \s*  =  \s*  " \s* ([^"]+? ) \s* "#six',$source,$sub,PREG_SET_ORDER)) {
		foreach ($sub as $item) {
			if (preg_match("#\{'  ([^']+?)  ' \s*  \|  \s* image\_resize#six",$item[1],$sub_img)) $src = $sub_img[1]; else $src = $item[1];
			$src_new = src($src,'img');
			$source = str_ireplace($src,$src_new,$source);
		};
	};

	
	
	
	// AJAX
	if (preg_match_all('# \$\.ajax\(\{ \s* url \s* \:  \s* " \s* ([^"]+?) \s* "#six',$source,$sub,PREG_SET_ORDER)) 
		foreach ($sub as $item) $source = str_ireplace($item[0],"$.ajax({url:'".src($item[1])."'",$source);
	// background url
	if (preg_match_all('# background: \s* url \s*   \(  \s* " \s* ([^"]+?) \s* " \)   #six',$source,$sub,PREG_SET_ORDER)) 
		foreach ($sub as $item) $source = str_ireplace($item[0],"background: url(\"".src($item[1],'img')."\")",$source);
	
	
	// CSS
	if (preg_match_all('#href \s*  =  \s*  " \s* ([^"]+? \.css) \s* "#six',$source,$sub,PREG_SET_ORDER)) {
		$dir_to = $iSmarty->compile_dir;
		$path_to = str_ireplace($_SERVER['DOCUMENT_ROOT'],'',$dir_to);
	
	
		foreach ($sub as $item) {
			$src = src($item[1],'css');
			
			// обработка самого файла
			if (strpos($src,'http://')===FALSE) {
			
				$fn = $_SERVER['DOCUMENT_ROOT'].$src;	
				$contentCSS = file_get_contents($fn);
				if (preg_match_all('#url \s* \( "   (  [^"]+?  )    "  \) #six',$contentCSS,$sub_urls,PREG_SET_ORDER)) {
					foreach ($sub_urls as $url_img) {
						$url_img[1] = str_replace(array('"',"'"),'',$url_img[1]);
						$contentCSS = str_ireplace($url_img[0],"url('".src($url_img[1],'img')."')",$contentCSS);	
					};
				};
				file_put_contents($dir_to.basename($src),$contentCSS);
				// подставляем новое имя в файл
				$source = str_ireplace($item[1],$path_to.basename($src),$source);
			};			
		};
	};
	
	// Замена всех относительных путей ссылок
	
	
	

	return $source;
	
};

function src($src, $type=NULL) {
	$paths = array(
		'root'=>array('js'=>ROOT_JS,'css'=>ROOT_CSS,'img'=>ROOT_IMG),
		'path'=>array('js'=>PATH_JS,'css'=>PATH_CSS,'img'=>PATH_IMG)
	);
	
	if (strpos($src,'http')===0 || file_exists($_SERVER['DOCUMENT_ROOT'].$src)) return $src; 
	else {
		
			
		if (file_exists(ROOT.$src)) $src = '/'.CMS_PATH.$src;
		elseif (!is_null($type) && file_exists(ROOT.$type.'/'.$src)) $src = '/'.CMS_PATH.$type.'/'.$src;
		elseif (!is_null($type) && file_exists($paths['root'][$type].'/'.$src)) $src = '/'.$paths['path'][$type].'/'.$src;
		else ;
			//trigger_error("Не найден файл - '{$src}' <br />\r\n (".ROOT."{$src}, ".ROOT."{$type}/{$src} ,{$paths['root'][$type]}/{$src}) ",E_USER_WARNING);
		
		return $src;
	};

};
