<?php

/**
 * 工厂方法
 *
 */
//最核心的是把 实例化推迟到子类,让子类决定实例化哪个类；让具体的工厂类去生产具体的产品；********
// 延迟实例化；
//定义一个创建对象的接口，让子类决定实例化那一个类；
//工厂方法最关键的是最终你想创建一个对象
//你不知道怎么构建，为什么构建或需要传递什么参数来构建这个对象；
//定义一个用于创建对象的接口，让子类决定实例化哪一个对象，使得一个类的实例化延迟到子类；（解耦；）
// 用户隔离类对象的使用者和具体类型之间的耦合关系；

// 创建 对象经常变化； 创建对象；
// 工厂方法： 没有要有有一个工厂来创建实例？？？？ 因为简单工厂根绝传入的参数不同选择不同的对象，对象这边是变化的，
//需要抽象或者接口化，所以就需要一个工厂；
// 其实使用了工厂也就是起到了延迟实例化的功能；

/**
 * 工厂方法 调用者 和 创建者解耦；
 * 抽象类；
 */
abstract class creator
{
    //工厂方法 获取
   public function someoperate(){
        $factory  = $this->factorymethod();
        echo "result:";
        $factory->operate();
    }
    abstract public function factorymethod();

}
//
class concretecreator1 extends creator
{
    public function factorymethod() :product{
        // todo: implement factorymethod() method.
        return new concreteproduct1();
    }
}

class concretecreator2 extends creator
{
    public function factorymethod(): product {
        // todo: implement factorymethod() method.
        return new concreteproduct2();
    }
}

//产品
interface product
{
    public function operate();
}
//实现的  具体的产品
class concreteproduct1 implements product
{
    public function operate() {
        echo "result of the concreteproduct1";
    }
}
class concreteproduct2 implements product
{
    public function operate() {
        echo "result of the concreteproduct2";
    }
}
echo "ceshi";
echo "ceshi";

class gen
{
    public static function gene(creator $factory){

            $factory->someoperate();
    }
}
//用的是第一个工厂 然后生产一个 产品  然后是另外一个产品 还是其中的一个产品是不是这个措施
// 工厂对象是从 外部传递进来的；
// 问题？？？？？ 注意这些问题；
//
//我们仅仅能保证我们自己factory 或者gen 是不依赖于具体的实现；变化仅仅是移动到其他位置去了，它并没有消失；
//变化不会消失仅仅移动到外部了；我们仅仅做的是保证我们内部不依赖于具体实现的类；

// ?????? 创建实例对象；注意我们这里需要拿到一个对象；

gen::gene(new concretecreator1());
gen::gene(new concretecreator2());
