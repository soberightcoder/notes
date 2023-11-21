<?php
/**
 * The Singleton class defines the `GetInstance` method that serves as an
 * alternative to constructor and lets clients access the same instance of this
 * class over and over.
 */
//创建一个用户级别的错误信息
//trigger_error('error'); //
//can capture error and exception php7
function my_exception_handler($e){
    echo $e->getMessage()."---set_exception_handler";
}
set_exception_handler("my_exception_handler");

//a(); //php7 也可以capture error
//die;
//设计模式追求的 高内聚 和低耦合
// 类内的高内聚  类类之间的低耦合
//total: 确保一个类只有一个实例，并提供一个全局访问点；
/**
 * Class Singleton
 * total :  保证一个类只有一个实例 并提供一个访问该实例的全局节点；
 */
class Singleton
{
    /**
     * The Singleton's instance is stored in a static field. This field is an
     * array, because we'll allow our Singleton to have subclasses. Each item in
     * this array will be an instance of a specific Singleton's subclass. You'll
     * see how this works in a moment.
     */
    private static $instances = [];

    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    protected function __construct() {
        // 阻断反射 产生的对象
//        if (self::$instances) {
//            throw new Exception('哈哈哈，被抓住了把，不要用反射来实例化');
//        }
    }

    /**
     * Singletons should not be cloneable.
     */
    protected function __clone() {

        echo " wc wo bei shili huale";
    }

    /**
     * Singletons should not be restorable from strings.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");

    }

    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * This implementation lets you subclass the Singleton class while keeping
     * just one instance of each subclass around.
     */
    public static function getInstance(): Singleton
    {
        $cls = static::class; //class_name  绑定滞后  都可以换成 get_call_class
        if (!isset(self::$instances[$cls])) {

            self::$instances[$cls] = new static; //滞后
        }

        return self::$instances[$cls];
    }

    /**
     * Finally, any singleton should define some business logic, which can be
     * executed on its instance.
     */
    public function someBusinessLogic()
    {
        // ...
    }
}

/**
 * The client code.
 */
//调用 属性必定会有一个$ 无论是静态的还是:: $this的调用
//$single = new Singleton; //__construct() from invalid context

//Singleton::$instance;
//$this->instance;
//$single = Singleton::getInstance();
//$str = serialize($single);
//$obj = unserialize($str);
//$cl = clone $single;  //clone transferN
//die;
//function clientCode()
//{
//    $s1 = Singleton::getInstance();
//    $s2 = Singleton::getInstance();
//    if ($s1 === $s2) {
//        echo "Singleton works, both variables contain the same instance.\n";
//    } else {
//        echo "Singleton failed, variables contain different instances.\n";
//    }
//}
//
//clientCode();

// self  and  static diff
// self is current class
//static later static binding
//self and static are class
//exist new self  and  new static  =>  objcet

//eg  对日记文件的权限进行控制

//class Logger extends Singleton
//{
//    private $fileHandler;
//
//    protected function __construct() {
//        //php://stdout stream stdin sd
//        $this->fileHandler = fopen("php://stdout","w");
//    }
//
//    public function writeLog($message){
//        $date = date("Y-m-d");
//        fwrite($this->fileHandler,"$date:$message\n");
//    }
//
//    public static function log($message){
//        $logger = static::getInstance();
//        $logger->writeLog($message);
//    }
//}
//Logger::log("start!!!");
//echo 测试;




//trait + 单例 无敌；

trait Single
{
    public static $instance;
    //私有化，不能外部的类实例化；
    protected function __construct() {

    }
    protected function wakeup() {

    }
    public function clone()  {
        throw new Exception("not clone!!");
    }

    public static function getInstance()
    {
        $cls  = static::class; //这里表示的是类名；
        // get_called_class(); 调用类；
        if (!isset(self::$instance[$cls])) {
            // get_class get_called_class static::class self::class表示的类名；仅仅是名字 注意区别！！
            // self  static  表示的类 整个类；
            // $this表示的是对象；
            self::$instance[$cls] = new static;
        }
        return self::$instance[$cls];
    }
}


interface ITest
{
    public function dotest();
}

class Single_TEST1 implements ITest
{
    use Single;
    public function dotest()
    {
        echo "test1";
    }
}

class Single_TEST2 implements ITest
{
    //多继承；
    use Single;
    public function dotest()
    {
        echo "test2";
    }
}

if (Single_TEST1::getInstance() === Single_TEST1::getInstance()) {

    echo "全等";
}

//
Single_TEST1::getInstance()->dotest();//test1

