<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/19 0019
 * Time: 下午 9:20
 */
App::http('index',function (){
    $list = App::$router;
    foreach ($list as $key  => $item){
        echo "<ul>";
        if($key){
            echo sprintf(" <li><a href='?r=%s'> $key </a></li> ",$key,$key);
        }
        echo "</ul>";
    }
});