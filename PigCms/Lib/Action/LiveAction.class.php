<?php
/**
 *
 * Live下Action的基类
 *
 * author: Nsinm
 * package: jinsi LiveAction.class.php
 * Date: 16/3/2
 * Time: 23:07
 */

class LiveAction extends Action
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
        $Live = D('Live');
        $openid = $Live->get_openid(get_url());
        $userid = $Live->get_user_info($openid);
        if(!session('userId'))
            session('userId', $userid);
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
}