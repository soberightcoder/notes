# tcp 分析

>

---



不丢包！！  所以要做ack； 为了不丢包要做ack的确认ack；序列号都是要存在的！！



为了不等待；为了一个发送一个包不在等下一个包的发送，RRT；我们一般会一次发送多个包！来抢占路由队列资源！！！

会有很多等待RTT,所有时间很短

发很多包！！ 直到收到ack开始，每受收到一个ack就发一个包；发一个等一个！！！

等在RTT时间然后进行重传！！！

发多个包，抢占路由队列资源！！！



## 三次握手的目的就是为了协同序列号！！！

>主要目的就是约定双方的序列号！

C :       SYN --------seq=n-1---------->  S   监听模式！！ listen ;

SYN_SENT                                                                               

C:         <----  ACK ----- ack = n-------  S

C:        <--SYN-----seq = m -1---------- S

​															**<font color=red>SYN_RCVD  接收模式；</font>**

C：     -------ACK-----------ack = m---->

establish                                             establlish 

### 攻击机制，半连接洪水  SYN_FLOOD  攻击你的连接洪水！！

永远只占用，第一次握手，第二次发的包，这个服务端收不到！

当S ack 之后，就是一个半连接，就会创建一个连接池；

**半连接的目的即使占满你的连接池！！！**

肉鸡很多，没办法！！！

解决方案：攻击连接池，不要连接池；压根就不保存你！！

在网络传输过程中，2s已经是很长了！！！

HASH(Cip+Cport + Sip+Sport+CSprotocol + salt）  ==== cookie

salt 盐，由操作系统内核来产生，每一秒变一次，这个cookie给用户，

第二次握手，会把这个cookie发给客户端！！！

当第三次握手的时候要带上这个cookie，如果验证成功才会连接，如果不成功就是超时，说明网络不好！！！

也就是说当前一秒不成功，算上上一秒，如果还是验证不通过，说明，客户端网络不好！！！

