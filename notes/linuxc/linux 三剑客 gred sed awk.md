# linux 三剑客 gred sed awk

****



### 三剑客的特点

*****

> grep sed awk 的特点

| 命令 | 特点                                                         | 场景                                  |
| :--- | ------------------------------------------------------------ | ------------------------------------- |
| grep | 过滤文本 对文本的行进行操作                                  | grep 来筛选过滤文本，是最快的一个命令 |
| sed  | 配置的的替换，修改配置，取行，取范围，对象是行，只有在替换的时候才可以对  行内的内容进进行操作 | 替换\和内容的修改<br />取范围         |
| awk  | 取列 ，统计计算，统计日志                                    | 取列<br />对比<br />统计计算          |

*****

### grep的用法

> 操作对象是行 对行的处理；结果是显示可以匹配到的行；
>
> egrep 就是grep正则的扩展；

| 参数    | 意义                                                         |
| ------- | ------------------------------------------------------------ |
| -E      | extend  就是开启正则的扩展   **egrep   就是支持正则扩展；**  |
| -A      | after A5就是匹配到的后5行                                    |
| -B      | before B5就是匹配到前5行                                     |
| -C      | context 上下文 上下文的5行                                   |
| -c      | 统计 ===  wc -l显示的是行数     显示总共有多少行被匹配到了，而不是显示被匹配到的内容  一般会用 wc -l 来进行统计 这个 -c 一般用的很少； |
| -n      | 显示行号                                                     |
| -w      | **精确匹配 相当于 正则匹配中的 /\bcontent\b/ 对一个字符的精确匹配 \b 来进行界定边界  //** |
| -i      | **不区分大小写 ignorecase**                                  |
| -v      | **排除   invert 反的  exclued //**                           |
| --color | 匹配到的内容以颜色的高亮显示 可以修改.bashrc export GREP_OPTION='--color-always' |
| -e      | **多个文件的匹配 显示文件名 和匹配的内容  //多个文件；**// 多文件的匹配问题！！！ |
| -l      | **仅仅显示匹配到的文件名**                                   |

````shell
[root@localhost shell]# grep -e @ *
ceshi.sh:echo $@
ceshi.sh:for i in $@
[root@localhost shell]# ^C
[root@localhost shell]# grep -l @ *
ceshi.sh
#注意： 行不通 cat 已经合并成了一个文件；所以并不能显示；cat 的意思就是合并并且打印文件；
cat * | grep -e @
````

##### 扩展

bzgrep 压缩之后的查询；



----



### sed的用法 （找谁干啥）

特点：

* sed stream editor 流编辑器，sed处理内容文本，就当是当作水一样不断的处理直到文件的末尾；
* 行编辑器，对象是行，对行进行处理；
* 如果进行范围匹配，如果到结尾的内容一直匹配不到，那么就会一直到匹配到结尾；
* **格式**

```sh
sed [option] 'Command' file ...
```

* option 参数

| 参数 | 意义                                                         |
| ---- | ------------------------------------------------------------ |
| -n   | 静默模式   一般和配合使用     **只显示匹配处理的行（否则会输出所有）（也就是关闭默认的输出）** |
| -i   | 直接修改源文件                                               |
| -r   | 正则的扩展  注意 这里的正则是反斜线的  \   \       \         |

