#NAT（network address translation）

>total: 解决ipv4不够用的问题，有效的避免来自外网的攻击；
>
>作用：将私有地址抓换成公网ip地址；
>
>分类： 静态地址转换（static），动态地址转换（dynamic ），端口地址转换（port address translation）

*******

**static address translation**

一个私有ip和一个公有的ip绑定，一对一；

**dynamic address translation**

一个私有ip和一个地址池（公有地址池）来绑定，一个私有地址对应地址池中的一个公有地址；

**port address tanslatin**  **（这种用的是最多的）** *********

一个私有地址和一个公有地址的端口绑定，一个地址对应一个接口；

**私有地址**

A类  10.1.0.0 - 10.16.255.255

B类 172.16.0.0 - 172.31.255.255

C类 192.168.0.0 - 192.168.255.255

