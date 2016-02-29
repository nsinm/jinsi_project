<?php
/**
 *
 * 用户相关控制器类
 *
 * Created by PhpStorm.
 * User: Nsinm
 * Date: 16/2/29
 * Time: 下午1:02
 */

class UserAction extends Action
{
    /**
     * 用户信息主页
     */
    public function index ()
    {
        $userId = $this->_get('userId');
        $getUserInfoUrl = U('getUserInfo');
        $this->assign('urls', $getUserInfoUrl);
        $this->display();
    }

    /**
     * 获取用户详细信息
     */
    public function getUserInfo ()
    {
        if(!IS_AJAX) _404('页面不存在');

        $result = array('errcode' => 1, 'msg' => '获取用户信息失败!');
        $userId = $this->_get('userId');
        if($userId){
            $userInfo = M('user')->where('id = ' . $userId)->select();
            if($userInfo){
                $result = array('errcode' => 0, 'msg' => '获取用户信息成功!', 'data' => $userInfo);
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }
}