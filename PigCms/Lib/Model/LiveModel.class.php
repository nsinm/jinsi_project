<?php
/**
 * Created by PhpStorm.
 * User: slash
 * Date: 16/2/28
 * Time: 上午11:53
 */

class LiveModel extends Model
{

    /**
     * @return mixed
     * 获取TOKEN并存入缓存
     */
    public function get_token($flag=0)
    {
        $appid = C('APPID_A');
        $apiOauth 		= new apiOauth();

        return $access_token  	= $apiOauth->update_authorizer_access_token($appid,'',$flag);

        /**
        $data = json_decode(F('jsapi_token'),true);
        if($data['expire_time']>time()){
            return $data['access_token'];
        }

        $appsecret= C('APPSECRET_A');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $data = json_decode(getUrl($url),true);
        $data['expire_time'] = time() + 7000;
        F('jsapi_token',json_encode($data));
        return $data['access_token'];
         * */
    }

    /**
     * @param $url
     * @return mixed
     * 返回商家ID
     */
    public function get_openid ($url)
    {
        $openid = session('openid');
        if($openid){
            return $openid;
        }
        //return $url;
        $code = $_GET['code'];
        $appid = C('APPID_A');
        $appsecret= C('APPSECRET_A');
        if($code){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
            $openid_json = json_decode(getUrl($url),true);
            //print_r($openid_json);
            session('openid',$openid_json['openid']);
            return $openid_json['openid'];
        }
        $url = urlencode($url);

        $wx_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        header("Location: {$wx_url}");
        //echo M('live')->get_openid('aa');
    }


    public function get_user_info($openid)
    {
        //$where['openid'] = $openid;
        $user = M('user');
        $user_info = $user->where("open_id='{$openid}'")->find();
        //echo $user->getlastsql();
        //print_r($user_info);
        if($user_info && $user_info['jinsi_user_name']!='') {
            //print_r($user_info);
            session('userId',$user_info['id']);
            session('jinsi_user_name',$user_info['jinsi_user_name']);
            session('jinsi_user_header_pic',$user_info['jinsi_user_header_pic']);
            return $user_info['id'];
            exit;
        }
        $token = $this->get_token(1);
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$token}&openid={$openid}&lang=zh_CN";
        $openid_info = json_decode(getUrl($url),true);

