<?php
/**
 *
 * 导师相关控制器类
 *
 * Created by PhpStorm.
 * User: Nsinm
 * Date: 16/2/29
 * Time: 下午1:02
 */

class InstructorAction extends Action
{
    /*
     * ajax调用的url
     */
    private $ajaxUrls;
    /*
     * 当前用户id
     */
    private $userId;

    /**
     * InstructorAction constructor.
     */
    function __construct()
    {
        if(!session('userId'))
            session('userId', 2);
        $this->userId = session('userId');
        $this->ajaxUrls = array(
            'instructorUrl' => U('instructor'),
            'liveRoomUrl' => U('Index/index'),
            'myUrl' => U('My/index'),
            'userId' => $this->userId
        );
    }

    /**
     * 用户信息主页
     */
    public function index ()
    {
        $userId = $this->_get('userId');
        $this->ajaxUrls['giiUrl'] = U('getInstructorInfo', 'userId='. $userId);
        $this->assign('urls', $this->ajaxUrls);
        $this->display();
    }

    /**
     * 获取用户详细信息
     */
    public function getInstructorInfo ()
    {
        if(!IS_AJAX) _404('页面不存在');

        $result = array('errcode' => 1, 'msg' => '获取导师信息失败!');
        $userId = $this->_get('userId');
        if($userId){
            $userInfo = M('user')->where('id = ' . $userId)->select();
            if($userInfo){
                $result = array('errcode' => 0, 'msg' => '获取导师信息成功!', 'data' => $userInfo);
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 导师页面
     */
    public function instructor ()
    {
        $this->ajaxUrls['gilUrl'] = U('getInstructorList');
        $this->ajaxUrls['followUrl'] = U('follow');
        $this->ajaxUrls['cfollowUrl'] = U('cancelFollow');
        $this->assign('urls', $this->ajaxUrls);
        $this->display();
    }

    /**
     * 获取导师列表
     */
    public function getInstructorList ()
    {
        if(!IS_AJAX) _404('页面不存在');

        $map = array('errcode' => 1, 'msg' => '获取导师列表失败!');

        $model = M();
        $filter = $this->_get('filter');
        if($filter == '2'){
            $where = 'jinsi_user_type = 2';
        }else{
            $where = 'jinsi_user_type = 2 AND jinsi_user_recommend = 1 ORDER BY jinsi_user_create_time';
        }
        $sql = "SELECT * FROM jinsi_user WHERE {$where}";
        $result = $model->query($sql);
        if($result) {
            $instructors = array();
            foreach ($result as $key => $value) {
                $sql = "SELECT count(1) follow_num FROM jinsi_follow WHERE jinsi_follow_id_user = {$value['id']}";
                $count = $model->query($sql);
                $value['follow_num'] = $count[0]['follow_num'];
                if($value['follow_num'] > 0) {
                    $sql = "SELECT jinsi_follow_user_id FROM jinsi_follow WHERE jinsi_follow_id_user = {$value['id']}";
                    $res = $model->query($sql);
                    $value['is_follow'] = in_array($this->userId, array_column($res, 'jinsi_follow_user_id')) ? 1 : 0;
                }
                array_push($instructors, $value);
            }

            if ($filter) {
                usort($instructors, function ($a, $b) {
                    if ($a['follow_num'] == $b['follow_num'])
                        return 0;
                    return $a['follow_num'] > $b['follow_num'] ? 1 : 0;
                });
            }
            $map = array('errcode' => 0, 'msg' => '获取导师列表成功!', 'data' => $instructors);
        }
        $this->ajaxReturn($map, 'JSON');
    }

    /**
     * 关注
     */
    public function follow ()
    {
        if(!IS_AJAX) _404('页面不存在');

        $result = array('errcode' => 1, 'msg' => '关注导师失败!');

        $userId = $this->_get('userId');
        $instructorId = $this->_get('instructorId');

        if($userId && $instructorId){
            $data = array(
                'jinsi_follow_user_id' => $userId,
                'jinsi_follow_id_user' => $instructorId,
                'jinsi_follow_create' => time()
            );
            $id = M('follow')->add($data);
            if($id)
                $result = array('errcode' => 0, 'msg' => '关注导师成功!');
        }
        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 取消关注
     */
    public function cancelFollow ()
    {
        if(!IS_AJAX) _404('页面不存在');

        $result = array('errcode' => 1, 'msg' => '取消关注失败!');

        $userId = $this->_get('userId');
        $instructorId = $this->_get('instructorId');

        if($userId && $instructorId){
            $status = M('follow')->where("jinsi_follow_user_id = {$userId} AND jinsi_follow_id_user = {$instructorId}")->delete();
            if($status)
                $result = array('errcode' => 0, 'msg' => '取消关注成功!');
        }
        $this->ajaxReturn($result, 'JSON');
    }
}