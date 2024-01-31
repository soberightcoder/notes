#虚拟机连接网络的方式ping

> 连接网络的方式；
>
> Internet Protocol version 4，*IPv4*
>
> : 9位数。分析如下：1、1亿=100000000
>
> 32位系统最多可以寻址2^32Byte内存； 也就是4G内存；32位电脑最多可以有4G的内存；	
>
> ipv4 一共有2^32 一共40亿个ip地址；

https://www.cnblogs.com/jpfss/p/8616517.html



### DHCP （Dynamic Host ConfigurationProtocol）动态主机配置协议

ip netmask gateway dns

arp 通过ip来查询mac地址；



### 路由  dstination  网关 子网掩码

````shell
[root@localhost ~]# route
Kernel IP routing table
Destination     Gateway         Genmask         Flags Metric Ref    Use Iface
default         gateway         0.0.0.0         UG    100    0        0 ens33
192.168.146.0   0.0.0.0         255.255.255.0   U     100    0        0 ens33

````



###交换机  会有一张 端口和mac地址绑定的mac地址表；

目的：把数据包发送到正确的位置；连接多个电脑也就是连接多个电脑；

交换机就是通过维护的mac地址表来找到目标的端口；

如果目的mac地址不在mac地址表那么就会使用arp协议去获取mac地址；并且缓存到mac地址表中；d



###**交换机和路由的区别？**

交换机：连接电脑与电脑（网卡连接网卡）；mac地址表；

路由器：连接网络和网络；



### wlan  lan  vlan  vpn的区别？

lan  局域网 用户自己的；

vlan 隔离广播域  一个vlan 是一个处于一个相同的广播段；如果想要跨网段传播 那么就需要路由器；vlan间的通信；

   虚拟局域网，也就是将一个物理上的局域网划分成多个逻辑上的局域网，隔离广播域，互相不能通信；如果想要通信，那么就需要路由；也就是网关；

wan 广域网 



### 虚拟机的网络连接方式？

>
>
>查看网卡的网关命令

在linux上跟网络有关的配置？？？？？？

https://blog.csdn.net/qq_15304853/article/details/78700197

`````shell
ip route # 查看网卡的网关命令
`````

