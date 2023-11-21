<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/7/14
 * Time ${Time}
 */
/**
 * 责任链设计模式
 * Chain of Responsibility
 * 比如一个请求   所有的  处理者 都会去处理这个请求,并且可以传递给链上的下一个处理者；
 *
 * eg:处理请求实例呀，或者申请请假的一个实例，或者linux的管道都会用到这部分代码；或者laravel的中间件也是用的责任链；
 */

/**
 * Class Processor
 * 责任链模式
 */

abstract class Processor
{
    protected $next;
//  设置处理流程；请求的处理流程；
    public function setNext(Processor $processor) {
        $this->next = $processor;
        return $processor;
    }
    // 处理
    abstract public function handle();
}

class ProcessorA extends Processor
{
    public function handle() {
        echo "i deal this request by ProcessA\n";
        if ($this->next){
            $this->next->handle();
        }
        return null;
    }
}

class ProcessorB extends Processor
{
    public function handle() {
        echo "i deal this request by ProcessorB\n";
        if ($this->next){
            $this->next->handle();
        }
        return null;
    }
}

class ProcessorC extends Processor
{
    public function handle() {
        echo "i deal this request by ProcessorC\n";
        if ($this->next){
            $this->next->handle();
        }
        return null;
    }
}

function client(Processor $processor){

    $processor->handle();
}


$processa = new ProcessorA;
// 责任链操作；
$processa->setNext(new ProcessorB())->setNext(new ProcessorC());

var_dump(client($processa));die;


