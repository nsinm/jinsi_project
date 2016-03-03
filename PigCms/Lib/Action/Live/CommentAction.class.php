<?php
/**
 *
 * author: Nsinm
 * package: jinsi CommentAction.class.php
 * Date: 16/3/2
 * Time: 23:04
 */

class CommentAction extends LiveAction
{
    /**
     * UploadAction constructor.
     */
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
            'addUrl' => U('add')
        );
        $urls = array_merge($this->ajaxUrls, $uris);
        $type = $this->_get('type');
        $cid = $this->_get('cid');
        $this->assign('urls', $urls);
        $this->assign('type', $type);
        $this->assign('cid', $cid);
        $this->display();
    }

    /**
     * 添加直播或评论
     */
    public function add () {
        if(!IS_AJAX) _404('页面不存在!');

        $result = array('errcode' => 1, 'msg' => '添加失败!');

        //当前用户id
        $userId = $this->userId;
        //ajax传递的userId
        $postUserId = $this->_post('userId');
        if($userId != $postUserId){
            $result = array('errcode' => 2, 'msg' => '非法用户!');
            $this->ajaxReturn($result, 'JSON');
        }

        $data = $this->_post();

        $this->ajaxReturn($data, 'JSON');

    }
}