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
    /*
     * 会员价格
     */
    private $price;

    /**
     * PayAction constructor.
     */
    function __construct()
    {
        parent::__construct();

        //获取当前会员价格
        $this->price = M('pay')->where('id=1')->getField('jinsi_pay_price');
        if(!$this->price){
            throw_exception('没有设置会员价格!');
        }
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
            $userInfo = M('user')->where('id=' . $userId)->select();
            if(!$userInfo){
                throw_exception('用户信息错误');
            }
            $data = array(
                'userId' => $userId,
                'followUserId' => $fid,
                'followUsername' => $username,
                'userInfo' => $userInfo[0],
                'price' => $this->price
            );
            $this->assign('data', $data);
        }else{
            throw_exception('参数错误');
        }
        $this->assign('urls', $this->ajaxUrls);
        $this->display();
    }

    /**
     * 跳到支付流程页面
     */
    public function toPayPage ()
    {
        $followUserId = $this->_get('fid');
        if(!$followUserId){
            throw_exception('缺少关键参数!');
        }
        $data = array(
            'userId' => $this->userId,
            'followUserId' => $followUserId,
            'price' => $this->price
        );
        $this->assign('data', $data);
        $this->display();
    }
}