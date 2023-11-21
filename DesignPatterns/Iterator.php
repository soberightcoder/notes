<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/7/18
 * Time ${Time}
 */
/**
 *  迭代器设计模式
 *  遍历集合中的所有的元素
 * 由于 PHP 已有内置的迭代器接口并能方便地与 foreach 循环整合， 因此你很轻松就能为任何数据结构创建你自己的迭代器。
 * 对对象的遍历其实就是用到了迭代器；
 * 遍历对象中的那个数据 需要 我们自己去控制；迭代器接口是怎么实现的；
 */

class MyIterator implements Iterator
{

    public $position = 0;// pos //记录下位置和data  直接写就行；
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function current() {
        //需要去输出
        return $this->data[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        return isset($this->data[$this->position]);
    }
}
$arr = [1,2,3,55,6,'a'];
$obj = new MyIterator($arr);

foreach ($obj as $item) {
    echo $item."\n";
}

//
//while ($obj->valid()) {
//    echo $obj->current()."\n";
//    $obj->next();
//}
// 对对象一些私有属性的数据的遍历；


//$ceshi = new Ceshi();
//