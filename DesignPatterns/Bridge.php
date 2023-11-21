<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/7/15
 * Time ${Time}
 */
/**
 * 桥接模式 存在于两个独立的变化的维度
 * 其实可以用继承但是 随着数量变多不好扩展，还有继承不能满足  开闭原则  多继承也不行
 *
 * 所以这里要使用组合  组合优于继承
 */

/**
 * eg: brand: 联想 苹果 华为    computer： desktop桌面版的电脑，笔记本notebook 平板电脑tablet
 */

interface Brand
{
    public function info();
}

class LianXiang implements Brand
{
    public function info() {
        echo "lianxiang\n";
    }
}

class Apple implements Brand
{
    public function info() {
        echo "apple\n";
    }
}
// 电脑的类型
abstract  class Computer
{
    // 组合
    protected $brand;
    public function __construct(Brand $brand) {
        $this->brand = $brand;
    }
    // 调用 info
    public function info() {
        $this->brand->info();
    }

}

class Tablet extends Computer
{
    public function info() {
        parent::info();
        echo " tablet\n";
    }
}

class Desktop extends Computer
{
    public function info() {
        parent::info();
        echo " desktop\n";
    }
}


class Client
{
    public function main() {
        // 联想台式机
        $computer1 = new Desktop(new LianXiang());
        $computer1->info();
        // 苹果台式机
        $computer2 = new Desktop(new Apple());
        $computer2->info();
    }
}
//$obj = new Client();
//$obj->main();


/**
 * 如果用trait多继承 当维度变多 或者 某一个维度的变量
 *
 *  会产生n*m*q个对象 继承后的对象
 *  n+m+q  父类
 *
 * 如果是使用组合 那么只需要 n+m+q个对象就可以了；
 */


trait Huawei
{
    public function ceshi() {
        echo "lianxiang\n";
    }
}

trait Meizu
{
    public function ceshi() {
        echo "apple\n";
    }
}

class Notebook
{
    public function info() {
        echo "notebook\n";
    }
}


interface Combine
{
    public function handle();
}

/**
 * Class LianxiangComputer
 * 先继承然后 实现
 * 那么要创建 n*m 个这样的实例
 */

class HuaweiNotebook extends Notebook implements Combine
{
    use Huawei;
    public function handle() {
        // TODO: Implement handle() method.
        $this->info();// 电脑  和 联想 的两个info都要输出
        $this->ceshi();
    }

}
$obj = new HuaweiNotebook();
$obj->handle();