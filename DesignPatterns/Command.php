<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/8/16
 * Time ${Time}
 */
/**
 * 命令设计模式
 * 实现 命令的执行者  和 接收者 做一个解耦；
 * 分为三个部分 菜单（命令）  服务员   厨师（命令的执行者）
 *  这里可以实现多个命令 多个接收者   多个执行者
 */

/**
 * Class Invoke
 * 命令的 传递着 或者接收者；
 * 会有明确的命令执行的内容；
 */

class Invoke
{
    public $command;
    public function __construct(Command $command) {
        $this->command = $command;
    }

    public function exec(){
        $this->command->execute();
    }
}

/**
 * Class Command
 * 需要明确给那个 执行者 执行
 */
abstract class Command
{
    public $receive;
    public function __construct(Receive $receive) {
        $this->receive = $receive;
    }
    abstract public function execute();
}

class Command1 extends Command
{
    public function execute() {
        // TODO: Implement execute() method.
        $this->receive->action();
    }
}

/**
 * Class Receive
 * 执行者
 */
class Receive
{
    public $name;
    public function __construct($name) {
        $this->name = $name;
    }

    public function action() {
        echo $this->name.'execute';
    }
}

$receive = new Receive('qq');
$invoke = new Invoke(new Command1($receive));

$invoke->exec();