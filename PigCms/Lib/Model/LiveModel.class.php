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
    public function get_token()
    {
        $data = json_decode(F('jsapi_token'),true);
        if($data['expire_time']>time()){
            return $data['access_token'];
        }
        $appid = C('APPID_A');
        $appsecret= C('APPSECRET_A');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $data = json_decode(getUrl($url),true);
        $data['expire_time'] = time() + 7000;
        F('jsapi_token',json_encode($data));
        return $data['access_token'];
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
        if($user_info) {
            //print_r($user_info);
            session('userId',$user_info['id']);
            session('jinsi_user_name',$user_info['jinsi_user_name']);
            session('jinsi_user_header_pic',$user_info['jinsi_user_header_pic']);
            return $user_info['id'];
            exit;
        }
        $token = $this->get_token();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$token}&openid={$openid}&lang=zh_CN";
        $openid_info = json_decode(getUrl($url),true);
        //print_r($openid_info);
        $data['jinsi_user_name'] = $openid_info['nickname'];
        $data['jinsi_user_create_time'] = time();
        $data['jinsi_user_header_pic'] = $openid_info['headimgurl'];
        $data['open_id'] = $openid;
        $lastInsId = $user->add($data);
        //echo $user->getlastsql();
        if($lastInsId){
            session('userId',$lastInsId);
            session('jinsi_user_name',$openid_info['nickname']);
            session('jinsi_user_header_pic',$openid_info['headimgurl']);
            return $lastInsId;
        } else {
            echo '数据写入错误！';
        }
    }

    function send_message($data)
    {
        $token = $this->get_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $t_id = "2UcqSgjddCH-Js8ahrO_11L_xaV5baBqOVCQLJ4F7sQ";
        $array['touser'] = $data['openid'];
        $array['template_id'] = $t_id;
        $array['url'] = $data['url'];
        $item['first'] = array('value'=>"您关注的{$data['auther']}有新消息发布了",'color'=>'#173177');
        $item['keynote1'] = array('value'=>$data['content'],'color'=>'#173177');
        $item['keynote2'] = array('value'=>$data['auther'],'color'=>'#173177');
        $date = date('Y-m-d H:i:s');
        $item['keynote3'] = array('value'=>$date,'color'=>'#173177');
        $item['remark'] = array('value'=>$data['content'],'color'=>'#173177');
        $array['data'] = $item;
        $str = json_encode($array);
        $result = vpost($url,$str);

        return json_decode($result,true);






    }
}