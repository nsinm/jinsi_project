<?php
/**
 *
 * 直播频道主页控制器类
 *
 * Created by PhpStorm.
 * User: Nsinm
 * Date: 16/2/24
 * Time: 上午11:06
 */

class IndexAction extends Action
{
    /**
     * 直播主页
     */
    public function index ()
    {
        $ajaxUrls = array(
            'griUrl' => U('getRecomendInstructor')
        );
        $this->assign('urls', $ajaxUrls);
        $this->display();
    }

    /**
     * 获取推荐导师列表
     */
    public function getRecomendInstructor ()
    {
        if(!IS_AJAX) _404('页面不存在');
        $result = array('status' => 'fail', 'errcode' => 1);
        $instructors = M('user')->where('jinsi_user_type = 2')->order('jinsi_user_create_time')->limit(8)->select();
        if($instructors){
            $result = array(
                'status' => 'success',
                'errcode' => 0,
                'data' => $instructors
            );
        }
        $this->ajaxReturn($result, 'JSON');
    }
}