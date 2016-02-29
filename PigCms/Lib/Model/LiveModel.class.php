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
        $data['expire_time'] = $time + 7000;
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
        $where['openid'] = $openid;
        $user = M('jinsi_user');
        $user_info = $user->where($where)->find();
        //print_r($user_info);
        if($user_info){

        }
        $token = $this->get_token();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$token}&openid={$openid}&lang=zh_CN";
        $openid_info = json_decode(getUrl($url),true);
        //print_r($openid_info);
        $data['jinsi_user_name'] = $openid_info['nickname'];
        $data['jinsi_user_create_time'] = time();
        $data['jinsi_user_header_pic'] = $openid_info['headimgurl'];
        $data['open_id'] = $openid;
        if($lastInsId = $user->add($data)){
            echo "插入数据 id 为：$lastInsId";
        } else {
            $this->error('数据写入错误！');
        }
    }
}