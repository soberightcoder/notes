# All Commands

>所有的常用的linux命令！！！

---

## 基本命令

find 

`````shell
find / -name 1.txt -print0|xargs -0 ls -al
-size  大小 +10M 大于 10M的文件  j
-type f  d  文件和 目录  来区分  文件类型的查找；
-ctime -1    change  文件权限和内容都可以修改 一天之内的修改；   +1 代表的是 一天之前的修改；
-mtime    modify   仅仅修改了文件的内容
-cmin  分钟；
-atime access 读过那些文件 access 访问过的；

-maxdepth 3  文件的深度 是3；
-print0|xargs -0
#xargs 把标准输入转换成参数
`````



strace 

````shell
#strace 
以下是一些常用的 strace 命令选项：
-o <文件>：将跟踪结果输出到指定文件。
-p <进程ID>：跟踪指定进程的系统调用。
-e <系统调用>：指定要跟踪的系统调用。
-c：显示系统调用的统计信息。
-t：在每行输出中显示时间戳。
以下是一些示例用法：

#跟踪程序的系统调用：
strace <命令>
这将执行指定的命令，并显示该命令执行期间的系统调用。

#将跟踪结果输出到文件：
strace -o <文件> <命令>
这将执行指定的命令，并将跟踪结果保存到指定的文件中。

#跟踪指定进程的系统调用：
strace -p <进程ID>
这将跟踪指定进程ID的系统调用。

#跟踪指定系统调用：
strace -e <系统调用> <命令>
这将跟踪指定命令执行期间的特定系统调用。
#------------------------------------------
#记录一下网卡的位置把；
#跟踪进程的系统调用 system trace ;
strace -p pid -f -e -o out.txt

# -f 跟踪fork 生成的子进程 注意跟踪的时候fork的产生的子进程，注意nginx的本身的work process本身就存在，所以并不能抓取到；
#-ff 如果提供-o filename,则所有进程的跟踪结果输出到相应的filename.pid中,pid是各进程的进程号.
#  nginx的监听 只能开三个shell分别监听不同的进程；


# -t  在输出的每一行信息前加上时间信息
#-tt 在输出中的每一行前加上t时间信息,微秒级. 
# -e 过滤
# -e trace=set   # 只跟踪指定的系统调用。例如，-e trace=open, close, read, write 表示只跟踪open、close、read和write这四种系统调用
# -e trace=file  # 只跟踪与文件操作相关的系统调用
# -e trace=process # 只跟踪与进程相关的系统调用
# -e trace=network # 只跟踪与网络相关的系统调用
# -e trace=signal # 值跟踪与信号相关的系统调用
# -e trace=ipc     # 只跟踪与进程间通信相关的系统调用
# -e signal=set    # 只跟踪指定的信号。

#-o 将strace输出写入指定的文件
#-e  过滤

strace -e bind,connect,socket,poll  ping www.baidu.com

strace -f -F -o ~/straceout.txt myserver
-f -F选项告诉strace同时跟踪fork和vfork出来的进程，-o选项把所有strace输出写到~/straceout.txt里 面，myserver是要启动和调试的程序。 

````

tcpdump 

`````shell
tcpdump tcp的抓包工具 charles  wireshark   回环网卡（Loopback adaptor）
# 也是一个网络 数据包的截取分析工具；也就是抓包工具；
#参数
tcpdump port 8888
tcpdump tcp/arp/ip/
tcpdump src/dst（没有则，都要监听） host（ip的形式） hostname（域名） net（xxx.xxx.xxx/24）
#监听某一个网卡
tcpdump -i eth0/lo
tcpdump -w ~/wireshark/route.api.log
#也可以对条件使用and 来进行链接
tcpdump tcp port 80 and src host 127.10.0.5 and ！ip1 除了整个ip之外的
-c 100 ： 只抓取100个数据包
-t  不显示时间戳；
-s 0 ； 抓包的时候默认抓取长度为多少个字节；-S 0；是代表完全的数据包；
#eg
tcpdump -i ens33 tcp port 80 and dst host 192.168.146.18 -w ~/wireshark/request
`````



wireshark 

````shell
#npcap 不要再给删除了，卡巴斯基杀毒软件一直提示有病毒，md；
#1 选择监听的网卡
#2 筛选条件  icmp and ip.src=127.0.0.1 
#ping
````



###lsof  

