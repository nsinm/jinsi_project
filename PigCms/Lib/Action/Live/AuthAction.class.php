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
        $Live->put_content(428);
        //print_r($rs);
        $this->display();
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
        var_dump($_GET);
        echo "<br>";
        var_dump($_POST);
    }
}