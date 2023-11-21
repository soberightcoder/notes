<?php

/**
 * Class Extend
 * 继承
 * 代码的复用
 * 多继承  trait  和  接口的多继承
 */

abstract class Bird
{
    protected $high;
    abstract public function fly();
    public function eat(){
        echo "eat food";
    }
}
// 这里就是组合； 这个就是变化的部分；我们需要摘出来  当特性来处理；
trait  Zhizhi
{
    public function quack() {
        echo "zhizhiz";
    }
}
trait  Kaka
{
    public function quack() {
        echo "kaka";
    }
}



class MedelBird extends Bird
{
    use Kaka;
    public function fly() {
        echo "i not fly";
    }
    public function perform() {
        $this->quack();
        $this->fly();
    }

}
$obj = new MedelBird();
$obj->perform();
//用多继承来实现