<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/12/8
 * Time 17:37
 */
/**
 * 注册树设计模式   === 容器
 * static 静态方法，不需要new 就可以使用，$this只能运行的时候才会生成 new 的时候才会给普通变量去申请内存；
 * static 是在编译的时候就会被申请内存；所以不需要new ，就可以使用静态变量和静态方法；
 */

class Regisiter
{
    protected static $objects;

    static public function set($alias,$obj) {
        self::$objects[$alias] = $obj;
    }
    // 在静态方法中不能使用 $this 只能使用self；
    static function get($alias) {
        return self::$objects[$alias];
    }
    //普通方法中可以使用；
    public function _unset($alias) {
        unset(self::$objects[$alias]);
    }
}

class A
{
    public $a= 1;
}
$a = new A;
Regisiter::set('a',$a);