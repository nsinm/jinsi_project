<?php
function isAndroid(){
	if(strstr($_SERVER['HTTP_USER_AGENT'],'Android')) {
		return 1;
	}
	return 0;
}

function arr_htmlspecialchars($value){
	return is_array($value) ? array_map('htmlspecialchars', $value) : htmlspecialchars($value);
}

function urlGetTpl($action){
	$url_content = curl_get_tpl($action);
	return $url_content;
}

/**
 * 2015-05-21	兼容老版本 为  staticPath == 0 || 1 || true 都为本地资源
 * 获取静态资源的链接	调用方法 $staticPath = getStaticPath();
 * @return String 
 */
function getStaticPath() {
	$staticPath = C('STATICS_PATH');
	if ('1' == $staticPath) {
		$staticPath = C('SITE_URL');
	} else {
		$staticPath =  C('STATICS_PATH') ? C('STATICS_PATH') : 'http://s.404.cn';
	}
	return $staticPath;
}

/**
 * 转换支付类型
 */
function getPayType($type) {
	$payType = array(
		'alipay' => '支付宝',
		'weixin' => '微信',
		'tenpay' => '财付通',
		'tenpaycomputer' => '财付通',
		'yeepay' => '易宝支付',
		'allinpay' => '通联支付',
		'daofu' => '货到付款',
		'dianfu' => '到店付款',
		'chinabank' => '网银在线',
		'cardpay' => '会员卡',
	);
	$type = strtolower($type);
	return $payType[$type]; 
}

/**
 * 去除BOM
 */
function removeUTF8Bom($string)
{
    if(substr($string, 0, 3) == pack('CCC', 239, 187, 191)) return substr($string, 3);
    return $string;
}

function shareFilter($subject) {
	$subject = str_replace("'", "", $subject);
	$subject = str_replace("\"", "", $subject);
	$subject = str_replace("\r", "", $subject);
	$subject = str_replace("\n", "", $subject);
	$subject = str_replace("\t", " ", $subject);
	return trim($subject);
}

?>