````shell
# list open file 列出打开的文件！！
-i：显示网络连接信息。
-p：指定要显示的进程 ID。
-u：指定要显示的用户名。
-c：指定要显示的进程名称。  selects  the  listing of files for processes executing the command that begins with the characters of c.
# -i 网络状况！！
lsof -p pid 
#网络状况
lsof -i tcp
lsof -i :80
#-c characters 可以通过进程名字来进行查询；
lsof -c bash  #进程名是bash打开的文件！！！
````



###zip unzip

````shell
#-r目录递归的压缩！！
zip -r xxx.zip /to/path/  
````



###tar 

`````shell
压缩文件 zip 

tar -czvf 目标文件 源文件
解压： tar -xzvf 目标文件

v : 显示详情；verbose;
f ：指定文件；     -f, --file=ARCHIVE         use archive file or device ARCHIVE
c ：create  archive ;创建一个文档，也就是压缩；
x : extract;   extract files from an archive
z : gzip压缩  来减少压缩后文件的大小！！
-----------------------------------------------------------------------------------------
##注意这个命令可以使用 --exclude  可以排除一部分文件；


//tar -czvf    // tar.gz ;
 tar -czvf  /ceshi/ceshi.tar \ 
     --exclude=/ceshi/ceshi.log \
     /opt/web/suyun_web  
#在Linux中，tar命令用于创建和提取归档文件，它可以将多个文件和目录打包成一个单独的文件。tar命令支持多种选项和参数，其中 -z 是其中之一。
#-z 选项用于在 tar 命令中启用 gzip 压缩。当你使用 -z 选项时，tar 命令会在打包文件时使用 gzip 压缩算法对文件进行压缩，以减小文件的大小。

例如，如果你想将一个目录打包成一个压缩文件，可以使用以下命令：
#tar -czf archive.tar.gz directory/
在这个命令中，-c 选项表示创建新的归档文件，-z 选项表示启用 gzip 压缩，-f 选项后面指定了归档文件的名称（archive.tar.gz），最后是要打包的目录（directory/）。
这样，tar 命令将会创建一个名为 archive.tar.gz 的压缩文件，其中包含了 directory/ 目录中的所有文件和子目录，并使用 gzip 压缩算法进行压缩。
当你需要提取这个压缩文件时，可以使用以下命令：
#tar -xzf archive.tar.gz
在这个命令中，-x 选项表示提取归档文件，-z 选项表示解压缩，-f 选项后面指定了要提取的归档文件的名称（archive.tar.gz）。
这样，tar 命令将会解压缩并提取 archive.tar.gz 文件中的所有文件和目录。
`````



###ifconfig

````shell
#ifconfig 
interface config ###网卡信息
````



###ping 

`````c
// 分为几部分组成
//type (8位)  cod额（位）
//checksum  检查和 防止被篡改
//查询报文 
//type = 8 echo request请求  
//type = 0 echo reply 会送请求；
//差错报文 
//type = 3 不可达 code 0 网路不可达（网络有问题） 1 主机不可以达（host 有问题）  2 协议不可达 不允许ip协议 3 端口不可达，防火墙
//type = 11 超时，time exceeded;
`````



###man

``````shell
#man
1 shell命令 默认
2 systemcall
3 C语言库lib库函数库；
5 configure 文件配置
7 tcp 概括简介！！！之类的；
9 kernel 内核有关
``````



###ssh

````shell
ssh user@192.168.1.100   #登陆服务器的命令
##（默认为 22）。-p 可以修改端口！！！
ssh -p 2222 username@hostname
##在服务器上执行命令！！！
ssh username@hostname command

#产生公私钥的命令；
###ssh-kengen

# 默认是rsa 就是公私钥，非对称加密！！rsa 是三个人人名的首字母！！！
- `-t`：指定要生成的密钥类型。常见的选项包括 `rsa`、`dsa`、`ecdsa` 和 `ed25519`。默认为 `rsa`。 #type
- `-b`：指定密钥的位数。默认为 2048。
- `-C`：为生成的密钥添加注释。#commit
- `-f`：指定要生成的密钥文件的文件名和路径。#file path
- `-N`：为生成的密钥设置密码短语。

ssh-kengen -t rsa -C "qiuqiu@163.com"

````



kill 

