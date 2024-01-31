# call_user_func  and call_user_func_array

>意义何在？  为什么不用直接调用 用call_user_func();
>
>不需要new 直接调用函数；
>
>call_user_func()：**调用一个回调函数处理字符串**,
>　　可以用匿名函数，可以用有名函数，可以传递类的方法，
>　　用有名函数时，只需传函数的名称
>　　用类的方法时，要传类的名称和方法名
>　　传递的第一个参数必须为函数名，或者匿名函数，或者方法
>　　其他参数，可传一个参数，或者多个参数，这些参数会自动传递到回调函数中
>　　而回调函数，可以通过传参，获取这些参数
>　　返回回调函数处理后的结果

`````php
##  params = array 做一下去别就可以了；
call_user_func([$obj,'dnd'], $params)

This resolves to
// 一个参数对应的是一个参数，参数可以是数组；对应是一个参数；
$obj->dnd(array(33, 22, 'fff'))
while
##  每一个数组的值 都对应着一个参数；
call_user_func_array([$obj,'dnd'], $params)

resolves to

$obj->dnd(33, 22, 'fff')
    
    
    
##  call 不同的点
    
/**
 * call_user_func
 * 就是一个函数的调用；
 */

class Ceshi123
{
    public function ceshi($a,$b) {
        var_dump($a,$b);
        echo "\n";
        echo "ceshi";
    }

    public static function ceshi2() {
        echo "static method";
    }
}

// call_user_func  调用一个对象，去使用一个对象； --- 
//call_user_func(array('Ceshi123','ceshi'),1,array(1,22));
echo "\n";
//call_user_func_array(array('Ceshi123','ceshi'),array(1,array(1,22)));

## 一般用这个把 直接用这个把； 和 要生成new 的做一个区分；
//call_user_func('Ceshi123::ceshi2');
//call_user_func(array('Ceshi123','ceshi2'));// 静态函数也可以使用
`````





``````php
# 可变参数的形式；
## 
array=func_get_args();

$count=func_num_args();

$value=func_get_arg(argument_number);
//

一个例子：

<?php $name=array("Fred","Barney","Wilma","Betty");function &find_one($n){global $name;return $name[$n];}

$person=&find_one(1);echo $person;?>

#需要注意的是，以上的三个函数的返回值都不能够作为其它函数的参数直接使用，要使用这些值的话，需要先将这些值赋值给变量，然后在函数调用中使用。

foo(func_num_args()) //错误

应该是：

$count=func_num_args();

foo($count);
``````





---

## 区别

在PHP中，直接调用函数和使用`call_user_func`函数之间有一些区别。

直接调用函数是指通过函数名和括号来调用函数，例如`myFunction($param1, $param2)`。这是最常见的方式，也是最直接的方式。

**而使用`call_user_func`函数则是以回调的方式来调用函数或方法。这意味着您可以将函数名作为字符串传递，并且可以动态地构建函数调用。这在某些情况下非常有用，比如当您需要根据某些条件来确定要调用的函数时，或者当您需要以变量的形式传递函数名时。**

另一个区别是，使用`call_user_func`函数可以调用类的静态方法，而直接调用函数则不能。这意味着您可以使用`call_user_func`来调用类的静态方法，而不需要实例化该类。

总的来说，直接调用函数更直观和简单，而`call_user_func`函数更灵活，可以动态地构建函数调用。在大多数情况下，直接调用函数是更常见和更好的选择。





`````php
//--- 区别 --- 传递的函数参数是字符串；
echo "\n";
function pre($int) {
	echo "第{$int}预处理";
}
function func($str,$int) {
    // 回调函数的形式来运行这个函数；
    call_user_func($str,$int);
}
func('pre',123);

//--- 传递的参数是closure 匿名函数；callback；
$pre1 = function() {
    echo 'pre closure';
};
function func1($pre) {
	$pre();
}
func1($pre1);
//summary 传递函数 直接运行，传递函数字符串可以使用call_user_func来运行；

`````





`````php
####   call_user_func是一个PHP函数，它允许您以回调的方式调用函数或方法。这个函数接受一个回调作为第一个参数，可以是一个函数名的字符串，也可以是一个包含对象和方法名的数组。随后的参数是要传递给回调的参数。
### 第一个参数是数组可以调用对象的普通方法，也可以调用对象的静态方法，写法是不一样的；
下面是call_user_func函数的基本语法：



call_user_func($callback, $parameter1, $parameter2, ...);
###其中，$callback可以是一个函数名的字符串，也可以是一个包含对象和方法名的数组。$parameter1, $parameter2, ...是要传递给回调的参数。

例如，您可以使用call_user_func来调用一个全局函数：



function myFunction($param1, $param2) {
    echo $param1 . ' ' . $param2;
}

###call_user_func('myFunction', 'Hello', 'World');
您还可以使用call_user_func来调用对象的方法：


class MyClass {
    public function myMethod($param1, $param2) {
        echo $param1 . ' ' . $param2;
    }
}

$obj = new MyClass();

####call_user_func(array($obj, 'myMethod'), 'Hello', 'World');
###总的来说，call_user_func函数提供了一种灵活的方式来以回调的形式调用函数或方法，特别适用于需要动态构建函数调用的情况。


## 调用静态方法

当使用call_user_func调用静态方法时，您可以传递一个包含类名和方法名的数组作为回调。这允许您以回调的方式调用类的静态方法。

以下是一个示例，演示了如何使用call_user_func调用类的静态方法：


Copy

Open
class MyClass {
    public static function myStaticMethod($param1, $param2) {
        echo $param1 . ' ' . $param2;
    }
}

// 使用call_user_func调用类的静态方法

####  call_user_func(array('MyClass', 'myStaticMethod'), 'Hello', 'World');
在这个示例中，array('MyClass', 'myStaticMethod')指定了要调用的类名和方法名，'Hello'和'World'是要传递给静态方法的参数。

通过这种方式，您可以使用call_user_func函数以回调的形式调用类的静态方法，而不需要实例化该类。
`````

