#php 一些基础知识点；

>**这一章节，必须要明白的一个概念就是，QPS！= 进程数，毕竟QPS是每秒处理的请求数，也就是每个请求每秒之内可以处理很多请求；**
>
>具体想起的qps需要用ab压测来测试；
>
>

---



**内存泄漏  memory leak  申请内存后无法释放自己申请的内存；一次泄漏不会有太大的危害，但是多次就会耗尽内存资源；多次就会造成内存溢出；**

**内存溢出  当申请一个内存时，没有足够的内存；**

l

**栈溢出**

1. **第一，程序要有向栈内写入数据的行为，并且写入长度要大于目标存储长度；；；；**



php是没有常驻内存的，除非使用swoole，一般一个请求结束的时候会销毁变量，global全局变量，static ，超全局变量；



php-fpm.conf  有一个参数，max_request  就是处理请求多少次会销毁这个worker进程来释放这些常驻内存；



php多进程模型是同步阻塞的；当进程数不够的时候只会被阻塞；因为php是同步阻塞的所以不会有任何的返回；



当请求数远远大于进程数目；

# An error occurred.  暂时不能服务；

Sorry, the page you are looking for is **currently unavailable.**
Please try again later.

If you are the system administrator of this resource then you should check the error log for details.

*Faithfully yours, nginx.*



-----



###php.fpm的一些参数：



### 查看位置：php-fpm.conf 配置的位置



**ps -ef  查看master主进程加载的配置的位置；** 



####php-fpm.conf  两部分：global 模块 和www模块



**www 就是php-fpm最重要的模块；应该是所有的子进程都是属于这一个进程池（www）；**



**一个php进程就需要占用20-40M的内存；**



####监听参数的介绍：

````shell
listen = 127.0.0.1:9000
#每个地址
; 必须用逗号分隔。 如果此值留空，则连接将是
; 从任何 IP 地址接受。
; 默认值：任何
#允许那些客户端链接；
listen.allowed_clients = 127.0.0.1
````

---



#### 静态模块



```shell
#进程管理的模式； 动态模式的优化
# PHP-FPM 会根据当前的负载情况动态调整活跃进程的数量。
pm = dynamic
#起始进程数；默认数；
pm.start_servers=10 
#最少空闲服务   保障至少 5个是空闲的；
pm.min_spare_servers = 5 # 最小空闲；
#php进程不能无限制的开启,限定最大的进程数目；因为资源是有限的；
pm.max_children = 50 # 最大进程数；
#空闲进程数超过10个之后，杀死多余的空闲进程；只保留十个空余进程；
pm.max_spare_servers = 10  #最大空闲；
#处理多少请求之后销毁； 
pm.max_requests = 500

```

---



#### 静态模块

`````shell

#静态模式  有请求就会开，开了就不管了；最大进程是static；
pm=static 
pm.max_children=50;
`````

---



#### 按需模式

````shell
#ondemand  按照需要的模式 有请求的时候会创建进程，但是空闲超时会被kill；
ondemand - no children are created at startup. Children will be forked when

;             new requests will connect. The following parameter are used:
;             pm.max_children           - the maximum number of children that
;                                         can be alive at the same time.
;             pm.process_idle_timeout   - The number of seconds after which
; 
an idle process will be killed.
pm=ondemand 
pm.max_children=500
pm.process_idle_timeout=10s
````

