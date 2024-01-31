# limit rate

###限流模块	分为 限请求  和 限连接两种方式；



###限制请求 

* [ngx_http_limit_req_module](http://nginx.org/en/docs/http/ngx_http_limit_req_module.html)

  1. **定义：**

     limit_req_zone \$binary_remote_addr（二进制的ip地址；4个字节） zone=req_zone:10m(开启一个10M的内存；这边是保存二进制ip的桶) rate1r/s（流 是每个ip每秒只能访问1次）; 

     

     **limit_req_zone \$binary_remote_addr zone=req_zone:10m rate=1r/s;**

     context:http;

     **当每秒同一个ip访问多次的时候就会返回503；**

     **rate : 速率以每秒请求数 (r/s) 为单位指定。如果需要小于每秒一个请求的速率，则在每分钟请求 (r/m) 中指定。例如，每秒半请求为 30r/m**

     
  
  2. **引用：**
  
     Syntax:	limit_req zone=name [burst=number] [nodelay | delay=number];
  
     **eg**:limit_req zone=req_zone;
  
     brust 
     
     context:server location http
     
     

<font color=red> **限流的算法**</font>

https://blog.csdn.net/hellow__world/article/details/78658041



* limit_req zone=req_zone;
  严格依照在limti_req_zone中配置的rate来处理请求
  超过rate处理能力范围的，直接drop
  表现为对收到的请求无延时

* limit_req zone=req_zone burst=5;
  依照在limti_req_zone中配置的rate来处理请求
  同时设置了一个大小为5的缓冲队列，在缓冲队列中的请求会等待慢慢处理
  超过了burst缓冲队列长度和rate处理能力的请求被直接丢弃
  表现为对收到的请求有延时
* limit_req zone=req_zone burst=5 nodelay;
  依照在limti_req_zone中配置的rate来处理请求
  同时设置了一个大小为5的缓冲队列，当请求到来时，会爆发出一个峰值处理能力，对于峰值处理数量之外的请求，直接丢弃
  在完成峰值请求之后，缓冲队列不能再放入请求。如果rate＝10r/m，且这段时间内没有请求再到来，则每6 s 缓冲队列就能回复一个缓冲请求的能力，直到回复到能缓冲5个请求位置。

<font color=red>注意：</font>

**注意：令牌桶算法不能与另外一种常见算法“漏斗算法（Leaky Bucket）”相混淆。这两种算法的主要区别在于“漏斗算法”能够强行限制数据的传输速率，而“令牌桶算法”在能够限制数据的平均传输数据外，还允许某种程度的突发传输。在“令牌桶算法”中，只要令牌桶中存在令牌，那么就允许突发地传输数据直到达到用户配置的门限，因此它适合于具有突发特性的流量。（这部分是网上很多博客都错误的地方）**



```shell
 # 注意之类 需要先过滤出来 tcp连接 然后再进行统计；  sort -nrk2 反序 数字排序  第二个key排序；
 netstat -nt | awk '/^tcp/ {S[$NF]++} END {for(a in S) print a, S[a]}'  | sort -rnk2      
 
 # tcp协议；
 [root@localhost html]# netstat -na | awk '/^tcp/'
tcp        0      0 127.0.0.1:25            0.0.0.0:*               LISTEN     
tcp        0      0 0.0.0.0:6379            0.0.0.0:*               LISTEN     
tcp        0      0 0.0.0.0:80              0.0.0.0:*               LISTEN     
tcp        0      0 0.0.0.0:22              0.0.0.0:*               LISTEN     
tcp        0     36 192.168.146.29:22       192.168.146.1:49627     ESTABLISHED
tcp6       0      0 ::1:25                  :::*                    LISTEN     
tcp6       0      0 :::6379                 :::*                    LISTEN     
tcp6       0      0 :::22                   :::*                    LISTEN     



[root@localhost ~]# 

LISTEN 7
ESTABLISHED 1

```



- [ngx_http_limit_conn_module](http://nginx.org/en/docs/http/ngx_http_limit_conn_module.html)

  

**limit_connect 限制tcp连接的模块；**





###工具 压测工具

apachebench 

ab -c 100 -n 10000 url







##nginx的限流主要通过修改nginx.conf文件来进行，有两种限流方式：

通过请求数进行限流
通过连接数进行限流
通过请求数进行限流

```nginx
http {
	limit_req_zone $binary_remote_addr zone=iplimit:10m rate=1r/s;
    server {
        server_name  www.nginx-lyntest.com;
        listen       80;
        location /access-limit/ {
            proxy_pass   http://127.0.0.1:5001/;
            # 根据ip地址限制流量
            limit_req zone=iplimit burst=2 nodelay;
        }
    }
}
```

参数解释：

**$binary_remote_addr：binary_目的是缩写内存占用，remote_addr表示通过IP地址来限流**
**zone:iplimit是一块内存区域（记录访问频率信息）,20m是指这块内存区域的大小**

**rate: 1r/s = 1 request / second，类似于100/m（每分钟100次请求）**

**burst: burst=2,设置一个大小为2的缓存区域，当大量请求到来，请求数量超过限流频率时，将其放入缓冲区域**

**nodelay: 缓冲区满了后直接返回503异常**



我们启一个简单的http服务，使用5001端口，/nginx路由返回一个string

````nginx
func main() {
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		w.Write([]byte("httpserver v1"))
	})
	http.HandleFunc("/nginx", nginx)
	log.Println("Starting v1 server ...")
	log.Fatal(http.ListenAndServe(":5001", nil))
}

func nginx(w http.ResponseWriter, r *http.Request) {
	w.Write([]byte("this is go server"))
}
````

访问http://www.nginx-lyntest.com/access-limit/nginx，重复刷新接口
可以发现再刷新频率较低时，能正常访问服务，当频率超过1r/s时，会抛503异常

上面是根据单ip进行修改，我们也同时支持根据服务器级别进行限流，将$binary_remote_addr修改为$server_name即可

````nginx
http {
	limit_req_zone $server_name zone=serverlimit:10m rate=1r/s;
    server {
        server_name  www.nginx-lyntest.com;
        listen       80;
        location /access-limit/ {
            proxy_pass   http://127.0.0.1:5001/;

            # 根据服务器级别进行限流

​            limit_req zone=serverlimit burst=2 nodelay;
​        }
​    }
}
````



参数解释：

**$server_name：服务器级别限流**

通过连接数进行限流

````nginx
http {
    limit_conn_zone $binary_remote_addr zone=perip:10m;
    limit_conn_zone $server_name zone=perserver:10m;
    server {
        server_name  www.nginx-lyntest.com;
        listen       80;
        location /access-limit/ {
            proxy_pass   http://127.0.0.1:5001/;

            # 每个server最多保持100个连接

​            limit_conn perserver 100;

            # 每个ip最多保持1个连接

​            limit_conn perip 1;
​        }
​    }
}
````


另外我们也可以在location下通过配置 limit_req_status 504或limit_conn_status 504来修改默认errorCode