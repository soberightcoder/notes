# 抽象工厂

>一个生产工厂的工厂；
>
>添加产品族不满足 开闭原则； 需要取修改抽象工厂；扩展
>
>添加工厂满足开闭原则；工厂（一个产品的集合；）

````` php
#工厂 qiniu  aliyun tencentyun  
#产品族 视频  图片  短视频

//vedio
interface Ivedio
{
    public function up();
    public function down();
    public function fee();
}

//qiniu
class qiniuvedio implements Ivedio
{
    public function up(){
        echo 'slow';
    }
    public function down(){
        echo 'slow';
	}
    public function fee(){
        echo "0";
    }
}
//aliyun

class Aliyunvedio implements Ivedio
{
    public function up(){
        echo 'middle';
    }
    public function down(){
        echo 'middle';
	}
    public function fee(){
        echo "2";
    }
}

//tencentyun
class Tencentyunvedio implements Ivedio
{
    public function up(){
        echo 'hign';
    }
    public function down(){
        echo 'hign';
	}
    public function fee(){
        echo "10";
    }
}

//图片；
interface Ipic
{
    public function up();
    public function down();
}


class qiniupic implements Ipic
{
    public function up(){
        echo "slow";
    }
    public function down(){
        echo "slow";
    }
}



//抽象工厂的抽象；
interface AbstractFactory
{
   	public function VedioFactory();
    public function shortFactory();
    public function picFactory();
}

class QiniuFactory
{
    
   	public function VedioFactory(){
     	return new   qiniuvedio;
    }
    public function shortFactory(){
        return new qiniushortvedio;
    }
    public function picFactory(){
        return new qiniupic;
    }
}
//client;
class Client
{
    public function gen(AbstractFactory $factory,$type){
        //
        $factory->vedioFactory;
        $factory->shortFactory;
        $factory->picFactory;
        
    }
}



`````

