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
        //$Live = D('Live');
        //$openid = $Live->get_openid(get_url());

        //$userid = $Live->get_user_info($openid);
        //echo M('live')->get_openid('aa');
        $jssdk = D('Jssdk');
        $signPackage = $jssdk->GetSignPackage();
        //print_r($signPackage);
        //$this->assign('signPackage',$signPackage);
        $data['title'] = "测试测试";
        $data['imgUrl'] = "https://www.baidu.com/img/baidu_jgylogo3.gif";
        $data['link'] = get_url();
        //$this->assign('data',$data);
        $send_data['openid'] = "o6Kftv49cTfM5sQfnCmp6_kyP_48";
        $send_data['auther'] = "我是12哥";
        $send_data['content'] = "有新的股票发布了";
        $send_data['url'] = "http://www.baidu.com";
        $rs = $jssdk->send_message($send_data);
        print_r($rs);
        $this->display();
    }
}