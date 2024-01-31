# Cor

>每一个处理者 都去处理请求；

chain of reponsibility 责任链

laravel 得中间件操作；

每一个处理者（中间件）都要对请求处理；

还比如 请假流程，我们需要得到一级级得审批，必须全部满足才能请假下来；



````php
# 这个是关键
abstract Processor{
	protected $next;
    
    public function setNext(Processor $next){
        $this->next = $next;
        return $next;
    }
    //
    abstract public function handle();
}

class ProcessorA extends Processor
{
    public function handle(){
        echo "process a doing";
        if ($this->next) {
            $this->next->handle();
		}
        // 
		return null;
    }
}


class ProcessorB extends Processor
{
    public function handle(){
        echo "process a doing";
        if ($this->next) {
            $this->next->handle();
		}
        // 
		return null;
    }
}

class ProcessorC extends Processor
{
    public function handle(){
        echo "process a doing";
        if ($this->next) {
            $this->next->handle();
		}
        // 
		return null;
    }
}

$process = new ProcessorA;

$process->setNext(new ProcessorB)->setNext(new ProcessorC);

$process->handle();
````

