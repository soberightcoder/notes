<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/12/8
 * Time 23:30
 */
/**
 * 装饰器 设计模式
 * 动态修改类的功能；
 * 运行的时候添加一个 修饰器对象就可以完成；
 */

/**
 * Interface Idecorawte
 * 修饰对象的接口；
 */
interface Idecorawte
{
    public function head();
    public function after();
}

class Decorator1  implements Idecorawte
{
    public function head() {
        echo "decorator1 11.\n";
    }
    public function after() {
        echo "decorator1.111\n";
    }
}
class Decorator2  implements Idecorawte
{
    public function head() {
        echo "decorator2 222.\n";
    }
    public function after() {
        echo "decorator2.2222\n";
    }
}


class Main
{
    protected $decoratorayy = [];

    public function addDecorator(Idecorawte $idecorawte) {
        $this->decoratorayy[] = $idecorawte;
    }
    public function before() {
        foreach ($this->decoratorayy as $item) {
            $item->head();
        }
    }

    public function after() {
        $mid = array_reverse($this->decoratorayy);
        foreach ($mid as $item) {
            $item->after();
        }
    }
    public function index() {
        $this->before();
        echo "index\n";
        $this->after();
    }
}
$main = new Main();
$decorateobj1 = new Decorator1();
$decorateobj2= new Decorator2();

$main->addDecorator($decorateobj1);
$main->addDecorator($decorateobj2);
$main->index();
//decorator1 11.
//decorator2 222.
//index
//decorator2.2222
//decorator1.111
// 如果我想在main 输出之前加 一个 brief 简介  在index 之后添加一个 main

/**
 * 传统形式来
 * 重写
 */
class Main1 extends Main
{
    public function index() {
        echo "brief\n";
        parent::index();
        echo "main";
    }
}

$main1 = new Main1();
//$main1->index();