````shell
kill -9
kill -15 
kill -9 是一个用于终止进程的命令，其中的 -9 是一个信号编号，表示强制终止进程。当你使用 kill -9 命令时，操作系统会发送一个 SIGKILL 信号给指定的进程，强制终止它的执行。
不可中断睡眠状态（D状态）是一种进程状态，通常发生在进程等待某些资源的情况下，例如等待磁盘I/O操作完成。在D状态下，进程无法响应信号或被终止。
尽管 kill -9 是一个强制终止进程的命令，但它并不能直接终止不可中断睡眠状态的进程。这是因为不可中断睡眠状态的进程处于内核级别的等待状态，无法被普通的信号终止。
##在大多数情况下，不可中断睡眠状态的进程是由于系统资源问题或驱动程序问题引起的。通常，最好的解决方法是识别和解决导致进程进入D状态的根本问题，而不是强制终止进程。
#crtrl + c 是发送什么信号！！SIGINT信号 kill -2
kill -l
````



ab  apache bench

````shell
ab -n 1000 -c 100 
Options are:
    -n requests     要执行的请求次数；
    -c concurrency  并发数量；
    -s timeout      响应时间；

​	-t timelimit 基准测试花费的时间；

 	-n requests     Number of requests to perform
    -c concurrency  Number of multiple requests to make at a time
    -t timelimit    Seconds to max. to spend on benchmarking
                    This implies -n 50000
    -s timeout      Seconds to max. wait for each response
                    Default is 30 seconds
-n: 请求个数 -c：并发量（模拟请求的客户端数量） -t: 多少秒内进行并发  ??????

demo
ab -n 1000 -c 100 -s 1 http://127.0.0.1:1080/event?config_name=mysql_config
````

### alias

`````shell
alias ll='ls -al'  取别名； type ll 
`````

### type 

````shell
type -t  # 查看命令的执行类型； 主要是这三种 alias builtin  file;
[root@810c31373153 linuxc]# type -t ls
alias
[root@810c31373153 linuxc]# type -t cd
builtin
[root@810c31373153 linuxc]# type -t  find
file
````

### chmod

`````shell
chmod -R 777 filename  chmod u+x filename  ugo(user group other)    rwx  组合 添加权限；go=
**文件的rwx 分别代表 打开文件读文件  修改写入文件  执行文件**
**目录的rwx 查看文件内容 必须是x的前提下，w文件的修改和重命名也必须在x的前提下，x允许打开目录；**
`````

crontab

````shell
##crontab  执行计划；定时任务；
##分 时 日 月 周

*代表 每
，并列
- 连续
/ 整除  能被整除都会被执行 能被整除才会运行  每隔多少分 或者每隔多少个小时运行一次；

*/2   2，4，6，8...58;
0/2  减去0 能被2 整除的会被执行；
7/2  也就是从 7分钟之后才会被执行；负的不会计算
秒的计时
* * * * *   执行脚本
* * * * * sleep 1;执行脚本   下一秒 运行脚本；每一秒运行脚本；
crontab -e 创建脚本
crontab -l 查看脚本
crontab -r 删除计划任务	
 # .---------------- minute (0 - 59)
  9 # |  .------------- hour (0 - 23)
 10 # |  |  .---------- day of month (1 - 31)
 11 # |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ...
 12 # |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat
vim /etc/crontab 
//
find 

curl 就是发送一个http请求

#看一下把；
示例：

0 4  * * 0     root emerge --sync && emerge -uD world              #每周日凌晨4点，更新系统

0 2 1 * *     root   rm -f /tmp/*                                                    #每月1号凌晨2点，清理/tmp下的文件

0 8 6 5 *   root     mail  robin < /home/galeki/happy.txt             #每年5月6日给robin发信祝他生日快乐

## 假如，我想每隔2分钟就要执行某个命令，或者我想在每天的6点、12点、18点执行命令，诸如此类的周期，可以通过 “ / ” 和 “ , ” 来设置：

*/2   *   *   *   *           root      ...............      #每两分钟就执行........

0 6,12,18   *   *   *    root      ...............      #每天6点、12点、18点执行........

##每两个小时

0 */2 * * * echo "have a break now." >> /tmp/test.txt

晚上11点到早上8点之间每两个小时，早上八点

0 23-7/2，8 * * * echo "have a good dream：)" >> /tmp/test.txt

每个月的4号与每个礼拜的礼拜一到礼拜三的早上11点

0 11 4 * 1-3 command line

1月1日早上4点

0 4 1 1 * command line
# #ls /var/log/cron* 日志所在的位置；可以查看位置；
````



### lszrz

