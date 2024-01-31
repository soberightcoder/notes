# Linux 命令

>ss  ip
>
>command [options] [arguments]  命令 选项 参数；
>
>linux的开机启动	

##ss  socket statistics  socket 统计；

* **option**
  
  * -n number   -n, --numeric
                  Do not try to resolve service names.
  
  * -p pid      -p, --processes
              Show process using socket.  
  
  * -l  listening 
  
  * -t  tcp
  
  * -a all
  
  * -u upd 
  
  * -m memory
  
  * -r resolve 解析 服务名称
  
  * -s summary   socket 的总结和摘要
  
  * -o options    -o  stat "established"
  
    ````shell
    #筛选，摘要；
    ss -o stat "established"
    ss -o state FIN-WAIT-1 dst 192.168.25.100/24
    
    ss dst 192.168.25.100
    ss dst 192.168.25.100:50460
    
    ss src 192.168.25.140
    
    ss -antp | grep :80
    [root@localhost ~]# ss -antp | grep :80
    LISTEN     0      128          *:80                       *:*                   users:(("nginx",pid=2668,fd=6),("nginx",pid=2667,fd=6),("nginx",pid=1033,fd=6))
    
    ````
    
    

##  ip

ip a  s 







### lsof **  要认真的学一下；

>当前系统中打开的所有的文件；list open file；
>
>在Linux环境下，我们可以理解为一切(包括网络套接口)皆文件。在实际使用过程中，lsof是一款非常强大的系统监控和系统诊断工具。在终端下输入lsof 即可显示系统打开的文件， lsof 一般需要访问核心内存和各种文件，所以必须以 root 用户的身份运行它才能够充分地发挥其功能。





1. 普通文件
2. 目录
3. 网络文件系统的文件
4. 字符或设备文件
5. (函数)共享库
6. 管道，命名管道
7. 符号链接
8. 网络文件（例如：NFS file、网络socket，unix域名socket）
9. 还有其它类型的文件，等等





- -a 列出打开文件存在的进程

- -c<进程名> 列出指定进程所打开的文件

- -g 列出GID号进程详情

- -d<文件号> 列出占用该文件号的进程

- +d<目录> 列出目录下被打开的文件

- +D<目录> 递归列出目录下被打开的文件

- -n<目录> 列出使用NFS的文件

- -i<条件> 列出符合条件的进程。（4、6、协议、:端口、 @ip ）  网络连接 

- -p<进程号> 列出指定进程号所打开的文件  查看 process 进程的详细信息；

- -u 列出UID号进程详情

- -h 显示帮助信息

- -v 显示版本信息

  

```php
####
COMMAND：进程的名称
PID：进程标识符
TID：任务 ID。Linux 下 TID 为空表示该行为进程
USER：进程所有者
FD：文件描述符。主要有：
	cwd：应用程序当前工作目录，这是该应用程序启动的目录，除非它本身对这个目录进行更改
	txt：该类型的文件是程序代码，如应用程序二进制文件本身或共享库，如上列表中显示的 /sbin/init 程序
	lnn：库引用（AIX）
	err：FD 信息错误
	jld：监狱目录（FreeBSD）
	ltx：共享库文本（代码和数据）
	mxx：十六进制内存映射类型号 xx
	m86：DOS合并映射文件
	mem：内存映射文件
	mmap：内存映射设备
	pd：父目录
	rtd：根目录
	tr：内核跟踪文件（OpenBSD）
	v86：VP/ix 映射文件
	0：标准输出
	1：标准输入
	2：标准错误
	文件描述符后一般还跟着文件状态模式：
	r：只读模式
	w：写入模式
	u：读写模式
	空格：文件的状态模式为 unknow，且没有锁定
	-：文件的状态模式为 unknow，且被锁定
	
	同时在文件状态模式后面，还跟着相关的锁：
	N：对于未知类型的 Solaris NFS 锁
	r：文件部分的读锁
	R：整个文件的读锁
	w：文件的部分写锁
	W：整个文件的写锁
	u：任何长度的读写锁
	U：用于未知类型的锁
	x：用于部分文件上的 SCO OpenServer Xenix 锁
	X：用于整个文件上的 SCO OpenServer Xenix 锁
	space：无锁
TYPE：文件类型。常见的文件类型有：
    
	REG：普通文件 - 
	DIR：表示目录  d
	CHR：表示字符类型   c
	BLK：块设备类型 b
	UNIX：UNIX 域套接字 s
	FIFO：先进先出队列  f
	IPv4：IPv4 套接字    s
    软连接  l
    
DEVICE：磁盘名称
SIZE：文件的大小或文件偏移量（以字节为单位）
NODE：索引节点
NAME：打开文件的确切名称
```



**lsof -i   显示所有的网络连接；**

internet	



  lsof -i -U
              lsof -i 4 -a -p 1234
              lsof -i 6
              lsof -i @wonderland.cc.purdue.edu:513-515
              lsof -i @mace
              lsof -i@128.210.15.17
              lsof -i@[0:1:2:3:4:5:6:7]
              lsof -i@[::1]

https://zhuanlan.zhihu.com/p/187594222





可以查看那些进程打开了这些文件

**lsof /bin/bash**



**lsof -p pid   这个进程打开了那些文件；**

[root@localhost ~]# lsof -p $$
COMMAND  PID USER   FD   TYPE DEVICE  SIZE/OFF     NODE NAME
bash    2905 root  cwd    DIR  253,0      4096 33574977 /root
bash    2905 root  rtd    DIR  253,0       240       64 /
bash    2905 root  txt    REG  253,0    964536 50548532 /usr/bin/bash
bash    2905 root  mem    REG  253,0 106176928 50548516 /usr/lib/locale/locale-archive
bash    2905 root  mem    REG  253,0     61560    41768 /usr/lib64/libnss_files-2.17.so
bash    2905 root  mem    REG  253,0   2156592    41748 /usr/lib64/libc-2.17.so
bash    2905 root  mem    REG  253,0     19248    41755 /usr/lib64/libdl-2.17.so
bash    2905 root  mem    REG  253,0    174576    42114 /usr/lib64/libtinfo.so.5.9
bash    2905 root  mem    REG  253,0    163312     5783 /usr/lib64/ld-2.17.so
bash    2905 root  mem    REG  253,0     26970    42071 /usr/lib64/gconv/gconv-modules.cache
bash    2905 root    0u   CHR  136,3       0t0        6 /dev/pts/3
bash    2905 root    1u   CHR  136,3       0t0        6 /dev/pts/3
bash    2905 root    2u   CHR  136,3       0t0        6 /dev/pts/3
bash    2905 root  255u   CHR  136,3       0t0        6 /dev/pts/3



**lsof  -i  网路连接；**

**lsof -itcp**

**lsof -i @ip**

**lsof -i :80**





4、6、协议、:端口、 @ip   	 **多个属性可以使用 ，来隔开；**



**[root@localhost ~]# lsof -i :80 | awk '/^nginx/{ a[$NF]++}END{for(i in a)print i,a[i];}'**
**(LISTEN) 3**













