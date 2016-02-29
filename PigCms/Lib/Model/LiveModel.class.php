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
        $url = urlencode($url);
        $appid = C('APPID_A');
        //$appsecret= C('APPSECRET_A');
        $wx_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$url}&response_type=code&scope=SCOPE&state=STATE#wechat_redirect";
        header("Location: {$wx_url}");
        //echo M('live')->get_openid('aa');
    }
}