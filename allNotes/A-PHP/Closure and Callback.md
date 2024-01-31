# Closure callable

>Closure 代表的是一个匿名函数，传递参数的时候使用的是
>
>``````php
>$c = fucntion() {
>    echo "sss";
>}
>main($c);
>
>``````
>
>callable 代表的是回调函数；
>
>给一个函数传递函数这个参数的时候可以使用这个callable
>
>``````php
>function f() {
>    echo "ff";
>}
>main("f"); 
>#closure  and callable //传递参数的方式是不一样的！！！
>``````
>

---

## 详细解释

>**闭包用于捕获作用域！！！**
>
>

**回调（callback）和闭包（closure）在PHP中是两个不同的概念。**

回调是指将函数作为参数传递给其他函数，以便在适当的时候调用该函数。**在PHP中，回调通常以字符串形式表示函数名，也可以使用数组表示类方法的回调。回调函数可以用于事件处理、排序、过滤等场景。**



**闭包是匿名函数的实例，它可以捕获其定义时的作用域。闭包可以在定义它们的作用域之外被调用，并且可以访问其定义时的作用域中的变量。闭包在PHP中通常使用`function() { }`语法来创建。**

因此，回调是指向函数的引用，而闭包是一个可以在定义时捕获作用域的匿名函数。回调通常用于传递函数引用，而闭包通常用于创建匿名函数并捕获作用域。

---

## 闭包和匿名函数的区别？？ 肯定是相关联的；

闭包是指一个函数，它可以在定义时捕获其所在作用域的变量，并且可以在定义之外的地方被调用。当我们说闭包是匿名函数的实例时，意味着闭包是通过匿名函数创建的，而不是通过具名函数。在PHP中，使用`function() { }`语法可以创建匿名函数，这些匿名函数可以被赋值给变量，作为参数传递给其他函数，或者直接调用。

因此，闭包是匿名函数的实例意味着闭包是通过匿名函数的方式创建的，它可以捕获其定义时的作用域，并且可以在定义之外的地方被调用。

**换一个思路思考闭包：因为局部变量，运行完函数会被销毁，如果你想要保存局部变量那么就可以使用闭包；**



---



denote //表示；

