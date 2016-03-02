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
    /*
     * ajax调用的url
     */
    private $ajaxUrls;
    /*
     * 当前登陆用户id
     */
    private $userId;

    function __construct()
    {
        if(!session('userId'))
            session('userId', 2);
        $this->userId = session('userId');
        $this->ajaxUrls = array(
            'userId' => $this->userId,
            'instructorUrl' => U('Instructor/instructor'),
            'liveRoomUrl' => U('index'),
            'myUrl' => U('My/index')
        );
    }

    /**
     * 直播主页
     */
    public function index ()
    {
        $uris = array(
            'griUrl' => U('getRecomendInstructor'),
            'gricUrl' => U('getReInCommnet'),
            'guiUrl' => U('Instructor/index'),
            'cUrl' => U('comment')
        );
        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 获取推荐导师列表
     */
    public function getRecomendInstructor ()
    {
        if(!IS_AJAX) _404('页面不存在');
        $result = array('errcode' => 1, 'msg' => '获取推荐导师数据失败!');
        $instructors = M('user')->where('jinsi_user_type = 2 AND jinsi_user_recommend = 1')->order('jinsi_user_create_time')->limit(8)->select();
        if($instructors){
            $result = array(
                'errcode' => 0,
                'msg' => '获取推荐导师数据成功!',
                'data' => $instructors
            );
        }
        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 获取关注导师直播列表
     */
    public function getReInCommnet ()
    {
        if(!IS_AJAX) _404('页面不存在');
        $result= array('errcode' => 1, 'msg' => '获取关注导师直播失败!');
        $instructors = M('follow')->where('jinsi_follow_user_id = ' . $this->userId)->select();
        if($instructors) {
            $instructorIds = array_column($instructors, 'jinsi_follow_id_user');
            $in = '(' . implode(',', $instructorIds) . ')';
            $sql = "SELECT FROM_UNIXTIME(jc.jinsi_content_create, '%Y-%m-%d %H:%i') AS content_create_time, jc.*, ju.id AS user_id, ju.jinsi_user_name, ju.jinsi_user_header_pic FROM jinsi_content AS jc LEFT JOIN jinsi_user AS ju ON jc.jinsi_content_create_user_id = ju.id WHERE jc.jinsi_content_create_user_id IN {$in} AND jc.jinsi_content_is_commend = 0 ORDER BY jc.jinsi_content_create DESC";
            $comments = M()->query($sql);
            if($comments){
                $result = array('errcode' => 0, 'msg' => '获取关注导师直播列表成功!', 'data' => $comments);
            }
        }
        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 评论详情页
     */
    public function comment ()
    {
        $cid = $this->_get('cid');
        $uris = array(
            'gcUrl' => U('getComment', 'instructorId=' . $cid),
        );
        $urls = array_merge($this->ajaxUrls, $uris);
        $this->assign('urls', $urls);
        $this->display();
    }

    public function getComment ()
    {

    }
}