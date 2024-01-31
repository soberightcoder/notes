# php魔术方法

>根据作用对象可以分为四类：
>
>* 属性： get set isset unset
>  * 方法：call callstatic
>* 对象： toString invoke sleep wakeup __construct ,\__destory;
>* 特殊：autoload();自动加载函数  \spl_autoload_register ; 自动加载函数；



```php
/**
 * 魔术方法 __callstatic 的使用
 * 查询构造器的实现
 * DB::table()
 */
#访问不存在静态方法的时候调用
class DB
{
    public function table(){
        echo 'table';
    }
    public static function __callStatic($name, $arguments) {
        // TODO: Implement __callStatic() method.
        call_user_func_array([self::class,$name],$arguments);
    }
}

DB::table();

// 把对象当成函数使用的时候调用
public function __invoke(){
    
}


//__construct

//__destory

//__clone

//__toString 对象当成字符串的时候调用



/**
 * call_user_func + 魔术方法
 * 分为三部分 --- 根据作用的对象的不同，分为三部分；
 * 属性  get set isset unset
 * 方法  call callstatic
 * 对象  invoke tostring sleep clone wakeup construct destory；
 */

class DB
{
    public $name = 'qsw';

    public $age = 19;
    public function table(){
        echo 'table';
    }
    public static function __callStatic($name, $arguments) {
        // TODO: Implement __callStatic() method.
        call_user_func_array([self::class,$name],$arguments);
    }

    public function __invoke() {
        // TODO: Implement __invoke() method.
        echo "ivoke";
    }
    public function __get($name) {
        // TODO: Implement __get() method.
        echo $name."is not exists";
    }
    //对象反序列化
    public function __wakeup() {
        echo "unserialize";
        // TODO: Implement __wakeup() method.
    }
    //  修改属性
    public function __set($name, $value) {
        // TODO: Implement __set() method.
        echo $name."-----".$value;
    }
    public function __sleep() {
        // TODO: Implement __sleep() method.
        echo "sleep";
    }
    //属性的设置；
    public function __isset($name) {
        // TODO: Implement __isset() method.
        echo "isset";
    }



}
//callstatic
//DB::table();
//__invoke
$obj = new DB;
//$obj();

//get
//echo $obj->name;

//__wakeup  反序列化
//var_dump(json_encode($obj,true));

//var_dump(json_decode(json_encode($obj,true)));die;
//$res = serialize($obj);

//echo $res;
//var_dump(unserialize($res));die;

//set 修改属性
//$obj->ceshi=1;

isset($obj->ceshi);
unset($obj->ceshi);


```



## autoload   自动加载魔术方法

`````php
<?php
    //spl_autoload_register 注册自动加载函数；
    
namespace website\Project;
spl_autoload_register('\website\Project\Autoload::main');

class Autoload
{
    public static function main($className){
        $file = trim($className, '\\');
        $file = explode('\\', $file);
        array_shift($file);
        array_shift($file);
        $path = __DIR__;
        $file = $path . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $file) . '.php';
        if (is_file($file)) {
            require_once($file);
        }
    }
}

//
function autoload() {
    //自动加载 函数；
}
`````

