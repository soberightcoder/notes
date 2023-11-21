<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/7/15
 * Time ${Time}
 */
/**
 *  观察者模式  又叫监听模式 listen  事件订阅模式；
 *  ****** 定义一种 一对多得依赖关系，当一个对象发生改变得时候，所有依赖于它的对象都会得到通知并且改变；
 *  观察者模式是一种行为设计模式， 允许你定义一种订阅机制， 可在对象事件发生时通知多个 “观察” 该对象的其他对象。
 * 观察者是一种行为设计模式， 允许一个对象将其状态的改变通知其他对象
 */

/**
 * Interface spl
 *  * @link http://php.net/manual/en/class.splsubject.php
 *
 *     interface SplSubject
 *     {
 *         // Attach an observer to the subject.
 *         public function attach(SplObserver $observer);
 *
 *         // Detach an observer from the subject.
 *         public function detach(SplObserver $observer);
 *
 *         // Notify all observers about an event.
 *         public function notify();
 *     }
 *
 * There's also a built-in interface for Observers:
 *
 * @link http://php.net/manual/en/class.splobserver.php
 *
 *     interface SplObserver
 *     {
 *         public function update(SplSubject $subject);
 *     }
 *
 */

//The SplObjectStorage class provides a map from objects to data 对象存储类
// 了解一下
//class A
//{
//    public $name = "A";
//}
//
//class B
//{
//    public $name = "B";
//}
//$store = new SplObjectStorage();
//$store->attach(new A);
//$store->attach(new B);
//// 类是可以遍历得；
//foreach ($store as $item) {
//    var_dump($item);
//}
//var_dump($store);die;

/**
 * Class Subject
 * subject  主题；
 * 被观察者；
 */
class Subject implements SplSubject
{
    public $state; // 类外 也要被保存；

    public $observers;

    public function __construct() {
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer) {
        // TODO: Implement attach() method.
        $this->observers->attach($observer);
    }
    public function detach(SplObserver $observer) {
        // TODO: Implement detach() method.
        $this->observers->detach($observer);
    }
    public function notify() {
        // TODO: Implement notify() method.
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
    public function someBusinessLogic(): void
    {
        echo "\nSubject: I'm doing something important.\n";
        $this->state = rand(0, 10);

        echo "Subject: My state has just changed to: {$this->state}\n";
        $this->notify();
    }
    // 获取存储对象的序列化
    public function seriable(){
        return $this->observers->serialize();
    }

    public function unseriable() {
        return $this->observers->unserialize($this->observers->serialize());
    }
}

/**
 * Class Subject1
 * 观察者；  类的名字 修改陈observe 会更好一些；observer  观察者；
 */
class Subject1 implements SplObserver
{
    public function update(SplSubject $subject) {
        // TODO: Implement update() method.
        if ($subject->state < 3) {
            echo "ConcreteObserverA: Reacted to the event.\n";
        }
    }
}

class subject2 implements SplObserver
{
    public function update(SplSubject $subject) {
        // TODO: Implement update() method.
        if ($subject->state == 0 || $subject->state >= 2) {
            echo "ConcreteObserverB: Reacted to the event.\n";
        }
    }
}


$subject = new Subject();
$subject->attach(new Subject1());
$subject->attach(new Subject2());
//var_dump($subject->observers);

echo $subject->seriable();
echo "\n";
var_dump($subject->unseriable());
die;

//$subject->someBusinessLogi();
$subject->state = 2; //状态改变去通知订阅者，也就是观察者；
$subject->notify();