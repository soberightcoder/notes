<?php

/**
 * Created By PhpStorm
 * User Leaveone
 * Date 2022/7/10
 * Time 12:40
 */

/**
 * 状态设计模式
 * 状态模式是一种行为设计模式， 让你能在一个对象的内部状态变化时改变其行为， 使其看上去就像改变了自身所属的类一样。
 * 注意和策略设计模式的区别；
 * 策略是外界给的，策略怎么变，是调用者考虑的事情，系统只是根据所给的策略做事情。
 * 状态是系统自身的固有的，由系统本身控制，调用者不能直接指定或改变系统的状态转移。
 * 状态模式是策略模式的孪生兄弟，是因为它们的UML图是一样的。
 * 但意图却完全不一样，策略模式是让用户指定更换的策略算法，而状态模式是状态在满足一定条件下的自动更换，用户无法指定状态，最多只能设置初始状态。
 */

/**
 * 注意一下状态机；  其实完全可以实现一个状态机的；
 */
/**
 * 根据不同的状态展示不同的行为；
 * 首先行为肯定是有限的；也就是request也就是有限制；
 * 状态如果是可变的；当我们的状态发生改变的时候行为也就会发生改变；
 * ****************区别就这两个
 * 状态的改变也可以发生在内部（或者某些行为之后状态发生改变；），也可以发生在外部；策略模式只能是客户端指定的(外部指定)；
 * 状态模式关注于状态的不同行为的不同，而策略更加关注于行为的具体实现；
 */
/**
 * ***********************这几点很重要 需要自己去理解一下；************************
 * 状态设计模式和 策略设计模式去的区别 就是
 *  状态是干不同的任务进而实现不同的状态的转换；
 *  策略是相同的任务，并且不同的策略的算法可以相互替换；
 * // 几个状态的转换一般是往前走的，不能往回退；或者 结束回到起始状态；如果不是这样那么将会有很多的request 来解决这样的问题；
    // 复杂性会变的很麻烦；
 */
function set_handle_func(Exception $e){
    echo "message:".$e->getMessage()."----code:".$e->getCode()."----line:".$e->getLine();
}
set_exception_handler('set_handle_func');

/**
 * Class Context
 * 状态模式 对状态的添加是满足开闭原则的
 * 但是对行为的添加是不满足开闭原则的；
 *
 * 对于行为的添加扩展的话 需要用 策略模式
 */

/**
 * Class Context
 * Context 上下文 其实就是状态的上下文切换； 装欢状态；
 */
class Context
{
    public $state; //仅仅是方便查看 测试  一般用protected
    // 外部改变
    public function __construct(State $state) {
        $this->transin($state);
    }
    //内部改变状态；
    public function transin(State $state) {
        echo "Context: Transition to " . get_class($state) . ".\n";
        $this->state = $state;
        $this->state->setContext($this);// 把可以转换状态的权限 授权给 State类；
    }
    // 只有一个request 更加会清晰一些；
    public function request1() {
        $this->state->handle1();
    }

    public function request2() {
        $this->state->handle2();
    }

    public function request3() {
        $this->state->handle3();
    }

}


abstract class State
{
    protected $context;
    // 设置 上下文转换的Context对象；//  对象里面也有 转换状态的对象， $this->contxt;  //$this 有$  后面就不需要了；
    public function setContext(Context $context) {
        $this->context = $context;
    }
    abstract public function handle1();

    abstract public function handle2();

    abstract public function handle3();
}

class HappyState extends State
{
    // 单向的只需要一个方法就行了，平常我们使用的 待付款，代发货，待收货，待评价，售后/退款；
    public function handle1(){
        //这里就是要写一些具体的操作然后转换成别的状态；
        echo "happy work\n";
        // 某中行为之后改变状态；
        $this->context->transin(new nohappy());
    }

    public function handle2() {
        echo "happy eat\n";
    }

    public function handle3() {
        echo "happy play\n";
    }
}

class nohappy extends State
{
    public function handle1() {
        echo "no happy work\n";
    }

    public function handle2() {
        echo "no happy eat\n";
        // 内部转换状态；
        $this->context->transin(new HappyState());
    }
    public function handle3(){
        throw new Exception('nohappy no this method',111);
    }
}

$obj = new Context(new HappyState()); // 定义初始状态的过程；

$obj->request1(); // 发生了动作 所以不开心了 work  工作了 就不开心了；
$obj->request3();
//$obj->request2();


//stateA---->request1----->State2
//   |                        |
//request2                  request1
//   |                        |
// stateA<---request2<------State2