* Command （增删查改）  完全可以用awk来代替；

  * 查 p  p 一般都是使用静默模式的； sed -n '//,//p'

  | 参数             | 意义                                                  |
  | ---------------- | ----------------------------------------------------- |
  | '4p'             | 查看确定的某一行                                      |
  | '1,5p'           | 范围，1-5行                                           |
  | '/regex/p'       | 正则匹配的查询，相当于 grep                           |
  | '/start/,/end/p' | 起始和结束的范围查询 ，可以用于logs某一个时间段的查询 |

  ```sh
  sed -n '\10:00\,\10:30\p' logs.txt #查看 10:00-10:30的所有的日志
  ```

  * 删 

    > 查和删是一样的参数所以直接把p换成d就可以了，分别是单独行的删除和范围删除；

    ````sh
    #删除文本中的空白行和注释行
    sed -r '/^$|#/d' file
    #不显示空白行和注释行 file 可以用 /etc/profile来代替
    sed -nr '/^$|#/!p' file 
    
    [root@localhost sed]# sed -r '/^$|^#/d' config
    config
    config3
    config4
    [root@localhost sed]# cat config 
    config
    #config
    config3
    
    config4
    # 也可以用 grep -v的反选；  这里需要用egrep的扩展；
    [root@localhost sed]# egrep -v '^$|^#' config
    config
    config3
    config4
    
    ````
  
    
  
  * 增 cai   也可以用 cat 或者echo 'ceshi' >> test.txt 追加写；
  
  | 参数               | 意义                                        |
  | ------------------ | ------------------------------------------- |
  | **c replace**      | 替代 改变整整一行的内容 c                   |
  | **a after append** | 在多少行后面进行添加一行  $代表的是最后一行 |
  | **i  insert**      | 在多少行前面进行插入一行                    |
  
  ````sh
  # 在某个文件的最后一行添加内容
  eg1:????  这里要搞定一下；
  cat > config <<EOF  #  cat > config <<EOF      创建一个文件；
  config1
  config2
  config3
  EOF   ###  不需要用 ;  // 注意；
  eg2:
  sed '$a config1\nconfig2\nconfig3' config  #只有加 -i才会改变源文件
  sed -i '1,3c config555\nconfig666' config
  ````
  
  * 改 s sub substitute   替换这里的 s///g  可以用静默模式查看一下效果；
  
    > 可以对行的内容进行操作； 
    >
    > **sed -ir 's/ceshi/ceshi2/g' ceshi  //默认是首个匹配；**
  
    语法格式： 
    
    ```sh
     #S/pattern/string/ 很像vim的替换
    sed 's/look_target/sub_target/g' file...  #g就是global sed 默认是匹配首个的，加g就是匹配整行; 
    ```
  
    **反向引用**（后向引用）：*************  **反向引用；**
  
    > 先保护起来在引用，先用（）保护然后再\1来引用，经常来处理没有规律的数据；
    
    `````sh
    #注意：用到后向引用的时候需要加-r来进行正则扩展
    #做参数的替换的时候 可以先设置一个变量来做替换；
    ~ # echo 123456 | sed -r 's/(.*)/<\1>/g'
    <123456>
    #
    #ifconfig 得到ip 
    ifconfig | sed -n '2p' | sed -r 's/(^.*t )(.*)( n.*$)/\2/g'
    #如果你想替换 \2部分完全可以 用这种方式 直接用这种方式来修改配置; 
    ifconfig | sed -n '2p' | sed -r 's/(^.*t )(.*)( n.*$)/\1127.0.0.1\2/g' 
    / # ip a s eth0                                                                             
    33: eth0@if34: <BROADCAST,MULTICAST,UP,LOWER_UP,M-DOWN> mtu 1500 qdisc noqueue state UP     
        link/ether 02:42:ac:11:00:03 brd ff:ff:ff:ff:ff:ff                                      
        inet 172.17.0.3/16 brd 172.17.255.255 scope global eth0                                 
           valid_lft forever preferred_lft forever  
     #显示 eth0的ip
      ip a s eth0 |sed -n '3p' |sed -r 's/(^.*t )(.*)(\/.*$)/\2/g'
      
      ###实例应用；
      
      
      root@b28137ec3b07:~# cat config
    #config     ceshi01
    
    
    root@b28137ec3b07:~# cat config.sh
    #!/bin/bash
    [ $# -ne 1 ] && {
            echo "必须只能输入一个参数"
            exit 9
    }
    mid=$1
    
    sed -r -i "s/(config)(\s+)\w+/\1\2${mid}/g" config
    
    [ $? -eq 0 ] && echo "success" || echo "fail"
    
    `````

----



### awk的用法 （条件动作）

> 满足条件执行动作；
>
> 过滤分析统计日志；
>
> 是一门语言；

特点：也是流的形式来读取数据，更多的是对列（字段）的处理；字段处理；

