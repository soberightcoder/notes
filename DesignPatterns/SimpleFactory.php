<?php
/**
 * Class SimpleFactory
 *
 * 工厂 肯定是生产 产品的 很好理解    用方法 参数来选择 生产 那种产品
 * 简单工厂
 * //要清晰 知道C/S  面向接口编程
 * //简单工厂模式 描述了一个类 会包含大量的条件语句的构建方法 可以根据方法的参数 来决定对那种产品初始化
 * 缺点 ： 当添加一个心得产品的时候 需要修改代码  违背了 开放封闭原则  所以 就会有了 下面的
 * //工厂生产 => 产品
 */
//创建实例的时候不需要new  直接调用工厂就可以了；

//简单工厂  就是根据 我们 传入的字符串或者其他的标识符 来返回 对应的产品(对象);
//total:
// 捕获异样之后，不在继续运行；
function exception_handler(Exception $e) {
    echo $e->getMessage();
}
set_exception_handler("exception_handler");
//抽象类
interface Products
{
    public function speak();
}

class Yellow implements Products
{
    public function speak() {
        echo " 我创建了一辆小黄车";
    }
}

class Blue implements Products
{
    public function speak() {
            //生产产品的具体操作 比如 db  可以分为 Oracle 或者 MySQL 之类的链接操作
        echo " 我制造了一辆小蓝车";
    }
}

class SimpleFactory
{
    public  function gen($type){
      switch($type){
          case "yellow":
              return new Yellow();
              break;
          case "blue":
              return new Blue;
              break;
          default:
              throw new Exception("没有该类型颜色的自行车");
      }
    }
}
//yellow 产生一个小黄车 c 客户端  给你提供一个接口 你只需要生产一个就行
$simple = new SimpleFactory();
//$factory = $simple->gen("yellow");
//$factory->speak();
//$factory->speak();

$factory = $simple->gen('cessss');
$factory->speak();

//$factory = SimpleFactory::gen("blue");
