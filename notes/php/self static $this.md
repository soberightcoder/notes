# self static \$this



静态的运行时绑定



**self引用的是当前类，[static](https://so.csdn.net/so/search?q=static&spm=1001.2101.3001.7020)允许函数调用在运行时绑定调用类**



**一个是绑定当前类  ，一个是绑定调用类**



<font color=red>**\$this 是绑定调用对象；静态方法中不能有$this,也只能调用静态类和静态属性，因为只有静态属性申请了内存！！！**</font> 



```php
class CeshiA
{
    public static function ceshi() {
        static::ceshi1();
    }

    public static function ceshi1() {
        echo "i m ceshia";
    }
}
class CeshiB extends CeshiA
{
    public static function ceshi1() {
        echo "i m ceshib";
    }
}
CeshiA::ceshi();
echo "\n";
CeshiB::ceshi();
echo "\n";


class CeshiE
{
    public static function ceshi() {
        self::ceshi1();
    }

    public static function ceshi1() {
        echo "i m ceshie";
    }
}

class CeshiF extends CeshiE
{
    public static function ceshi1() {
        echo "i m ceshif";
    }
}
CeshiF::ceshi();
echo "\n";
CeshiE::ceshi();


class CeshiC
{
    public function ceshi() {
        $this->ceshi1();
        echo "\n";
        echo get_class();   //CeshiC
        echo "\n";
        echo get_called_class(); //CeshiD  调用的；
    }

    public function ceshi1() {
        echo "i m ceshic";
    }

}

class CeshiD extends CeshiC
{
    public function ceshi1() {
        echo "i m ceshid";
    }
}

echo "\n";
$ceshic = new ceshiC;
$ceshic->ceshi();
echo "\n";
$ceshid = new CeshiD;
$ceshid->ceshi();

```





```php
/**
 * get_called_class 和 sttic的恩怨情仇
 */

class A
{
    public function ceshi() {
        echo static::class; //类名
        var_dump(new static); // 对象
        echo get_called_class();
    }
}
class B extends A
{

}
$b = new B;
$b->ceshi();

//static::class == get_called_class(); 
// 在对象中是可以访问到静态变量的很合理；；
//注意：在静态方法中不能访问非静态变量；因为非静态变量还没有开辟内存区保存这个变量；静态变量在在代码的加载的时候已经开辟内存保存了静态变量；
```

**非静态的运行时候绑定对象；**

\$this



**简单来说，就是使用self返回的值一直是初始类，而static的继承类返回的值是离它最近的类内部的数据。**



举个例子：

**这两个案例仅仅是为了重写之后调用父类的方法或者是调用本身类的方法；**

**self是一个只认爸妈的小孩，而static是谁带着它就认谁的小孩**

**get_class();也是一个只认识爸妈的小孩，但是get_called_class(); 是一个谁带他就认谁的小孩；**只认识爸爸的小孩；

**\$this->肯定是调用对象；谁调用那么就属于那个对象**也是谁带他他就认谁 ！！！



```php
echo get_called_class();  //Log::step1InstanceLog  // 谁调用那么就是谁； static::class
echo get_class();  //获取对象的名字；只认识 父类；//只认识父类； == self::class
```



## 注意

`````php
// zan'ye
self static //表示的是类；  所以可以new self; new static;  可以直接实例化！！！！
    
self::class static::class //表示的是类名； 
//get_class();  and get_called_class 是类名；但是可以通过下面的方式来做实例化！！！
    

/**
 * get_class  get_called_class(); 是类还是类名？？？
 * 
 */
echo "\n";
class FUNC_TEST1
{
    public function main() {
        echo get_class();//
        // $cname =  get_class();
        $cname = self::class;
        $obj = new $cname;
        $obj->test();
        echo "\n";
        echo get_called_class();
    }
    public function test() {
        echo "func test1";
    }
}

class FUNC_SON extends FUNC_TEST1
{

}

$son = new FUNC_SON();
$son->main();


`````

