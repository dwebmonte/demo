<?php

/*
<link rel="canonical" href="http://www.example.com/article?story=abc&page=2"/>
<link rel="prev" href="http://www.example.com/article?story=abc&page=1&sessionid=123" />
<link rel="next" href="http://www.example.com/article?story=abc&page=3&sessionid=123" />
*/



function smarty_prefilter_pages_2_1($source, &$smarty)  {
	$smarty->config_load('modules.conf','seo');
	$source = preg_replace('#\<\!\-\-\!   .+?    \-\-\> #six','',$source);
	

	$meta_insert = array(
		0=>array('attr'=>'http\-equiv', 'value'=>'content\-type', 'insert'=>'<meta charset="utf-8">'),
		1=>array('value'=>'title', 'insert'=>'<meta name="title" content="{$config.title|default:$config.title_seo|default:$smarty.config.title}{$smarty.config.title_after}" />'),
		2=>array('value'=>'keywords', 'insert'=>'<meta name="keywords" content="{$config.keywords_seo|default:$smarty.config.keywords}" />'),
		3=>array('value'=>'description', 'insert'=>'<meta name="description" content="{$config.description_seo|default:$smarty.config.description}" />'),
		4=>array('value'=>'author', 'insert'=>'<meta name="author" content="WebMonte.net" />'),
		5=>array('value'=>'viewport', 'insert'=>'<meta name="viewport" content="width=device-width,initial-scale=1" />'),
		
		10=>array('value'=>'og:title', 'insert'=>'<meta name="og:title" content="{$config.title_seo|default:$smarty.config.og_title}" />'), 
		11=>array('value'=>'og:description', 'insert'=>'<meta name="og:description" content="{$config.keywords_seo|default:$smarty.config.og_description}" />'),
		12=>array('value'=>'og:locale', 'insert'=>'<meta name="og:locale" content="ru_RU" />'),
		//13=>array('value'=>'og:image', 'insert'=>'<meta name="og:image" content="{$config.image_seo|default\"\"}" />'),
		
	);
	/*
	<meta property="og:url"       content="http://svejo.net/1792774-protsesat-na-tsifrovizatsiya-v-balgariya-zapochva"/>
<meta property="og:type"      content="article"/>
<meta property="og:site_name" content="Svejo.net"/>
*/
	
	if (preg_match('#<html .+?  <head>(   .+?   )</head> #six',$source,$sub_head)) {
		$ins_head = "{config_load file='modules.conf' section='seo'}";
		$ins_head .= "\t".'<!--[if lt IE 9]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->'."\r\n";
		$ins_head .= "\t".'<!--[if lt IE 9]><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->'."\r\n";
		$ins_head .= "\t<link rel=\"icon\" href=\"".'{$smarty.config.favicon}'."\" type=\"image/x-icon\">\r\n";
		$ins_head .= "\t<link rel=\"shortcut icon\" href=\"".'{$smarty.config.favicon}'."\" type=\"image/x-icon\">\r\n";
		
		
		foreach ($meta_insert as $meta) {
			if (!isset($meta['attr'])) $meta['attr'] = 'name';

			if (!preg_match('#<meta [^>]+? '.$meta['attr'].' \s* =  \s*  "'.$meta['value'].'"  #six',$sub_head[1],$sub)) 
				$ins_head .= "\t{$meta['insert']}\r\n";
		};

		// <title>
		if (!preg_match('#<title> [^>]+? </title>"  #six',$sub_head[1],$sub)) 
			
			if (isset($GLOBALS['_lang'])) $ins_head .= "\t".'<title><lang>{$config.title|default:$smarty.config.title}{$smarty.config.title_after}</lang></title>'."\r\n";
				$ins_head .= "\t".'<title>{$config.title|default:$smarty.config.title}{$smarty.config.title_after}</title>'."\r\n";
				
		// my head block
		if (!preg_match('#\{\$  meta\_css  \}  #six',$sub_head[1],$sub)) 
			$ins_head .= "\t".'{$meta_css|default:""}'."\r\n";
		
		
		if (!empty($ins_head)) $source = preg_replace('#<head> (.+?) </head>#six',"<head>\r\n{$ins_head}\r\n$1\r\n</head>",$source);
	};
	

	
	return $source;
}


