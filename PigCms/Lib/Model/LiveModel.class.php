<?php
/**
 * Created by PhpStorm.
 * User: slash
 * Date: 16/2/28
 * Time: 上午11:53
 */

class LiveModel extends Model
{

    public function get_openid ($url)
    {
        //return $url;
        $code = $_GET['code'];
        $appid = C('APPID_A');
        $appsecret= C('APPSECRET_A');
        if($code){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
            $openid_json = json_decode(getUrl($url),true);
            print_r($openid_json);
            return $code;
        }
        $url = urlencode($url);

        $wx_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        header("Location: {$wx_url}");
        //echo M('live')->get_openid('aa');
    }
}