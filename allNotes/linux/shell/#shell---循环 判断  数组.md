#shell---循环(循环控制) 判断  数组 拼接

>**\$可作为取变量运算符，如echo $PATH 将会输出PATH 变量的内容**  
>
>**注意：  赋值 不需要加\$;**
>
>**用\$ 来取变量的内容，注意一下 但是在运算的时候也会有特例 ((i=i+1)) 其他的只要是取变量内容都需要用\**  
>
>````shell
>#((i=i+1))  === ((i=$i+1))  只要保证赋值的时候左边变量没有$就行而且还不能由空格，不然会被当成一个命令
>i=1;
>````
>
>
>
>在c语言中，变量名就代表的是地址；
>
>shell中不加\$代表的是地址；加$代表的是值；
>
>当在运算的时候 i + 1；肯定代表的是i的值加1；而不是地址 + 1；
>
>*shell中*$(( ))、$( )、``与${ }的区别说明:${ }这种形式其实与用法一和二是一样的,属于*变量*替换的范畴,只不过在*变量*替换中可以加上大括号,也可以不加大括号。((i=i+1)) 运算；echo \$((a + 1));   \${变量名}   \$()  命令替换 === ;
>
>`````shell
>#和c不一样，shell语言右边最好带上$代表的是取a变量的值；
>root@469ac484bce7:/var/www/html# php -m | xdebug kafka
>bash: xdebug: command not found
>root@469ac484bce7:/var/www/html# a=111
>root@469ac484bce7:/var/www/html# echo 'aaa'a
>aaaa
>root@469ac484bce7:/var/www/html# a='aaa'a
>root@469ac484bce7:/var/www/html# echo
>
>root@469ac484bce7:/var/www/html# $a
>bash: aaaa: command not found
>root@46
># 左边是地址  右边必须加 $ 才是取地址的值；
>aaaa
>root@469ac484bce7:/var/www/html# a=$a'sss'
>root@469ac484bce7:/var/www/html# echo $a;
>aaaasss
>
>`````
>
>





#### shell的赋值

```shell
# 0.赋值不要加空格 会被当成command
[root@localhost ~]# ceshi1 =123
-bash: ceshi1: command not found 
# 1.正常赋值
ceshi=123
#  2.命令替换
ceshi=`ls -al`
# 3.read 交互式赋值-t timeout -s 输入加密  -p 输入的格式 ip就是赋值的变量
read -s -t 5 -p "ip:"ip
#4.参数的传递
ceshi=$1

```

```shell
loop do done
#条件 [ ]
if [ ];then
command
elif [ ];then
command
else
command
fi
#注意空格
#阵型的计算；
if [ $1 -eq 0 ];then

fi
```



#### 循环 loop  do done

`````shell
#i++;实现
root@469ac484bce7:~# echo $a;
10
root@469ac484bce7:~# a=$((a+1))
root@469ac484bce7:~# echo $a;
11
#---------
root@469ac484bce7:~#
root@469ac484bce7:~#
root@469ac484bce7:~# ((a=a+1))
root@469ac484bce7:~# echo $a;
12
##------------
root@469ac484bce7:~# a=$[a+1]
root@469ac484bce7:~# echo $a;
13
#---------
root@469ac484bce7:~# a=`expr $a + 1`
root@469ac484bce7:~# echo $a;
14

##------
root@469ac484bce7:~# let a++
root@469ac484bce7:~# echo $a
15
#----
\root@469ac484bce7:~# let a=a+1
root@469ac484bce7:~# echo $a
16
##------
root@469ac484bce7:~# let a=$a+1
root@469ac484bce7:~# echo $a;
17
####--------------------
root@469ac484bce7:~# ((a=$a+1))
root@469ac484bce7:~# echo $a;
18

`````



````shell
# c 语言的循环  
#shell循环 do  done
#for((i=1;i<=100;i++))do echo $i;done; 注意要加空格 更加标准；
for ((i=1;i<=100;i++))
do
echo $i
done

# 列表的遍历   数组的遍历 ；
for i in {1..200}
do
echo $i
done
# for i in {1..100};do echo $i; done
#for i in {1..100};do echo $i; done
#for((i=1;i<=100;i++));do echo $i; done

