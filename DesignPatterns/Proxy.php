<?php
/**
 * Create by PhpStorm
 * User Leaveone
 * Data 2022/7/13
 * Time ${Time}
 */
/**
 * 代理设计模式
 * 中介 正向代理
 * //分为四部分
 *
 *  客户
 *
 *  代理
 *  真正的subject 主题
 *  subject的代理  真正的代理
 * 主体
 *
 */

abstract class Rent
{
    abstract public function handle();
}

class Realhost extends Rent
{
    public function handle() {
        echo "realhost rent house";
    }
}

class Proxy extends Rent
{
    private $realSubject;
    //组合 has 功能； // rent  的权限在于realhost 所以要给予权限；
    public function __construct(Rent $subject) {
        $this->realSubject = $subject;
    }

    public function handle() {

        if ($this->lookAtTheHouse()) {
            $this->payBrokerageFee();
            // 租房子了；
            $this->realSubject->handle();
        }
    }

    public function lookAtTheHouse() {
        echo "house is good----";
        return true;
    }

    public function payBrokerageFee() {
         echo "pay 中介费---";
    }
}




function client(Rent $subject){

    $subject->handle();
}
//直接找房东
$realHost = new Realhost();
client($realHost);

echo "\n";
// 找中介；
$proxy = new Proxy($realHost);
client($proxy);
