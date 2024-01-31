# Psr-1 -  基础编码规范；Psr-2 是对1的扩展；



**psr  php standard recommendations（建议）  php标准规范；**



**来源： https://www.php-fig.org/psr/**

---

###Psr-1



* 类名：大驼峰
* 常量：全部大写
* 属性和方法：都是小驼峰；**或者下划线方式；**  根据你的团队或者框架选择一个就像可以；



````php
驼峰命名法和大驼峰命名法统称为驼峰命名法（Camel-Case)。驼峰命名法是电脑编程时的一套命名规则。指在命名变量和函数时混合使用大小写字母来构造名字。
这样可以方便程序员之间的代码交流，也可以增强可读性。
##二.小驼峰命名法

用途：方法变量

约定1：当标识符是一个单词的时候，首字母小写

示例：name

##约定2：当标识符有多个单词的时候，第一个首字母是小写，其他的首字母都是大写

示例：myStudentCount ，myFirstName

##三.大驼峰命名法

用途：类

约定1：当标识符只有一个单词的时候，首字母大写

示例：Name

##约定2：当标识符有多个单词的时候，所有单词的首字母均是大写，比如：

MyStudentCount , MyFirstName

##驼峰命名法一般是用于变量名或函数名等多个单词连接在一起的情况，因为高低起伏像骆驼一样，所以名为驼峰命名法。
````



----



### Psr-2



* Psr-1规范，及其通用规则（行 缩进等）；

​		tab 缩进 4个空格；

​		**空白行 或者缩进之类的；**

​		



**phpstorm 具体的格式 可以使用ctrl+ alt +l 来格式化；**



* 命名空间 类 属性 方法	

  

​		关键字必须是小写，null false true namespace public function  之类的；

​		namesapce  后面**必须** 要有空白行

​		use 之后**必须**有一个空白行；

​		extends 和 implements 继承和实现必须在同一行；

​		属性不能以下划线i或者是数字开头；

​		**方法名和小括号之间不能用空格**；花括号的开始和结束花括号必须要独立占用一行；**多参数，逗号后必须有一个空格，默认值必须放在末尾；**  

​		**abstract 和 final  必须放在访问修饰词之前，static必须放在访问修饰符之后；**

​		函数的调用参数可以是多行；

````php
#函数的调用可以实多行；
ceshi(
	$canshu1,
	$canshu2,
    $canshu3,
    function ceshi($ceshi) {
        echo $ceshi;
    }
);
````



* 控制语句，控制语句（if for foreach switch try catch），闭包函数；

````php
#if elseif   
# 1.控制语句之后必须要有一个空格；
# 2. 小括号和花括号之间要有空格；
# 3.结构主体要有一个tab的缩进；
# 4. 结束括号必须是独立一行；

if ($ceshi) {
    echo "ceshi";
} elseif ($ceshi) {
    
} else {
      

}


function ceshi($ceshi) {
    echo "ceshio";
}

ceshi($ceshi);

for ($i = 0; $i < 10; $i++) {
    echo $i;
}

foreach ($ceshi as $key => $val) {
    echo $ceshi;
}

class Ceshi
{
    
    
}

class Ceshi
{
    
    public function ceshi()
    {
        echo "ceshi";
    }
}

# ide phpstorm 的格式；
class Ceshi
{
    public function ceshi($ceshi) {
        echo "ceshi";
    }
}


````

