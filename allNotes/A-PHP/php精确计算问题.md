# php 精确计算



`````php
//bcmath 扩展：bcmath 扩展提供了用于任意精度数学运算的函数。您可以使用 bcadd()、bcsub()、bcmul()、bcdiv() 等函数来执行加法、减法、乘法和除法运算。以下是一个示例代码：

Copy

Open
///bcmath 是 Binary Calculator 的缩写，意为二进制计算器。它是 PHP 中的一个内置扩展，提供了用于任意精度数学运算的函数。这个扩展允许您在 PHP 中执行高精度的数学计算，以避免浮点数运算中可能出现的精度丢失问题。
 
$amount = '0.1234';

$num = 0.58;
echo $num*100;
// 进行精确计算
$result = bcmul($amount, '2', 4);  // 假设进行了乘法运算，结果保留4位小数

echo $result;  // 输出结果

bcadd(); //就是用字符串的形式

`````

**精确计算问题！！！**

>比较的话，舍去，近似值的而部分；；需要去舍去；

![image-20231205174017881](./php%E7%B2%BE%E7%A1%AE%E8%AE%A1%E7%AE%97%E9%97%AE%E9%A2%98.assets/image-20231205174017881.png)



---

## printf 来显示小数的位数；



``````php
/**
 * php 精确计算 
 * bcmth 
 *  */ 
$a = "0.12";
$res =bcadd($a,$a,2);//return string;

// 当你以浮点型来保存的时候，就已经有问题了！！
$num = 0.58; // 已经是一个近似值了呀；
printf("%.20lf",$num);
$num = $num*100;

var_dump($num);
var_dump($res);
``````

