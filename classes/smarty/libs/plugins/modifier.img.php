<?php


	function favicon($rs, $watermark) {
		$rsBlock = imagecreatefrompng(ROOT_IMG."/watermark.png");
		
		$koef = 1/(imagesy($rs)/3);
		$logoWidth= 300;
		$logoHeight= 300;
		
		$fromX = ceil(imagesx($rs)/2.8);
		$toX = ceil(imagesx($rs)/1.5);
		
		// коэффициент растяжение по горизонтали
		$koefX = ($toX - $fromX)/(imagesx($rsBlock));
		// новая высота логотипа
		$newHeight = imagesy($rsBlock)*$koefX;
		
		$fromY = ceil((imagesy($rs)-$newHeight)/2);
		$toY = $fromY+$newHeight;
		
		
		$fromX = ceil(imagesx($rs)/4);
		$toX = imagesx($rs)-ceil(imagesx($rs)/4)*2;
		
		$koef = ($toX)/(imagesx($rsBlock));
		// новая высота логотипа
		$newHeight = ceil(imagesy($rsBlock)*$koef);
		
		$fromY = ceil((imagesy($rs)-$newHeight)/2);
		$toY = $newHeight;
		imagecopyresampled($rs, $rsBlock, $fromX, $fromY, 0, 0, $toX, $toY, imagesx($rsBlock), imagesy($rsBlock));
		return $rs;
	}	





function smarty_modifier_img($string, $sizeX = 0,$sizeY = 0,$quality = 100, $watermark = null) {
	//return $string;
	
	//if (!IS_LOCAL_SERVER) {
	
		$max_img_resize = $GLOBALS['_smarty']->get_config_vars('max_img_resize');
		if (!is_null($max_img_resize)) {
			if (!isset($GLOBALS['_current_count_img_resize'])) $GLOBALS['_current_count_img_resize'] = 0;
			if ($GLOBALS['_current_count_img_resize'] > $max_img_resize) return $string;
		};
	//};
	
	
	
	if (empty($string)) return '';
	if (strpos($string,'/')===0) $fn = 'http://'.$_SERVER['HTTP_HOST'].$string; else $fn = $string;
	//$fn = $string;
	
	$info = pathinfo($fn);
	//var_dump($info);
	//exit();

	
	if (isset($info['extension'])) $fn_res = ROOT_RESIZED_IMAGE.'/'.str_ireplace('.'.$info['extension'], '-'.$sizeX.'-'.$sizeY.'.'.$info['extension'],basename($fn));
	else $fn_res = ROOT_RESIZED_IMAGE.'/'.basename($fn).'-'.$sizeX.'-'.$sizeY;
	
	
	if (!file_exists($fn_res)) {
		$rs = rs($fn,$ext);
		if (is_null($rs)) {
			//if (TESTING) trigger_error("Ошибка уменьшения картинки - '{$fn}'", E_USER_ERROR);
			return $string;
		};

		
		if (isset($GLOBALS['_current_count_img_resize'])) $GLOBALS['_current_count_img_resize']++;
		
		
		if ($sizeX >  imagesx($rs)) $sizeX =  imagesx($rs);
		
		if ($sizeX==0 && $sizeY==0) {
			$sizeX = imagesx($rs);
			$sizeY = imagesy($rs);
		
		} elseif ($sizeY==0) {
			$koef = $sizeX/imagesx($rs);
			$sizeY = ceil($koef*imagesy($rs));
		} elseif ($sizeX==0) {
			$koef = $sizeY/imagesy($rs);
			$sizeX = ceil($koef*imagesx($rs));
		};

		
		
		
		if (imageistruecolor($rs)) $resImg = imagecreatetruecolor($sizeX,$sizeY);
		else $resImg = imagecreate($sizeX,$sizeY);
		imagecopyresampled($resImg, $rs, 0, 0, 0, 0, $sizeX, $sizeY, imagesx($rs), imagesy($rs));		
		
		if (IMAGE_INTERLACE) imageinterlace($rs,1); 
		
		
		if (!is_null($watermark)) $resImg = favicon($resImg, $watermark);
		
		imagejpeg($resImg,$fn_res,$quality);	
	
	};
	
	//var_dump('/'.PATH_RESIZED_IMAGE.'/'.basename($fn_res));
	//exit();
	
	return '/'.PATH_RESIZED_IMAGE.'/'.basename($fn_res);

}

	function rs($url,&$ext) {
		if (strpos($url,'http://')===FALSE) {
			$url = realpath(ROOT.$url);	
			//$url = str_ireplace(DOCUMENT_ROOT,$_SERVER['HTTP_HOST'],$url);		

			//$url = $_SERVER['HTTP_HOST'].$url;
		};
		$rs = NULL;
		@$imgType = getimagesize($url);
		if (is_array($imgType))
		switch ($imgType[2]):
			case 2: $rs = imagecreatefromjpeg($url); $ext='.jpg'; break;
			case 3: $rs = imagecreatefrompng($url); $ext='.png'; break;
			case 1: $rs = imagecreatefromgif($url); $ext='.gif'; break;
			case 6: $rs = imagecreatefromwbmp($url); $ext='.bmp'; break;
		endswitch;
		return $rs;
	}

?>