````shell
yum install -y lrzsz 
##lrzsz 文件的上传和下载
yum install -y lrzsz 使用说明
##sz命令发送文件到本地：
 #sz filename1rz命令本地上传文件到服务器：
 #rzsz中的s意为send（发送），告诉客户端，我（服务器）要发送文件 send to cilent，就等同于客户端在下载。
##rz中的r意为received（接收），告诉客户端，我（服务器）要接收文件 received by cilent，就等同于客户端在上传。
##对象是 服务器；
````



### export env declare set 

`````shell
#查看环境变量
export  有序
env  无序
#自定义变量：  会显示所有的变量 包括环境变量和自定定义的变量！！！
declare 有序
set 无序  
##declare -x  也是声明一个 环境变量！！！

##declare
在 Linux 中，declare -x 是用于声明环境变量的命令。
## 通过使用 declare -x 命令，你可以将一个变量声明为环境变量，使其在当前会话中对所有子进程可见。
以下是 declare -x 命令的示例用法：
declare -x MY_VARIABLE="Hello, World!"
上述命令将会声明一个名为 MY_VARIABLE 的环境变量，并将其值设置为 "Hello, World!"。这样，该环境变量将在当前会话中对所有子进程可见。
你可以通过运行 echo $MY_VARIABLE 命令来验证环境变量是否设置成功。如果成功，它将会输出 "Hello, World!"。
##请注意，declare -x 命令只在当前会话中生效。如果你希望在每次登录时都自动设置环境变量，你可以将其添加到你的 shell 配置文件（如 ~/.bashrc 或 ~/.bash_profile）中。


##
env 用于显示环境变量或在指定环境下执行命令。
##declare 用于声明变量和设置变量属性，但默认情况下不会成为环境变量。
##但是，declare 命令声明的变量默认情况下不会成为环境变量，只在当前 shell 会话中可见。
set 用于设置 shell 的选项和位置参数，也可以用于设置普通变量。
export 用于将变量设置为环境变量，使其在当前 shell 会话中和所有子进程中可见。
`````



````shell
当涉及到 env、declare、set 和 export 命令时，以下是它们之间的详细区别：

env 命令：

##
env 命令用于显示当前环境变量的值或在指定环境下执行命令。
它可以用于查看当前环境中定义的所有环境变量。
##它还可以用于在特定环境中运行命令，例如 env VAR=value command。
env 命令不会直接设置或修改环境变量。

declare 命令：
declare 命令用于声明变量，并可以设置变量的属性。
在 Bash shell 中，declare 命令可以用于声明普通变量、数组变量、关联数组变量和函数。
它还可以设置变量的属性，如只读属性、整数属性等。
## 但是，declare 命令声明的变量默认情况下不会成为环境变量，只在当前 shell 会话中可见。

set 命令：
set 命令用于设置 shell 的选项和位置参数。
它还可以用于显示当前 shell 的设置。
在设置环境变量方面，set 命令可以用于设置普通变量。
与 declare 命令类似，set 命令设置的变量默认情况下不会成为环境变量，只在当前 shell 会话中可见。

## 
export 命令：
##export 命令用于将变量设置为环境变量，使其在当前 shell 会话中可见，并且对于所有子进程也可见。
通过使用 export 命令，你可以将一个普通变量提升为环境变量。
例如，export MY_VARIABLE="Hello" 将会将 MY_VARIABLE 设置为环境变量，使其对当前 shell 会话中的所有子进程可见。
总结：

##
env 用于显示环境变量或在指定环境下执行命令。
declare 用于声明变量和设置变量属性，但默认情况下不会成为环境变量。
set 用于设置 shell 的选项和位置参数，也可以用于设置普通变量。
export 用于将变量设置为环境变量，使其在当前 shell 会话中和所有子进程中可见。
````



---

## 文件处理和统计命令

###less more head tail cat

`````shell 
cat more less head tail 查看文件
cat  -n 显示行号 还有文件的合并 多个文件合并到一起 经常和split 来一起使用
more 空格往下翻 不能返回  最好用more来查看；more 去查看比较安全；
less space 往下翻 b返回 q 退出； 很明显要把文件全部加载到内存中 所以不能查看过大的文件；
head -n 
tail -n
tail -f 动态查看
`````



###grep 

````shell
grep  文本的过滤 注意后面的awk sed 文件的处理；
-i  忽略大小写  ****
-n 显示行号
-w 精确匹配 
-v 反向匹配
-A after 匹配到的后5行 -A5
-C context 上下文 -C5 上下文5行
-B before 前5行；