Callbacks can be denoted by the [callable](https://www.php.net/manual/en/language.types.callable.php) type declaration.

Some functions like [call_user_func()](https://www.php.net/manual/en/function.call-user-func.php) or [usort()](https://www.php.net/manual/en/function.usort.php) accept user-defined callback functions as a parameter. Callback functions can not only be simple functions, but also object methods, including static class methods.

### Passing[ ¶](https://www.php.net/manual/en/language.types.callable.php#language.types.callable.passing)

php 函数可以通过字符串来传递的；类似于c的函数指针来传递代码块；

**A PHP function is passed by its name as a string.** Any built-in or user-defined function can be used, except language constructs such as: [array()](https://www.php.net/manual/en/function.array.php), [echo](https://www.php.net/manual/en/function.echo.php), [empty()](https://www.php.net/manual/en/function.empty.php), [eval()](https://www.php.net/manual/en/function.eval.php), [exit()](https://www.php.net/manual/en/function.exit.php), [isset()](https://www.php.net/manual/en/function.isset.php), [list()](https://www.php.net/manual/en/function.list.php), [print](https://www.php.net/manual/en/function.print.php) or [unset()](https://www.php.net/manual/en/function.unset.php).





**//  callable 代表的是传递的参数 是一个代码块；就是传递的参数是一个函数；php可以通过 函数名字的字符串来传递；**



//closure  代表的是匿名函数；











## [PHP Closure(闭包)类详解](https://www.cnblogs.com/echojson/p/10957362.html)

#  Closure

面向对象变成语言代码的复用主要采用继承来实现，而函数的复用，就是通过闭包来实现。这就是闭包的设计初衷。

 

**注：**PHP里面闭包函数是为了复用函数而设计的语言特性，如果在闭包函数里面访问指定域的变量，使用use关键字来实现。

 

**PHP具有面向函数的编程特性，但是也是面向对象编程语言，PHP 会自动把闭包函数转换成内置类 Closure 的对象实例**，依赖Closure 的对象实例又给闭包函数添加了更多的能力。 

 

闭包不能被实例(私有构造函数)，也不能被继承(finally 类)。可以通过反射来判断闭包实例是否能被实例，继承。

 

## 匿名函数

匿名函数，是php5.3的时候引入的,又称为Anonymous functions。字面意思也就是没有定义名字的函数。


提到闭包就不得不想起匿名函数，也叫闭包函数（closures），貌似PHP闭包实现主要就是靠它。声明一个匿名函数是这样：

 

```
$say` `= ``function``() {``　　``return` `'我是匿名函数'``;``}; ``//带结束符<br><br>echo $say(); //这是最直接调用匿名函数方式<br><br>function test(Closure $callback){ <br>　　return $callback(); <br>} <br><br>echo test($say); //这是间接调用匿名函数方式<br><br>
```

 当然也可以这样写 :
 echo test( function() {
　　return '我是匿名函数';
 });

　　

可以看到，匿名函数因为没有名字，如果要使用它，需要将其返回给一个变量。匿名函数也像普通函数一样可以声明参数，调用方法也相同：

```
$func` `= ``function``( ``$param` `) {``  ``echo` `$param``;``};``$func``( ``'some string'` `);` `//输出：``//some string
```

　　

顺便提一下，PHP在引入闭包之前，也有一个可以创建匿名函数的函数：create function，但是代码逻辑只能写成字符串，这样看起来很晦涩并且不好维护，所以很少有人用。

 

## 实现闭包


将匿名函数在普通函数中当做参数传入，也可以在函数中被返回。这就实现了一个简单的闭包。

 

**连接闭包和外界变量的关键字：USE**


PHP在默认情况下，匿名函数不能调用所在代码块的上下文变量，而需要通过使用use关键字。

```
function` `getMoney() {``  ``$rmb` `= 1;``  ``$func` `= ``function``() ``use` `( ``$rmb` `) {``    ``echo` `$rmb``;``    ``//把$rmb的值加1``    ``$rmb``++;``  ``};``  ``$func``();``  ``echo` `$rmb``; ``//闭包内的变量改变了，但是闭包外没有改变。``}``getMoney();` `//输出：``//1``//1
```

 

在上面我们看见匿名函数不能改变上下文的变量，是因为use所引用的也只不过是变量的一个副本clone而已（非完全引用变量本身）。

如果我们想在匿名函数中改变上下文的变量呢？想要完全引用变量，而不是复制呢?要达到这种效果，在变量前加一个 & 符号即可。

 

```
function` `getMoney() {``  ``$rmb` `= 1;``  ``$func` `= ``function``() ``use` `( &``$rmb` `) {``    ``echo` `$rmb``;``    ``//把$rmb的值加1``    ``$rmb``++;``  ``};``  ``$func``();``  ``echo` `$rmb``;``}``getMoney();` `//输出：``//1``//2
```

　

好，这样匿名函数就可以引用上下文的变量了。如果将匿名函数返回给外界，匿名函数会保存use所引用的变量，而外界则不能得到这些变量，这样形成‘闭包’这个概念可能会更清晰一些。

根据描述我们再改变一下上面的例子：

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
function getMoneyFunc() {
    $rmb = 1;
    $func = function() use ( &$rmb ) {
        echo $rmb.'<br>';
        //把$rmb的值加1
        $rmb++;
    };
    return $func;
}

$getMoney = getMoneyFunc(); //匿名函数返回给外界,保存了$rmb的变量
$getMoney();
$getMoney();
$getMoney();

//输出：
//1
//2
//3从例子中理解“将匿名函数返回给外界，匿名函数会保存use所引用的变量，而外界则不能得到这些变量”，将匿名函数返回给外界后，$rmb这个引用变量就被保存了，提升成了全局变量(全局变量，类似静态变量)，而后面每次再调用匿名函数，传入的都是这个保存后的值
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

 

 

### 总结：

**闭包函数不能直接访问闭包外的变量，而是通过use 关键字来调用上下文变量(闭包外的变量)，也就是说通过use来引用上下文的变量；**

**闭包内所引用的变量不能被外部所访问(即，内部对变量的修改，外部不受影响)，若想要在闭包内对变量的改变从而影响到上下文变量的值，需要使用&的引用传参。**

>  ***\*use所引用的是变量的复制(副本而），并不是完全引用变量。如果要达到引用的效果，就需要使用 & 符号，进行引用传递参数；\****

---



如果我们要调用一个类里面的匿名函数呢？直接上demo

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
<?php
class A {
    public static function testA() {
        return function($i) { //返回匿名函数
            return $i+100;
        };
    }
}

function B(Closure $callback)
{
    return $callback(200);
}

$a = B(A::testA());
print_r($a);//输出 300
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

其中的A::testA()返回的就是一个无名funciton。

 

## 绑定的概念

**上面的例子的Closure只是全局的的匿名函数，好了，那我们现在想指定一个类有一个匿名函数。也可以理解说，这个匿名函数的访问范围不再是全局的了，而是一个类的访问范围。**

那么我们就需要将“一个匿名函数绑定到一个类中”。

 

PHP Closure 类是用于代表匿名函数的类，匿名函数（在 PHP 5.3 中被引入）会产生这个类型的对象，Closure类摘要如下：

```
Closure {``  ``__construct ( void )``  ``public` `static` `Closure bind (Closure ``$closure` `, object ``$newthis` `[, mixed ``$newscope` `= ``'static'` `])``  ``public` `Closure bindTo (object ``$newthis` `[, mixed ``$newscope` `= ``'static'` `])``}
```

 

参数说明：

**closure**
需要绑定的匿名函数。

**newthis**
需要绑定到匿名函数的对象，或者 NULL 创建未绑定的闭包。

**newscope**
想要绑定给闭包的类作用域，或者 'static' 表示不改变。如果传入一个对象，则使用这个对象的类型名。 类作用域用来决定在闭包中 $this 对象的 私有、保护方法 的可见性。（备注：可以传入类名或类的实例，默认值是 'static'， 表示不改变。）

**返回值**：
返回一个新的 Closure 对象 或者在失败时返回 FALSE

 

方法说明：

> 　
>
> ```
> Closure::__construct — 用于禁止实例化的构造函数``Closure::bind — 复制一个闭包，绑定指定的``$this``对象和类作用域。``Closure::bindTo — 复制当前闭包对象，绑定指定的``$this``对象和类作用域。
> ```

除了此处列出的方法，还有一个 __invoke 方法。这是为了与其他实现了 __invoke()魔术方法 的对象保持一致性，但调用闭包对象的过程与它无关。

 

**Closure::bind是Closure::bindTo的静态版本**

 

> ```
> 深入理解bind参数：
> 
> 要理解bing参数，先要理解类属性的可访问权限 public,private(子类不可访问),protect(子类可访问，类外不可以访问)。
> php的public、protected、private三种访问控制模式的区别
> 
> public: 公有类型 在子类中可以通过self::var调用public方法或属性,parent::method调用父类方法
>     在实例中可以能过$obj->var 来调用 public类型的方法或属性
> protected: 受保护类型在子类中可以通过self::var调用protected方法或属性,parent::method调用父类方法
>     在实例中不能通过$obj->var 来调用  protected类型的方法或属性
> private: 私有类型该类型的属性或方法只能在该类中使用，在该类的实例、子类中、子类的实例中都不能调用私有类型的属性和方法
> 
> 不能通过 $this 访问静态变量，静态方法里面也不可用 $this (原因：静态属性属于类本身而不属于类的任何实例。静态属性可以被看做是存储在类当中的全局变量，可以在任何地方通过类来访问它们)
> 在类外不能通过 类名::私有静态变量，只能在类里面通过self,或者static 访问私有静态变量：
> 
> 第一个参数：需要绑定的匿名函数。
> 第二个参数：关于bind的第二个参数为object还是null，取决于第一个参数闭包中是否用到了`$this`的上下文环境。(绑定的对象决定了函数中的$this的取值)
> 若闭包中用到了`$this`,则第2个参数不可为null，只能为object实例对象；若闭包中用到了静态访问(::操作符)，第2个参数就可以为null,也可以为object
> 第三个参数(作用域)：是控制闭包的作用域的，如果闭包中访问的是 private 属性，就需要第3个参数提升闭包的访问权限，若闭包中访问的是public属性，第三个参数可以不用。只有需要改变访问权限时才要，传对象，类名都可以。
> ```
>
> 　　[bind的第三个参数：mixed类型的类作用域，决定了这个匿名函数中能够调用哪些私有和保护的方法。也就是说this可以调用的方法，即这个this可以调用的方法，即这个this可以调用的方法与属性，与这个scope一致。
> 　　第三个参数如果是类实例对象与类的名称都代表着这个闭包有类作用域，如果是static则表示这个闭包与外部变量作用域一样，不能访问类的私有以及保护方法。
> 　　mixed类型在PHP中也就是没有类型限定的意思，缺省情况下第三个参数是个字符串，值是‘static’]

 　**第2个参数是给闭包绑定`$this`对象的，第3个参数是给闭包绑定作用域的。**

**通过成员的可访问行来举例子理解：**

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
  class A{
      private $name = '王力宏';
      protected $age = '30';
      private static $weight = '70kg';
      public $address = '中国';
      public static $height = '180cm';
  }
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

 

 

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
  $obj = new A();
  //echo $obj->name;//报错 Cannot access private property A::$name
  //echo $obj->age;//报错 Cannot access protected property A::$age
  //echo A::$weight; //报错 Cannot access private property A::$weight
  echo $obj->address;//正常 输出 中国
  echo A::$height;//正常 输出 180cm
  $fun = function(){
      $obj = new A();
      return $obj->address;//实例对象可以获得公有属性,  $obj->name等私有属性肯定不行 上面例子已列出报错
  }
  echo $fun();//正常 输出 中国
  $fun2 = function(){
      return A::$height;//  类可以直接访问公有静态属性，但A::$weight肯定不行，因为weight为私有属性
  }
  echo $fun2();//正常 输出 180cm
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

 

以上都理解的情况下 我们来看看这样的情况，有如下匿名函数:

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
$fun = function(){
    return $this->name;
}
或者
$fun = function(){
    return A::$height;
}
echo $fun();//会报错的
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

其实单独这段代码是肯定不能运行 调用的，因为里面有个$this,程序压根不知道你这个$this是代表那个对象 或 那个类(并且就算知道那个对象或类，该对象是否拥有name属性，如果没有照样会有问题)

因此想让其正常运行肯定有前提条件啊(就好比你想遍历某个数组一样，如果这个数组压根你就没提前定义 声明 肯定会报错的)
如果这样:

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
$fun = function(){
    //name是私有属性，需要第3个参数
    return $this->name;
} ;
$name = Closure::bind($fun,new A() ,'A');                                                                                                                                                           
echo $name();//输出 王力宏 
该函数返回一个全新的 Closure匿名的函数，和原来匿名函数$fun一模一样，只是其中$this被指向了A实例对象,这样就能访问address属性了。
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

使用了bind函数后 ，

其实是匿名函数里的$this被指定到了或绑定到了A实例对象上了

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
Closure::bind($fun,new A() );
这个使用 你可以理解成对匿名函数做了如下过程:
$fun = function(){
   $this = new A();
    return $this->name;
} ;
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

你可以想象认为,$this就成了A类的实例对象了，然后在去访问name属性，就和我们正常实例化类访问成员属性一样，上面2中的例子$obj = new A()就是这样，(因为$this是关键字，在这里我们其实不能直接$this = new A();这么写，为了好理解我写成$this，但是原理还是这个意思)，但是我们都知道因为name属性是私有的，上面2中我已说过，实例对象不能访问私有属性，那该怎么办呢，于是添加第三个参数就很重要了，一般传入传入一个对应对象，或对应类名(对应的意思是:匿名函数中$this-name想获取name属性值，你这个$this想和那个类和对象绑定在一起呢，就是第二个参数，这时你第三个参数写和第二个参数写一样的对象或类就行了，就是作用域为这个对象或类，这就会让原理的name私有属性变为公有属性)

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
$fun = function(){
    //address为公开，第3个参数可以不需要
    return $this->name;
} ;
$address = Closure::bind($fun,new A()); 
echo $address();
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

这里数一下bind这次为什么没添加第三个参数，因为我们要访问的address属性是公有的，一个对象实例是可以直接访问公有属性的，这个例子中只要匿名函数中$this被指向了A对象实例(或者叫绑定也可以)，就能访问到公有属性，所以可以不用添加第三个参数，当然你加上了第三个参数 如这样Closure::bind($fun2, new A(), ‘A’ );或Closure::bind($fun2, new A(), nwe A() );不影响 照样运行，就好比把原来公有属性 变为公有属性 不影响的(一般当我们访问的属性为私有属性时，才使用第三个参数改变作用域 ，使其变为公有属性)

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
$fun = function() {
  //访问私有静态属性，访问静态属性，第2个参数可以为null，访问私有属性，需要第3个参数提高作用域
　　//return A::$weight;  这样写，会报错，提示不能通过类名访问私有静态变量
　　//weight 为类的私有属性，只可在类中访问
　　return self::$weight;
 }; //echo $fun(); 运行会报错 因为weight为私有属性 。 $weight = Closure::bind($fun,null,'A'); //通过bind函数作用，返回一个和$fun匿名函数一模一样的匿名函数，只是该匿名函数中A::$weight, weight属性由私有变成公有属性了。 echo $weight();
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)


为什么第二个参数又成null了呢，因为在该匿名函数中A::$weight 这属于正常类使用啊(php中 类名::公有静态属性，这是正常访问方法，上面2中例子已经说的很清楚了)，所以不用绑定到某个对象上去了，于是第二个参数可以省略，唯一遗憾的是weight属性虽是静态属性，但是其权限是private私有属性，于是我们要把私有属性变公有属性就可以了，这时把第三个参数加上去就可以了，第三个参数可以是A类(Closure::bind($fun,null,'A'))，也可以是A类的对象实例(Closure::bind($fun,null, new A() ))，两种写法都可以，最终第三个参数的添加使私有属性变成了公有属性，(这个例子中当然你非得添加第二个参数肯定也没问题，只要第二个参数是A的实例对象就行Closure::bind($fun,new A(),'A')，不影响，只是说 A::$weight 这种使用方法本身就是正常使用，程序本身就知道你用的是A类，你在去把它指向到A类自己的对象实例上，属于多此一举，因此第二个参数加不加都行，不加写null就行)

 

> 综上大家应该理解其用法了吧，有时第二个参数为null，有时第三个参数可以不要，这些都跟你匿名函数里 代码中访问的方式紧密相关
> 总结：
> 1、一般匿名函数中有$this->name类似这样用 $this访问属性方式时，你在使用bind绑定时 ，第二个参数肯定要写，写出你绑定那个对象实例，第三个参数要不要呢，要看你访问的这个属性，在绑定对象中的权限属性，如果是private，protected 你要使用第三个参数 使其变为公有属性, 如果本来就是公有，你可以省略，也可以不省略
> 2、一般匿名函数中是 类名::静态属性 类似这样的访问方式(比如例子中A::$weight)，你在使用bind绑定时，第二个参数可以写null,也可以写出具体的对象实例，一般写null就行(写了具体对象实例多此一举)，第三个参数写不写还是得看你访问的这个静态属性的权限是 private 还是 public,如果是私有private或受保护protected的，你就得第三个参数必须写，才能使其权限变为公有属性 正常访问，如果本来就是公有public可以不用写，可以省略
>
> 3、需要提升属性作用域时，第3个参数需要传，传对象或者类名都可以。

 

例子：

```
class` `Animal {``  ``public` `$cat` `= ``'cat'``;``  ``public` `static` `$dog` `= ``'dog'``;``  ``private` `$pig` `= ``'pig'``;``  ``private` `static` `$duck` `= ``'duck'``;``}` `//不能通过 $this 访问静态变量``//不能通过 类名::私有静态变量，只能通过self,或者static,在类里面访问私有静态变量` `$cat` `= ``function``() {``  ``return` `$this``->cat;``};` `$dog` `= ``static` `function` `() {``  ``return` `Animal::``$dog``;``};` `$pig` `= ``function``() {``  ``return` `$this``->pig;``};` `$duck` `= ``static` `function``() {``  ``//return Animal::$duck; 这样写，会报错，提示不能通过类名访问私有静态变量`` ``return` `self::``$duck``; ``// return static::$duck``};` `$bindCat` `= Closure::bind(``$cat``, ``new` `Animal(), ``'Animal'``);``$bindCat2` `= Closure::bind(``$cat``, ``new` `Animal(), ``new` `Animal());``echo` `$bindCat``() . PHP_EOL;``echo` `$bindCat2``() . PHP_EOL;` `$bindDog` `= Closure::bind(``$dog``, null, ``'Animal'``);``$bindDog2` `= Closure::bind(``$dog``, null, ``new` `Animal());``echo` `$bindDog``() . PHP_EOL;``echo` `$bindDog2``() . PHP_EOL;` `$bindPig` `= Closure::bind(``$pig``, ``new` `Animal(), ``'Animal'``);``$bindPig2` `= Closure::bind(``$pig``, ``new` `Animal(), ``new` `Animal());``echo` `$bindPig``() . PHP_EOL;``echo` `$bindPig2``() . PHP_EOL;` `$bindDuck` `= Closure::bind(``$duck``, null, ``'Animal'``);``$bindDuck2` `= Closure::bind(``$duck``, null, ``new` `Animal());``echo` `$bindDuck``() . PHP_EOL;``echo` `$bindDuck2``() . PHP_EOL;
```

 

通过上面的例子，可以看出**函数复用得，可以把函数挂在不同的类上，或者对象上**。

 

**闭包函数的应用：**

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
/**
* 一个基本的购物车，包括一些已经添加的商品和每种商品的数量
*
*/
class Cart {
  // 定义商品价格
  const PRICE_BUTTER = 10.00;
  const PRICE_MILK = 30.33;
  const PRICE_EGGS = 80.88;
  protected $products = array();

  /**
  * 添加商品和数量
  *
  * @access public
  * @param string 商品名称
  * @param string 商品数量
  */
  public function add($item, $quantity) {
      $this->products[$item] = $quantity;
  }

  /**
  * 获取单项商品数量
  *
  * @access public
  * @param string 商品名称
  */
  public function getQuantity($item) {
      return isset($this->products[$item]) ? $this->products[$item] : FALSE;
  }

  /**
  * 获取总价
  *
  * @access public
  * @param string 税率
  */
  public function getTotal($tax) {
      $total = 0.00;
      $callback = function ($quantity, $item) use ($tax, &$total) {
          $pricePerItem = constant(__CLASS__ . "::PRICE_" . strtoupper($item)); //调用以上对应的常量
          $total += ($pricePerItem * $quantity) * ($tax + 1.0);
      };

      array_walk($this->products, $callback);
      
      return round($total, 2);
  }
}

$my_cart = new Cart;
// 往购物车里添加商品及对应数量
$my_cart->add('butter', 10);
$my_cart->add('milk', 3);
$my_cart->add('eggs', 12);
// 打出出总价格，其中有 3% 的销售税.
echo $my_cart->getTotal(0.03);//输出 1196.4
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

 

 **给类的私有属性赋值：**

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
class A {
    private $attr = array();
}

class B {
    public static function bind (A $a) {
        return \Closure::bind(function () use ($a) {
            //给私有属性赋值
            $a->attr = [
                'color' => 'red',
                'weight' => '1.0',
            ];
        }, null, A::class);
    }
}

//我们在对象外部给私有对象赋值时，需要通过\Closure::bind ,来提高闭包作用域进行赋值
$a = new A();
//不能对私有属性直接进行$a->attr = ['color' => 'red','weight' => '1.0'];
call_user_func(B::bind($a));
print_r($a);
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

 

　通过上面的几个例子，其实匿名绑定的理解就不难了....我们在看一个扩展的demo(引入trait特性)

**给类动态的添加方法**

[官方文档有例子，点击查看](https://www.php.net/manual/zh/closure.bindto.php)

 

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
/**
 * 给类动态添加新方法
 *
 * @author fantasy
 */
trait DynamicTrait {

    /**
     * 自动调用类中存在的方法
     */
    public function __call($name, $args) {
        if(is_callable($this->$name)){
            return call_user_func($this->$name, $args);
        }else{
            throw new \RuntimeException("Method {$name} does not exist");
        }
    }
    /**
     * 添加方法
     */
    public function __set($name, $value) {
        $this->$name = is_callable($value)?
            $value->bindTo($this, $this):
            $value;
    }
}

/**
 * 只带属性不带方法动物类
 *
 * @author fantasy
 */
class Animal {
    use DynamicTrait;
    private $dog = '汪汪队';
}

$animal = new Animal;

// 往动物类实例中添加一个方法获取实例的私有属性$dog
$animal->getdog = function() {
    return $this->dog;
};

echo $animal->getdog();//输出 汪汪队
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

 

获取类属性:第3个参数 score 范围 设置为null 时，只能获取到 public 属性。

如果希望完全取消绑定，则需要将闭包和范围都设置为null

 

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

```
class MyClass
{
    public $foo = 'a';
    protected $bar = 'b';
    private $baz = 'c';

    /**
     * @param bool $all 是否获取全部的属性
     *
     * @return array
     */
    public function toArray($all = false)
    {
        // Only public variables
        $callback = (function ($obj) {
            // get_object_vars — 返回由对象属性组成的关联数组 ,在类内调用时，会返回所有的属性(private,protect,public), 在类外使用只返回public
            return get_object_vars($obj);
        });

        //指定作用域 为 null 则会返回 public 属性； 指定作用域默认 ‘static’，则会返回所有属性
        if ($all) {
            $callback = $callback->bindTo(null);
        } else {
            //类内获取public属性
            $callback = $callback->bindTo(null, null);
        }
        return $callback($this);
    }
}

$obj = new MyClass;
$vars = get_object_vars($obj); // get_object_vars 类外使用，获取到的是 public 属性
$vars = $obj->toArray();
```

[![复制代码](./Closure%20and%20Callback.assets/copycode.gif)](javascript:void(0);)

 

 

总结：

**1. 闭包内如果用 $this, 则 $this 只能调用非静态的属性，这和实际类中调用原则是一致的，且 Closure::bind() 方法的第2个参数不能为null，必须是一个实例 (因为$this,必须在实例中使用)，第三个参数可以是实例，可以是类字符串，或 static；**

**2. 闭包内调用静态属性时，闭包必须声明为 static,同时Closure::bind()方法的第2个参数需要为null,因为 静态属性不需要实例，第3个参数可以是类字符串，实例，static.**

from:  https://www.cnblogs.com/echojson/p/10957362.html

