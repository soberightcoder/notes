<?php
/**
 * Created By PhpStorm
 * User Leaveone
 * Date 2022/7/8
 * Time 22:24
 */

/**
 * 策略模式是一种行为设计模式， 它能让你定义一系列算法， 并将每种算法分别放入独立的类中， 以使算法的对象能够相互替换。
 * Class TaxStragegy
 * Q: 快递费用的计算方式 每个国家都是不一样的；
 *
 * // 策略模式更加关注于集体行为的具体实现；
 * // 就是要把 变化的部分做抽象就可以了；tax计算方法做抽象；会产生多个
 */

abstract class TaxStragegy
{
    abstract public function calculate();
}

class ZH_tax extends TaxStragegy
{
    public function calculate() {
        echo "zh——tax";
    }
}

class US_tax extends TaxStragegy
{
    public function calculate() {
        echo "us_tax";
    }
}

class ZH_remote_tax extends TaxStragegy
{
    public function calculate() {
        echo "zh_remote";
    }
}

//client
class TaxCalculate
{
    private $strategy;

    public function __construct(TaxCalculate $strategy) {
        $this->strategy = $strategy;
    }

    public function com() {
        $this->strategy->calculate();
    }
}
//根据不同的 注意外部变化这部分 new ZH_remote 也需要优化；
//
//$taxobj = new TaxCalculate(new ZH_remote_tax());
//$taxobj->com();

// 容器和工厂的区别？？？？/
// 这个相当于就是一个全局变量了，因为是一个静态的变量和函数，所以类似于是一个全局变量！！！
class App
{
    protected static $registry=[];
    //bind
    public static function bind($name, Closure $resolver){
        self::$registry[$name] = $resolver;
    }
    //make
    public static function make($name){
        if(isset(self::$registry[$name])){
            $resolver = self::$registry[$name];
            return $resolver();
        }
    }
}

/*
 * 这一部分  直接在加载boot的时候 直接就添加到了容器里面去了；
 */
App::bind('zh_tax',function(){
    return new ZH_tax;
});
App::bind('us_tax',function(){
    return new US_tax();
});
App::bind('zh_remote_tax',function(){
    return new ZH_remote_tax();
});

// if else if else if
$taxType = 'zh_tax';
if ($taxType == 'zh_tax') {
     $obj = new ZH_tax();
     $obj->calculate();
} else if ($taxType == "us_tax") {
    $obj = new US_tax();
    $obj->calculate();
}else if ($taxType == "zh_remote_tax") {
    $obj = new ZH_remote_tax();
    $obj->calculate();
}

// 第一个
$taxObj = new TaxCalculate();
$taxObj->com(App::make($taxType));

