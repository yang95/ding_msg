<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/19 0019
 * Time: 下午 9:20
 */
App::http('send',function (){

});
App::http('notice_yangakw',function (){
    $msg = App::gpcs("msg");
    return DingTalk::send("manager9194",$msg."(".time().")");
});
App::http('user_list',function (){
    return DingTalk::userList();
});