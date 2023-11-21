<?php
/**
 * Class Log
 * 抽象方法中不能使用 静态方法吧
 *
 * 模板方法模式是一种行为设计模式， 它在超类中定义了一个算法的框架， 允许子类在不修改结构的情况下重写算法的特定步骤。
 */
//
abstract class Log
{
    public  function run(){
        $this->step1();
        $this->step2();
        $this->step3();
        $this->step4();
        $this->step5();
    }
    //step 1
    public  function step1(){
      echo __METHOD__;// === get_class ;
        echo get_called_class();  //Log::step1InstanceLog
        echo get_class();
        echo "\n";
      echo "\n";
   }
   // step 2
    abstract  public function step2();
  //step 3
    public  function step3(){
       echo __METHOD__;
        echo "\n";
    }
    //step 4
    abstract public function step4();

   public function step5(){
       echo __METHOD__;
       echo "\n";
   }
}


class Instance extends Log
{
   public  function step2() {
       //Instance::step2InstanceInstance
       echo __METHOD__;
       echo get_called_class();
       echo get_class();
       echo "\n";
   }
   public function step4() {
       echo __METHOD__;
       echo "\n";
   }
}

$obj = new Instance();
$obj->run();