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
        $openid = $Live->get_openid(get_url());

        $Live->get_user_info($openid);
        //echo M('live')->get_openid('aa');
    }
}