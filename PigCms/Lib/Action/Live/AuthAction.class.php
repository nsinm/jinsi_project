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
        echo $Live->get_openid('aaa');
        //echo M('live')->get_openid('aa');
    }
}