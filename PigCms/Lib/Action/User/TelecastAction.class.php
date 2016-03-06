<?php
/**
 *
 * 直播后台控制器类
 *
 * Created by PhpStorm.
 * User: Nsinm
 * Date: 16/3/4
 * Time: 下午2:22
 */

class TelecastAction extends UserAction
{
    /**
     * 显示用户管理页
     */
    public function index ()
    {
        $params = array(
            'userCount' => M('user', 'jinsi_')->count(),
            'commentCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=1')->count(),
            'liveCount' => M('content', 'jinsi_')->where('jinsi_content_is_comemnt=0')->count()
        );
        $this->assign('vars', $params);
        $this->display();
    }

    /**
     * 获取用户列表
     */
    public function getUserList ()
    {
        $this->_to404();

        $result = array('errcode' => 1, 'msg' => '获取用户列表失败!');

        $model = M('user', 'jinsi_');
        $count = $model->count();
        $page = $this->_get('page');
        $pageSize = $this->_get('pageSize');
        $start = ($page - 1) * $pageSize;
        $userList = M('user', 'jinsi_')->limit($start, $pageSize)->select();
        if($userList){
            $result = array('errcode' => 0, 'msg' => '获取用户列表成功!', 'total' => $count, 'data' => $userList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    public function delUser ()
    {
        $this->_to404();

        $result = array('errcode' => 1, 'msg' => '删除用户失败!');

        $model = M('user', 'jinsi_');
        $count = $model->count();
        $page = $this->_get('page');
        $pageSize = $this->_get('pageSize');
        $start = ($page - 1) * $pageSize;
        $userList = M('user', 'jinsi_')->limit($start, $pageSize)->select();
        if($userList){
            $result = array('errcode' => 0, 'msg' => '获取用户列表成功!', 'total' => $count, 'data' => $userList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 非ajax请求错误提示
     */
    private function _to404 ()
    {
        if(!IS_AJAX) _404('该页面不存在!');
    }

    private function page ($table, $where=1, $pageRows=20, $currentPage=1)
    {
        $model = M($table, 'jinsi_');
        if(!$model)
            $this->ajaxReturn(array('errcode' => 2, 'msg' => '连接数据表失败!'), 'JSON');
        //数据库中总的记录数
        $count = $model->where($where)->count();
        //总页数
        $pageNum = ceil($count / $pageRows);

    }
}