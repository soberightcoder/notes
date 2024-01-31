# 状态设计模式



状态的转换；状态机；

状态模式 ；可以内部转换；

可以设置初始的状态；



``````php
# 语境 上下文；环境；
class Context
{
    private $state;
    
    public function __construct(State $state){
        $this->tansfer($state);
    }
    # 转换状态；
    public function transfer(State $state) {
        $this->state = $state;
        //把权限给 State 状态；
        
        $this->state->setContext($this);
    }
    public function request1(){
        $this->state->request1();
    }
    public function request2(){
        $this->state->request2();
    }
}

#好好看一下这个；
abstract State
{
    private $context;
    public function setContext(Context $context) {
        // 接收Context；上下文；
        $this->context = $context;
    }
    abstract public function request1();
    abstract public function request2();
}

class State1 extends State
{
    public function request1(){
        echo "state1 request1";
        $this->context->transfer(new State2);
    }
    public function request2(){
        echo "state1 request2";
    }
}

class State2 extends State
{
     public function request1(){
        echo "state1 request1";
      
    }
    public function request2(){
        echo "state1 request2";
        $this->context->transfer(new State1);
    }
}

#可以设置初始状态
$context = new Context(new State1);
$context->transfer(new State2);
$context->request2();

//stateA---->request1----->State2
//   |                        |
//request2                  request1
//   |                        |
// stateA<---request2<------State2

``````





