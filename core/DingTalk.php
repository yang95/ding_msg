<?php


class DingTalk extends Loader
{
    const NOTICE_URL = "https://oapi.dingtalk.com/topapi/message/corpconversation/asyncsend_v2?access_token=ACCESS_TOKEN";
    const ACCESS_TOKEN_URL = "https://oapi.dingtalk.com/gettoken?appkey=%s&appsecret=%s";
    const SIMPLE_LIST = "https://oapi.dingtalk.com/user/simplelist?access_token=ACCESS_TOKEN&department_id=1";

    private static function access_token(){
        $app = self::get("ding_talk");
        $resp = self::curl_get(
            sprintf(self::ACCESS_TOKEN_URL,$app["key"],$app["secrect"])
        );
        return isset($resp["access_token"])?$resp["access_token"]:'';
    }
    //curl get
    static function curl_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        $dom = curl_exec($ch);
        curl_close($ch);
        $dom = json_decode($dom,true);
        return $dom;
    }

    //curl post
    static function curl_post($url, $postdata)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        $result = curl_exec($curl);
        $result = json_decode($result,true);
        return $result;
    }
    static function userList(){
        $token = self::access_token();
        $resp = self::curl_get(
            call_user_func(function() use($token){
                return str_replace("ACCESS_TOKEN",$token,self::SIMPLE_LIST);
            })
        );
        return $resp;
    }
    static function send($userId,$content){
        $token = self::access_token();
        $agent_id = self::get("ding_talk")["agent_id"];
        return self::curl_post(
            call_user_func(function()use($token){
                return str_replace("ACCESS_TOKEN",$token,self::NOTICE_URL);
            }),
            [
                "agent_id"=>$agent_id,
                "userid_list"=>$userId,
                "msg"=>json_encode([
                    "msgtype"=>"text",
                    "text"=>[
                        "content"=>$content
                    ]
                ])
            ]
        );
    }
}