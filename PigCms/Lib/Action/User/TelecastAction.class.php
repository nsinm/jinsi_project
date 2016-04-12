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
        $type = $this->_get('type');
        $startPage = ($page - 1) * $pageSize;
        if(!$type){
            $userList = $model->limit($startPage, $pageSize)->select();
        }else{
            $username = $this->_get('username');
            $start = $this->_get('start');
            $end = $this->_get('end');

            $where = 1;
            if($username){
                $where = "jinsi_user_name LIKE '%$username%' ";
                if($start && !$end)
                    $where .= "AND jinsi_user_create_time >=" . strtotime($start);
                elseif(!$start && $end)
                    $where .= "AND jinsi_user_create_time <=" . strtotime($end);
                elseif($start && $end)
                    $where .= "AND jinsi_user_create_time BETWEEN " . strtotime($start) . " AND " . strtotime($end);
            }else{
                if($start && !$end)
                    $where = "jinsi_user_create_time >= " . strtotime($start);
                elseif(!$start && $end)
                    $where = "jinsi_user_create_time <= " . strtotime($end);
                elseif($start && $end)
                    $where = "jinsi_user_create_time BETWEEN " . strtotime($start) . " AND " . strtotime($end);
            }

            $sql = "SELECT * FROM jinsi_user WHERE $where ORDER BY jinsi_user_create_time DESC LIMIT $startPage, $pageSize";

            $userList = M()->query($sql);
        }

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
                        'jinsi_user_name' => $this->_post('name'),
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
     * banner管理页面
     */
    public function banner()
    {
        $params = array(
            'bannerCount' => M('banner', 'jinsi_')->count(),
        );

        $this->assign('vars', $params);
        $this->display();
    }

    /**
     * 添加banner
     */
    public function addBanner ()
    {
        if(!IS_AJAX) $this->_to404();

        $result = array('errcode' => 1, 'msg' => '添加失败!');

        $picPath = $this->_post('pic');
        $url = $this->_post('url');

        if($picPath && $url){
            $data = array(
                'jinsi_banner_pic' => $picPath,
                'jinsi_banner_url' => $url
            );
            $id = M('banner', 'jinsi_')->add($data);
            if($id){
                $result = array('errcode' => 0, 'msg' => '添加成功!');
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 获取banner列表
     */
    public function bannerList ()
    {
        if(!IS_AJAX) $this->_to404();

        $result = array('errcode' => 1, 'msg' => '获取失败!');

        $model = M('banner', 'jinsi_');
        $page = $this->_get('page');
        $pageSize = $this->_get('pageSize');
        $start = ($page - 1) * $pageSize;
        $bannerList = $model->limit($start, $pageSize)->select();
        if($bannerList){
            $result = array('errcode' => 0, 'msg' => '获取成功!', 'data' => $bannerList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 删除banner
     */
    public function bannerDel ()
    {
        if(!IS_AJAX) $this->_to404();

        $result = array('errcode' => 1, 'msg' => '删除失败!');
        $bid = $this->_get('bid');
        if($bid){
            $status = M('banner', 'jinsi_')->where('id=' . $bid)->delete();
            if($status){
                $result = array('errcode' => 0, 'msg' => '删除成功!');
            }
        }

        echo json_encode($result);
    }

    /**
     * 添加banner页面
     */
    public function addtelecast ()
    {
        $this->display();
    }

    /**
     * 获取所有条件存在的用户数量
     */
    public function searchCount ()
    {
        if(!IS_AJAX) $this->_to404();

        $result = array('errcode' => 1, 'msg' => '获取用户数量失败!');

        $username = $this->_get('username');
        $start = $this->_get('start');
        $end = $this->_get('end');

        $where = 1;
        if($username){
            $where = "jinsi_user_name LIKE '%$username%' ";
            if($start && !$end)
                $where .= "AND jinsi_user_create_time >=" . strtotime($start);
            elseif(!$start && $end)
                $where .= "AND jinsi_user_create_time <=" . strtotime($end);
            elseif($start && $end)
                $where .= "AND jinsi_user_create_time BETWEEN " . strtotime($start) . " AND " . strtotime($end);
        }else{
            if($start && !$end)
                $where = "jinsi_user_create_time >= " . strtotime($start);
            elseif(!$start && $end)
                $where = "jinsi_user_create_time <= " . strtotime($end);
            elseif($start && $end)
                $where = "jinsi_user_create_time BETWEEN " . strtotime($start) . " AND " . strtotime($end);
        }

        $sql = "SELECT count(id) count FROM jinsi_user WHERE $where";

        $count = M()->query($sql);
        if($count !== false){
            $result = array('errcode' => 0, 'msg' => '获取用户数量成功!', 'data' => $count);
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
}