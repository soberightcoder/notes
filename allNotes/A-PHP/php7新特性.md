# php7新特性





```php
/**
 *  php7 的特
 * 性
 * ??  isset(); 设置默认值
 * try catch 或者set_exception_handler()来设置的异常处理函数可以出来 错误 当出现错误的时候还可以继续往下运行；
 * list 可以使用 [$a,$b] = array($b,$a);来做替换
 *
 * declare (strict_types = 1);1.declare (strict_types = 1); //开启严格模式，检查参数的类型
 * 要去检查返回的数据类型和 函数传入的数据类型；
 
 * php7 zval的重写；zval变小了；现在是16个字节 php7之前是24个字节；
 
 * 数组hashtable的缓存； 减少hash的计算；
 *
 */
// list 的替换
$a = 1;
$b = 2;

// 交换
[$a,$b] = array($b,$a);
//echo $a,$b;
//list($a,$b) = array($b,$a);

//strict  mode
//
//function ceshi09(int $int) :int {
//    return $int;
//}
//echo ceshi09(19);

// ??
//echo $int ?? 1;


//try catch 可以抓取错误
//try {
//    sjdkdjlkjd();
//} catch (Error $e){
//    echo $e->getMessage();
//}
//或者直接使用  set_exception_handler();来处理
//function set_error(Error $e){
//    echo $e->getMessage();
//}
//set_exception_handler('set_error');
//csksjkskj();
//<=>
echo 1 <=> 2; // -1
echo 1 <=> 1; // 0
echo 2 <=> 1; // 1
```