#99乘法表 99.sh 
#-n 不输出尾随换行符
#-e 启用反斜杠转义的解释 就是转义；
# \t 制表  跳到下一个tab位置；\t 下一额
 #!/bin/bash
  2 for ((i=1;i<=9;i++))
  3     do
  4       for((j=1;j<=$i;j++))
  5         do
  6         echo -n -e "${j}*${i}=$((i*j))\t"
  7         done
  8         echo 
  9     done


##code
 1 #!/bin/bash
  2 for ((i=1;i<=9;i++))
  3 do
  4         for ((j=1;j<=i;j++))
  5         do
  6         echo -n -e "${i}*${j}=$((i*j))\t"
  7         done
  8 echo -e "\n"
  9 done
##code end

# while  （满足条件）循环

num=$1
i=1
while [ $i -le $num ]
do
echo $i
((i=i+1))  ## 注意这个赋值；
done

#while [ $i -le $a ]; do echo $i;((i=i+1));done

## 注意 一定要注意  ubuntu  要用bash来运行  傻逼 这个错误 错了两次了
##
1 #!/bin/bash
  2
  3 i=0
  4
  5 while [ $i -le 12 ]
  6 do
  7 echo $i
  8 ((i=i+1))
  9 done
  let i=i+1;
````

#### 循环控制

````shell
#循环控制
#退出本次循环
continue
#退出整个循环
break n
# 退出函数
return n
#退出脚本
exit n 
````



#### 判断(judge) if fi  case esac 

`````shell
# if
ceshi=$1
# 字符串的比较用 =  比较；
# 条件  注意字符串的比较；
if ["${ceshi}" = "ceshi" ];then
	echo "ceshi"
fi
#if else fi
if [ "$ceshi" = "ceshi" ];then
	echo "ceshi"
elif [ "$ceshi" =];then
	echo "ceshi2
else
	echo "ceshielse"
fi
#成功 则执行下面的 一条语句 不需要{}
[ "$ceshi" = "ceshi" ]&&{
	echo "equal"
	echo "true equal"	
}
#案例：
#!/bin/bash
ceshi=$1
echo $ceshi
if [ "$ceshi" = "ceshi" ];then
                echo "ceshi"
fi
#if else fi
if [ "$ceshi" = "ceshi" ];then
                echo "ceshi"
                elif [ "$ceshi" = "ceshi2" ];then
                echo "ceshi222"
                else
                echo "ceshielse"
fi

# success
[ "$ceshi" = "ceshi" ]&& echo "ceshi"
#fail 
[ "$ceshi" = "ceshi" ]|| echo "ceshi"
#混合的
[ "$Ceshi" = "ceshi" ] && echo "success" || echo "fail"

# multiple 多个命令
[] && command 前面命令成功才会执行 上面的命令；
[] && {
command1
command2
}

# case 
case ${num} in
1) echo "1"
;;
2) echo "2"
;;
3|4) echo "3,4"
;;
*) echo "default"
;;
esac
`````

####数组

`````shell
#格式
array[0]=10.0.0.61
array[1]=10.0.0.71
array[2]=10.0.0.81

# 必须带${} ${array}就是代表的是第一个  下标 从0开始
echo ${array[0]} 
# 全部取出来  * 或者 @  前面加#代表有几个元素  返回的是一个列表list
echo ${array[*]} #这个代表一个数组；
echo ${#array[*]} #数组的长度


#数组的赋值
#1. 直接赋值
#2. 批量赋值
#数组的赋值；
arr=(10.0.0.61 10.0.0.71 10.0.0.81)
#3.从文件获取内容 cat
ip=(`cat ~/ceshi.txt`)
	
#c语言的遍历 和普通的遍历  单个的遍历  案例
#!/bin/bash
path=~/array
ip_list=(`cat ${path}`)

#echo ${ip_list[*]}  一般使用这个来遍历数组；
for i in ${ip_list[*]}
do
echo $i
done

# c language for
# 注意 赋值 不需要用 $
for((i=0;i<=${#ip_list[*]};i++)) #shell循环；
do
echo ${ip_list[$i]}
done

#  一般换行 需要加;
# for i in ${arr[*]};do echo $i;done
#user=($(awk -F: '{print $1}'))	
# for i in ${user[*]};do echo $i;done

[root@localhost ~]# arr1=(1 2 3 4 5 5 6 7);
[root@localhost ~]# for i in ${arr1[*]};do echo $i;done;


`````



