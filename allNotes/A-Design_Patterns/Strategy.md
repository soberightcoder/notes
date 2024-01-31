# Strategy  策略  [ˈstrætədʒi]

>不同行为的具体实现，并且行为可以相互替换；

一般做if else ifelse if else if else  这样场景的简化；使用策略模式 + 容器模式（特殊的工厂）；

`````php
# 不同的邮费的计算；
interface Istrategy
{
    public function calulate();
}

class ZH_fee implements Istrategy
{
    public function calulate(){
        echo "zh_fee 15";
    }
}

class US_fee implements Istrategy
{
    public function calulate(){
        echo "us_fee";
    }
}

class ZH_remote_fee implements Istrategy
{
    public function calulate(){
        echo "zh_remote_fee";
    }
}

class Client
{
    public function fee(Istrategy $strategy){
        $strategy->calulate();
	}
}
//
$client = new Client();
$client->fee(new US_fee);
`````

