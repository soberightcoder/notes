<?php

/**
 * Class OCP
 * 策略模式
 * strstr()  一个字符串在另外一个字符串中是否存在；false 就代表不存在；
 */

/**
 * Class Ceshi
 * 如果 以后还要添加 那么就会很麻烦 不满足 开放封闭原则，那么测试就会很麻烦，所有的模块都要测试；
 */
//class Ceshi
//{
//    public function com($ceshi){
//        if($ceshi == "123"){
//           echo '123';
//        }elseif($ceshi == "234"){
//           echo "234";
//        }else{
//            echo "other";
//        }
//    }
//}
abstract class BaseCom
{
    abstract function com();
}

class Ceshi123 extends BaseCom
{
    public function com() {
        echo "123";
    }
}

class Ceshi234 extends BaseCom
{
    public function com() {
        echo '234';
    }
}
class Ceshiother extends BaseCom
{
    public function com() {
        echo "other";
    }
}

class Ceshi
{
    public function com($obj){
       $obj->com();
    }
}
$obj = new Ceshi234();
$ceshi = new Ceshi();
$ceshi->com($obj);
echo "\n";