# callback 回调函数 参数是一个代码段（closure 匿名函数）而已

> 函数传参数两种方式，一个是一种数据类型，或者一个是一段代码段，当传递的代码段，运行的时候就是回调函数；
>
> 回调函数；可以看看 php是怎么传递函数参数的？ 一种就是匿名函数，另外一种就是函数名 + call_user_func();

-----

## 回调编程或者说是异步编程；

`````php
//回调函数是指在编程中，将一个函数作为参数传递给另一个函数，并在特定事件发生时由另一个函数来调用这个函数。回调函数通常用于异步编程、事件处理和处理异步操作的结果。
//相当于是异步的通知；另外一个函数；

在许多编程语言中，回调函数被广泛应用。例如，在JavaScript中，回调函数常用于处理异步操作，比如在文件读取完成后执行特定的操作。在PHP中，回调函数可以用于自定义排序函数、数组处理函数等。

下面是一个简单的JavaScript回调函数的示例：

```javascript
function processUserData(userData, callback) {
    // 模拟异步操作
    setTimeout(function() {
        // 操作完成后调用回调函数
        callback(userData);
    }, 1000);
}

function displayUserData(userData) {
    console.log("User data: " + userData);
}

// 调用函数，并传入回调函数
processUserData("John Doe", displayUserData);
```

在这个示例中，`processUserData` 函数接受一个用户数据和一个回调函数作为参数。在模拟的异步操作完成后，它调用传入的回调函数 `displayUserData` 来显示用户数据。

//回调函数是一种强大的编程技术，它可以使代码更加灵活和可复用，特别是在处理异步操作和事件处理时非常有用。
`````



---



## 回调函数就是一个被当成参数传递的函数；



###**这样一来，只要我们改变传进库函数的参数，就可以实现不同的功能，且不需要修改库函数的实现，变的很灵活，*\*这就是解耦\**。**    其实这就是一个模板方法；哈哈



https://blog.csdn.net/llzhang_fly/article/details/104933969





如果你把函数的指针（地址）作为[参数传递](https://so.csdn.net/so/search?q=参数传递&spm=1001.2101.3001.7020)给另一个函数，当这个指针被用来调用其所指向的函数时，就说这是回调函数。



### 回调的参数比较特殊 ，它是一个代码段而已；回调函数就是一个代码段，会在某时刻就会被执行； 参数是一个代码段而已；







即：把**一段可执行的代码像参数传递那样传给其他代码，而这段代码会在某个时刻被调用执行，就叫做回调。如果代码立即被执行就称为同步回调，如果在之后晚点的某个时间再执行，则称为异步回调。**



**比如：我们去“新白鹿”餐馆点餐，好多人排队正在等餐，你吃完了我才能进去吃，我就在哪儿一直等着......我也不急么；后来你过来要吃饭，我先给你一个电子牌替你排好队，我先做给其他顾客吃，你去干你自己的事（逛附件商场），等好了，我叫你（并把你要的饭菜给你），这就是回调**



比如 array_map();  直接回调；

call_user_func_array(); 直接回调；返回结果；

```php
$arr = [1, 2, 34, 5];
$tmparr = array_map(function ($v) {
    return $v * 2;
}, $arr);
var_dump($arr);
var_dump($tmparr);
$arr = [1,2,33,5];
// 传值；而不是传的引用；
$arr1 = array_map(function ($v) {
    return $v * 2;
},$arr);
var_dump($arr1);die;
die;
//回调；

class Ceshias
{
    public function ceshi($ceshi1,$ceshi2) {
        echo $ceshi1;
        echo "\n";
        echo $ceshi2;
        echo "\n";
        echo "ceshi\n";
    }
}


// 不需要new 直接调用; 不需要new 直接调用就好了  在call_user_func(); 在内部会自己newInstance
call_user_func_array(array('Ceshias', 'ceshi'),array(1,2));
call_user_func(array('Ceshias','ceshi'),1,2);
```



**就是把一段可执行的代码传递给其他的代码；                        **参数是一块代码段；这个代码段会在某个时刻会被执行；**



``````php

/**
 * closure
 *
 *
闭包就是能够读取其他函数内部变量的函数。
 */

function affir(Closure $callback){
    $a = 1;
    $b = 2;
    $callback($a,$b);
}

/**
 * 闭包就是能够读取其他函数内部变量的函数。
 */
function main() {
    $a = 3;
    $b = 4;
    affir(function ($x,$y) use ($a,$b) {
        echo $a,$b;
        echo $x,$y;
    });
}

main(); // 3412
``````



# 缺点

回调函数的缺点：
1）回调函数固然能解决一部分系统架构问题但是绝不能再系统内到处都是，如果你发现你的系统内到处都是回调函数，那么你一定要重构你的系统。

2）回调函数本身是一种破坏系统结构的设计思路，回调函数会绝对的变化系统的运行轨迹，执行顺序，调用顺序。回调函数的出现会让读到你的代码的人非常的懵头转向。可读性比较差把；