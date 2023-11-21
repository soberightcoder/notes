<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/12/8
 * Time 21:39
 */

/**
 * ORM 数据对象映射关系；
 * 对象和数据存储的映射的关系；
 * Class User
 * 数据对象映射模式
 *
 */


class User
{
    public $id;
    public $name;
    public $mobile;
    public $age;

    public function __construct($id) {
        $db = new mysqli();
        $db->connect('127.0.0.1','root','test');
        $res = $this->db->query("select * from user where id = {$id}");
        $data = $res->fetch_assoc();
        // 读数据 ，直接可以通过  属性来
        $this->id = $data[$id];
        $this->name = $data[$name];
        $this->mobile = $data[$mobile];
        $this->age = $data[$age];
    }

    public function __destruct() {
        // TODO: Implement __destruct() method.
        // update  跟新操作，会把属性的值存储到数据库；
        // $db->query(update 操作);
    }
}


class A
{
    public function index($id) {
//        $res = new User($id);
        $res = Factory::getUserObj(1);
        $res->name = 'shuaibq';
        $this->main($id);
    }

    public function main($id) {
//       $res = new User($id);
        $res = Factory::getUserObj(1);
        $res->age = 19;
    }
}
$aobj = new A;
$aobj->index(1);
// 当运行完的时候会保存  age = 19 and name = shuaibq


class Factory
{
    public static $container;

    //工厂   +   注册器；
    public static function getUserObj($id) {
//        return new User($id); // 这种方式创建了 多个资源；
        $key = 'user_'.$id;
        $user = Regisiter::get($key);
        // 每次都是用一个对象；节约相同类型对象的资源；节约内存；
        if (!$user) {
            $user = Regisiter::set($key,new User($id));
        }
        return $user;
    }
}


class Register
{
    protected static $container;

    public static function set($alias,$obj) {
        self::$container[$alias] = $obj;
    }

    public static function get($alias) {
        return self::$container[$alias];
    }
}
