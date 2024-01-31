# [Centos7安装Redis](https://www.cnblogs.com/heqiuyong/p/10463334.html)

一、安装gcc依赖

由于 redis 是用 C 语言开发，安装之前必先确认是否安装 gcc 环境（gcc -v），如果没有安装，执行以下命令进行安装

 **[root@localhost local]# yum install -y gcc** 

 

二、下载并解压安装包

**[root@localhost local]# wget http://download.redis.io/releases/redis-5.0.3.tar.gz**

**[root@localhost local]# tar -zxvf redis-5.0.3.tar.gz**

 

三、cd切换到redis解压目录下，执行编译

**[root@localhost local]# cd redis-5.0.3**

**[root@localhost redis-5.0.3]# make**

 

四、安装并指定安装目录

**[root@localhost redis-5.0.3]# make install PREFIX=/usr/local/redis**

 

五、启动服务

5.1前台启动

**[root@localhost redis-5.0.3]# cd /usr/local/redis/bin/**

**[root@localhost bin]# ./redis-server**

 

5.2后台启动

从 redis 的源码目录中复制 redis.conf 到 redis 的安装目录

**[root@localhost bin]# cp /usr/local/redis-5.0.3/redis.conf /usr/local/redis/bin/**

 

修改 redis.conf 文件，把 daemonize no 改为 daemonize yes

**[root@localhost bin]# vi redis.conf**

