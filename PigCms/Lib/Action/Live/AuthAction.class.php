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
        $this->assign('signPackage',$signPackage);
        $data['title'] = "测试测试";
        $data['imgUrl'] = "https://www.baidu.com/img/baidu_jgylogo3.gif";
        $data['link'] = get_url();
        $this->assign('data',$data);
        $this->display();
    }
}