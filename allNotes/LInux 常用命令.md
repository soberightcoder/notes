#  LInux 常用命令(包含一小小部分windows的，自动过滤)

#### ln -s 源目文件 目标文件

软连接 （类似于windows的快捷方式）

解决的问题：不用再每一个目录都放一个相同的文件，不必重复的占用磁盘空间；

有两个特性

* 同步 每一出链接文件发生更新 其他的文件都发生更新
* ln -s（symbolic） 软链接 ln 没参数是硬链接   
  * 软链接 会在你选定的位置创建一个镜像，不会占用磁盘空间；
  * 硬链接 没有有参数 -shuangjji按 ，会在你选定的位置创建一个和源文件大小相同的文件 占用磁盘空间；



#### //安装软件命令 configure make make install 

理解这几个命令需要知道几个概念：

* GCC: GUN Compiler Collection (GUN编译器套件)，就是一个编译器 ，可以编译很多语言；
* C语言的执行流程，源文件编译变成可执行文件（exe文件，计算机可以识别的二进制文件），然后才能去运行，C语言一次编译，多次执行；



configure:  就是一个shell脚本；用来检查你安装平台的目标特性（环境）；**./configiure 生成Makefile为编译做准备；**当然我们也可以添加参数来进行控制，例如：./configure --prefix=/usr,安装在/usr目录，指令就会安装在/usr/bin，同时一些软件的配置文件可以通过--sys-config=，有一些软件可以加--with，--enable，--without，--disable等等参数对编程加以控制，你可以通过 ./configure --help 查看详细说明情况；

make:用来编译，他从Makefile中读取指令，然后编译；

make install :从Makefile中读取指令，安装到指定的目录（有些软件需要make check 或者make test来进行一些测试）；

参考  https://www.jianshu.com/p/c70afbbf5172

----



#### Docker Debian procps net-tools ping

debian系统 安装procps（ps）和net-tools（ifconfig），apt-get update 更新索引源，源所在的位置/etc/apt/source.list.d ,/etc/apt/source.list（如果你感觉自己的源速度太慢，可以修改成国内源）,然后直接安装，apt-get install procps；还有安装ping命令的时候需要安装inetutils-ping（utils 工具）iproute 路由工具；

#### tracert(windows) traceroute(linux)

**追踪网络数据包的路由途径**c

tracert url

tracetoute url

#### **windows** 端口被占用

例如：443端口被占用；

~~~
netstat -ano | findstr/grep 443              //获取pid_name
~~~

* a :所有
* n:以数字的形式显示端口和地址；
* -o    -o            显示拥有的与每个连接关联的进程 ID。
* t:tcp协议；
*  -p proto      显示 proto 指定的协议的连接；proto
                  可以是下列任何一个: TCP、UDP、TCPv6 或 UDPv6。如果与 -s
                  选项一起用来显示每个协议的统计信息，proto 可以是下列任何一个:
                  IP、IPv6、ICMP、ICMPv6、TCP、TCPv6、UDP 或 UDPv6。

~~~
tasklist | findstr/grep pid_num
~~~

~~~shell
//方法1
ctrl+shift+esc 打开任务管理器，关掉进程;
//方法2
taskkill /pid pid_num  //杀死进程 就是linux中的kill -9 pid_num

#强制杀死  taskkill /F /pid 13116
$ taskkill /F /pid 13616
SUCCESS: The process with PID 13616 has been terminated.
~~~

### LInux浏览文件的命令  cat  less more



cat 是查看所有的文件内容，一下子全部显示出来

* -n  是number 显示行号

* -b 对于非空输出行号

  ~~~
  cat -n 123.txt 456.txt  //可以连接多个文件
  ~~~

less 不是显示所有的内容，是一页一页的展示：

* 空格回车都是下一页
* b上一页
* q退出
* = 显示光标所在位置的一些详细信息，字符数呀，占用了多少比例，是多少行

more  比less 简单是  less的前身 空格就是翻页 不能回退

### linux export 

`````sh
export -np  
#-n删除
#-p 显示所有的环境变量
export CESHI=test 就是环境变量参数；
#如果像保持持久化 可以写入到.bashrc        source ~/.bashrc  
`````

Linux export 命令用于设置或显示环境变量。

export  之后一定要使用source 之后才会生效；source /etc/profile

在 shell 中执行程序时，shell 会提供一组环境变量。export 可新增，修改或删除环境变量，供后续执行的程序使用。export 的效力仅限于该次登陆操作。













## tasklist

>**findstr  可以换成 grep 因为我是用的是cmder 所以 可以使用一些 linux命令；来做代替！！！！**

本文主要是介绍Windows结束某个端口的进程，对大家解决编程问题具有一定的参考价值，需要的程序猿们随着小编来一起学习吧！

1.打开cmd命令窗口，输入命令：`netstat -ano | findstr 8080`，根据端口号查找对应的PID。结果如下：

![img](./LInux%20%E5%B8%B8%E7%94%A8%E5%91%BD%E4%BB%A4.assets/202204030720447846.png)

发现8080端口被PID（进程号）为2188的进程占用。

2.根据PID找进程名称，输入命令：`tasklist | findstr 2181`，发现是占用8080端口的进程为：javaw.exe。

![img](./LInux%20%E5%B8%B8%E7%94%A8%E5%91%BD%E4%BB%A4.assets/202204030720448784.png)

3.根据PID结束对应进程。输入命令`taskkill -PID 2188 -F`，强制关闭PID为2188的进程。 

![img](./LInux%20%E5%B8%B8%E7%94%A8%E5%91%BD%E4%BB%A4.assets/202204030720449734.png)

 