![img](https://img2018.cnblogs.com/blog/1336432/201903/1336432-20190302212509880-1874470634.png)

后台启动

**[root@localhost bin]# ./redis-server redis.conf**

![img](https://img2018.cnblogs.com/blog/1336432/201903/1336432-20190302212804992-1094141996.png)

 

六、设置开机启动

添加开机启动服务

**[root@localhost bin]# vi /etc/systemd/system/redis.service**

复制粘贴以下内容：

[Unit]
Description=redis-server
After=network.target

[Service]
Type=forking
ExecStart=/usr/local/redis/bin/redis-server /usr/local/redis/bin/redis.conf
PrivateTmp=true

[Install]
WantedBy=multi-user.target

注意：ExecStart配置成自己的路径 

 

设置开机启动

**[root@localhost bin]# systemctl daemon-reload**

**[root@localhost bin]# systemctl start redis.service**

**[root@localhost bin]# systemctl enable redis.service**

 

创建 redis 命令软链接

**[root@localhost ~]# ln -s /usr/local/redis/bin/redis-cli /usr/bin/redis**

测试 redis

![img](https://img2018.cnblogs.com/blog/1336432/201903/1336432-20190302221347104-518199130.png)

 

服务操作命令

systemctl start redis.service  #启动redis服务

systemctl stop redis.service  #停止redis服务

systemctl restart redis.service  #重新启动服务

systemctl status redis.service  #查看服务当前状态

systemctl enable redis.service  #设置开机自启动

systemctl disable redis.service  #停止开机自启动

 

代码改变一切！







##daemon



https://blog.csdn.net/skh2015java/article/details/94012643



##**一、systemctl理解**
Linux 服务管理两种方式service和systemctl  centos7.x

systemd是Linux系统最新的初始化系统(init),作用是提高系统的启动速度，尽可能启动较少的进程，尽可能更多进程并发启动。

**systemd对应的进程管理命令是systemctl**

1. **systemctl命令兼容了service**
**即systemctl也会去/etc/init.d目录下，查看，执行相关程序**

**systemctl redis start**

**systemctl redis stop**

# 开机自启动

systemctl enable redis
2. **systemctl命令管理systemd的资源Unit**
**systemd的Unit放在目录/usr/lib/systemd/system(Centos)或/etc/systemd/system(Ubuntu)**



主要有四种类型文件.**mount,.service,.target,.wants**



.mount文件

.mount文件定义了一个挂载点，[Mount]节点里配置了What,Where,Type三个数据项

等同于以下命令：

mount -t hugetlbfs /dev/hugepages hugetlbfs

.service文件



.service文件定义了一个服务，分为[Unit]，[Service]，[Install]三个小节

**[Unit]**

**Description:描述，**

**After：在network.target,auditd.service启动后才启动**

**ConditionPathExists: 执行条件**

**[Service]**

**EnvironmentFile:变量所在文件**

**ExecStart: 执行启动脚本**

**Restart: fail时重启**

**[Install]**

**Alias:服务别名**

**WangtedBy: 多用户模式下需要的**

**.target文件**



**.target定义了一些基础的组件，供.service文件调用**

**.wants文件**



**.wants文件定义了要执行的文件集合，每次执行，.wants文件夹里面的文件都会执行**

二、常用命令
1.查看版本号
systemctl –-version


**2.管理服务(unit)**
**systemctl 提供了一组子命令来管理单个的 unit，其命令格式为：**

**systemctl [command] [unit]**

**command 主要有：**

**start：立刻启动后面接的 unit。**

**stop：立刻关闭后面接的 unit。**

**restart：立刻关闭后启动后面接的 unit，亦即执行 stop 再 start 的意思。**

**reload：不关闭 unit 的情况下，重新载入配置文件，让设置生效。**

**enable：设置下次开机时，后面接的 unit 会被启动。**

**disable：设置下次开机时，后面接的 unit 不会被启动。**

**status：目前后面接的这个 unit 的状态，会列出有没有正在执行、开机时是否启动等信息。**

**is-active：目前有没有正在运行中。**

**is-enabled：开机时有没有默认要启用这个 unit。**

**kill ：不要被 kill 这个名字吓着了，它其实是向运行 unit 的进程发送信号。**

**show：列出 unit 的配置。**

**mask：注销 unit，注销后你就无法启动这个 unit 了。**

**unmask：取消对 unit 的注销。**

**我们先通过 etcd.service 来观察服务类型 unit 的基本信息：**



输出内容的第一行是对 unit 的基本描述。

第二行中的 Loaded 描述操作系统启动时会不会启动这个服务，enabled 表示开机时启动，disabled 表示开机时不启动。而启动该服务的配置文件路径为：/lib/systemd/system/etcd.service。

第三行 中的 Active 描述服务当前的状态，active (running) 表示服务正在运行中。如果是 inactive (dead) 则表示服务当前没有运行。后面则是服务的启动时间。

第四行的 Docs 提供了在线文档的地址。

下面的 Main PID 表示进程的 ID，接下来是任务的数量，占用的内存和 CPU 资源。

再下面的 Cgroup 描述的是 cgrpup 相关的信息，笔者会在后续的文章中详细的介绍。

最后是输出的日志信息。

关于 unit 的启动状态，除了 enable 和 disable 之外还有：

static：这个 unit 不可以自己启动，不过可能会被其它的 enabled 的服务来唤醒。

mask：这个 unit 无论如何都无法被启动！因为已经被强制注销。可通过 systemctl unmask 改回原来的状态。

关于 unit 的运行状态 Active，除了 active 和 inactive 之外还有：

active (exited)：仅执行一次就正常结束的服务，目前并没有任何程序在系统中执行。举例来说，开机或者是挂载时才会进行一次的 quotaon 功能，就是这种模式！ Quotaon 不需要一直执行，只在执行一次之后，就交给文件系统去自行处理。通常用 bash shell 写的小型服务，大多是属于这种类型。

active (waiting)：正在执行当中，不过还再等待其他的事件才能继续处理。举例来说，打印的相关服务就是这种状态。

enable 和 disable 操作

比如我们为 etcd 服务创建了配置文件 /lib/systemd/system/etcd.service，然后执行 enable 命令：

systemctl enable etcd.service


所谓的 enable 就是在 multi-user.target.wants 下面创建了一个链接文件：



至于为什么会链接到 multi-user.target.wants 目录下，则是由 etcd.server 文件中的配置信息决定的。

查看 unit 的配置

使用 show 子命令可以查看 unit 的详细配置情况：

 systemctl show etcd.service
————————————————
版权声明：本文为CSDN博主「思维的深度」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。
原文链接：https://blog.csdn.net/skh2015java/article/details/94012643