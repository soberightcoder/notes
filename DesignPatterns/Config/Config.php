<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/12/9
 * Time 17:50
 */


/**
 *  自动加载配置；
 * 注意ArrayAccess
 * ArrayAccess 是把一个对象当成数组；
 */


class Config implements \ArrayAccess
{
    public $path;
    public $config = [];//保存加

    public function __construct($path) {
        $this->path = $path;
    }

    /** @param $offset to modify
     * @param $value new value
     */

    function offsetSet($offset, $value){
        throw new Exception("not write");
    }

    /** @param $offset to retrieve
     * @return value at given offset
     */
    function offsetGet($offset) {  //  注意这里叫key 更加合适  就是一个配置的文件名；//配置名字；
        if (!isset($this->config[$offset])) {
            $file_path = $this->path.'/'.$offset.'.php';
            //注意 这里引过来 也是一个局部变量，运行结束之后也会销毁；require  和 include  引入外部文件；
            $config = require $file_path;
            $this->config[$offset] = $config;
        }
        return $this->config[$offset];
    }

    /** @param $offset to delete
     */
    function offsetUnset($offset) {
        throw new Exception("not delete");
    }

    /** @param $offset to check
     * @return whether the offset exists.
     */
    function offsetExists($offset) {

        return isset($this->config[$offset]);
    }

}
//绝对路径
$path = __DIR__.'/config';  //  /datadisk/website/Project/DesignPatterns/Config

//echo $path;
$config = new Config($path);
//array(1) {
//  'home' =>
//  array(1) {
//    'decorator' =>
//    array(1) {
//      [0] =>
//      string(6) "映射"
//    }
//  }
//}
//var_dump($config['Controller']);die;
var_dump($config['Database']);
echo $config['Database']['user'];
//
//$obj = new SplStack();  // ArrayAcess  Countable Iterator  // 这几个对象的操作接口注意一下；
//interface Countable {
//
//    /**
//     * Count elements of an object
//     * @link http://php.net/manual/en/countable.count.php
//     * @return int The custom count as an integer.
//     * </p>
//     * <p>
//     * The return value is cast to an integer.
//     * @since 5.1.0
//     */
//    public function count();
//}

class A implements Countable
{
    public $data;
    public function __construct(Array $arr) {
        $this->data = $arr;
    }

    public function count() {
        return count($this->data);
    }
}
$arr = [1,23,4];
$a = new A($arr);
echo count($a);// 11

