# print() echo printf(); print_r();var_dump();



```php 
# 八种数据结构
# 基础数据类型： long double boolean string   
# 特殊数据类型： null resource 
# 复式数据类型：object  array

//boolean 被打印是 0 或者1；
```

### print_r();函数  打印，按照一定的格式显示键和元素；  打印复合类型（array）      print_r以人性化的方式打印变量

用来输出数组的；只能输出一个变量；

输出boolean 是 1 或者0；



### var_dump();  函数；可以打印多个变量，而且可以显示数据类型； 打印复式数据类型；没有返回值；

可以输出数组对象和资源；会带有数据类型；可以输出多个变量；

输出boolean是带有数据类型；



### echo   语言结构；可以作拼接

打印一个或者多个变量；

````php
echo $a,$b;
````



echo "acesji".\$Ceshi;

###print   语言结构；只能跟一个变量；  print(\$Ceshi);  有返回值；

打印一个变量，以字符串的形式；不能输出数组和对象；



---

## TEST

`````php
// print();语言结构 但是有返回值；只能打印一个变量；
$a = 1;
$b = 2;
$arr = [1,2,3];
$arr1 = [4,5,6];
if(print($a)){
    echo "\n";
    echo "print success!";
}
echo "\n";
echo $a,$b;
//可以打印复式数据类型；
echo "\n";
//会有返回值 可以打印复式数据类型； 会有返回值；用来判断是否打印成功；
if(print_r($arr)) {
    echo "\n";
    echo "打印成功";
}
// 可以打印多个数据类型，显示数据类型；
// 不会有返回值；
//
if(var_dump($arr,$arr1)) {
    echo "\n";
    echo "打印成功";
}
//
echo true; //1
// 不可见，只能用var_dump才是可见的；
echo "\n";
echo NULL;
var_dump(NULL);
`````





---



### printf(); c语言的 print format  根据格式来打印；

````php
#打印一个字符串 输出一个字符串把；
 # %hd   h  short  %d int   %ld  long 整型
#格式控制符	说明
%c	输出一个单一的字符
%hd、%d、%ld	以十进制、有符号的形式输出 short、int、long 类型的整数
%hu、%u、%lu	以十进制、无符号的形式输出 short、int、long 类型的整数
%ho、%o、%lo	以八进制、不带前缀、无符号的形式输出 short、int、long 类型的整数
%#ho、%#o、%#lo	以八进制、带前缀、无符号的形式输出 short、int、long 类型的整数
%hx、%x、%lx
%hX、%X、%lX	以十六进制、不带前缀、无符号的形式输出 short、int、long 类型的整数。如果 x 小写，那么输出的十六进制数字也小写；如果 X 大写，那么输出的十六进制数字也大写。
%#hx、%#x、%#lx
%#hX、%#X、%#lX	以十六进制、带前缀、无符号的形式输出 short、int、long 类型的整数。如果 x 小写，那么输出的十六进制数字和前缀都小写；如果 X 大写，那么输出的十六进制数字和前缀都大写。
%f、%lf	以十进制的形式输出 float、double 类型的小数
%e、%le
%E、%lE	以指数的形式输出 float、double 类型的小数。如果 e 小写，那么输出结果中的 e 也小写；如果 E 大写，那么输出结果中的 E 也大写。
%g、%lg
%G、%lG	以十进制和指数中较短的形式输出 float、double 类型的小数，并且小数部分的最后不会添加多余的 0。如果 g 小写，那么当以指数形式输出时 e 也小写；如果 G 大写，那么当以指数形式输出时 E 也大写。
%s	输出一个字符串
    
    
    
 %o   // 八进制    八进制 octal 八进制；
 %d   //十进制  decimal  
 %p   // 指针；
 %f   // 浮点型；
 %lf //double 浮点型；
 %s    // 字符串
 %x  // 16进制    16进制； hex  16进制；
 h  //是short的意思，所以 16进制只能使用 x 来表示16进制；   
 %u //无符号
 %e  //以科学计数法的形式表示
    
 #code
  $ceshi = 'aaa';
//输出格式 可以定义输出的格式；和字符串；
printf('%d',$ceshi);  //0  
$d = 100;
printf('%o',$d);

$ceshi = 'aaa';
//输出格式 可以定义输出的格式；和字符串；
printf('%d',$ceshi);
$d = 100;
printf('%o',$d);//8进制；
echo "\n";
printf('%x',$d); // 16进制
echo "\n";
$d = 0.3 + 0.1;
printf('%f',$d);
````



区别：

**echo可以打印多个变量,但是没有返回值**

**print只能打印一个返回值,但是有返回值**

gettype(变量) 输出查看当前变量的数据类型;





### 语言结构

1.什么是语言结构

语言结构：就是PHP语言的关键词，语言语法的一部分；它不可以被用户定义或者添加到语言扩展或者库中；**它可以有也可以没有变量和返回值。**

2.语言结构执行速度快的原因

**函数都要先被PHP解析器(Zend引擎)分解成语言结构，所以，函数比语言结构多了一层解析器解析，速度就相对慢了**

3.php中语言结构有哪些

echo()

print()

die()

isset()

unset()

include()，注意，include_once()是函数

require()，注意，require_once()是函数

array()

list()

empty()



4.怎样判断是语言结构还是函数

使用function_exists

eg：

function check($name){

if(function_exists($name)){

echo $name.'为函数';

}else{

echo $name.'为语言结构';

}

}

5.语言结构与函数的区别

1.语言结构比对应功能的函数快

2.语言结构在错误处理上比较鲁棒，由于是语言关键词，所以不具备再处理的环节

3.语言结构不能在配置项(php.ini)中禁用，函数则可以。

4.语言结构不能被用做回调函数

备注：

php.ini中怎样禁用函数？

php.ini中查找 disable_functions =

在等于后添加函数名，多个函数名用,分割

比如

disable_functions =

exec,passthru,popen,proc_open,shell_exec,system,chgrp,chmod,chown



