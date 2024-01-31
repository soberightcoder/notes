# ReflectionClass 反射

```php
<?php
/**
 * 反射类+递归 实现 Ioc的自动注入
 * total实现依赖对象的自动注入 *****
 */
/**
 * Class Point
 */
class Point
{
    public $x;
    public $y;

    /**
     * Point constructor.
     * @param int $x  horizontal value of point's coordinate
     * @param int $y  vertical value of point's coordinate
     */
    public function __construct($x = 0, $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
    }
}


class Circle
{
    /**
     * @var int
     */
    public $radius;//半径

    /**
     * @var Point
     */
    public $center;//圆心点


    const PI = 3.14;

    public function __construct(Point $point, $radius = 1)
    {
        $this->center = $point;
        $this->radius = $radius;
    }

    //打印圆点的坐标
    public function printCenter()
    {
        printf('center coordinate is (%d, %d)', $this->center->x, $this->center->y);
    }

    //计算圆形的面积
    public function area()
    {
        return 3.14 * pow($this->radius, 2);
    }
}
class IoC
{
    /**
     * @param $className
     * @return object
     * @throws ReflectionException
     * 获取已经注入依赖的对象
     */
    public static function make($className){
        $reflectionObj = new ReflectionClass($className);
        $constructor = $reflectionObj->getConstructor();
        $parameters = $constructor->getParameters();
        $dependencies = self::getDependencies($parameters);
        return $reflectionObj->newInstanceArgs($dependencies);
    }

    /**
     * @param $parameters
     * @return array
     * return construct parameters array
     */
    public static function getDependencies($parameters){
        //一维数组
       foreach($parameters as $parameter){
           //判断参数是否是类，是则返回 obj  不是返回null
            $denpency = $parameter->getClass();
            if(is_null($denpency)){
                if($parameter->isDefaultValueAvailable()){
                    $dependencies[] = $parameter->getDefaultValue();
                }else{
                    //当没有默认值时候，给一个默认值 '0'
                    $dependencies[] = '0';
                }
            }else{
                //这里才是重点  递归  解析出依赖的对象 *****
                $dependencies[] = self::make($denpency->name);
            }
       }
       return $dependencies;
    }

}
$obj = IoC::make('Circle');
//object ( Circle )[ 11 ]
//   public 'radius' =>  int  1
//  public 'center' =>
//    object ( Point )[ 10 ]
//       public 'x' =>  int  0
//      公共'y' =>  int  0
//参数
var_dump($obj);
//object ( Point )[ 10 ]
//   public 'x' =>  int  0
//  public 'y' =>  int  0
var_dump($obj->center);
```







### ReflectionParameter 查看一下这个类；



````php
<?php
/**
 * Created By PhpStorm
 * User Leaveone
 * Date 2022/7/9
 * Time 0:47
 */

class Ceshi
{
    public $x = 10;
}

class Ceshi1
{
    public function run(Ceshi $ceshi) {
        echo $ceshi->x;
    }
}

//$method = new ReflectionParameter("Ceshi1","run");
$method=new ReflectionMethod('Ceshi1','run'); // 建立 Person这个类的反射类
$params=$method->getParameters();
foreach ($params as $param) {
    $depency = $param->getClass();
    if (!is_null($depency)) {
        echo "i m a obj";
    }
}
````



**查看一下newInstanceArgs($dependencies);**

**根据输入的参数 实例化生成一个对象；**	**这个到底生成的原理是什么 必须要了解；**











之前就听说Laravel的特点中依赖注入就是其中之一，一直在寻找依赖注入和Spring的感觉。

Laravel提供了多种依赖注入的方式。首先就将实现构造器或者方法参数的注入，这种依赖注入的方式比较简单，也不需要怎么配置。只要在方法的参数中写入类的类型，这个时候，类的实例就会注入到这个参数上，我们在使用的时候，就可以直接使用，而不用我们再去new这个类的

class Test
{
    //这是一个类        
}

class TestController extend Controller
{
    public function __contract(Test $test)
    {
        print_r($test);
    }
}
实例，这个new的过程，已经由框架替我们做了。

这样我们不用对$test变量做任何的赋值操作，Laravel会帮我们把Test的实例赋值给$test变量，这就是一种依赖注入的使用。我们的依赖的Test就这样被注入到了参数里头。我们平时使用Laravel的控制器中接收页面参数的时候，就是依赖注入。
