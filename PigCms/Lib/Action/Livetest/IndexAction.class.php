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

class IndexAction extends LiveAction
{
    function __construct()
    {
        parent::__construct();
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
            'cUrl' => U('comment'),
            'tocUrl' => U('Comment/index')
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
        $where = 'jinsi_user_type = 2 AND jinsi_user_recommend = 1';
        $instructors = M('user')->where($where)->order('jinsi_user_sort ASC')->limit(8)->select();
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

        $type = $this->_get('type'); //1 所有导师 2关注导师

        if($type == 2){
            $instructors = M('follow')->where('jinsi_follow_user_id = ' . $this->userId)->select();
            $instructorIds = array_column($instructors, 'jinsi_follow_id_user');
            if($this->userType == 2){
                if($instructorIds){
                    array_push($instructorIds, $this->userId);
                }else{
                    $instructorIds[0] = $this->userId;
                }
            }
            $in = '(' . implode(',', $instructorIds) . ')';
            if($instructorIds)
                $sql = "SELECT FROM_UNIXTIME(jc.jinsi_content_create, '%Y-%m-%d %H:%i') AS content_create_time, jc.*, ju.id AS user_id, ju.jinsi_user_name, ju.jinsi_user_header_pic FROM jinsi_content AS jc LEFT JOIN jinsi_user AS ju ON jc.jinsi_content_create_user_id = ju.id WHERE jc.jinsi_content_create_user_id IN {$in} AND jc.jinsi_content_is_comment = 0 ORDER BY jc.jinsi_content_create DESC LIMIT 50";
        }else{
            $sql = "SELECT FROM_UNIXTIME(jc.jinsi_content_create, '%Y-%m-%d %H:%i') AS content_create_time, jc.*, ju.id AS user_id, ju.jinsi_user_name, ju.jinsi_user_header_pic FROM jinsi_content AS jc LEFT JOIN jinsi_user AS ju ON jc.jinsi_content_create_user_id = ju.id WHERE jc.jinsi_content_is_comment = 0 ORDER BY jc.jinsi_content_create DESC LIMIT 50";
        }

        $comments = M()->query($sql);
        $data = array();

        //加入当前用户是否赞过
        foreach($comments as $key => $value){
            $value['current_user_praise'] = 0;
            $praise = M('praise')->where('jinsi_praise_content_id=' . $value['id'] . ' AND jinsi_praise_user_id=' . $this->userId)->find();
            if($praise){
                $value['current_user_praise'] = 1;
            }
            array_push($data, $value);
        }
        if($comments){
            $result = array('errcode' => 0, 'msg' => '获取关注导师直播列表成功!', 'data' => $data);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 直播详情页
     */
    public function comment ()
    {
        $cid = $this->_get('cid');

        //更新阅读数
        $readNo = M('content')->where('id=' . $cid)->getField('jinsi_content_read_no');
        $update['jinsi_content_read_no'] = $readNo + 1;
        M('content')->where('id=' . $cid)->save($update);

        $uris = array(
            'gcUrl' => U('getComment', 'cid=' . $cid),
            'pUrl' => U('praise'),
            'tocUrl' => U('Comment/index'),
            'guiUrl' => U('Instructor/index')
        );
        $sql = "SELECT FROM_UNIXTIME(jc.jinsi_content_create, '%Y-%m-%d %H:%i') AS content_create_time, jc.*, ju.id AS user_id, ju.jinsi_user_name, ju.jinsi_user_header_pic FROM jinsi_content AS jc LEFT JOIN jinsi_user AS ju ON jc.jinsi_content_create_user_id = ju.id WHERE jc.id = {$cid}";
        $liveInfo = M()->query($sql);
        $urls = array_merge($this->ajaxUrls, $uris);
        $praise = M('praise')->where('jinsi_praise_content_id=' . $cid . ' AND jinsi_praise_user_id=' . $this->userId)->find();
        $liveInfo[0]['current_user_praise'] = 0;
        if($praise){
            $liveInfo[0]['current_user_praise'] = 1;
        }
        $jssdk = D('Jssdk');
        $signPackage = $jssdk->GetSignPackage();
        //print_r($signPackage);
        $this->assign('signPackage',$signPackage);
        $data['title'] = $liveInfo[0]['jinsi_content_info'];
        $data['imgUrl'] = "https://www.baidu.com/img/baidu_jgylogo3.gif";
        $data['link'] = get_url();
        $this->assign('data',$data);
        $this->assign('live', $liveInfo[0]);
        $this->assign('urls', $urls);
        $this->display();
    }

    /**
     * 获取直播评论
     */
    public function getComment ()
    {
        if(!IS_AJAX) _404('页面不存在');
        $result= array('errcode' => 1, 'msg' => '获取直播评论失败!');

        $cid = $this->_get('cid');
        if($cid){
            $sql = "SELECT FROM_UNIXTIME(jc.jinsi_content_create, '%Y-%m-%d %H:%i') AS content_create_time, jc.*, ju.id AS user_id, ju.jinsi_user_name, ju.jinsi_user_header_pic FROM jinsi_content AS jc LEFT JOIN jinsi_user AS ju ON jc.jinsi_content_create_user_id = ju.id WHERE jc.jinsi_content_id = {$cid} ORDER BY jc.jinsi_content_create ASC";
            $comments = M()->query($sql);

            $data = array();

            //加入当前用户是否赞过
            foreach($comments as $key => $value){
                $value['current_user_praise'] = 0;
                $praise = M('praise')->where('jinsi_praise_content_id=' . $value['id'] . ' AND jinsi_praise_user_id=' . $this->userId)->find();
                if($praise){
                    $value['current_user_praise'] = 1;
                }
                $sql = "SELECT FROM_UNIXTIME(jr.jinsi_reply_time, '%Y-%m-%d %H:%i') AS reply_create_time, jr.*, ju.id AS user_id, ju.jinsi_user_name, ju.jinsi_user_header_pic FROM jinsi_reply AS jr LEFT JOIN jinsi_user AS ju ON jr.jinsi_reply_user_id = ju.id WHERE jr.jinsi_reply_content_id = {$value['id']} ORDER BY jr.jinsi_reply_time ASC";
                $replies = M()->query($sql);
                $value['replies'] = $replies;
                array_push($data, $value);
            }

            if($comments){
                $result= array('errcode' => 0, 'msg' => '获取直播评论成功!', 'data' => $data);
            }
        }
        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 获取banner
     */
    public function getBanner ()
    {
        if(!IS_AJAX) _404('页面不存在');

        $result = array('errcode' => 1, 'msg' => '获取banner列表失败');
        $bannerList = M('banner', 'jinsi_')->order('id desc')->limit('5')->select();
        if($bannerList){
            $result = array('errcode' => 0, 'msg' => '获取banner列表成功', 'data' => $bannerList);
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 添加回复
     */
    public function addComment ()
    {
        if(!IS_AJAX) _404('页面不存在!');

        $result = array('errcode' => 1, 'msg' => '添加回复失败!');

        $cid = $this->_post('cid');
        $userId = $this->_post('userId');
        $content = $this->_post('content');
        $fid = $this->_post('fid');

        if($cid && $userId && $content && $fid){
            $data = array(
                'jinsi_reply_user_id' => $userId,
                'jinsi_reply_content_id' => $cid,
                'jinsi_reply_content' => $content,
                'jinsi_reply_time' => time()
            );

            $id = M('reply', 'jinsi_')->add($data);
            if($id){
                $model = D('Live');
                $model->put_comment($id, $this->userId);
                $model = M('content');
                $number = $model->where('id=' . $fid)->getField('jinsi_content_comment_no');
                $upData['jinsi_content_comment_no'] = $number + 1;
                $status = $model->where('id=' . $fid)->save($upData);
                if($status)
                    $result = array('errcode' => 0, 'msg' => '添加回复成功!');
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 赞
     */
    public function praise ()
    {
        if(!IS_AJAX) _404('页面不存在');
        $result= array('errcode' => 1, 'msg' => '点赞失败!');

        $cid = $this->_get('cid');
        if($cid){
            $data = array(
                'jinsi_praise_content_id' => $cid,
                'jinsi_praise_user_id' => $this->userId
            );

            $status = M('praise')->add($data);

            $praiseNo = M('content')->where('id=' . $cid)->getField('jinsi_content_praise_no');
            $update['jinsi_content_praise_no'] = $praiseNo + 1;
            $fetchRows = M('content')->where('id=' . $cid)->save($update);
            if($status && $fetchRows){
                $result = array('errcode' => 0, 'msg' => '点赞成功!');
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 分享
     */
    public function share ()
    {
        if(!IS_AJAX) _404('页面不存在');
        $result= array('errcode' => 1, 'msg' => '分享失败!');

        $cid = $this->_get('cid');
        if($cid){
            $shareNo = M('content')->where('id=' . $cid)->getField('jinsi_content_share_no');
            $update['jinsi_content_share_no'] = $shareNo + 1;
            $fetchRows = M('content')->where('id=' . $cid)->save($update);
            if($fetchRows){
                $result = array('errcode' => 0, 'msg' => '分享成功!');
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }

    /**
     * 已阅
     */
    public function read ()
    {
        if(!IS_AJAX) _404('页面不存在');
        $result= array('errcode' => 1, 'msg' => '更新失败!');
        $cid = $this->_get('cid');
        if($cid){
            $readNo = M('content')->where('id=' . $cid)->getField('jinsi_content_read_no');
            $update['jinsi_content_read_no'] = $readNo + 1;
            $fetchRows = M('content')->where('id=' . $cid)->save($update);
            if($fetchRows){
                $result = array('errcode' => 0, 'msg' => '更新成功!');
            }
        }

        $this->ajaxReturn($result, 'JSON');
    }
}