````sh
#命令格式# F是自定义分隔符 
#BEGIN代表的是文本被读取之前的事情  END代表的是文本被读取之后做的事情
#默认分隔符是space
# awk -F 'if{action}if{action}if{action}...' file
awk -F ， 'BEGIN{print "name"}{pattern + action}END{print"end of file"}' file...
#eg
~ # awk -F, 'BEGIN{print "name"}{print $2}END{print "end of file"}' config
name
cdddd
lll
202020
#找谁{干啥}
#条件{动作}
#读取文件之前的工作；
'BEGIN{print "name"}'
#条件(动作) 也是找谁干啥  {这里是执行的动作}	读取文件的一行内容 判断条件是否满足 执行响应的命令，最后取读取下一行或者跳到文件结束；
{print $2}  #输出第二行；
#读取文件结束之后的擦走哦
END{print "end of file"} 

#-v 参数  传值；
root@d40d4317e0d5:~# ceshi=123
root@d40d4317e0d5:~# awk -v ceshi=$ceshi 'BEGIN{print ceshi}'
123

````

### 行列（awk 默认是对record field 进行分割 行是回车，列是-F）

| 定义                                | awk           | 说明                                         |
| ----------------------------------- | ------------- | -------------------------------------------- |
| 行                                  | 记录 record   | **每一行通过回车来分割**                     |
| 列                                  | 字段 域 field | **一般都是通过 -F 来分割 默认是space来分割** |
| awk中的行和列结束标记都是可以修改的 |               |                                              |

### awk的内置变量

| 变量（内置变量需要大写） | 意义                                                         |
| ------------------------ | ------------------------------------------------------------ |
| NR                       | number record **行号** 目前正在处理的是第几行数据            |
| NF                       | number field 一行($0)拥有的字段数 （\$NF也就是**最后一个列（字段）**） **每行有多少列；** |
| FS                       | 分隔符，默认是space field separator 字段分段符，每个字段结束标记；**=== -v FS=: 代表的就是分隔符**  **把分隔符分享到awk内；** |
| OFS                      | output field separator 输出字段分隔符，代表的是**输出的时候字段用什么分隔；** 必须要和-v 一起使用，这个就是一个变量而已； |

### 取行操作

| awk  条件           |                             |
| ------------------- | --------------------------- |
| NR==1  **行操作；** | 取出第一行  **取某一行**    |
| NR>=1 && NR<=5      | 1，5的范围   取1，5行；     |
| /ceshi/             | 类似于 sed取行操作；        |
| /101/,/103/         | 类似于sed的范围查询操作；   |
| 逻辑符号            | == >= <= !=   && 逻辑运算符 |

```shell
# 只有条件 没有动作； 找谁 没有干啥！！！
root@d40d4317e0d5:~/ceshi# awk 'NR==1' ceshi
ceshi,ceshi2,ceshi3
root@d40d4317e0d5:~/ceshi# awk 'NR>=1 && NR<=5' ceshi
ceshi,ceshi2,ceshi3
ceshi4,ceshi5,ceshi6
ceshi7,ceshi8,ceshi9
ceshi,ceshi,ceshi
1,ceshi,cece
#包含ceshi的行
root@d40d4317e0d5:~/ceshi# awk '/ceshi/' ceshi
ceshi,ceshi2,ceshi3
ceshi4,ceshi5,ceshi6
ceshi7,ceshi8,ceshi9
ceshi,ceshi,ceshi
1,ceshi,cece
# 查看 日记的行数 记录 从那个时间到那个时间；
awk '/101/,/103/' ceshi  
# OFS  -v OFS=:
[root@localhost ~]# awk -F: -v OFS=: 'NR==1{print $1,$2,$3}' /etc/passwd
root:x:0
# $0  和 $NF  最后一个字段值；  $0 代表这一行数据
[root@localhost fd]# awk -F: 'NR==1{print $0,$1,$2,$3,$NF}' /etc/passwd
root:x:0:0:root:/root:/bin/bash root x 0 /bin/bash

```



### 取列

