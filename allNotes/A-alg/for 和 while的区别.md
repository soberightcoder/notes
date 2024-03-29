# for 和 while的区别

>**for 更加倾向于循环了多少次数；**  --- **次数**  
>
>**while 更加倾向于满足某个条件的循环；**-- **条件**
>
>
>
><font color=red>**两者之间可以相互替换；**</font>
>
>
>
><font color=red>循环的3个条件，一定要有：写循环一定要去考虑这几个条件</font> 
>
>* 初始条件 （初始的条件）
>* 循环条件  (什么时候去循环,什么时候停止循环)
>* 循环体**（循环增量的如何去变化） 循环变量的增量 + 具体操作** 

区别：



1、使用场景不同：

<font color=red>**知道执行次数的时候一般用for，条件循环时一般用while。**</font>

2、两种循环在构造死循环时的区别：

while循环里的条件被看成表达式，因此，当用while构造死循环时，里面的TRUE实际上被看成永远为真的表达式，这种情况容易产生混淆，有些工具软件如PC-Lint就会认为出错了，因此构造死循环时，最好使用for(;;)来进行。

3、两种循环在普通循环时的区别：



<font color=red>**对一个数组进行循环时，一般来说，如果每轮循环都是在循环处理完后才讲循环变量增加的话，使用for循环比较方便。**</font>

<font color=red>**如果循环处理的过程中就要将循环变量增加时，则使用while循环比较方便。**</font>



**还有在使用for循环语句时，如果里面的循环条件很长，可以考虑用while循环进行替代，使代码的排版格式好看一些。**

用法：

**for循环可以设置次数，while循环条件满足没有次数限制。**



[![img](for 和 while的区别.assets/37d3d539b6003af3c520a68d3b2ac65c1138b641)](https://iknow-pic.cdn.bcebos.com/37d3d539b6003af3c520a68d3b2ac65c1138b641)







**扩展资料：**

for循环语法：



###**1.语句最简形式为：**

for( ; ; )  while(1) {};  死循环；

````php
// 死循环 也可以使用break跳出来哦；不是不可以中断；
for (;;){// 死循环；
    echo "111";
}

while (1) {// 死循环；
    echo "111";
}
# 完全可以替换的for while  
 $i = 1
for (;$i<100;){
    echo $i;
    $i++; //循环体结束的时候循环变量
}

$i = 1;
while($i<100) {
    echo $i;
    $i++;
}

// 完全是一个东西 完全可以相互转换；

/**
 * for 和 while 完全可以相互替换
 * 所以完全一样的；
 * 但是for 可读性 好一些 一眼就可以看到 初始值 循环体（循环增量） 循环条件；
 */

$i = 1;
while ($i < 10) {
    $i ++ ;
    echo $i;
}

echo "\n";
for ($i = 1; $i < 10;) {
    $i++;
    echo $i;
}

echo "\n";
for ($i = 1; $i < 10;$i++) {
    echo $i;
}
````



###**2.一般形式为：**

<font color=red>for（单次表达式;条件表达式;末尾循环体）</font>

{

中间循环体；

**[末尾循环体];**

}

<font  color=red>**其中，表示式皆可以省略，但分号不可省略，因为“;”可以代表一个空语句，省略了之后语句减少，即为语句格式发生变化，则编译器不能识别而无法进行编译。 [1]** </font>

for循环小括号里第一个“;”号前为一个为不参与循环的单次表达式，其可作为某一变量的初始化赋值语句, 用来给循环控制变量赋初值； 也可用来计算其它与for循环无关但先于循环部分处理的一个表达式。

“;”号之间的条件表达式是一个关系表达式，其为循环的正式开端，当条件表达式成立时执行中间循环体。

**执行的中间循环体可以为一个语句，也可以为多个语句，当中间循环体只有一个语句时，其大括号{}可以省略，执行完中间循环体后接着执行末尾循环体。**

执行末尾循环体后将再次进行条件判断，若条件还成立，则继续重复上述循环，当条件不成立时则跳出当下for循环。 



while典型循环：

WHILE <条件>

<语句体>

end while



do   **先去执行一次；**

<语句体>

while <条件>