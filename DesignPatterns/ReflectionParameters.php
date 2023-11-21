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
    public function run(Ceshi $ceshi , $a=111 , $b) {
        echo $ceshi->x;
        var_dump($ceshi);die;
    }
}

//$method = new ReflectionParameter("Ceshi1","run");
//$method=new ReflectionMethod('Ceshi1','run'); // 建立 Person这个类的反射类
//$params=$method->getParameters();
//foreach ($params as $param) {
//    $depency = $param->getClass();
//    if (!is_null($depency)) {
//        echo "i m a obj";
//    }
//}

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

        if (is_null($constructor)) {
            // 没有构造；
            $dependencies = [];
        } else {
            $parameters = $constructor->getParameters(); //TODO null 情况，为null的情况注意下；
            if ($parameters) {
                //hasparameters
                $dependencies = self::getDependencies($parameters);
            } else {
                //parameters == null
                $dependencies = [];
            }
        }
//        return $dependencies;
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
//                    当没有默认值时候，给一个默认值 null
                    $dependencies[] = null;
                }
            }else{
                //这里才是重点  递归  解析出依赖的对象 *****
                $dependencies[] = self::make($denpency->name);
            }
        }
        return $dependencies;
    }

    /**
     * @param $class
     * @param $method
     * @return array
     * @throw
     * s ReflectionException
     * 返回的是某个方法的参数
     */
    public static function makeMethod($class,$method) {
        $method = new ReflectionMethod($class,$method);
        $params = $method->getParameters();//array array内部是一个个参数对象；
        if ($params) {
            $dependencies = self::getDependencies($params);
        } else {
            $dependencies = [];
        }
        return $dependencies;

    }
}
//
$arrobj = IoC::makeMethod("Ceshi1","run");
$obj = new Ceshi1;
call_user_func_array(array($obj, 'run'),$arrobj);

//call_user_func call_user_func_array 的区别
//call_user_func：把第一个参数作为回调函数进行调用，其余参数作为回调函数的参数

//call_user_func_array：把第一个参数作为回调函数进行调用，第二个参数传入数组，将数组中的值作为回调函数的参数
//call_user_func 参数是参数的形式
//call_user_func_array 参数是数组的形式；
//func_get_args  获取参数;

//echo call_user_func(array(new Test(), 'test'), 1);//输出结果为1
//echo call_user_func_array(array(new Test(), 'test'), [1]);//输出结果为1

///function test($test1, $test2) {
//return $test1 . $test2;
//}
//echo call_user_func('test', 'a','b');//输出结果为ab
//echo call_user_func_array('test', ['c', 'd']);//输出结果为cd


//function foo()
//{
//    $numargs = func_num_args(); //参数数量
//    echo "参数个数是: $numargs<br />\n";
//    if ($numargs >= 2) {
//        echo "第二个参数的值:" . func_get_arg(1) . "<br />\n";
//    }
//    $arg_list = func_get_args();
//    for ($i = 0; $i < $numargs; $i++) {
//        echo "第{$i}个参数值:{$arg_list[$i]}<br />\n";
//    }
//}
//
//foo(1, 'd', 3,4);



/**
 * callback 回调函数
 */

function func_call_array(Closure $func,$param) {
    return $func($param);
}
$param = 1;
func_call_array(function ($param){
    echo $param;
},$param);
