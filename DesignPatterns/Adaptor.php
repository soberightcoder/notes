<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/7/15
 * Time ${Time}
 */


/**
 * 适配器模式
 * 解决：两个接口不兼容的问题；
 *
 * 适配器模式是一种结构型设计模式， 它能使接口不兼容的对象能够相互合作。
 *
 * 适配器模式在 PHP 代码中很常见。 基于一些遗留代码的系统常常会使用该模式。 在这种情况下， 适配器让遗留代码与现代的类得以相互合作。
 * 一般用于维护老的接口；old interface；  一些接口返回的数据是xml数据，现在都在用json数据； 所以这里需要做适配；
 */

/**
 * eg: 转换器；很多电脑都没有网线插口，就需要一个网线转换器；就是一个适配器；
 * 通过转换器，网线可以连接到笔记本上；
 */

/**
 *  适配器：并不会改变原先的接口，仅仅是加了一层做适配；
 *  装饰着模式：会改变原先的接口，在这里做功能的扩展；
 */

/**
 * Class
 *  组合类型的适配器
 */
interface Target
{
    public function handle();
}
//  适配器 组合
class JsonAdapter implements Target
{
    protected $adaptee;
    public function __construct($daptee) {
        $this->adaptee = $daptee;
    }
    // Json适配器  转换其他数据为json数
    public function handle() {
        $data = $this->adaptee->do();
        echo "转换数据".$data."成json数据\n";
    }

}

//需要被适配得对象有很多个，组合是配置 扩展性比较好；继承适配器扩展比较复杂；
// 要被适配的类  网线
class Adaptee
{
    public function do(){
        // 我输出xml的数据类型
        echo " i m xml\n";
    }
}

class Adaptee1
{
    public function do(){
        echo "i m xml too\n";
    }
}


 //i want to json data
class Client
{
    public function handle() {
       $obj = new JsonAdapter(new Adaptee());
       $obj->handle();
       $obj1 = new JsonAdapter(new Adaptee1());
       $obj1->handle();
    }
}

$obj = new Client();
$obj->handle();

/**
 * 继承类型的适配器
 * 如果很多得话，需要很多得类得；
 */

/**
 * Class JsonAdapter
 *  没有一种被适配得对象都要继承创建一个类，很明显；继承还是扩展比较复杂得；
 *
 *  每有一种需要被适配得对象都要去继承；创建一个新的适配器；扩展比较麻烦；
 */

//class JsonAdapter extends Adaptee implements Target
//{
////    protected $adaptee;
//    // Json适配器  转换其他数据为json数
//    public function handle() {
//        echo "转换数据".$this->do()."成json数据\n";
//    }
//}
//
//class JsonAdapter1 extends Adaptee1 implements Target
//{
////    protected $adaptee;
//    // Json适配器  转换其他数据为json数
//    public function handle() {
//        echo "转换数据".$this->do()."成json数据\n";
//    }
//}
//
//
//$obj = new JsonAdapter();
//$obj->handle();
//
//$obj1 = new JsonAdapter1();
//$obj1->handle();
