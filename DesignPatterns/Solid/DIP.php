<?php


class DIP
{

}
/**
 * instanceof  判断一个对象是否实现了某个接口；判断一个对象继承了某个类；
 * 接口和trait 来实现多继承；
 *
 * 依赖倒置
 * denpency inversion principle
 * 高级模块不应该依赖于低级模块，应该依赖于抽象（抽象类或者接口）；
 * 抽象不应该依赖于细节，细节也应该依赖于抽象；
 *抽象（稳定，抽象类或者接口）；
 * 细节就是抽象类的继承类；
 *
 * 通俗来说
 * 变量不应该指向具体类；
 * 类不应该继承具体类;
 * 因为具体类是变化的，当发生变化的时候需要去修改代码；
 */
//interface Ceshi{
//    public function ceshi1();
//}
//interface Ceshi1{
//    public function ceshi11();
//}
//interface Zong extends Ceshi,Ceshi1
//{
//
//}
//class Ceshi12 implements Zong
//{
//   public function ceshi1() {
//       // TODO: Implement ceshi1() method.
//   }
//   public function ceshi11() {
//       // TODO: Implement ceshi11() method.
//   }
//}
abstract class Wheel
{
    // 抽象方法 abstract function
  abstract public function run();
}

class Slowwheel extends Wheel
{
   public function run(){
       echo "run slow";
   }
}
class Quickwheel extends Wheel
{
    public function run() {
        echo "run quick";
    }
}
class Middlewheel extends Wheel
{
    public function run() {
        echo "middle speed";
    }
}
//工厂 主要是生产对象；
abstract Class Factory{
    abstract public function product();
}
//
class QuickFactory extends Factory
{
   public function product() {
       return new Quickwheel();
   }
}
class SlowFactory extends Factory
{
    public function product() {
        return new Slowwheel();
    }
}
class MiddleFactory extends Factory
{
    public function product() {
        return new Middlewheel();
    }
}


// 依赖于 一个具体的类
class Person
{
    //yi依赖于 一个具体的类 不满足开放原则
    public function goshopping(){
        $res = new Slowwheel();
        $res->run();
    }
    public function goto(Wheel $wheel){
       $wheel->run();
    }

}
//这里是一个稳定的对象; 我们的对象就是人
$obj = new Person();
// 这里不满足 一个变量不应该指向一个具体类；
$wheel = new Quickwheel();
$obj->goshopping();
echo "\n";
$obj->goto($wheel);
echo "\n";
// 调用不同的工厂生产不同的实例；
$wheelobj = new MiddleFactory();
$obj->goto($wheelobj->product());