* 需要 -F 分隔符来分隔字段，默认是space 或者tab； 需要通过F来指定分隔符  <font color=red> F大之处就在于可以直接使用正则来筛选；</font>

* $数字 取出某一列，\$$0代表的是这一行数据；$$代表的就是取数据；数字NF代表的就是这一行；

  ```shell
  #$+数字 用来取某一列；$0 显示整行的内容；$NF 表示最后一列
  #column -t  #是用来对齐的 显示第五行和第就行  	判断输入行的列数来创建一个表
  root@d40d4317e0d5:~/ceshi# ls -al |awk '{print $5,$9}' |column -t
  4096  .
  4096  ..
  94    ceshi
  23    ceshi.sh
  0     ceshi.txt
  86    con.sh
  105   config
  # $NF 最后一列 内置变量需要大写
  bash: conlumn: command not found
  ## 拼接 awk的拼接； 变量和字符串直接拼接  只有沙雕php才会用.
  root@d40d4317e0d5:~/ceshi# ls -l |awk '{print $5"@@"$NF}' |column -t
  16
  94   ceshi
  23   ceshi.sh
  0    ceshi.txt
  86   con.sh
  105  config
  # 第一列和最后一列来交换
  root@d40d4317e0d5:~/ceshi# awk -F: -v OFS=: '{print $NF,$2,$3,$4,$5,$6,$1}' /etc/passwd
  /bin/bash:x:0:0:root:/root:root
  /usr/sbin/nologin:x:1:1:daemon:/usr/sbin:daemon
  /usr/sbin/nologin:x:2:2:bin:/bin:bin
  /usr/sbin/nologin:x:3:3:sys:/dev:sys
  /bin/sync:x:4:65534:sync:/bin:sync
  /usr/sbin/nologin:x:5:60:games:/usr/games:games
  /usr/sbin/nologin:x:6:12:man:/var/cache/man:man
  /usr/sbin/nologin:x:7:7:lp:/var/spool/lpd:lp
  /usr/sbin/nologin:x:8:8:mail:/var/mail:mail
  /usr/sbin/nologin:x:9:9:news:/var/spool/news:news
  /usr/sbin/nologin:x:10:10:uucp:/var/spool/uucp:uucp
  /usr/sbin/nologin:x:13:13:proxy:/bin:proxy
  /usr/sbin/nologin:x:33:33:www-data:/var/www:www-data
  /usr/sbin/nologin:x:34:34:backup:/var/backups:backup
  /usr/sbin/nologin:x:38:38:Mailing List Manager:/var/list:list
  /usr/sbin/nologin:x:39:39:ircd:/var/run/ircd:irc
  /usr/sbin/nologin:x:41:41:Gnats Bug-Reporting System (admin):/var/lib/gnats:gnats
  /usr/sbin/nologin:x:65534:65534:nobody:/nonexistent:nobody
  /bin/false:x:100:65534::/nonexistent:_apt
  /bin/false:x:101:101::/var/spool/exim4:Debian-exim
  /bin/false:x:102:103::/var/run/dbus:messagebus
  
  #找出 消耗cpu最多的前15个进程； OFS 必须和-v 来一起使用；
  ps axu | awk -v OFS=" " 'BEGIN{print "command mem cpu"}NR>1{print $11,$3,$4}'  | sort -nrk3 | head -15
  
  
  ```

* NF代表的是最后一个字段；

````sh
# 取eth0网卡的ip地址  
~ # ip a s eth0 | awk -F"[ /]+" 'NR==3{print $3}'
172.17.0.3 
#ifconfig的ip
root@d40d4317e0d5:~/ceshi# ifconfig | awk 'NR==2'| awk '{print $2}'
172.18.0.4
#要注意看一下把；
#找到 第三列以1或2开头的行，并且显示第一行，第三行和最后一行；也可以对数据列的过滤；
# -F支持正则匹配；
awk -F: '$3~/^1|^2/{print $1,$3,$NF}' /etc/passwd
awk -F: '$3~/^[12]/{print $1,$3,$NF}' /etc/passwd