#eg
grep -v "#" man_db.conf  >> 1.txt  可以把注释选项给省略掉
docker inspect nginx | grep -i -C5 cmd

#注意  ：xargs 把标准输入转换成参数  一般配合 | 来使用；eg : echo 1 2 3 4 4 | xargs touch
````



###sed 

###awk



###uniq

```shell
uniq  去重 需要和 sort 联合使用
-c 计算重复出现的次数  count 
-d 只显示重复的行  显示重复的行    --repeated   only print duplicate lines, one for each group**
-u 只显示不重复的行               -u, --unique          only print unique lines
# 根据出现的次数进行排序
sort config | uniq -c | sort -r
```

####**sort**

`````shell
sort 排序（字典序，ascII排序）sort -nrk2 最出名的；
-r  反序
-n 自然数形式排序
-t 分隔符      -t, --field-separator=SEP
-k 第几个key 排序
-f 不区分大小写       -f, --ignore-case           fold lower case to upper case characters
# 根据出现的次数来进行排序
sort config | uniq -c | sort -r  
sort -t ":" -k 3 -f config
`````



wc  

````shell
wc word count
-l 计
-w 单词数
-c 字节数    -c, --bytes            print the byte counts
````



### ulimit -a

`````shell
#ulimit -a 查看用户的资源限制；
ulimit -u # 查看当前用户可以使用的进程数目；
ps -u root |wc -l #当前用已使用的进程数目；
# 僵尸进程战胜的原因，子进程退出的时候，没有wait父进程没有捕获到子进程的退出信息！！！没有办法清理子进程的一些资源！！！
ps -aux | grep -w Z  #查看 或者用top 来查看 是否有僵尸进程！！
##僵尸进程是接收不到 信号的 kill -9之类的！！1
`````



### column 

`````shell
#column -t 输出结果来制表！！！
`````



---

## 进程管理命令和资源使用状况的命令

>基本所有的信息都是从/proc/虚拟文件系统里获取的；
>
>可以通过 strce -e trace=open command 拉查看！！！！
>
>vmstat vitual memory statistics 虚拟内存的统计 对 进程 内存 cpu io 性能的监控！！1

###硬盘 

###du 

````shell
-sh  summary  
du disk usage 磁盘使用状况
-h 易读性比较好
-s 总结  sum 总计
-a 文件下的所有文件全部遍历；
#eg
du -sh 显示当前文件目录大小；
du -sh .  和上面一样！！！
du -sh * 
du -sh *| sort -nr
````



df

````shell
#  df - report free disk space
# 报告可用的磁盘空间！！！
df -T
[root@810c31373153 linuxc]# df  -T
Filesystem     Type    1K-blocks     Used Available Use% Mounted on
overlay        overlay  61664044  7268880  51233104  13% /
tmpfs          tmpfs       65536        0     65536   0% /dev
tmpfs          tmpfs     1023428        0   1023428   0% /sys/fs/cgroup
//10.0.75.1/G  cifs    314572796 16534868 298037928   6% /linuxc
/dev/sda1      ext4     61664044  7268880  51233104  13% /etc/hosts
shm            tmpfs       65536        0     65536   0% /dev/shm
tmpfs          tmpfs     1023428        0   1023428   0% /proc/scsi
tmpfs          tmpfs     1023428        0   1023428   0% /sys/firmware
[root@810c31373153 linuxc]# df
Filesystem     1K-blocks     Used Available Use% Mounted on
overlay         61664044  7268880  51233104  13% /
tmpfs              65536        0     65536   0% /dev
tmpfs            1023428        0   1023428   0% /sys/fs/cgroup
//10.0.75.1/G  314572796 16534868 298037928   6% /linuxc
/dev/sda1       61664044  7268880  51233104  13% /etc/hosts
shm                65536        0     65536   0% /dev/shm
tmpfs            1023428        0   1023428   0% /proc/scsi
tmpfs            1023428        0   1023428   0% /sys/firmware
````



iostat

