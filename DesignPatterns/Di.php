<?php

//dependence
//class Wheel
//{
//    public function create(){
//        echo __METHOD__.'|';
//    }
//}
////另外一种轮胎
//class MoreWheel
//{
//    public function create(){
//        echo __METHOD__;
//    }
//}
////定义一个车类 依赖于Wheel
//class Car
//{
//    public function run(){
//        $wheel = new Wheel();
//        $wheel->create();
//        echo __METHOD__.'|';
//    }
//}
//
////定义人类 依赖于Car类
//class Human
//{
//    public function drive(){
//
//        $car = new Car();
//        $car->run();
//        echo __METHOD__.'|';
//    }
//}
//
////
//$ob = new Human();
//$ob->drive();

#耦合性很强
class Wheel
{
    public function create(){
        echo __METHOD__.'|';
    }

}
//Car类 通过传递参数对象的形式来解除依赖关系
class Car
{
    private $wheel;
    //injection
    public function __construct(Wheel $wheel) {
        $this->wheel = $wheel;
    }

    public function run(){
        $this->wheel->create();
        echo __METHOD__.'|';
    }
}
//Human 类  通过传对象的形式来接触依赖关系
//需要什么样的轮胎那么就可以传递什么样子的轮胎 解耦 不需要直接去修改代码s
class Human
{
    private $car;

    public function __construct(Car $car) {
       $this->car = $car;
    }

    public function drive(){
        $this->car->run();
        echo __METHOD__.'|';
    }
}
//$car = new Car(new Wheel());
//$ob = new Human($car);
//$ob->drive();

//defination IoC normal
// container 的优点：
// 1.降低耦合度
// 2. 实现了惰性加载 只有make的时候才会创建一个对象
// 3. 便于管理，所有的类都在对象中  便于管理
//class IOC
//{
//    protected static $registry=[];
//    //bind 绑定
//    public static function bind($name,$resolver){
//       static::$registry[$name] = $resolver;
//    }
//   //make 生产;
//    public static function make($name){
//        if(isset(static::$registry[$name])){
//            $resolver = static::$registry[$name];
//            return $resolver;
//
//    }
//}
//// 绑定容器
//IoC::bind('wheel',new Wheel());
//IoC::Bind('car',new Car(IoC::make('wheel')));
//IoC::bind('human',new Human(IoC::Make('car')));
////
//$human = IoC::make('human');
//$human->drive();

//defination IoC laravel
//基础知识 匿名函数 和调用
$a = function (){
    return 'i m niming';
};
echo $a();

class IoC
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
            // 延迟绑定  回调函数;
            return $resolver();
        }
    }
}
//bind
IoC::bind('wheel',function (){
    return new Wheel();
});
IoC::bind('car',function (){
    return new Car(IoC::make('wheel'));
});
IoC::bind('human',function (){
    return new Human(IoC::make('car'));
});
$human = IoC::make('human');
$human->drive();