#### 函数

`````shell
#函数
check_ip(){
}
#执行
check_ip 
`````

#### 算术运算

`````shell 
#数字的运算可使用let、(( )) ，其中运算时不需要变量$符号，运算符为 +、-、*、/、% ，不建议使用expr
#数字的比较使用 (( )) ，其运算符 >、>=、<、<=、==、!=
#可以使用算术扩展，如：(( 99+1 <= 101 ))

#这个是命令的替换 所以 运算只能使用双括号
$() 
# 整数运算 一般用下面的两种方法来进行赋值
echo $((b+c))  #没有复制直接输出的；
let a=b+c
((i=a+b))  # 直接复制的；
# 注意格式 必须两个全部都是整数  echo $? 来判断是不是都是整数
expr $a + $b 

#小数的计算
awk -vn1=$n1 -vn2=$n2 'BEGIN{print n2/n1}'
#bc basic 
echo $n1/$n2 |bc -l

#案例
#!/bin/bash
a=$1
b=$2
let c=a+b
echo $c

#expr 注意 $a + $b 需要加空格 注意：
d=`expr $a + $b`
echo $d

echo $?

#let
let e=a+b
echo $e

#float
f=`awk -vn1=$a -vn2=$b 'BEGIN{print n1/n2}'`
echo $f

#bc basic compute 基础计算；
echo `echo $a/$b |bc -l`

`````

#### 字符串拼接concat

`````shell
bash: grep~: command not found
[root@27d40a3f1787 shell]# cat * |grep~
bash: grep~: command not found
[root@27d40a3f1787 shell]# cat * |grep ~
[root@27d40a3f1787 shell]# cat * |grep "~"
path=~/array
$path=~/yasuo/ceshi
#备份 案例
#!/bin/bash
path=~/yasuo/ceshi
echo $path
date=`date +%y%m%d`
echo $date
res=${path}/${date}_sy.ss
echo $res
tar -zcf $res  
# shell 字符串的拼接 非常的暴力 直接放在一起就行 也不需要其他符号的拼接  最好使用${}来进行变量的拼接
$a=ceshi    =====  $a="ceshi"
$b=ceshi2   =====  $b="ceshi2"
$c=${a}${b};
$d="ceshi${a}:cesjj${b}"

#案例
[root@27d40a3f1787 shell]# sh concat.sh
ceshiceshi1ssjsjsjsjceshi2sss
ceshiceshi1ce:,,,ceshi2
[root@27d40a3f1787 shell]# car concat.sh
bash: car: command not found
[root@27d40a3f1787 shell]# cat concat.sh
#!/bin/bash
ceshi=ceshi1
ceshi1=ceshi2
echo ceshi${ceshi}ssjsjsjsj${ceshi1}sss
echo "ceshi${ceshi}ce:,,,${ceshi1}"
echo ceshi${c^Chi}\$
# $ 的转义；
[root@localhost ~]# echo ceshi$ceshi\$
ceshiceshi$
#
[root@localhost ~]# [ -e /etc/passwd ] && echo "exists"
exists
[root@localhost ~]# [ -f /etc/passwd ] && echo "exists"
exists
[root@localhost ~]# [ -d /etc/passwd ] && echo "exists"
[root@localhost ~]# ls
`````



## 问题

**注意下面的错误；**

````shell
问题：
sh脚本中有数组初始化的内容

$ str="123 456 789"
$ array=($str)
$ echo ${array[2]}
##sh执行脚本会报错 Syntax error: "(" unexpected

原因：
其他常见的linux发行版，虽然很多是将sh指向bash

##debian/ubuntu上sh命令默认是指向dash，而不是bash

又因为dash是比bash还轻量的，只支持基本的shell功能， 

其中不包括刚才那种数组初始化，所以才会识别不了，直接报Syntx error

解决：

 ##解决办法是，直接用 bash test.sh，或者./test.sh,这两种方式来执行脚本。

````