`````shell
# 这个很重要！！！
# io 和cpu 都会统计 ，但是一般用来看 io负载问题，cpu可以使用mpstat来看多核！！！
# 一个系统吞吐量通常由QPS(TPS)
# 主要是用来看，io负载情况！！
#iostat
-k     Display statistics in kilobytes per second.
-m     Display statistics in megabytes per second.
-d     Display the device utilization report.
-x     Display extended statistics.
-c     cpu
-y     Omit first report with statistics since system boot, if displaying multiple records at given interval.
#iostat -dx -m  1 5

Device:         rrqm/s   wrqm/s     r/s     w/s    rkB/s    wkB/s avgrq-sz avgqu-sz   await r_await w_await  svctm  %util
sda               0.00     0.12    0.30    0.16     4.34    29.99   150.51     0.01   20.28    7.66   44.03   3.67   0.17
scd0              0.00     0.00    0.06    0.00     4.02     0.00   141.30     0.00    0.82    0.82    0.00   0.65   0.00
scd1              0.00     0.00    0.00    0.00     0.00     0.00     4.00     0.00    0.00    0.00    0.00   0.00   0.00

# 详解 这几个参数

# **avgqu-sz: 平均I/O队列长度。**  IO队列的长度；等待io操作的队列长度！！！
#**await: 平均每次设备I/O操作的等待时间 (毫秒)。** 系统延迟 这个单位是毫秒！！！ 不能太长！！！ 太长的话，肯定会有io瓶颈问题！！！
#**%util: 一秒中有百分之多少的时间用于 I/O 操作，即被io消耗的cpu百分比**
#还要去看一下 吞吐量！主要就是这几个数据！！！

**如果 %util 接近 100%，说明产生的I/O请求太多，**
**I/O系统已经满负荷，该磁盘可能存在瓶颈。**
**如果avgqu-sz比较大，也表示有当量io在等待。**

`````



## sar 

`````shell
##历史情况 io负载情况！！//todo
sudo yum install sysstat
`````



### 内存

free -h

````shell
[root@810c31373153 linuxc]# free -h
              total        used        free      shared  buff/cache   available
Mem:           2.0G        267M        147M        3.3M        1.5G        1.5G
Swap:          1.0G          0B        1.0G
````



vmstat

````shell
# 监控所有的信息 进程 内存 置换（swap） 磁盘io  系统  cpu
[root@810c31373153 linuxc]# vmstat
procs -----------memory---------- ---swap-- -----io---- -system-- ------cpu-----
 r  b   swpd   free   buff  cache   si   so    bi    bo   in   cs us sy id wa st
 0  0      4 144904  32724 1597396    0    0     6    23    7  133  0  0 100  0  0
 
 
#r : 数字 显示cpu中有多少个进程正在等待
#如果r列是数字，大于cpu核数，那么说明现在现在有大量的进程在等待cpu进行计算，现在可能出现了cpu不够用的情况。----cpu成了我们的性能瓶颈，此时，可能需要去增加cpu数量；或者减少运行的进程数。
#b ： 数字 现在有多少进程正在不可中断的休眠. 如果这个数字过大，就说明，资源不够用#

#cs context switch 上下文的切换！！！

##io
#bi block input 块输入！
#bo block output   块输出！ 

#st stolen  虚拟机占用的cpu；
````



pidstat  

````shell
# 这个要好好了解一下！！
## 监控某一个pid 进程的使用状况；
##pidstat 是一个 Linux 命令行工具，用于监视和报告进程的 CPU 使用情况、内存使用情况、I/O 活动和上下文切换等信息。它可以提供有关特定进程或整个系统的性能统计数据。
## pidstat - Report statistics for Linux tasks.
-d  Report I/O statistics (kernels 2.6.20 and later only).  The following values may be displayed:

pidstat 命令有许多参数可以用来定制其行为和输出。以下是一些常用的 pidstat 参数：

-p <PID>：指定要监视的进程的 PID。可以同时指定多个 PID，用逗号分隔。
##cpu  内存 和磁盘
-u：显示 CPU 使用情况的统计信息，包括用户空间和内核空间的 CPU 使用率、上下文切换和中断。
-r：显示内存使用情况的统计信息，包括物理内存和虚拟内存的使用量、页面错误和页面交换。
-d：显示磁盘 I/O 活动的统计信息，包括读取和写入的数据量、I/O 请求和平均响应时间。

-w：显示上下文切换的统计信息，包括进程切换和自愿/非自愿上下文切换。 # switch切换信息；

-t：显示进程的线程统计信息，包括线程数量、线程上下文切换和线程睡眠时间。
-h：以人类可读的格式显示输出，例如使用 K、M、G 来表示数据大小。
-I <interval>：指定输出的时间间隔，单位为秒。
-n <count>：指定输出的次数。
````





