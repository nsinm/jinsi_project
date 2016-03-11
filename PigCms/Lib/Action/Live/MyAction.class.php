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

class MyAction extends LiveAction
{
    /**
     * UploadAction constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * 我的主页
     */
    public function index ()
    {
        $uris = array(
            'followUrl' => U('follow'),
            'fansUrl' => U('fans'),
            'liveUrl' => U('live'),
            'feedbackUrl' => U('feedback'),
            'exceptionUrl' => U('exception'),
            'userInfoUrl' => U('Instructor/index') . '&userId=' . $this->userId . '&type=1'
        );
        $urls = array_merge($this->ajaxUrls, $uris);
        $userInfo = M('user')->where('id=' . $this->userId)->select();
        $userType = M('user')->where('id=' . $this->userId)->getField('jinsi_user_type');
        $this->assign('user', $userInfo[0]);
        $this->assign('urls', $urls);
        $this->assign('userType', $userType);
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
        $uris = array(
            'fansUrl' => U('getMyFansList')
        );
        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 获取我的粉丝列表
     */
    public function getMyFansList ()
    {
        if(!IS_AJAX) _404('页面不存在!');
        $result = array('errcode' => 1, 'msg' => '获取粉丝列表失败!');

        $res = M('follow')->where('jinsi_follow_id_user=' . $this->userId)->select();
        if($res){
            $fansIds = array_column($res, 'jinsi_follow_user_id');
            $in = '(' . implode(',', $fansIds) . ')';
            $fansInfos = M('user')->where('id IN ' . $in)->select();
            $result = array('errcode' => 0, 'msg' => '获取粉丝列表成功!', 'data' => $fansInfos);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 我的直播
     */
    public function live ()
    {
        $uris = array(
            'llUrl' => U('getMyLiveList'),
            'commentUrl' => U('Index/comment')
        );

        $cUserId = $this->_get('userId');

        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('cUserId', $cUserId);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 获取我的直播列表
     */
    public function getMyLiveList ()
    {
        if(!IS_AJAX) _404('页面不存在!');

        if($this->_get('userId')){
            $this->userId = $this->_get('userId');
        }

        $result = array('errcode' => 1, 'msg' => '获取直播列表失败!');
        $sql = "SELECT FROM_UNIXTIME(jc.jinsi_content_create, '%Y-%m-%d %H:%i') AS content_create_time, jc.*, ju.id AS user_id, ju.jinsi_user_name, ju.jinsi_user_header_pic FROM jinsi_content jc LEFT JOIN jinsi_user ju ON jc.jinsi_content_create_user_id = ju.id WHERE jc.jinsi_content_create_user_id = {$this->userId} AND jc.jinsi_content_is_comment = 0 ORDER BY jc.jinsi_content_create DESC";
        $liveList = M()->query($sql);
        if($liveList){
            $result = array('errcode' => 0, 'msg' => '获取直播列表成功!', 'data' => $liveList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 用户反馈
     */
    public function feedback ()
    {
        $uris = array(
            'addFeedUrl' => U('addFeedback', 'userId=' . $this->userId)
        );

        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 添加反馈
     */
    public function addFeedback ()
    {
        if(!IS_AJAX) _404('页面不存在!');

        $userId = $this->userId;
        $content = $this->_post('content');
        $result = array('errcode' => 1, 'msg' => '添加反馈失败!');
        if($userId && $content){
            $data = array(
                'jinsi_feedback_content' => $content,
                'jinsi_feedback_user_id' => $userId,
                'jinsi_feedback_time' => time()
            );
            $id = M('feedback', 'jinsi_')->add($data);
            if($id){
                $result = array('errcode' => 0, 'msg' => '添加反馈成功!', 'id' => $id);
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /*
     * 免责声明页
     */
    public function exception ()
    {
        $this->display();
    }
}