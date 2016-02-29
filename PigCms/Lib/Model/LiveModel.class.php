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

        return C('APPID_A');
        //echo M('live')->get_openid('aa');
    }
}