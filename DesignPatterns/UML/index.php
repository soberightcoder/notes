<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2023/3/28
 * Time 17:15
 */
/**
 * UML的几种关系
 *
 *  继承 实现
 *  关联  依赖
 *  组合 聚合
 */

/**
 * 继承
 * B -\>  A 实线空三角箭头
 */
class  A
{
}
class B extends A
{

}

/**
 *
 * 实现
 * 虚线空三角箭头
 * C -----\>  D
 */
interface C
{

}
class D implements C
{

}


/**
 * 依赖  --- 使用关系；
 * 虚线箭头 普通箭头
 * ----->
 * 1. 局部变量
 * 2. 形参
 * 3. 静态方法调用
 */

class E
{
    public static function run() {
        echo "静态方法的调用";
   }

    public function index() {
        echo "index";
   }
}
class F
{
    //局部变量
    //强依赖，一般不会用；
    public function index() {
        $obj = new E();
        $obj->index();
    }
    //形参
    //DI  IOC 依赖注入
    public function index1(E $e) {
        $e->index();
    }
    // 静态方法的调用
    public function index2() {
        E::run();
    }
}

/**
 * 关联 ---  拥有关系；
 *  ->  实线箭头
 *  属性 来保存对象
 * 对象G 是拥有 对象H；或者可以来访问对象G的属性和方法；
 */

class G
{

}
class H
{
    public $obj;

    public function __construct(G $g) {
        $this->obj = $g;
    }
}

/**
 *  整体和部分的关系；
 *  经典的例子：
 *  公司 部门 员工
 */
/**
 *  组合   --- 整体和部分的关系
 *  很明显，组合成一个整体，当整体不存在的时候，部分也就不存在；
 *  表示 需要看 typora 文档;
 */

class Company
{

}
class Department
{
    public $com;
    public function __construct(Company $c) {
        $this->com = $c;
    }
}

/**
 *  聚合，人聚在一起，整体不存在的时候，部分依然存在；
 *  聚集在一起，肯定可以分离；
 */

class Employee
{
    public $com;
    public function __construct(Company $c) {
        $this->com = $c;
    }
}


/**
 * 我们平常 说的组合继承的关系，啥多用组合的关系
 */
interface I
{
    public function index();
}
//接口来实现代码的多态；
class I1 implements I
{
    public function index() {
        echo "i1";
        echo "\n";
    }
}

class I2 implements I
{
    public function index() {
        echo "i1";
        echo "\n";
    }
}



class J
{
    public  $i;
    // 组合 + 委托 来实现代码的复用？？？？
    //组合
    public function __construct(I $i) {
        $this->i = $i;
    }
    // 委托 来实现
    public function index() {
        $this->i->index();
    }
}

$obj = new J(new I1);
$obj->index();

/**
 * 多维 组合 变化维度有多的时候，最好用组合；
 */
interface L
{
    public function run();
}

class L1 implements L
{
    public function run() {
        echo "L1";
    }
}

class L2 implements L
{
    public function run() {
        echo "L2";
    }
}

/**
 * 多个维度只需要创建 m个对象就行了；
 */
class J1  extends L1
{
    public  $i;
    public function __construct(I $i) {
        $this->i = $i;
    }

    public function index() {
        $this->i->index();
    }
}

$obj1 = new J1(new I2);
$obj1->index();
$obj1->run();


/**
 * 继承就比较麻烦
 * 如果变化的维度特别多，那么会更加复杂，会变成 N*M;
 * 会生成多个对象，如果是多个维度会变得很麻烦；
 *  m * n
 */

class K1 extends  I1
{

}

class K2 extends I2
{

}

/**
 *  多个维度的变化;
 * 可以使用多继承；
 * 需要m*n个对象；
 */

class M extends I1
{
    //多继承； 时使用 trait来实现的;use来实现；

}

// trait use 的多继承；
trait ceshiA
{

}

/**
 * 当继承层次太深的时候，继承就会变得很麻烦；
 * 会产生很多对象；
 */
