# 代理者模式

>让你能提供真实服务对象的替代品给客户端使用；
>
> 不需要去修改客户端代码的前提下，对已有类的对象上添加额外的行为；
>
>主要分为  realsubject        proxy    用户  三部分；

用户去访问代理者；珍重的用户需要去操作；proxy会有额外的行为操作；

````php
// 主体
interface Subject
{
    public function request();
}
//real客户端
class RealSubject implements Subject
{
    public function request();
}

//代理  需要继承 需要实现subject
class Proxy implements Subject
{
    private $realSubject;
    
    public function __construct(RealSubject $realSubject){
        $this->realSubject = $realSubject;
    }
    public function request(){
        if ($this->checkAcess()) {
            $this->realSubject->request();
            $this->logAcess();
        }
    }
    public function checkAcess(){
        return true;
    }
    public function logAcess() {
        echo 'log';
    }
}

//client
$proxy = new Subject(new RealSubject);
$proxy->request();
````



