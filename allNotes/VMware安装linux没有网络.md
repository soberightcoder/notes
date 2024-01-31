# VMware安装linux没有网络

安装centos7，没有网络，解决方案：

* ping 8.8.8.8用来查看又没有网络；

* 激活网卡

  ~~~
  vim   /etc/sysconfig/network-scripts/ifcfg-eth0     //找到自己定义的网卡，不一定是这个名字。默认是eth0
  onboot=yes  
  
  ifconfig  if === interface  就是网卡  ifconfig  就是网卡配置；
  ~~~

  * onboot:就相当于一个网卡的开关，只有打开了这个开关才能网络通信；

* reboot 重启linux；

  

**interfaces 也有网卡意思 ，其实就是当一个接口用；**

```
ifconfig` `eth0 up    ``# 启动 <br>ifcfg etho up      # 启动
ifconfig` `eth0 down   ``# 关闭<br>ifcfg eth0 down     # 关闭
ifconfig` `eth0 reload  ``# 重启
```

