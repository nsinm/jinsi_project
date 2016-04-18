<?php

/**
 *
 * 支付控制器类
 *
 * Created by PhpStorm.
 * User: Nsinm
 * Date: 16/4/18
 * Time: 下午3:38
 */

class PayAction extends LiveAction
{
    /**
     * PayAction constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * 跳到支付页面
     */
    public function index ()
    {
        $userId = $this->_get('userId');
        $fid = $this->_get('fid');
        $username = $this->_get('insName');
        if($userId && $fid && $username){
            $data = array(
                'userId' => $userId,
                'followUserId' => $fid,
                'username' => $username
            );
            $this->assign('data', $data);
        }else{
            throw_exception('参数错误');
        }
        $this->assign('urls', $this->ajaxUrls);
        $this->display();
    }
}