        if($openid_info['openid']){
            //print_r($openid_info);
            $data['jinsi_user_name'] = $openid_info['nickname'];
            $data['jinsi_user_create_time'] = time();
            $data['jinsi_user_header_pic'] = $openid_info['headimgurl'];
            $data['open_id'] = $openid;
            if($user_info){
                $data['id'] = $user_info['id'];
                $user->save();
                $lastInsId = $user_info['id'];
            }else{
                $lastInsId = $user->add($data);
            }

            //echo $user->getlastsql();
            if($lastInsId){
                session('userId',$lastInsId);
                session('jinsi_user_name',$openid_info['nickname']);
                session('jinsi_user_header_pic',$openid_info['headimgurl']);
                return $lastInsId;
            } else {
                return false;
            }
        }else{
            return false;
        }

    }

    /**
     * @param $data
     * @return mixed
     * 发送模板消息
     */
    function send_message($data,$self=0)
    {
        $token = $this->get_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $t_id = "2UcqSgjddCH-Js8ahrO_11L_xaV5baBqOVCQLJ4F7sQ";
        $array['touser'] = $data['openid'];
        $array['template_id'] = $t_id;
        $array['url'] = $data['url'];
        $data['content'] = cut_str($data['content'],20);
        if($self==1){
            $item['first'] = array('value'=>"您有新消息发布了",'color'=>'#173177');
        }elseif($self==2){
            $item['first'] = array('value'=>"您关注的导师{$data['auther']}回复了您的消息",'color'=>'#173177');
        }else{
            $item['first'] = array('value'=>"您关注的{$data['auther']}有新消息发布了",'color'=>'#173177');
        }

        $item['keyword1'] = array('value'=>$data['content'],'color'=>'#173177');
        $item['keyword2'] = array('value'=>$data['auther'],'color'=>'#173177');
        $date = date('Y-m-d H:i:s');
        $item['keyword3'] = array('value'=>$date,'color'=>'#173177');
        $item['remark'] = array('value'=>$data['content'],'color'=>'#173177');
        $array['data'] = $item;
        $str = json_encode($array);
        $result = postUrl($url,$str);
        $rs_arr = json_decode($result,true);
        if($rs_arr['errcode']==42001){
            $token = $this->get_token(1);
        }
        return $rs_arr;






    }


    public function put_content($id)
    {
        $content = M('content');
        $content_arr = $content->find($id);
        //print_r($content_arr)；
        $user_info = $this->get_user_one_info($content_arr['jinsi_content_create_user_id']);
        //print_r($user_info);
        $follow = M('follow');
        $follow_list = $follow->where("jinsi_follow_id_user=".$content_arr['jinsi_content_create_user_id'])->select();
        $data['auther'] = $user_info['jinsi_user_name'];
        $data['content'] = $content_arr['jinsi_content_info'];
        $data['url'] = "http://mp.jinsxy.com".U('Index/comment')."&cid=".$id;
        $infos['id'] = $id;
        $infos['push'] = 2;
        $content->save($infos);
        //给自己推送一条
        $data['openid'] = $user_info['open_id'];
        $rs = $this->send_message($data,1);
        //查询会员
        $time = time();
        $member = M('member');
        $member_list = $member->where("follow_id=".$content_arr['jinsi_content_create_user_id']." and over_time<".$time)->select();
        if($member_list){
            foreach($member_list as $v){
                $user_arr = $this->get_user_one_info($v['jinsi_follow_user_id']);
                $data['openid'] = $user_arr['open_id'];
                $rs = $this->send_message($data);
                //print_r($rs);
            }
        }
        //判断是否给非会员推送
        if($content_arr['push']!=-1){
            if($follow_list){

                foreach($follow_list as $v){
                    $user_arr = $this->get_user_one_info($v['jinsi_follow_user_id']);
                    $data['openid'] = $user_arr['open_id'];
                    $rs = $this->send_message($data);
                    //print_r($rs);
                }

            }
        }


        //$data['push'] = 2;
        //if($flag)
        //$content->save($infos);
        //print_r($follow_list);



    }


    /**
     * @param $id
     * 推送评论
     */
    public function put_comment($id,$user_id)
    {
        $reply = M('reply');
        $reply_arr = $reply->find($id);
        $content = M('content');
        $content_replay_arr = $content->find($reply_arr['jinsi_reply_content_id']);
        $content_arr = $content->find($content_replay_arr['jinsi_content_id']);
        //如果不是作者回复，则不会发送
        if($content_arr['jinsi_content_create_user_id']!=$user_id){
            return false;
        }
        //print_r($content_arr)；
        $user_info = $this->get_user_one_info($content_arr['jinsi_content_create_user_id']);

        //print_r($user_info);
        $data['auther'] = $user_info['jinsi_user_name'];
        $data['content'] = $reply_arr['jinsi_reply_content'];
        $data['url'] = "http://mp.jinsxy.com".U('Index/comment')."&cid=".$content_replay_arr['jinsi_content_id'];

        //回复人的ID
        $reply_info = $this->get_user_one_info($content_replay_arr['jinsi_content_create_user_id']);
        $data['openid'] = $reply_info['open_id'];
        $this->send_message($data,2);
                //print_r($rs);
    }
    public function get_user_one_info($id)
    {
        $user = M('user');
        $user_info = $user->find($id);
        return $user_info;
    }


    public function update_order($order_id,$transaction_id)
    {
        $order = M('order');
        $order_data = $order->where("order_no='{$order_id}'")->find();
        //更新支付状态
        $update_data['status'] = 1;
        $update_data['transaction_id'] = $transaction_id;
        $order->where("order_no='{$order_id}'")->setField($update_data);
        //$sql1 = $order->getLastSql();
        //如果是购买会员则有以下动作
        if($order_data['type'] == 1){
            $member = M('member');

            $data['user_id'] = $order_data['user_id'];
            $data['follow_id'] = $order_data['follow_id'];
            $data['crea_time'] = time();
            $data['pay_time'] = time();
            $next_time = strtotime(date("Y-m-d H:i:s",strtotime("+1 month")));
            $data['over_time'] = $next_time;
            $data['status'] = 1;
            $member->add($data);

            $this->send_pay($order_data['user_id'],$order_data['follow_id'],$order_data['order_no']);
            //$sql = $member->getLastSql();
            //return $sql1.'----'.$sql.'----'.json_encode($data);
        }else{
            $this->send_pay($order_data['user_id'],$order_data['follow_id'],$order_data['order_no'],1);
        }


    }


    function send_pay($user_id,$follow_id,$pay_no,$type=0)
    {
        $user_info = $this->get_user_one_info($user_id);
        $follow_id = $this->get_user_one_info($follow_id);
        $token = $this->get_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $t_id = "PQKYlOBTrVEm5i_lXmfrlo_vsdmfUH_oX00lVE8Et6E";
        $array['touser'] = $follow_id['openid'];
        $array['template_id'] = $t_id;
        if($type==0){
            $item['first'] = array('value'=>"您的会员被订购",'color'=>'#173177');
        }else{
            $item['first'] = array('value'=>"您被打赏了",'color'=>'#173177');
        }


        $item['keyword1'] = array('value'=>$pay_no,'color'=>'#173177');

        $date = date('Y-m-d H:i:s');
        $item['keyword2'] = array('value'=>$date,'color'=>'#173177');
        if($type==0){
            $item['remark'] = array('value'=>"{$user_info['jinsi_user_name']}购买了您的会员，请关注",'color'=>'#173177');
        }else{
            $item['remark'] = array('value'=>"{$user_info['jinsi_user_name']}打赏了您，请关注",'color'=>'#173177');
        }

        $array['data'] = $item;
        $str = json_encode($array);
        $result = postUrl($url,$str);
        $rs_arr = json_decode($result,true);
        if($rs_arr['errcode']==42001){
            $token = $this->get_token(1);
        }
        return $rs_arr;
    }
}