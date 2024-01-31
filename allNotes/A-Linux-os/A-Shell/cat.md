# cat

cat  合并 打印文件

```shell
# 清空 test.txt
cat /dev/null > /etc/test.txt
[root@localhost sed]# cat config1
ceshi
[root@localhost sed]# cat /dev/null > config1 
[root@localhost sed]# cat config1



#cat -n  显示行号；
[root@localhost sed]# cat -n config
     1	config
     2	#config
     3	config3
     4	
     5	config4
     6	config5

#多个文件用 空格隔开；  创建一个文件并且输入 文件内容 <<EOF
#文件内容输入到cat命令内，然后cat输出到config文件内
#创建一个文件并且输入这个内容呗；
###就是cat 命令的输入和输出问题; 
cat >> config <<EOF
config1
config2
config3
EOF 

#这个东西的实现原理是什么？ EOF前面不能有空格
[root@localhost sed]# cat<<EOF
> eshi
> ceshi
> EOF
eshi
ceshi



#也是 输入；
sh < test.sh 

#EOF 是什么东西；EOF是“end of file”，表示文本结束符。


```

``````shell
### 重定向  就是输入和输出的重定向；
##>> >  << <  
# 起始就是操作一个 命令的输入和输出；
``````







### echo -e -n 

**echo -n 不换行输出**

**[root@localhost sed]# for((i=1;i<=10;i++));do echo -n $i;done**
**12345678910**

**echo -e   激活转义**

**[root@localhost sed]# echo "\n"**
**\n**
**[root@localhost sed]# echo -e "\n"**





**-e：激活转义字符。使用-e选项时，若字符串中出现以下字符，则特别加以处理，而不会将它当成一般文字输出：**

•\a 发出警告声；
•\b 删除前一个字符；
•\c 最后不加上换行符号；
•\f 换行但光标仍旧停留在原来的位置；
•\n 换行且光标移至行首；
•\r 光标移至行首，但不换行；
•\t 插入tab；
•\v 与\f相同；
•\\ 插入\字符；
•\nnn 插入nnn（八进制）所代表的ASCII字符；







### EOF

 在shell中，文件分界符（通常写成EOF，你也可以写成FOE或者其他任何字符串）紧跟在<<符号后，意思是分界符后的内容将被当做标准输入传给<<前面的命令，直到再次在独立的一行遇到这个文件分界符(EOF或者其他任何字符，注意是独立一行，**EOF前面不能有空格**)。**通常这个命令是cat，用来实现一些多行的屏幕输入或者创建一些临时文件。**

**1、最简单的用法**

**root@ribbonchen-laptop:~# cat<<EOF**

**\> ha**

**\> haha**

**\> hahaha**

**\> EOF**

**输出：**

**ha**

**haha**

**hahaha**

2、把输出追加到文件

root@ribbonchen-laptop:~# **cat<<EOF>out.txt**

\> ha

\> haha

\> hahaha

\> EOF

root@ribbonchen-laptop:~# cat out.txt

ha

haha

hahaha

3、换一种写法

root@ribbonchen-laptop:~# **cat>out.txt<<EOF**

\> ha

\> haha

\> hahaha

\> EOF

root@ribbonchen-laptop:~# cat out.txt

ha

haha

hahaha

**4、cat>filename，创建文件，并把标准输入输出到filename文件中，以ctrl+d作为输入结束**

root@ribbonchen-laptop:~# cat>filename

ha  

haha 

hahaha

root@ribbonchen-laptop:~# cat filename

ha

haha

hahaha







<font color=red>**<<EOF表示后续的输入作为子命令或子Shell的输入，直到遇到EOF为止，再返回到主Shell。**</font>

####最核心的EOF 直接看这里就可以了；



**root@ribbonchen-laptop:~# cat<<EOF**

**\> ha**

**\> haha**

**\> hahaha**

**\> EOF**

**输出：**

**ha**

**haha**

**hahaha**





**4、cat>filename，创建文件，并把标准输入输出到filename文件中，以ctrl+d作为输入结束**

root@ribbonchen-laptop:~# cat>filename

ha  

haha 

hahaha

root@ribbonchen-laptop:~# cat filename

ha

haha

hahaha