注意： [CentOS7](https://so.csdn.net/so/search?q=CentOS7&spm=1001.2101.3001.7020)最小化安装后是没有 ifconfig 命令的,所以没有办法通过 ifconfig 查看网卡相关配置信息的，这个时候通过新的ip 命令来查看网卡相关配。

````shell
ip addr  查看centos的地址；
````

 **CentOS7默认网卡接口配置文件**

````shell
vim /etc/sysconfig/network-script/ifcfg-ens33

[root@localhost ~]# cat /etc/sysconfig/network-scripts/ifcfg-eno16777736 通过 cat 查看CentOS7最小化安装默认网卡设备配置信息, 如下:
 
TYPE=Ethernet               # 网卡类型：为以太网
PROXY_METHOD=none           # 代理方式：关闭状态
BROWSER_ONLY=no             # 只是浏览器：否
BOOTPROTO=dhcp              # 网卡的引导协议：DHCP[中文名称: 动态主机配置协议]
DEFROUTE=yes                # 默认路由：是, 不明白的可以百度关键词 `默认路由` 
IPV4_FAILURE_FATAL=no       # 是不开启IPV4致命错误检测：否
IPV6INIT=yes                # IPV6是否自动初始化: 是[不会有任何影响, 现在还没用到IPV6]
IPV6_AUTOCONF=yes           # IPV6是否自动配置：是[不会有任何影响, 现在还没用到IPV6]
IPV6_DEFROUTE=yes           # IPV6是否可以为默认路由：是[不会有任何影响, 现在还没用到IPV6]
IPV6_FAILURE_FATAL=no       # 是不开启IPV6致命错误检测：否
IPV6_ADDR_GEN_MODE=stable-privacy           # IPV6地址生成模型：stable-privacy [这只一种生成IPV6的策略]
NAME=eno16777736            # 网络接口名称，即配置文件名后半部分。
UUID=f47bde51-fa78-4f79-b68f-d5dd90cfc698   # 通用唯一识别码, 每一个网卡都会有, 不能重复, 否两台linux只有一台网卡可用
DEVICE=ens33                # 网卡设备名称
ONBOOT=no                   # 是否开机启动， 要想网卡开机就启动或通过 `systemctl restart network`控制网卡,必须设置为 `yes` 


#网卡配置
 DEVICE=ens33  #要配置的网卡
 ONBOOT=yes    #开机自启动
 BOOTPROTO="static"  #静态ip方式
 IPADDR=192.168.189.130 # ipv4地址
 PREFIX=24
 GATEWAY=192.168.189.2  #设置网关
 DNS1=115.156.76.144  #设置主DNS
 DNS2=8.8.4.4  #设置备用DNS
 
       # GATEWAY0=192.168.189.2  #设置网关，此处为局部变量设置，它会覆盖/etc/sysconfig/network中的全局设置，不建议在此配置。
       # DNS1=115.156.76.144  #设置主DNS，此处为局部变量设置，总的DNS=/etc/resolv.conf 中的全局设置+此处的局部设置，此处可写可不写。
       # DNS2=8.8.4.4  #设置备用DNS，同上。
````

### DNS的配置

````shell
2、DNS配置
      如果没有DNS服务就会出现无法解析域名的情况，如： ping www.baidu.com
      
  解决方式一、打开 /etc/hosts 文件

  [root@localhost ~]# vi /etc/hosts  输入IP与域名的对应记录, 保存退出。
  
     解决方式二、域名无穷无尽，只能采用配置DNS方式解决域名解析问题，NDS配置文件如下：

      vi /etc/resolv.conf
       添加如下内容：
                nameserver 115.156.76.144  #默认域名服务器
                nameserver 8.8.8.8 #google域名服务器
                nameserver 8.8.4.4 #google域名服务
````

### 全局网关和开启网路的配置

`````shell
1、开启网络，再次设置网关（一般情况下重启电脑都会自动配置好网关）
       vi /etc/sysconfig/network ，将NETWORKING值设为yes,设置GATEWAY值为现在的网关，如下：


        NETWORKING=yes #表示系统是否使用网络，一般设置为yes。如果设为no，则不能使用网络。

        HOSTNAME=centos #设置本机的主机名，这里设置的主机名要和/etc/hosts中设置的主机名对应

        GATEWAY=192.168.189.2 #设置本机连接的网关的IP地址。
`````



* NAT 网络地址转换v8： 网络

* host-only  v1仅主机 模式  要和外部通信 需要 只能和主机来进行通信；不能和外网通信，除非使用网络共享；
* bridge  v0 桥接模式   相当于看成一个交换机把，gateway 和主机是一样的；netmask 也是 ipaddr 只能是和主机在一个网络内；



**下面的v1 和 v8 和v0 是网络接口 仅仅是为了主机和虚拟机之间的通信；**

````shell


以太网适配器 VMware Network Adapter VMnet1:

   连接特定的 DNS 后缀 . . . . . . . :
   本地链接 IPv6 地址. . . . . . . . : fe80::58b:dfd7:c40e:861d%22
   IPv4 地址 . . . . . . . . . . . . : 192.168.222.1
   子网掩码  . . . . . . . . . . . . : 255.255.255.0
   默认网关. . . . . . . . . . . . . :

以太网适配器 VMware Network Adapter VMnet8:

   连接特定的 DNS 后缀 . . . . . . . :
   本地链接 IPv6 地址. . . . . . . . : fe80::29eb:b15:e027:a641%8
   IPv4 地址 . . . . . . . . . . . . : 192.168.146.1
   子网掩码  . . . . . . . . . . . . : 255.255.255.0
   默认网关. . . . . . . . . . . . . :

无线局域网适配器 WLAN:

   连接特定的 DNS 后缀 . . . . . . . :
   本地链接 IPv6 地址. . . . . . . . : fe80::9d2f:4e7b:a0ff:5ffe%4
   IPv4 地址 . . . . . . . . . . . . : 192.168.1.103
   子网掩码  . . . . . . . . . . . . : 255.255.255.0
   默认网关. . . . . . . . . . . . . : 192.168.1.1
````







##  这个很重要 一定要明白

`````shell
# 一定要记住 交换机处于链路层 是没有ip的说法的；
# 但是不同的网段是怎么通信的呢？ 其实这里靠的是路由表来实现的；
#  用路由来实现的；类似于 docker0 肯定都是NAT来实现的； docker0 接入网络的方式 其实是类似于路由的； 访问外网需要做nat转换；
# 桥接 类似于 一台电脑 用交换机接入到网络
# 一台路由器 的lan口和wifi连接的设备的ip都是处于同一个网段的；
#NAT 是单向的，只能从内部访问外部，外部访问内部的ip需要做内网穿透，或者需要做端口的绑定；

`````



#### 网卡

网卡作为计算机与计算机间进行通信的桥梁，主要有以下两大功能一是**读入由网络设备传输过来的数据包**，经过拆包，**将其变成计算机可以识别的数据**，并将**数据传输到所需设备中**；另一个功能是将计算机**发送的数据**，打包后输送到其他网络设备中。

接收数据和发送数据；

网络是通过模拟信号将信息转化为电流传播的，网卡在这里面就充当了一个解码器的作用**，将电信号重新转换文文字图像等就是网卡的责任**。网卡的其他功能还有监控上传及下载流量，控制网速稳定的作用，它就相当于电脑的港口，所有信息上传到网络之前都要先到网卡这里走一遭。



网卡是网络接口卡NIC（NetworkInterfaceCarD.的简称，也称为网络适配器，通信适配器或网络接口卡，它是连接计算机与网络的硬件设备，是局域网最基本的组成部分之一。



一台计算机可以有多个网卡，然后我们就可以根据 路由规则来查看使用那个网卡来上网；

````shell
[root@localhost ~]# route
Kernel IP routing table
Destination     Gateway         Genmask         Flags Metric Ref    Use Iface
default         gateway         0.0.0.0         UG    100    0        0 ens33
172.17.0.0      0.0.0.0         255.255.0.0     U     0      0        0 docker0
192.168.146.0   0.0.0.0         255.255.255.0   U     100    0        0 ens33

````

其实都是同一个链路上的，直接就可以访问；其实就是创建了一个路由规则和一个网卡；然后来实现通信；

### 光猫

将光信号转成上网需要的信号（二进制把）；

路由器 就是把光猫转换成的信号传输到各个家中的各个设备中去；--------------