root@d40d4317e0d5:~/ceshi# awk -F: '$3~/^(1|2)/{print $1,$3,$NF}' /etc/passwd
daemon 1 /usr/sbin/nologin
bin 2 /usr/sbin/nologin
uucp 10 /usr/sbin/nologin
proxy 13 /usr/sbin/nologin
_apt 100 /bin/false
Debian-exim 101 /bin/false
messagebus 102 /bin/false
````

### 表示范围(范围条件)

* /start/,/end/  常用 ***

* 
  ````shell
  NR==1,NR==5  就是从第一行开始到第五行结束，类似于sed -n '1,5p'
  ````

  ````shell
  awk '/11:02:00/,/11:02:00/{print $1,$3,$NF}' ceshi.log
  ````
  
  

###特殊模式 BEGIN{}  和END{}

| 模式     | 含义                                                         | 应用场景                                                     |
| -------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| BEGGIN{} | 在awk**读文件之前**执行                                      | 1. 进行简单的统计，**不涉及读取文件**    **（常见）**<br />2.处理文件之前先加一个表头；<br />3.用来定义awk的变量 （很少用，因为有-v传递变量） |
| END{}    | 在awk**读取文件之后**执行                                    | 1. awk进行统计，一般过程，先进行计算，**最后END里面输出结果；**<br />2. awk数组，用来输出数组结果**（常见）** |
| {}       | 读文件中<br />一行行读取文件，前面可以对行做限制；//  正则 或者NR ==1  之类的做行的过滤； | **会一行一行的读取，判断是否满足条件，满足条件则执行动作，直到所有的行迭代结束；**<br />然后进入到END； 读取文件结束；<br />**当含有这部分内容的时候 行 和列的计算，都需要跟文件，不然会报错；** |

* end{}统计计算

* 统计方法

  | 统计方法              |             |            |
  | --------------------- | ----------- | ---------- |
  | i=i+1                 | i++         | 计数       |
  | sum=sum+???           | sum+=？？？ | 求和，累加 |
  | 注意 i 和sum 都是变量 |             |            |

  ````shell
  # 统计 /etc/services里面空行的个数
  root@d40d4317e0d5:~/ceshi# awk '/^$/' /etc/services | wc -l
  6
  root@d40d4317e0d5:~/ceshi# awk '/^$/{i++}END{print i}' /etc/services
  6
  # 1+2+3+....100 怎么计算
  root@d40d4317e0d5:~/ceshi# seq 100 | awk '{sum=sum+$1}END{print sum}'
  5050
  # 查看过程
  root@d40d4317e0d5:~/ceshi# seq 100 | awk '{sum=sum+$1;print sum}END{print sum}'
  5050
  ````

  

### awk 数组

* 统计日志：类似于
* 统计次数，**ip出现的次数**，**统计状态码出现的次数**，统计系统中每个用户被攻击的次数，统计攻击者ip出现次数；
* 累加求和统计每个ip消耗的流量；累加

|                       | shell 数组                                                   | awk数组                                                      |
| --------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| 形式                  | array[0]="ceshi" array[1]="ceshi1"                           | array[0]=ceshi;array[1]=ceshi1                               |
| 使用                  | echo \${array[0]} \${array[1]}  <br />变量的调用需要用/${var} | print array[0],array[1]                                      |
| **array[]=array[]+1** | **array[\$n]++;**  ..\$n ++ 值；                             | **数组分类的计数**                                           |
| **数组的遍历**        | for i in \$(array[*])<br />do<br />echo \$i<br />done        | **#i 代表 index<br />**for(i in array)<br />print i,array[i] |
| 初始化！！！          | my_array=(“apple” “banana” “cherry”) ；                      | 另外一种数组的遍历<br />一种是类似于c语言的写法for(i=1;i<=length(array);i++) 另外一种就是for (a in array) 一般都是推荐使用第二种方式进行遍历。 |



