<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/19 0019
 * Time: 下午 8:34
 */
require "core/Loader.php";
Loader::init();
Loader::build("CORE_PATH",__DIR__."/core");
Loader::build("SRC_PATH",__DIR__."/src");
Loader::build("ding_talk",[
    "agent_id" =>"198221868",
    "key" =>"dingofdafafb1nwriwkz",
    "secrect" =>"_vCx9MIio0R2Z30fTveSwplRgvwvn-YzkA8V12VltHeFZ4rdNsSM75if5ausFhXc",
]);
Loader::build("app_run_send",function($resp){
    header('content-type:application/json;charset=utf-8');
    header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
    header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
    echo json_encode($resp);
});
Loader::build("app",new App);

App::routerFile("router");
Loader::get("app")->run();