<?php

/**
 * Class LSP
 * 里氏替换原则
 *  **LiskovSubstitution Principle,LSP**
 * 子类完全可以替换父类
 * 通俗来说 子类不可以重写父类已经实现的方法，可以重写抽象的方法;
 */
abstract class Computers
{
   public function add($a,$b){
       return $a+$b;
   }
   abstract function mul($a,$b);
}

class Computers1 extends Computers
{
    // 如果 你这里重写了 那么 computers1 就不能代替父类了，是不是？ 如果代替了父类，那么computers2 肯定会计算错误
    public function add($a, $b) {
        return $a-$b;
    }

    public function mul($a, $b) {
        return $a*$b;
    }
}

class Computers2 extends Computers
{
    public function mul($a, $b) {
        return $a*$b;
    }
}