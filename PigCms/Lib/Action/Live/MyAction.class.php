<?php
/**
 *
 * 我的控制器类
 *
 * Created by PhpStorm.
 * User: Nsinm
 * Date: 16/3/3
 * Time: 下午4:50
 */

class MyAction extends Action
{
    /*
     * ajax调用的url
     */
    protected $ajaxUrls;
    /*
     * 当前登陆用户id
     */
    protected $userId;
    /*
     * 用户类型 1用户 2讲师
     */
    protected $userType;

    /**
     * 获取用户信息
     */
    function __construct ()
    {
        parent::__construct();
        if(!session('userId'))
            session('userId', 2);
        $this->userId = session('userId');
        $this->userType = M('user')->where('id=' . $this->userId)->getField('jinsi_user_type');
        $this->ajaxUrls = array(
            'userId' => $this->userId,
            'userType' => $this->userType,
            'instructorUrl' => U('Instructor/instructor'),
            'liveRoomUrl' => U('Index/index'),
            'myUrl' => U('My/index')
        );
    }

    /**
     * 我的主页
     */
    public function index ()
    {
        $uris = array(
            'followUrl' => U('follow'),
            'fansUrl' => U('fans'),
            'liveUrl' => U('live')
        );
        $urls = array_merge($this->ajaxUrls, $uris);
        $userInfo = M('user')->where('id=' . $this->userId)->select();
        $this->assign('user', $userInfo[0]);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 我的关注
     */
    public function follow ()
    {

    }

    /**
     * 我的粉丝
     */
    public function fans ()
    {

    }

    /**
     * 我的直播
     */
    public function live ()
    {

    }
}