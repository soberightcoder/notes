<?php
//抽象工厂
// 抽象工厂会返回多个类，与工厂方法的区别； 一个工厂生产一系列相关的对象；
// 提供一个 创建一系列相关或相互依赖对象 的接口，而无需指定他们的类；
//抽象工厂模式提供了一个接口，用于创建相关或依赖对象的家族，而不需要明确指定具体类；
//抽象工厂模式有多个Product需要创建，有多工厂方法，

/**
 * 抽象工厂模式是一种创建型设计模式， 它能创建 一系列相关的对象， 而无需指定其具体类。
 *
 * 什么是 “系列对象”？ 例如有这样一组的对象：运输工具+ 引擎+ 控制器 。 它可能会有几个变体：
    汽车+ 内燃机+ 方向盘
    飞机+ 喷气式发动机+ 操纵杆
    如果你的程序中并不涉及产品系列的话， 那就不需要抽象工厂。
 */
/**
 * 生产工厂的工厂，是一个超级工厂用来生产工厂；
 * 扩展产品族 会违背 开闭原则；
 */


/**
 *  小米  和  华为
 *
 *  都可以生产 phone router  是属于一个产品族 属于小米的产品族；自己的东西 自己需要创建一个总工厂去生产；
 *
 *  每一个抽象工厂产生一系列的对象，这里的一系列对象其实就是产品族的对象；调用不同的方法，可以产生产品族里的对象；
 *
 *  给产品族做扩展的话是比较麻烦的；不满足开闭原则；
 *
 */


interface Iphone
{
    public function boot();
    public function shutDown();
    public function sendSms();
    public function call();
}

class XiaomiPhpone implements Iphone
{
    public function boot() {
        echo "xiaomi boot\n";
    }

    public function shutDown() {
        echo "xiao mi shut down\n";
    }

    public function sendSms() {
        echo "xiao mi send sms\n";
    }

    public function call() {
        echo "xiaomi  call\n" ;
    }
}


class HuaweiPhone implements Iphone
{
    public function boot() {
        echo "huawei boot\n";
    }

    public function shutDown() {
        echo "huawei mi shut down\n";
    }

    public function sendSms() {
        echo "huawei send sms\n";
    }

    public function call() {
        echo "huawei  call\n" ;
    }
}


interface Irouter
{
    public function boot();
    public function shutDown();
}

class Mirouter implements Irouter
{
    public function boot() {
        echo "mirouter boot\n";
    }

    public function shutDown() {
        echo "mirouter mi shut down\n";
    }
}

class Huarouter implements Irouter
{
    public function boot() {
        echo "mirouter boot\n";
    }

    public function shutDown() {
        echo "mirouter mi shut down\n";
    }
}
// 抽象工厂；
interface IProductFactory
{
    // 这里是工厂；
    public function phonefactory();

    public function routefactory();
}

//  抽象工厂； 会生产一个族类；  抽象工厂会生产 工厂；
class  MiFactory implements IProductFactory
{
    public function phonefactory() {
        return new  XiaomiPhpone();
    }

    public function routefactory() {
        return new Mirouter();
    }
}

class HuaFactory implements IProductFactory
{

    public function  phonefactory() {
        return new HuaweiPhone();
    }

    public function routefactory() {
        return new Huarouter();
    }
}

// 客户
function client(IProductFactory $factory,$type){
    //mi phone
//    $phone = $factory->routefactory();
//    $phone->boot();
//    $phone->shutDown();
    $method = $type.'factory';
    return call_user_func_array(array($factory,$method),array());
}

client(new MiFactory(),'route')->boot();