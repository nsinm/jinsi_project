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
    public function pay ()
    {
        $followUserId = $this->_get('fid');
        $payName = $this->_get('payName');
        if(!$followUserId || !$payName){
            throw_exception('缺少关键参数!');
        }
        $data = array(
            'userId' => $this->userId,
            'followUserId' => $followUserId,
            'price' => $this->price,
            'payName' => $payName,
            'payTime' => date('Y-m-d')
        );
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 写入订单
     */
    public function writeOrder ()
    {
        if(!IS_AJAX) $this->_404('页面不存在!');

        $result = array('errcode' => 1, 'msg' => '生成订单失败!');

        $followUserId = $this->_post('fid');
        $serviceName = $this->_post('payName');
        $telNo = $this->_post('telNo');
        $realName = $this->_post('realName');
        $identityCardNo = $this->_post('cardNo');

        if($followUserId && $serviceName && $telNo && $realName && $identityCardNo){
            $existsOrder = M('order')->where('user_id=' . $this->userId . ' AND follow_id=' . $followUserId)->count();
            if($existsOrder > 0){
                $status = M('order')->where('user_id=' . $this->userId . ' AND follow_id=' . $followUserId)->delete();
                if(!$status)
                    $this->ajaxReturn($result, 'JSON');
            }
            $data = array(
                'pay_time' => time(),
                'pay_money' => $this->price,
                'order_no' => str_replace('.', '', uniqid('MEMBERSERVICE', true)),
                'status' => 0,
                'user_id' => $this->userId,
                'follow_id' => $followUserId,
                'real_name' => $realName,
                'tel_no' => $telNo,
                'identity_card_no' => $identityCardNo,
                'service_name' => $serviceName
            );

            $id = M('order')->add($data);
            if($id){
                $result = array('errcode' => 0, 'msg' => '生成订单成功!', 'id' => $id);
            }
        }
        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 订单支付
     */
    public function payOrder ()
    {
        $fid = $this->_post('fid');
        if($fid){
            $orderInfo = M('order')->where('user_id=' . $this->userId . ' AND follow_id=' . $fid . ' AND status=0')->select();
            if($orderInfo){
                $directUrl = "mp.jinsxy.com/wxpay/demo/js_api_call.php?order_no={$orderInfo[0]['order_no']}&pay_no={$orderInfo[0]['pay_money']}&content={$orderInfo[0]['service_name']}&jinsi_sign=";
                $this->success('确认支付?', $directUrl);
            }
        }
        $this->error('支付失败');

    }
}