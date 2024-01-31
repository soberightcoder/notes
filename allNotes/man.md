# man

遇到的问题：想用man 查看C标准库函数的man pages，输入命令

```
man 2 read
```

bash命令行报错了

```
第2节没有关于read的手册页条目
```

在网上查了解决方案，这里也记录下关于man 的用法

man 中对命令和函数进行了分类，我们在查询时如果没有指定页面，查到的结果可能并不是我们想要的，底下是man pages的分类表



![img](https://img2020.cnblogs.com/blog/2002459/202004/2002459-20200410094728534-166626843.png)

 

 

 所以需要在查询是指定相应的代号可以精确的找到相应的结果

另外，系统应该默认不安装有关于标准库函数的man pages，我们需要手动安装，执行下述的命令，安装完成后我们就可以通过man 命令查看标准库上述里的头文件函数了。

linux下开发C代码需要安装的manpages：

$ sudo apt-get install manpages-dev
$ sudo apt-get install manpages-posix
$ sudo apt-get install manpages-posix-dev

**manpages-dev 包含 GNU/Linux 的基本操作API**
**manpages-posix 包含 POSIX 所定义公用程序的方法**
**manpages-posix-dev 包含 POSIX 的 header files 和 library calls 的用法**

**yum install -y install man-pages**   安装这个就可以实现 man 2 read  查看系统调用；

posix  

dev 





　　POSIX表示可移植操作系统[接口](https://www.hqchip.com/app/1039)（**Portable Opera[TI](https://bbs.elecfans.com/zhuti_715_1.html)ng System Interface of UNIX**，缩写为 POSIX ），POSIX标准定义了操作系统应该为应用程序提供的接口标准，是IEEE为要在各种UNIX操作系统上运行的软件而定义的一系列API标准的总称，其正式称呼为IEEE 1003，而国际标准名称为ISO/IEC 9945。

　　POSIX标准意在期望获得源代码级别的软件可移植性。换句话说，为一个POSIX兼容的操作系统编写的程序，应该可以在任何其它的POSIX操作系统（即使是来自另一个厂商）上编译执行。





### A note about CentOS version 7 and 8

The syntax is as follows on CentOS Linux 7 and 8:
`# yum install man-pages man-db man`





## Installing man pages on a CentOS 6

The syntax is as follows on **CentOS 6**:
`$ sudo yum install man man-pages`





## docker 安装 centos 容器安装 man；

// 可以使用轻量级虚拟机busybox吗？ 自带很多命令；我们直接通过这个来实现就可以了呀； 好像不行只有最基础的命令，并没有manman



## yum无法下载文档

容器可以看文档；

前面讲到Docker镜像为了减少大小，一般是不会下载软件文档的，即使后面重新安装了软件，会发现软件虽然安装了但文档却没有下载，这是通过`/etc/yum.conf`来设置的:

```
[main]
//...
tsflags=nodocs
```

将这行配置注释后，使用`yum`安装软件时就会自动下载文档了；其实这个选项是传递给了`rpm`命令，参看: [yum-plugin-tsflags](https://jsmith.fedorapeople.org/drafts/SMG/html/Software_Management_Guide/ch06s22.html)





## man  install

// centos7安装；

yum install -y man man-pages man-db

查找man手册相关内容，报错：

$man 2 read

No manual entry for read in section 2

解决办法：yum install man-pages

 

引申：man手册八章目录。

第一章：shell 命令。如：ls、vim，查询方法：>$ man ls

第二章：系统调用。如：open、close，查询方法：>$ man 2 open 或 >$ man close。因为第一章也有 open，所以 man 的参数中要加章节号；因为第一章中没有 close，所以查询 close 不需要加章节号。

第三章：库函数。如：printf、fopen，查询方法：>$ man 3 printf 或 >$ man fopen

第四章：/dev 下的文件。如：zero。

第五章：一些配置文件的格式。如：/etc/shadow，查询方法：>$ man shadow

第六章：预留给游戏的，由游戏自己定义。如：sol。

第七章：附件和变量。如 iso-8859-1。

第八章：只能由 root 执行的系统管理命令。如 mkfs。

第九跟kernel有关；内核有关；

`````c
// 3 c lib c语言的库函数 
// 1  shell 默认的；
//2  systemcall
// 5 ini 配置问题；
//9  内核有关的；
`````

