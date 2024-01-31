# keepalive  http and tcp

>tcp 是保活  
>
>**KeepAlive并不是TCP协议规范的一部分，但在几乎所有的TCP/IP协议栈（不管是Linux还是Windows）中，都实现了KeepAlive功能。**
>
>
>
>http 是链接的复用
>
>---

---



http keepalive  仅仅是链接的复用减少链接频繁的创建；应该会有一个线程池直接去里面去拿就行了；

----



tcp keepalive  

* 这时候TCP协议提出一个办法，当客户端端等待超过一定时间后自动给服务端发送一个空的报文，如果对方回复了这个报文证明连接还存活着，如果对方没有报文返回且进行了多次尝试都是一样，那么就认为连接已经丢失，客户端就没必要继续保持连接了。**如果没有这种机制就会有很多空闲的连接占用着系统资源。**

* ## 使用的场景

  一般我们使用KeepAlive时会修改空闲时长，避免资源浪费，系统内核会为每一个TCP连接
  建立一个保护记录，相对于应用层面效率更高。

  常见的几种使用场景：

  1. 检测挂掉的连接（导致连接挂掉的原因很多，如服务停止、网络波动、宕机、应用重启等）
  2. 防止因为网络不活动而断连（使用NAT代理或者防火墙的时候，经常会出现这种问题）
  3. TCP层面的心跳检测

  KeepAlive通过定时发送探测包来探测连接的对端是否存活，
  但通常也会许多在业务层面处理的，他们之间的特点：

  - TCP自带的KeepAlive使用简单，发送的数据包相比应用层心跳检测包更小，仅提供检测连接功能
  - 应用层心跳包不依赖于传输层协议，无论传输层协议是TCP还是UDP都可以用
  - 应用层心跳包可以定制，可以应对更复杂的情况或传输一些额外信息
  - KeepAlive仅代表连接保持着，而心跳包往往还代表客户端可正常工作

* ## 如何设置它?

  在设置之前我们先来看看KeepAlive都支持哪些设置项

  1. KeepAlive默认情况下是关闭的，可以被上层应用开启和关闭
  2. **tcp_keepalive_time**: KeepAlive的空闲时长，或者说每次正常发送心跳的周期，默认值为7200s（2小时）
  3. **tcp_keepalive_intvl**: KeepAlive探测包的发送间隔，默认值为75s
  4. **tcp_keepalive_probes**: 在tcp_keepalive_time之后，没有接收到对方确认，继续发送保活探测包次数，默认值为9（次）

  我们讲讲在Linux操作系统和使用Java、C语言以及在Nginx如何设置

  ## 在Linux内核设置

  KeepAlive默认不是开启的，如果想使用KeepAlive，需要在你的应用中设置**SO_KEEPALIVE**才可以生效。

  查看当前的配置：

  ```bash
  cat /proc/sys/net/ipv4/tcp_keepalive_time
  cat /proc/sys/net/ipv4/tcp_keepalive_intvl
  cat /proc/sys/net/ipv4/tcp_keepalive_probes
  ```

  在Linux中我们可以通过修改 **/etc/sysctl.conf** 的全局配置：

  ```bash
  net.ipv4.tcp_keepalive_time=7200
  net.ipv4.tcp_keepalive_intvl=75
  net.ipv4.tcp_keepalive_probes=9
  ```

  添加上面的配置后输入 **sysctl -p** 使其生效，你可以使用 **sysctl -a | grep keepalive** 命令来查看当前的默认配置

  > 如果应用中已经设置**SO_KEEPALIVE**，程序不用重启，内核直接生效

  ------

  

## 和Http中Keep-Alive的关系

1. HTTP协议的Keep-Alive意图在于连接复用，同一个连接上串行方式传递请求-响应数据
2. TCP的KeepAlive机制意图在于保活、心跳，检测连接错误

# 前言

一开始接触到长连接、keepalive的概念时，可能对这些概念比较模糊，具体到协议以及开发中这些都是啥，以下几个问题展开说明，记录于此，有漏指正。

问题一：http1.1协议内容默认是长连接，即keepalive，同时在tcp协议中也有keepalive的概念，区别是什么？

问题二：http的长连接和tcp有什么关系？

问题三：长连接是为了传输效率，客户端/服务端都做了什么？

# 什么是keepalive

很明确的说，在http 应用层的keepalive 和 tcp 传输层的 keepalive是两个没啥关系的概念。

## 一、http

http 的keepalive是 http协议内容，http 是在tcp 建链完成的基础上进行的，keepalive意思我作为客服端告诉服务端，我的http消息发过去，你完事了不能把这个tcp链接给我关了，我建个tcp链接也不容易啊，下次我指不定还能用得上这个链接。

这里涉及到双端协议的大概：
 **第一**  client端connect()后，通过send/recv完成http请求后，不会立即关闭这个链接（**链接池统一管理**），下次不需要重新connect()而是直接从链接池中拿出来用。
 **第二**  server端被告知不能在send http response后立即关闭这个链接，http是无状态但是tcp必须双端都保证不关闭，所以http的keepalive 说直白点就是，在http 协议层通过头域connection:keep-alive 来确保两边都要**延迟关闭**tcp链接，以达到复用。

对于客服端，通常的实现是采用链接池，每次使用完的链接，统一由链接池管理，业务每次过来取一个可用的就行(如果服务端确实都关闭了，再重新再建也不迟)。



```php
ngx_http_keepalive_handler(ngx_event_t *rev)
{
...

c = rev->data;
ngx_log_debug0(NGX_LOG_DEBUG_HTTP, c->log,0,"http keepalive handler");


if (rev->timedout || c->close) {
    ngx_http_close_connection(c);
    return;
}
...
}
```

对于服务端，看一段nginx 源码，服务端收到keepalive请求后，没有把链接直接关掉，而是在定时器中注册超时回调函数**ngx_http_keepalive_handler**（注意nginx中epollo 事件c-read也被重置为ngx_http_keepalive_handler ，所以要么超时后定时器触发，要么有客服端发消息过来触发epoll读事件），如果是超时触发的rev->timedout=1（为毛说好的客服端半天没再发消息来，如果超时前客服端有消息过来，epoll read事件肯定先触发），又或者链接处于待关闭状态 c->close，这时候再关闭掉这个链接(服务端：我已经尽力了，兄弟)。说明链接并**不活跃**。

## 二、TCP

TCP建链完成后，可以想象为一根数据管道，要么正常传输，管道中有数据往来，要么处于闲置状态，等待被关闭，但是问题来了，通常在代码层面由客服端或服务端主动close(fd)(但要是代码就煞笔了没写漏掉了呢，且不懵逼，tcp协议栈在操作系统层面，操作系统自然不可能不管）。

对于这个链路有个**保活机制**保证，闲置状态下，每隔一段时间服务端会发送一个探测包，看客服端是否正常响应。以上面的http 的keepalive要求tcp保持一段时间这种情况为例。
 **第一**（假如突然就是没业务往来了），代码上也并没有nginx那样的关闭动作，那tcp自己的保活机制将会自动在2小时后关闭(操作系统参数配置)。
 **第二** 假如网路中断，服务端没收到任何客服端fin包是不可能知道网线断了的（有点夸张），那也可以通过这个机制，保证tcp正常关闭。

## 三、所以一句话：

http keepalive是协商如何复用tcp链接，即所谓http长连接，TCP keepalive是管道的保活机制，避免链接无业务盲等。



作者：七月牧夫
链接：https://www.jianshu.com/p/5895b3d62bf2
来源：简书
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。