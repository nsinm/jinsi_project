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
     * 编辑个人信息页
     */
    public function edit ()
    {

    }

    /**
     * 我的关注
     */
    public function follow ()
    {
        $uris = array(
            'gfUrl' => U('getMyFollowList'),
            'cfUrl' => U('Instructor/cancelFollow')
        );
        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 获取我的关注列表
     */
    public function getMyFollowList ()
    {
        if(!IS_AJAX) _404('页面不存在!');
        $result = array('errcode' => 1, 'msg' => '获取关注列表失败!');

        $res = M('follow')->where('jinsi_follow_user_id=' . $this->userId)->select();
        if($res){
            $followIds = array_column($res, 'jinsi_follow_id_user');
            $in = '(' . implode(',', $followIds) . ')';
            $followInfos = M('user')->where('id IN ' . $in)->select();
            $result = array('errcode' => 0, 'msg' => '获取关注列表成功!', 'data' => $followInfos);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 我的粉丝
     */
    public function fans ()
    {
        $uris = array();
        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 我的直播
     */
    public function live ()
    {
        $uris = array();
        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('urls', $urls);
        $this->display();
    }
}