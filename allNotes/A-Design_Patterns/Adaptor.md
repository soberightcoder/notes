# 适配器模式

>解决接口不兼容的问题；
>
>主要分为两部分：需要去适配的对象，适配器；



`````php
//所有的适配器的抽象；
interface Target 
{
	public function handle();
}
#json的适配器
class JsonAdaptor implements Target
{
    public $adaptee;
    #组合的适配器
    public function __construct($adaptee) {
        $this->adaptee = $adaptee;
    }
    public function handle() {
        $data = $this->adaptee->do();
        echo "transfer  data".$date."to json";
    }
}
//adaptee  被适配者
//需要去适配的
class AdapteeA
{
    public function do(){
        echo "return xml data";
    }
}

//需要去做适配的；
class AdapteeB
{
    public function do(){
        echo "return xml data";
    }
}

$adaptor = JsonAdaptor(new AdapteeA);
$adaptor->handle();
//结果就是json数据


`````



