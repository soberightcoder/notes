# DI（IOC Inversion of Control）

> dependence injection container 依赖  注入 容器三个概念；
>
> 依赖注入是一个花哨的名字，实质上是指：类的依赖(B类)通过构造器，或者一些特定的方法来实现注入(B类做为对象参数的形式传入)；
>
> total:解耦；
>
> 依赖注入(DI)和控制反转(IOC)是从不同的角度的描述的同一件事情，就是指通过引入IOC容器，利用依赖关系注入的方式，实现对象之间的解耦。
>
> 缺点：由于IOC容器生成对象是通过反射方式，在运行效率上有一定的损耗；
>
> Reflection(反射):通俗来讲就是根据给出的类名（字符串方式）来动态地生成对象。这种编程方式可以让对象在生成时才决定到底是哪一种对象。

****



## dependence

Q：类的依赖关系，A类的实现要依赖B类的支持，所以A就要依赖于B；

例如：人要出行，需要开车，所以人就依赖于车；

​			车要跑动，需要轮胎，所以车依赖于轮胎；

```php
#耦合性很强，当依赖做了修改，我们A类也要做修改;
#假如 我们换一种轮胎 morewheel，那么我们就需要去修改代码，而依赖注入是不需要;
class Wheel
{
    public function create(){
        echo __METHOD__.'|';
    }
}
//more wheel 
class MoreWheel
{
    public function create(){
        echo __METHOD__;
    }
}
//定义一个车类 依赖于Wheel
class Car
{
    public function run(){
        $wheel = new Wheel();
        $wheel->create();
        echo __METHOD__.'|';
    }
}

//定义人类 依赖于Car类 需要自己new Car 自己创造一辆车
class Human
{
    public function drive(){

        $car = new Car();
        $car->run();
        echo __METHOD__.'|';
    }
}

//
$ob = new Human();
$ob->drive();
```

*****

## injection 

Ｑ：一般是类的构造方法里传入另外一个类的对象做参数；

`````php
#解耦，耦合性降低；
class Wheel
{
    public function create(){
        echo __METHOD__.'|';
    }

}
//Car类 
class Car
{
    private $wheel;
    //injection
    public function __construct(Wheel $wheel) {
        $this->wheel = $wheel;
    }

    public function run(){
        $this->wheel->create();
        echo __METHOD__.'|';
    }
}
//Human 类  通过传对象的形式来接触依赖关系   直接买一辆车
class Human
{
    private $car;

    public function __construct(Car $car) {
       $this->car = $car;
    }

    public function drive(){
        $this->car->run();
        echo __METHOD__.'|';
    }
}
$car = new Car(new Wheel());
$ob = new Human($car);
$ob->drive();

`````

## container（IOC）

*****

> 容器一般会有两个方法，make(生产)，bind(绑定)；
>
> 容器的优点：
>
> 1. 解耦；
> 2. 实现惰性加载，当需要对象的时候make才会产生，不需要的时候不需要仅仅是一个闭包；
> 3. 便于管理；
>
> 借助一个第三方(container)来实现具有依赖关系的对象解耦；都依赖第三方，全部对象的控制权全部上交给第三方(容器);
>
> 为什么叫控制反转?
>
> 控制被反转之后，获得依赖对象的过程由  <font color='red'>自身管理</font>变为了由<font color=red>IOC容器主动注入</font>

```````php
//1.defination IoC normal
class IOC
{
    protected static $registry=[];
    //bind 绑定
    public static function bind($name,$resolver){
       static::$registry[$name] = $resolver;
    }
   //make 生产;
    public static function make($name){
        if(isset(static::$registry[$name])){
            $resolver = static::$registry[$name];
            return $resolver;
        }
    }
}
// 绑定容器
IoC::bind('wheel',new Wheel());
IoC::Bind('car',new Car(IoC::make('wheel')));
IoC::bind('human',new Human(IoC::Make('car')));
// 
$human = IoC::make('human');
$human->drive();


//2.defination IoC laravel
//基础知识 匿名函数 执行
$a = function (){
    return 'i m niming';
};
echo $a();

class IoC
{
    protected static $registry=[];
   //bind
    public static function bind($name, $resolver){
        static::$registry[$name] = $resolver;
    }
    //make
    public static function make($name){
        if(isset(self::$registry[$name])){
            $resolver = static::$registry[$name];
            return $resolver();
        }
    }
}
//bind
IoC::bind('wheel',function (){
    return new Wheel();
});
IoC::bind('car',function (){
    return new Car(IoC::make('wheel'));
});
IoC::bind('human',function (){
    return new Human(IoC::make('car'));
});
$human = IoC::make('human');
$human->drive();

```````





#### IOC

````php
class A
{
  public function run(){
      echo "run success";
  }
    
}
class B
{
    protected $B;
    public function __construct(){
        $this->B = new A;
	}
    public function test(){
        $this->B->run();
    }
}
````



**控制反转就是说创建对象的控制权进行转移，以前创建对象的主动权和创建时机都是由自己把控的，现在把这种权力转移到第三放，比如交给了IOC容器，他是一个专门创建对象的工厂，你需要什么对象，它就给你什么对象 ，有了IOC容器后，依赖关系就变了，原先的依赖关系就没了，他们依赖关系就没了，他们都依赖于IOC容器，通过IOC容器来实现依赖关系的解耦；***    控制反转就是站在B的角度；



**DI 依赖注入** 

**对象通过外部以参数的形式注入到方法内就是依赖注入；**  DI是站在容器的角度



DI和IOC是同一个问题不同角度的分析；



缺点：

* 无法解决 递归依赖的问题； 这确实是一个很大的问题；



* **无法提前生成实例化对象，这不是优点吗？ 节约空间？？？？**







**闭包 就是子函数可以使用夫函数的变量；**

``````php
function ceshi(){
    $a=1;
    $b=2;
    return function ceshi1($data)use($a,$b){
        return $data.$a.$b;
    }
}

$func = ceshi();
$func('ceshi');
``````



servicecontainer = = app 用来管理 服务提供者；说白了就是一个实例化对象，这里就是一个容器，启动之初会去注册和启动服务提供者，然后就可以使用这个服务者绑定的对象了；

serviceprovider = 就是服务提供者；或者开发一个模块，支付；或者第三方包就可以了；需要自己注册属于自己的的serviceprovider；

提供属于自己的服务；

```
* Laravel Framework Service Providers...
```

```
* Package Service Providers...
*/
```

```
/*
 * Application Service Providers...
 */
```

而 laravel中出去非常基本事件，异常处理，facades以外，其他的服务都是通过sericeprovider注册进来使用的；比如路由请求 caceh DB reponse'



注意  servers phpstorm 配置 才能用xdebug

