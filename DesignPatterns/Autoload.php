<?php
/**
 * Created By PhpStorm
 * User Leaveone
 * Date 2022/7/9
 * Time 0:06
 */
//设计模式这里用鸡儿自动加载  还是用terminal 直接php 目标文件把；傻叉；傻Ⅹ；
class Autoload
{
    public static function className($name) {
        $prefix = "Shuai";
        // if exists delete prefix
        if (strpos(trim($name,"\\"),"Shuai") !== false) {
            $name = trim(substr($name,strlen($prefix)),"\\");
        }
        // get namesapce
        $namespace = trim(substr($name,0,strrpos($name,"\\")),"\\");
        //className
        $className = trim(substr($name,strrpos($name,"\\")),"\\");
        // 获取map 映射；
        $map = require("./Map.php");
        if ($map[$namespace]) {
            $path = trim($map[$namespace],"/")."/".$className.".php";
        } else {
            $path = str_replace("\\","/",$name);
            $path = $path.".php";
        }
        if (file_exists($path)) {
            require_once $path;
        }
    }
}
//register；注册；
spl_autoload_register("Autoload::className");