## 网路IO

>netstat  ss lsof -i 都是可以的！！！

netstat  

````shell
netstat -a   all 
## 查看网络状况和连接状况；
-a：显示所有的网络连接和监听端口。
-t：仅显示 TCP 协议相关的连接。
-u：仅显示 UDP 协议相关的连接。
-n：以数字形式显示 IP 地址和端口号。
-p：显示与连接相关的进程 ID 和程序名称。
-r：显示路由表信息。
#-s：显示网络统计信息。

-t tcp 
-u  udp 
-n  number  用 数字的形式显示 不需要使用host 直接使用ip就可以； 
-p 显示进程的信息；pid
-c continue  持续的输出  动态查看连接数；

$ netstat -ct   
这个命令可持续输出 TCP 协议信息。

# 展示正在监听的tcp连接 
netstat -tnl
-l listen  监听；
# 比较常用的命令
netstat -anp 
````

ss 

````shell
#netstat命令安装包是net-tools，ss命令的安装包是iproute2  iproute  也是可以的，并不一定需要2；
ss socket statistics
-a all
-t tcp
-u udp
-p    -p, --processes     show process using socket  process name process pid  fd     -p, --processes
              Show process using socket.
-l listen 
#-s statistics 统计！！！

ss -tl | grep :2375 
#注意 awk数组的遍历必须加（）shell 不需要（）
[root@localhost shell]# ss -antp | awk 'NR>1{b[$1]++}END{for (i in b) print i,b[i]}'
LISTEN 7
ESTAB 2
##sort -nrk2; 
[root@ab16eef254c6 linuxc]# ss -atp | awk 'NR>1{data[$1]++}END{for (i in data) print i,data[i]}' | sort -nrk2
LISTEN 1
````

`````shell
# ss和netstat的区别
ss 和 netstat 都是用于显示网络连接和相关信息的 Linux 命令，但它们在一些方面有所不同。
以下是 ss 和 netstat 的一些区别：
输出格式：ss 命令的输出格式更加简洁和易读，而 netstat 命令的输出格式较为繁杂。ss 命令的输出默认以表格形式展示，而 netstat 命令的输出则以文本形式展示。
#效率：ss 命令相对于 netstat 命令来说更加高效。ss 命令使用了更底层的系统调用来获取网络连接信息，因此在处理大量连接时，ss 命令的性能更好。
功能：ss 命令提供了更多的过滤和筛选选项，可以更精确地显示所需的网络连接信息。它支持更多的协议和状态过滤选项，可以根据源地址、目标地址、端口号等进行过滤。而 netstat 命令的过滤选项相对较少。
#兼容性：netstat 命令在不同的操作系统中具有更广泛的兼容性，而 ss 命令在某些较旧的 Linux 发行版中可能不可用。
#综上所述，ss 命令相对于 netstat 命令来说更加高效、功能更强大，并且输出格式更易读。但是，根据具体的需求和操作系统环境，你可以选择使用适合的命令。
## 安装 ss 只需要安装 iproute就行 在linux中！！
`````



## cpu

````shell
CPU
    These are percentages of total CPU time.
    us: Time spent running non-kernel code.  (user time, including nice time)
    sy: Time spent running kernel code.  (system time)  系统时间；
    id: Time spent idle. cpu空间时间；Mt #idle cpu的空闲时间！
    wa: Time spent waiting for IO.#cpu花在等待io的时间！
    st: Time stolen from a virtual machine. #stolen 偷窃虚拟机的cpu 时间；
````

top 

````shell
# top 然后 1 就是选择多核心！！！
# 可以查看的数据
##1. average load  平均负载
## 2. tasks 处于各种状态的进程数；
## 3 cpu 使用状况！！
## 4 内存使用状况
## 5 进程的详细信息！！！
````



mpstat mutiprocessor   

