# Observer 观察者模式

>事件订阅模式；监听listen模式；
>
> 分为两部分：被观察者，和观察者；被观察者状态发生改变；回去通知观察者；

````php
class Subject implements SplSubject
{
    public $state;
    protected $observers;
    public function __construct(){
        //存储对象类，实现了，这些接口；Iterator Countable arrayAccess Seriables;
        $this->observers = new SplObjectStorage();
    }
    public function attach(SplObserver $observer){
        $this->observers->attach($observer);
    }
    public function detach(Splobeserver $observer) {
        $this->observers->detach($observer);
    }
    public function notify(){
        foreach($this->observers as $observer) {
        	$observer->update($this);
        }
    }
}

//SplObserver  观察者的接口
class ObserverA implements SplObserver
{
    public function update(SplSubject $subject){
        if ($subject->state > 3) {
            echo " i see state lt 3";
        }
    }
}

class ObserverA implements SplObserver
{
    public function update(SplSubject $subject){
        if ($subject->state <=3 ) {
            echo " i see state lt 3";
        }
    }
}
$subject = new Subject();
$subject->attach(new ObserverA;
$subject->attach(new ObserverB);
 
$subject->state = 4;
$subject->notify();

````