````shell
#awk 字母会被识别为变量，如果只是想使用字符串需要加双引号；  每一行代码结束 用；来隔开
# 字符串一定要用"" 来表示 不然会当成变量；
root@d40d4317e0d5:~/ceshi# awk 'BEGIN{a[0]=1;a[1]="ceshi";print a[0],a[1]}'
1 ceshi
# 数组的循环
root@d40d4317e0d5:~/ceshi# awk 'BEGIN{a[0]=1;a[1]="ceshi";for(i in a)print i,a[i]}'
1
ceshi

#测试 一定要在BEGIN里面来测试；

[root@localhost network-scripts]# awk 'BEGIN{a[0]=1234;a[1]="ceshi";for(i in a) print i,a[i]}'
0 1234
1 ceshi
````

`````shell
## 这个是一个很重要的内容！！  用awk加数组来做统计！！！
#处理一下文件内容，将域名取出来进行计数排序处理：面试题
# set paste 去做一个vim 的复制 ！！
root@d40d4317e0d5:~/ceshi# cat array
 http://www.baidu.com/index.html
 http://www.baidu.com/1.html
 http://post.baidu.com/index.html
 http://mp3.baidu.com/index.html
 http://www.baidu.com/3.html
 http://post.baidu.com/2.html

 post.baidu.com  出现的次数
 mp3.baidu.com	出现的次数
 www.baidu.com	出现的次数
 
# sort -nrk2  分割符默认是空格-t
# 内容就是出现的次数；
root@d40d4317e0d5:~/ceshi# awk -F "[./]+" '{a[$2]++}END{for(i in a) print i,a[i]}' array |sort -nrk2
www 3
post 2
mp3 1
root@d40d4317e0d5:~/ceshi# awk -F "[./]+" '{a[$2]++}END{for(i in a) print i,a[i]}' array |sort -nk2
mp3 1
post 2
www 3q
# 统计状态码出现的次数：
 awk -F "[./]+" '$9>=200&&$9<=600{a[$9]++}END{for(i in a) print i,a[i]}' array |sort -nk2
# 注意这里 要做一个精确的匹配；

##  用awk数组 做统计
root@d40d4317e0d5:~/ceshi# awk -F "[./]+" '{a[$2]++}END{for(i in a) print i,a[i]}' array |sort -nrk2 |head -10;
`````

#### for循环

| shell编程c语言for循环                                 | awkfor循环                       |                                                       |
| ----------------------------------------------------- | -------------------------------- | ----------------------------------------------------- |
| for((i=1;i<=100;i++))<br />do<br />echo $i;<br />done | for(i=1;i<=100;i++)<br />print i | **awk的循环用来循环每个字段**<br />**多条语句使用{}** |
|                                                       |                                  |                                                       |
|                                                       |                                  |                                                       |

`````shell
#1+....100
#注意这种计算 需要在begin
# 上来做运算 当进入到 条件{动作}的时候就需要读取文件的行了；
root@d40d4317e0d5:~/ceshi# awk "BEGIN{for(i=1;i<=100;i++) sum=sum+i;print sum}"
5050
# 显示遍历过程；
root@d40d4317e0d5:/usr/local# awk 'BEGIN{for(i=1;i<=100;i++){ sum=sum+i;print sum}}'

`````

#### if 判断

| shell if                                                     | awk if                                                       |          |
| ------------------------------------------------------------ | ------------------------------------------------------------ | -------- |
| if [ "ceshi"-eq 18];then<br />echo "ceshi";<br />fi          | if(条件)<br />print “ceshi”                                  | **常用** |
| if[ "ceshi" -eq 18];then<br />echo "ceshi";<br />else<br />echo "ceshi2";<br />fi<br />#上面的eq写法是错误的！！！ | if(条件)<br />print “ceshi”<br />else<br />print "ceshi2"<br /> |          |
|                                                              | **多个语句使用{}**                                           |          |

