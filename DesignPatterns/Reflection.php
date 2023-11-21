<?php
/**
 * 反射类的实现 Ioc的自动注入
 * total:根据传递的类名（字符串），来动态的产生对象；
 * 使用递归来解决所有依赖关系；
 * 实现依赖实例的自动注入 *****
 * // 条件是：依赖的类必须通过construct 构造函数来传递；
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
                }
                else{
//                    当没有默认值时候，给一个默认值 '0'
                    $dependencies[] = null;
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


