<?php
header("Content-type: text/html; charset=utf-8");
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
 */
include_once("../WxPayPubHelper/WxPayPubHelper.php");

//使用jsapi接口
$jsApi = new JsApi_pub();

//=========步骤1：网页授权获取用户openid============
//通过code获得openid
if (!isset($_GET['code'])) {
    $url = WxPayConf_pub::JS_API_CALL_URL . '?' . $_SERVER['QUERY_STRING'];
    //触发微信返回code码
    $url = $jsApi->createOauthUrlForCode($url);
    Header("Location: $url");
} else {
    //获取code码，以获取openid
    $code = $_GET['code'];
    $jsApi->setCode($code);
    $openid = $jsApi->getOpenId();
    if(!$openid){
        Header("Location: 'http://mp.jinsxy.com/index.php?g=Livetest&m=Index&a=index");
    }
}


//传入数据校验
$jinsi_token = "jinsi";

//=========步骤2：使用统一支付接口，获取prepay_id============
//使用统一支付接口
$unifiedOrder = new UnifiedOrder_pub();

//设置统一支付接口参数
//设置必填参数
//appid已填,商户无需重复填写
//mch_id已填,商户无需重复填写
//noncestr已填,商户无需重复填写
//spbill_create_ip已填,商户无需重复填写
//sign已填,商户无需重复填写
$unifiedOrder->setParameter("openid", "$openid");//商品描述
$body = isset($_GET['content']) ? $_GET['content'] : "会员购买";
$unifiedOrder->setParameter("body", $body);//商品描述
//自定义订单号，此处仅作举例
$timeStamp = time();
//$out_trade_no = WxPayConf_pub::APPID."$timeStamp";

$str = isset($_GET['order_no']) ? $_GET['order_no'] : '';
$order_arr = explode('_', $str);
$out_trade_no = $order_arr[0];
$unifiedOrder->setParameter("out_trade_no", "$out_trade_no");//商户订单号
$total_fee = $order_arr[1];
$check_no = md5($out_trade_no . $openid . $total_fee . $jinsi_token);
$jinsi_sign = isset($_GET['jinsi_sign']) ? $_GET['jinsi_sign'] : '';
if ($check_no != $jinsi_sign) {
    //echo "error";
    //exit;
}
$unifiedOrder->setParameter("total_fee", $total_fee);//总金额
//$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址
$unifiedOrder->setParameter("notify_url", "http://mp.jinsxy.com/wxp/pay");//通知地址
$unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
//非必填参数，商户可根据实际情况选填
//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
//$unifiedOrder->setParameter("device_info","XXXX");//设备号
//$unifiedOrder->setParameter("attach","XXXX");//附加数据
//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
//$unifiedOrder->setParameter("openid","XXXX");//用户标识
//$unifiedOrder->setParameter("product_id","XXXX");//商品ID

$prepay_id = $unifiedOrder->getPrepayId();
//=========步骤3：使用jsapi调起支付============
$jsApi->setPrepayId($prepay_id);

$jsApiParameters = $jsApi->getParameters();
//echo $jsApiParameters;
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>

    <script type="text/javascript">

        //调用微信JS api 支付
        function jsApiCall() {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function (res) {
                    WeixinJSBridge.log(res.err_msg);
                    //alert(res.err_code+res.err_desc+res.err_msg);
                }
            );
        }

        function callpay() {
            if (typeof WeixinJSBridge == "undefined") {
                if (document.addEventListener) {
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                } else if (document.attachEvent) {
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            } else {
                jsApiCall();
            }
        }


        function jump_url()
        {
            window.location.href="http://mp.jinsxy.com/index.php?g=Livetest&m=My&a=live&userId=<?=$order_arr[2]?>";
        }


        callpay();
        setTimeout(jump_url,10000)
    </script>
</head>
<body>
</br></br></br></br>
<div align="center">
    <button
        style="width:210px; height:30px; background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;"
        type="button" onclick="callpay()">付款
    </button>
</div>
</body>
</html>