`````shell
#需要安装sysstat的工具包，这个工具包中带了很性能分析命令yum install sysstat -y
# multiprocessor  多核处理器！！！
# -P ALL：显示所有处理器的统计信息。
#mpstat 是一个用于监视多处理器系统的命令行工具。它提供了对每个处理器的使用率、上下文切换、中断和其他性能指标的实时监控。
mpstat -P ALL 2 5 

[root@810c31373153 linuxc]# mpstat -P ALL 1 2
Linux 4.9.60-linuxkit-aufs (810c31373153)       11/25/23        _x86_64_        (2 CPU)

## 多核的cpu使用状况！！
11:17:20     CPU    %usr   %nice    %sys %iowait    %irq   %soft  %steal  %guest  %gnice   %idle
11:17:21     all    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
11:17:21       0    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
11:17:21       1    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00

11:17:21     CPU    %usr   %nice    %sys %iowait    %irq   %soft  %steal  %guest  %gnice   %idle
11:17:22     all    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
11:17:22       0    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
11:17:22       1    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00

Average:     CPU    %usr   %nice    %sys %iowait    %irq   %soft  %steal  %guest  %gnice   %idle
Average:     all    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
Average:       0    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
Average:       1    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00    0.00  100.00
`````



uptime 

````shell
#平均负载！！！
[root@810c31373153 linuxc]# uptime
 10:58:01 up  7:46,  0 users,  load average: 0.00, 0.00, 0.00
````



## 进程

ps 

```shell
#todo

-aux   
-ef  进程关系
-eLf  线程；#light weight process LWP 轻量级进程 其实就是线程

#
ps -a显示当前终端相关的所有进程；当前用户下，会省略他的leader session（bash 领导会话！！）；也就是当前的shell（当前的bash）

ps -e 显示所有的进程；包括，所有的用户，包括无控制终端的命令；

ps -u 指定用户的所有进程； 

ps -f 显示pid 和ppid 以树关系的方式来显示！！！

ps -x 就是显示没有控制终端的进程  一般tty 是？ 的进程；

ps -aux 就是显示所有的进程；包括 所有的用户和无终端进程！！！##tty 是？ 的进程就是无终端进程；

ps -ef和 ps-aux 两种显示格式把；显示的信息是不一样的，你可以根据自己需要什么信息来查询那个命令！！！

#eg 
#shell  ctrl+Z: 把当前进程转到后台运行，使用fg命令恢复，或者使用bg命令后台运行
ctrl +z  前台服务后台运行；
jobs 查看命令号
fg % 命令号  #前台运行
bg % 后台运行
## 或者直接后台运行一个命令；
php index8.php &  # 直接后台运行！！
root@a398928451ab:/datadisk/website/Project# php index8.php &
[1] 350
# 会给你返回一个 jobs 
fg 1 ##就会把这个程序前台运行；
```



top 

````shell
## 还要总结一下呀；
## 动态的去监视 系统进程和系统资源的使用状况！！！！
#top 是一个常用的命令行工具，用于实时监视  系统的进程和系统资源  的使用情况。它提供了一个交互式的界面，可以显示当前运行的进程列表、CPU 使用率、内存使用情况、系统负载等信息。

当你运行 top 命令时，它会以实时更新的方式显示系统的状态信息。默认情况下，top 显示的是按 CPU 使用率排序的进程列表。你可以使用键盘上的不同命令来切换不同的视图和排序方式。

以下是一些常用的 top 命令的键盘命令：

q：退出 top 命令。
k：终止选定的进程。
r：修改选定的进程的优先级。

#1：切换到全局 CPU 使用率视图。 显示的是多核心！！！ 
#m：切换到内存使用情况视图。
#t：切换到进程和 CPU 时间视图。
#P：按 CPU 使用率排序进程列表。
#M：按内存使用率排序进程列表。

c：切换显示命令行参数。

top - 10:58:30 up  7:47,  0 users,  load average: 0.00, 0.00, 0.00
Tasks:   5 total,   1 running,   4 sleeping,   0 stopped,   0 zombie
%Cpu(s):  0.2 us,  0.2 sy,  0.0 ni, 99.7 id,  0.0 wa,  0.0 hi,  0.0 si,  0.0 st
KiB Mem :  2046860 total,   150496 free,   273520 used,  1622844 buff/cache
KiB Swap:  1048572 total,  1048572 free,        0 used.  1609548 avail Mem

  PID USER      PR  NI    VIRT    RES    SHR S  %CPU %MEM     TIME+ COMMAND                                                              
    1 root      20   0   11836   2812   2536 S   0.0  0.1   0:00.02 bash
   17 root      20   0   11812   2976   2572 S   0.0  0.1   0:00.05 bash
   92 root      20   0   81992   4044   3508 S   0.0  0.2   0:00.00 su
   93 root      20   0   11836   3000   2588 S   0.0  0.1   0:00.04 bash
  185 root      20   0   56060   3696   3196 R   0.0  0.2   0:00.00 top                                                                  
````

