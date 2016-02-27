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
        $this->display();
    }

    /**
     * 获取推荐导师列表
     */
    public function getRecomendInstructor ()
    {
        $instructors = M('user', 'jinsi_')->where('jinsi_user_type = 1')->order('jinsi_user_create_time')->limit(8)->select();
        p($instructors);
    }
}