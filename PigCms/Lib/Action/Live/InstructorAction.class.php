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

    /**
     * InstructorAction constructor.
     */
    function __construct()
    {
        $this->ajaxUrls = array(
            'instructorUrl' => U('instructor'),
            'liveRoomUrl' => U('Index/index'),
            'myUrl' => U('My/index')
        );
    }

    /**
     * 用户信息主页
     */
    public function index ()
    {
        $userId = $this->_get('userId');
        $this->ajaxUrls['getUserInfoUrl'] = U('getInstructorInfo', 'userId='. $userId);
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
        $where = 'jinsi_user_type = 2 AND jinsi_user_recommend = 1 ORDER BY jinsi_user_create';
        if($filter)
            $where = 'ju.jinsi_user_type = 2';
        $sql = "SELECT * FROM jinsi_user WHERE {$where}";
        $result = $model->query($sql);
        if($result) {
            $instructors = array();
            $sql = "SELECT count(1) FROM jinsi_follow WHERE jinsi_follow_id_user = ";
            foreach ($result as $key => $value) {
                $count = $model->query($sql .= $value['id']);
                $value['follow_num'] = $count;
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
}