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
            'liveCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=0')->count()
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
        $page = $this->_get('page');
        $pageSize = $this->_get('pageSize');
        $start = ($page - 1) * $pageSize;
        $userList = $model->limit($start, $pageSize)->select();
        if($userList){
            $result = array('errcode' => 0, 'msg' => '获取用户列表成功!', 'data' => $userList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 编辑用户
     */
    public function editUser ()
    {
        $this->_to404();

        $result = array('errcode' => 1, 'msg' => '操作失败!');

        $handleType = $this->_post('type');
        $userId = $this->_post('userId');
        if($handleType && $userId){
            $model = M('user', 'jinsi_')->where('id=' . $userId);
            switch ($handleType){
                case '1':
                    $status = $model->delete();
                    M('follow', 'jinsi_')->where('jinsi_follow_id_user=' . $userId)->delete();
                    if($status)
                        $result = array('errcode' => 0, 'msg' => '删除成功!');
                    break;
                case '2':
                    $data['jinsi_user_type'] = 1;
                    $data['jinsi_user_recommend'] = 0;
                    $status = $model->save($data);
                    if($status)
                        $result = array('errcode' => 0, 'msg' => '取消成功!');
                    break;
                case '3':
                    $data['jinsi_user_recommend'] = 0;
                    $status = $model->save($data);
                    if($status)
                        $result = array('errcode' => 0, 'msg' => '取消成功!');
                    break;
                case '4':
                    $data['jinsi_user_recommend'] = 1;
                    $status = $model->save($data);
                    if($status)
                        $result = array('errcode' => 0, 'msg' => '推荐成功!');
                    break;
                case '5':
                    $data['jinsi_user_type'] = 2;
                    $status = $model->save($data);
                    if($status)
                        $result = array('errcode' => 0, 'msg' => '设置成功!');
                    break;
                case '6':
                    $data = array(
                        'jinsi_user_style' => $this->_post('style'),
                        'jinsi_user_sign' => $this->_post('sign'),
                        'jinsi_user_info' => $this->_post('content'),
                        'jinsi_user_city' => $this->_post('city')
                    );
                    $status = $model->save($data);
                    if($status)
                        $result = array('errcode' => 0, 'msg' => '修改成功!', 'status' => $status);
                    else
                        $result = array('errcode' => 1, 'msg' => '修改失败!', 'status' => $status);
                    break;
            }
        }
        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 直播管理页面
     */
    public function live ()
    {
        $params = array(
            'userCount' => M('user', 'jinsi_')->count(),
            'commentCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=1')->count(),
            'liveCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=0')->count()
        );
        $this->assign('vars', $params);
        $this->display();
    }

    /**
     * 评论管理页面
     */
    public function comment ()
    {
        $params = array(
            'userCount' => M('user', 'jinsi_')->count(),
            'commentCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=1')->count(),
            'liveCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=0')->count()
        );
        $this->assign('vars', $params);
        $this->display();
    }

    /**
     * 获取直播列表
     */
    public function getLiveList ()
    {
        $this->_to404();

        $result = array('errcode' => 1, 'msg' => '获取失败!');

        $page = $this->_get('page');
        $pageSize = $this->_get('pageSize');
        $type = $this->_get('type'); //1评论 0直播
        $start = ($page - 1) * $pageSize;

        $sql = "SELECT FROM_UNIXTIME(jc.jinsi_content_create, '%Y-%m-%d %H:%i') AS content_create_time, jc.*, ju.id AS user_id, ju.jinsi_user_name FROM jinsi_content AS jc LEFT JOIN jinsi_user AS ju ON jc.jinsi_content_create_user_id = ju.id WHERE jc.jinsi_content_is_comment = {$type} ORDER BY jc.jinsi_content_create DESC LIMIT {$start}, {$pageSize}";
        $liveList = M()->query($sql);
        if($liveList){
            $result = array('errcode' => 0, 'msg' => '获取成功!', 'data' => $liveList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 删除评论或直播
     */
    public function delContent ()
    {
        $this->_to404();

        $result = array('errcode' => 1, 'msg' => '操作失败!');

        $cid = $this->_get('cid');
        if($cid){
            $status = M('content', 'jinsi_')->where('id=' . $cid)->delete();
            if($status){
                $result = array('errcode' => 0, 'msg' => '删除成功!');
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 获取直播列表
     */
    public function getFeedbackList ()
    {
        $this->_to404();

        $result = array('errcode' => 1, 'msg' => '获取失败!');

        $page = $this->_get('page');
        $pageSize = $this->_get('pageSize');
        $start = ($page - 1) * $pageSize;

        $sql = "SELECT FROM_UNIXTIME(jf.jinsi_feedback_time, '%Y-%m-%d %H:%i:%s') AS feedback_create_time, jf.*, ju.id AS user_id, ju.jinsi_user_name FROM jinsi_feedback AS jf LEFT JOIN jinsi_user AS ju ON jf.jinsi_feedback_user_id = ju.id WHERE 1 ORDER BY jf.jinsi_feedback_time DESC LIMIT {$start}, {$pageSize}";
        $feedbackList = M()->query($sql);
        if($feedbackList){
            $result = array('errcode' => 0, 'msg' => '获取成功!', 'data' => $feedbackList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 反馈管理页面
     */
    public function feedback ()
    {
        $params = array(
            'userCount' => M('user', 'jinsi_')->count(),
            'commentCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=1')->count(),
            'liveCount' => M('content', 'jinsi_')->where('jinsi_content_is_comment=0')->count(),
            'feedbackCount' => M('feedback', 'jinsi_')->count()
        );
        $this->assign('vars', $params);
        $this->display();
    }

    /**
     * 非ajax请求错误提示
     */
    private function _to404 ()
    {
        if(!IS_AJAX) _404('该页面不存在!');
    }
}