`````sh
# df -h 磁盘超过 百分之70 就说明内存不足；显示信息；
root@d40d4317e0d5:~# df -h |awk -F "[ %]+" 'NR>1{if($5>100) print "disk not enough",$1,$4,$NF}' | column -t
disk  not  enough  overlay        52G   /
disk  not  enough  //10.0.75.1/G  277G  /datadisk/website
disk  not  enough  /dev/sda1      52G   /etc/hosts
# 面试题：统计这段语句中，字符数小于6的单词，显示出来
echo i am very shuai welcome to my home
$ echo i am very shuai welcome to my home | gawk "{for(i=1;i<=NF;i++) print $i}"
i
am
very
shuai
welcome
to
my
home

$ echo i am very shuai welcome to my home | gawk "{for(i=1;i<=NF;i++) print $i}"
i
am
very
shuai
welcome
to
my
home
#测试 一定要 i<=NF  就是行的最后一个元素；

[root@localhost network-scripts]# echo i am very shuai| awk '{for(i=1;i<=NF;i++)print $i}'
i
am
very
shuai

#显示长度大于6的字符串；
G:\website\docker-lnmp
$ echo i am very shuai welcome to my home | gawk '{for(i=1;i<=NF;i++) if(length($i) >6) print $i}'
welcome

G:\website\docker-lnmp
$ echo i am very shuai welcome to my home ceshicsss | gawk '{for(i=1;i<=NF;i++) if(length($i) >6) print $i}'
welcome
ceshicsss
# length()函数 显示字符串的长度  如果不写 就代表整行的字符数
echo ceshi | awk '{length()}'
root@d40d4317e0d5:~#  echo ceshi | awk '{print length()}'
5
#  某一个列
root@d40d4317e0d5:~#  echo ce	shi ceshi2 | awk '{print length($1)}'
5
root@d40d4317e0d5:~#  echo ceshi ceshi2 | awk '{print length($2)}'
6
`````



shell

````shell
# 数组的遍历；
# 常规数组的遍历；
#和初始化！！
  1 #!/bin/bash
  2 arr=("a" "b" "c")
  3 
  4 for i in ${arr[*]}
  5 do
  6 echo $i
  7 done
  8 
  9 echo -e "\n"
 10 
 11 for ((i=0;i<${#arr[*]};i++))
 12 do
 13     echo ${arr[i]}
 14 done
 ## 关联数组的遍历
 ## 关联数组的初始化！！
## 关联数组使用 declare 命令来声明，语法格式如下：declare -A array_name ，-A 选项就是用于声明一个关联数组。
 17 declare -A arr2=(["a"]="aval"  ["b"]="bval")
 	#declare -A arr21
 	#arr21["c"]="c"
 	#arr21["d"]="d"
 18 #echo "${arr2[*]}"
 19 #echo "${arr2[@]}"
 20 #这个是key的一维数组；然后遍历 输出key 就是了，${arr2[$key]} // 因为key是key数组的key 所以可以输出值；
 21 echo "${!arr2[*]}"
 22 #  遍历一维数组的方法来遍历就行！！！
 23 for key in ${!arr2[*]}
 24 do
 25 echo  $key "--->" ${arr2[$key]}
 26 done
````

 

````shell
#awk_test.sh 统计！！！

 #!/bin/bash
  2 
  3 awk -F"[./]+" '{a[$2]++}END{for (i in a) print i,a[i]}' awk_test
````



````shell
## shell 换行的问题！！
[root@810c31373153 test]# cat test.sh 
#!/bin/bash
echo "ssss"
echo -e "abc\nefg" 
printf "hello\nsss"

#man 文档！！！
# 可以用下面的方法来查看！！！
man echo | grep -i '\-e'
````



awk

循环    **他用括号()来标志 for if 语句的结束； 如果有多条命令 用{} 来表示；**

for(i=1;i<=100;i++)

​	print \$i



for(i in a)

print i,a[i]



if(条件)

print “success"

else

print  "fail"



数组：

awk

赋值；

array[0]=1；

引用

array[0] 直接引用

数组的遍历

for(i in a)

print i,a[i]



shell  do for的的借宿    ；then 代表if的结束；条件要放在 [] 里面；

array[0]=1

ip=(“ceshi” “ceshi1” “ceshi2");批量赋值；

引用

\${array[0]}

\$array  ==  \${array[0]}

数组的遍历

for i in \${array[\*]}  

do

echo \$i

done











