<?php
/**
 * Created by PhpStorm.
 * User: slash
 * Date: 16/2/28
 * Time: 上午11:53
 */

class AuthAction extends Action
{

    public function index ()
    {

        $Live = D('Live');

        //$Live->put_comment(11,15);
        $Live->send_pay(11,15,100);
        //$openid = $Live->get_openid(get_url());

        //$userid = $Live->get_user_info('o6KftvwBgDKYsQoUaoiCzC8bKpV0');
        //print_r($userid);exit;
        //echo M('live')->get_openid('aa');
        //$jssdk = D('Jssdk');
        //$signPackage = $jssdk->GetSignPackage();
        //print_r($signPackage);
        //$this->assign('signPackage',$signPackage);
        /*
        $data['title'] = "测试测试";
        $data['imgUrl'] = "https://www.baidu.com/img/baidu_jgylogo3.gif";
        $data['link'] = get_url();
        //$this->assign('data',$data);
        $send_data['openid'] = "o6Kftv49cTfM5sQfnCmp6_kyP_48";
        $send_data['auther'] = "我是12哥";
        $send_data['content'] = "有新的股票发布了";
        $send_data['url'] = "http://www.baidu.com";
        */
        //$rs = $Live->send_message($send_data);
        //$Live->put_content(428);
        //print_r($rs);
        //$this->display();
    }

    public function send ()
    {
        $content = M('content');
        $Live = D('Live');
        $content_arr = $content->where('push=1')->select();
        //print_r($content_arr);
        if($content_arr){
            foreach($content_arr as $v){
                $Live->put_content($v['id']);
            }
        }
    }

    public function get_pay_info()
    {
        $dir = dirname(__FILE__);
        require($dir."/../../../../wxpay/demo/log_.php");
        include_once($dir."/../../../../wxpay/WxPayPubHelper/WxPayPubHelper.php");

        //使用通用通知接口
        $notify = new Notify_pub();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======

        //以log文件形式记录回调信息
        $log_ = new Log_();
        $log_name=$dir."/../../../../wxpay/demo/notify_url.log";//log文件路径
        $log_->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");

        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                $log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
            }
            elseif($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                $log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作

                //支付成功，开始写入数据库
                $array = $this->xmlToArray($xml);
                $Live = D('Live');
                $rs = $Live->update_order($array['out_trade_no'],$array['transaction_id']);
                $log_->log_result($log_name,"【支付成功】:\n".$rs."\n");
                //$xml = json_encode($array);
                //$log_->log_result($log_name,"【支付成功】:\n".$xml."\n");
            }

            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }
    }

    public function xmlToArray($xml)
    {
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }
}