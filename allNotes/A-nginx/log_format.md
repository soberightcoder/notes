# log_format



---

#### nginx.conf

root 默认的root是哪里？



nginx  有两种日志：

**error_log  错误日志模块；**





**access_log 的格式可以通过 log_format 来自己定义log的格式；**

**access_log  访问日志 模块**





### format

`````nginx
 #log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
 22     #                  '$status $body_bytes_sent "$http_referer" '
 23     #                  '"$http_user_agent" "$http_x_forwarded_for"';
 24 

#http_x_forwarded_for 代理服务器的ip地址；反向代理这边要用；//有代理服务器的话可以带一个 代理服务器的ip 
`````





### http模块的嵌入式变量；



<font color=red>注意：带有http的都是请求的header头信息； 客户端想要获取该字段信息必须要加一个http</font>；

<font color=red>注意 带有\$request的基本都跟请求行有关；请求的相关信息；</font>

<font color=red> \$remote  基本都跟客户端相关的信息；</font>

<font color=red>$server 都是跟服务器 相关的信息；</font>

````nginx
#最常用的几个参数
$request 
$request_uri == $uri
$request_filename  #绝对路径
$request_method  
$args  参数query_string;
$is_arg 是否有参数
#   try_files $uri $uri/  /index.php$is_args$args;
$request_body
$document_root
$request_id # 不怎么常用；

# header头
$http_user_agent
$http_referer
$content_type
$status  状态
$host
$scheme

#remote  客户端
$remote_addr
$remote_port
$remote_name
$binary_remote_addr  # 二进制 客户端ip

# 服务端
$server_addr
$server_name
$server_port
$time_local 本地的时间格式；



url   http://192.168.146.29/ceshiceshi/a.html

\$uri  /ceshiceshi/a.html   request 请求的目录；

\$request_filename  ===> /usr/local/nginx/ceshi/ceshiceshi/a.html  基于root（根） 和别名的url；
$request_filename
当前请求的文件路径，基于 根或别名 指令，以及请求 URI
````





几个比较重要的嵌入式变量；

$remote_addr 

$remote_port

$http_user_agent

$http_cookie

**\$arg = \$query_string**

$bytes_sent

$content_type

$uri

$request_filename        /usr/local/nginx/html/

````nginx
  if (!-e $request_filename){
  rewrite ^/(.*)$ /index.php?s=/$1 last;
  }
````



$time_local  本地时间格式；

**请求中的当前 URI，标准化**
**的值$uri可能会在请求处理期间发生变化，例如在进行内部重定向或使用索引文件时。**

$host

\$hostname

\$limit_rate
设置此变量可启用响应率限制；见limit_rate

$remote_user
随基本身份验证提供的用户名

\$server_protocol
请求协议，通常是“ HTTP/1.0”、“ HTTP/1.1”或“ HTTP/2.0 ”
$status 状态码

**$is_args**
**“ ?” 如果请求行有参数，否则为空字符串**

**$args**
**请求行中的参数**

###代理

$proxy_protocol_addr
来自 PROXY 协议标头 (1.5.12) 的客户端地址
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。

$proxy_protocol_port
来自 PROXY 协议标头的客户端端口 (1.11.0)
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。

$proxy_protocol_server_addr
来自 PROXY 协议标头的服务器地址 (1.17.6)
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。

$proxy_protocol_server_port
来自 PROXY 协议标头的服务器端口 (1.17.6)
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。





###请求



<font color=red>**\$request**  **其实就是请求行的意思**</font>
**完整的原始请求行**  请求行；

**$request_body**
请求正文
当请求正文被读取到内存缓冲区时， 该变量的值在 proxy_pass、 fastcgi_pass、 uwsgi_pass和 scgi_pass指令处理的位置中可用。

$request_body_file
带有请求正文的临时文件的名称
在处理结束时，需要删除文件。要始终将请求正文写入文件， 需要启用client_body_in_file_only 。当临时文件的名称在代理请求或向 FastCGI/uwsgi/SCGI 服务器的请求中传递时，传递请求正文应分别由 proxy_pass_request_body off、 fastcgi_pass_request_body off、 uwsgi_pass_request_body off或 scgi_pass_request_body off 指令禁用.

\$request_completion
“ OK” 如果请求已完成，否则为空字符串\$request_filename
当前请求的文件路径，基于 根或别名 指令，以及请求 URI
$request_id
从 16 个随机字节生成的唯一请求标识符，十六进制 (1.11.0)
**\$request_length**
请求长度（包括请求行、标头和请求正文）（1.3.12、1.2.7）
**\$request_time**
**以毫秒为单位的请求处理时间（1.3.9、1.2.6）；从客户端读取第一个字节后经过的时间**

**\$request_uri**
完整的原始请求 URI（带参数）





url   http://192.168.146.29/ceshiceshi/a.html



**\$uri  /ceshiceshi/a.html**   request 请求的目录；



**\$request_filename  ===> /usr/local/nginx/ceshi/ceshiceshi/a.html**  基于root（根） 和别名的url；

t

<font color=red>**$request_filename**
**当前请求的文件路径**，**基于 根或别名 指令**，**以及请求 URI**</font>



`````nginx
#嵌入式变量  http://nginx.org/en/docs/http/ngx_http_core_module.html#var_request_length
该ngx_http_core_module模块支持名称与 Apache 服务器变量匹配的嵌入式变量。首先，这些是表示客户端请求头字段的变量，例如$http_user_agent、$http_cookie等。还有其他变量：

$arg_name
name请求行中的 参数

$args
请求行中的参数

$binary_remote_addr
二进制形式的客户端地址，对于 IPv4 地址，值的长度始终为 4 个字节，对于 IPv6 地址，值的长度始终为 16 个字节

$body_bytes_sent
发送到客户端的字节数，不包括响应头； 此变量与Apache 模块 的“ %B”参数 兼容mod_log_config

$bytes_sent
发送到客户端的字节数（1.3.8、1.2.5）
$connection
连接序列号（1.3.8、1.2.5）
$connection_requests
当前通过连接发出的请求数（1.3.8、1.2.5）
$connection_time
以毫秒为单位的连接时间（1.19.10）
$content_length
“Content-Length”请求头域

$content_type
“Content-Type”请求头域

$cookie_name
name饼干 

$document_root 就是root；
当前请求的 根或别名指令的值

$document_uri
如同$uri

$host
按此优先顺序：请求行中的主机名，或“主机”请求标头字段中的主机名，或与请求匹配的服务器名

$hostname
主机名
$http_name
任意请求头字段；变量名的最后一部分是转换为小写的字段名，其中破折号替换为下划线
$https
“ on” 如果连接在 SSL 模式下运行，否则为空字符串
$is_args
“ ?” 如果请求行有参数，否则为空字符串

$limit_rate
设置此变量可启用响应率限制；见limit_rate
$msec
当前时间（以秒为单位，以毫秒为单位） (1.3.9, 1.2.6)
$nginx_version
nginx版本
$pid
工作进程的PID
$pipe
“ p” 如果请求是流水线的，“ .” 否则 (1.3.12, 1.2.7)

$proxy_protocol_addr
来自 PROXY 协议标头 (1.5.12) 的客户端地址
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。

$proxy_protocol_port
来自 PROXY 协议标头的客户端端口 (1.11.0)
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。

$proxy_protocol_server_addr
来自 PROXY 协议标头的服务器地址 (1.17.6)
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。

$proxy_protocol_server_port
来自 PROXY 协议标头的服务器端口 (1.17.6)
PROXY 协议必须事先通过设置 listen指令 proxy_protocol中的参数来启用。

$query_string
如同$args

$realpath_root
与当前请求 的根或别名指令的值 相对应的绝对路径名 ，所有符号链接都解析为真实路径
$remote_addr
客户地址
$remote_port
客户端端口
$remote_user
随基本身份验证提供的用户名
$request
完整的原始请求行
$request_body
请求正文
当请求正文被读取到内存缓冲区时， 该变量的值在 proxy_pass、 fastcgi_pass、 uwsgi_pass和 scgi_pass指令处理的位置中可用。

$request_body_file
带有请求正文的临时文件的名称
在处理结束时，需要删除文件。要始终将请求正文写入文件， 需要启用client_body_in_file_only 。当临时文件的名称在代理请求或向 FastCGI/uwsgi/SCGI 服务器的请求中传递时，传递请求正文应分别由 proxy_pass_request_body off、 fastcgi_pass_request_body off、 uwsgi_pass_request_body off或 scgi_pass_request_body off 指令禁用.

$request_completion
“ OK” 如果请求已完成，否则为空字符串
$request_filename
当前请求的文件路径，基于 根或别名 指令，以及请求 URI
$request_id
从 16 个随机字节生成的唯一请求标识符，十六进制 (1.11.0)
$request_length
请求长度（包括请求行、标头和请求正文）（1.3.12、1.2.7）
$request_method
请求方法，通常是“ GET”或“ POST”
$request_time
以毫秒为单位的请求处理时间（1.3.9、1.2.6）；从客户端读取第一个字节后经过的时间
$request_uri
完整的原始请求 URI（带参数）
$scheme
请求方案，“ http”或“ https”
$sent_http_name
任意响应头域；变量名的最后一部分是转换为小写的字段名，其中破折号替换为下划线
$sent_trailer_name
在响应结束时发送的任意字段（1.13.2）；变量名的最后一部分是转换为小写的字段名，其中破折号替换为下划线

$server_addr
接受请求的服务器地址
计算这个变量的值通常需要一个系统调用。为了避免系统调用，listen指令必须指定地址并使用bind参数。

$server_name
接受请求的服务器的名称
$server_port
接受请求的服务器端口
$server_protocol
请求协议，通常是“ HTTP/1.0”、“ HTTP/1.1”或“ HTTP/2.0 ”
$status
响应状态（1.3.2、1.2.2）
$tcpinfo_rtt, $tcpinfo_rttvar, $tcpinfo_snd_cwnd, $tcpinfo_rcv_space
有关客户端 TCP 连接的信息；在支持TCP_INFO套接字选项 的系统上可用
$time_iso8601
ISO 8601 标准格式 (1.3.12, 1.2.7) 的本地时间
$time_local
通用日志格式的本地时间 (1.3.12, 1.2.7)
$uri
请求中的当前 URI，标准化
的值$uri可能会在请求处理期间发生变化，例如在进行内部重定向或使用索引文件时。
`````





### 配置  root

`````nginx
在配置 nginx.conf 总会遇到一些问题，下面列举一些常见的问题并说明如何解决

1、相对路径的问题

例如配置文件中 location 设置

1
2
3
location ~ .php${
 root html
 }
location 中root所指向的html是一个相对路径，相对的是这个配置文件的路径，假设此配置文件的位置是/etc/nginx/conf.d，那么这个html的绝对路径就是/etc/nginx/conf.d/html。因此为避免出现不必要的麻烦，在配置root路径的过程中最好用绝对路径。

2、路径的继承问题

2.1 第一种情况

假如server 中声明:

1
root /usr/share;
且 location 中声明:

1
2
3
location /{
 root /usr/html/www
 }
此时会优先使用 location 中的路径

2.2 第二种情况

假如 location 中未对root路径进行声明:

1
2
3
location /app {
 
}
则默认使用 location 外的 root 声明的路径

3、首页的设置问题

假如我们在声明server 中声明:

index index.html index.php

那么我们此时请求 / 就会在内部重定向到 url/index.php 或者 url/index.html
然后再由相关的location 进行匹配 之后再进行解析
nginx.conf文件的详解

官网对各个模块参数配置的解释说明网址： Nginx中文文档
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
68
69
70
71
72
73
74
75
76
77
78
79
80
81
82
83
84
85
86
87
88
89
90
91
92
93
94
95
96
97
98
99
100
101
102
103
104
105
106
107
108
109
110
111
112
113
114
115
116
117
118
119
120
121
122
123
124
125
126
127
128
129
130
131
132
133
134
135
136
137
138
139
140
141
142
143
144
145
146
147
148
149
150
151
152
153
154
155
156
157
158
159
160
161
162
163
164
165
##代码块中的events、http、server、location、upstream等都是块配置项##
##块配置项可以嵌套。内层块直接继承外层快，例如：server块里的任意配置都是基于http块里的已有配置的##
 
##Nginx worker进程运行的用户及用户组 
#语法：user username[groupname]  默认：user nobody nobody
#user用于设置master进程启动后，fork出的worker进程运行在那个用户和用户组下。当按照"user username;"设置时，用户组名与用户名相同。
#若用户在configure命令执行时，使用了参数--user=usergroup 和 --group=groupname,此时nginx.conf将使用参数中指定的用户和用户组。
#user nobody;
 
##Nginx worker进程个数：其数量直接影响性能。
#每个worker进程都是单线程的进程，他们会调用各个模块以实现多种多样的功能。如果这些模块不会出现阻塞式的调用，那么，有多少CPU内核就应该配置多少个进程，反之，有可能出现阻塞式调用，那么，需要配置稍多一些的worker进程。
worker_processes 1;
 
##ssl硬件加速。
#用户可以用OpneSSL提供的命令来查看是否有ssl硬件加速设备：openssl engine -t
#ssl_engine device;
 
##守护进程(daemon)。是脱离终端在后台允许的进程。它脱离终端是为了避免进程执行过程中的信息在任何终端上显示。这样一来，进程也不会被任何终端所产生的信息所打断。##
##关闭守护进程的模式，之所以提供这种模式，是为了放便跟踪调试nginx，毕竟用gdb调试进程时最繁琐的就是如何继续跟进fork出的子进程了。##
##如果用off关闭了master_proccess方式，就不会fork出worker子进程来处理请求，而是用master进程自身来处理请求
#daemon off;  #查看是否以守护进程的方式运行Nginx 默认是on 
#master_process off; #是否以master/worker方式工作 默认是on
 
##error日志的设置#
#语法： error_log /path/file level;
#默认： error_log / log/error.log error;
#当path/file 的值为 /dev/null时，这样就不会输出任何日志了，这也是关闭error日志的唯一手段；
#leve的取值范围是debug、info、notice、warn、error、crit、alert、emerg从左至右级别依次增大。
#当level的级别为error时，error、crit、alert、emerg级别的日志就都会输出。大于等于该级别会输出，小于该级别的不会输出。
#如果设定的日志级别是debug，则会输出所有的日志，这一数据量会很大，需要预先确保/path/file所在的磁盘有足够的磁盘空间。级别设定到debug，必须在configure时加入 --with-debug配置项。
#error_log logs/error.log;
#error_log logs/error.log notice;
#error_log logs/error.log info;
 
##pid文件（master进程ID的pid文件存放路径）的路径
#pid    logs/nginx.pid;
 
 
events {
 #仅对指定的客户端输出debug级别的日志： 语法：debug_connection[IP|CIDR]
 #这个设置项实际上属于事件类配置，因此必须放在events{……}中才会生效。它的值可以是IP地址或者是CIRD地址。
 #debug_connection 10.224.66.14; #或是debug_connection 10.224.57.0/24
 #这样，仅仅以上IP地址的请求才会输出debug级别的日志，其他请求仍然沿用error_log中配置的日志级别。
 #注意：在使用debug_connection前，需确保在执行configure时已经加入了--with-debug参数，否则不会生效。
 worker_connections 1024;
}
 
##核心转储(coredump):在Linux系统中，当进程发生错误或收到信号而终止时，系统会将进程执行时的内存内容(核心映像)写入一个文件(core文件)，以作为调试只用，这就是所谓的核心转储(coredump).
 
http {
##嵌入其他配置文件 语法：include /path/file
#参数既可以是绝对路径也可以是相对路径（相对于Nginx的配置目录，即nginx.conf所在的目录）
  include    mime.types;
  default_type application/octet-stream;
 
  #log_format main '$remote_addr - $remote_user [$time_local] "$request" '
  #         '$status $body_bytes_sent "$http_referer" '
  #         '"$http_user_agent" "$http_x_forwarded_for"';
 
  #access_log logs/access.log main;
 
  sendfile    on;
  #tcp_nopush   on;
 
  #keepalive_timeout 0;
  keepalive_timeout 65;
 
  #gzip on;
 
  server {
##listen监听的端口
#语法：listen address:port [ default(deprecated in 0.8.21) | default_server | [ backlog=num | rcvbuf=size | sndbuf=size | accept_filter=filter | deferred | bind | ssl ] ]
#default_server: 如果没有设置这个参数，那么将会以在nginx.conf中找到的第一个server块作为默认server块
 listen    8080;
 
#主机名称：其后可以跟多个主机名称，开始处理一个HTTP请求时，nginx会取出header头中的Host，与每个server中的server_name进行匹配，以此决定到底由那一个server来处理这个请求。有可能一个Host与多个server块中的server_name都匹配，这时会根据匹配优先级来选择实际处理的server块。server_name与Host的匹配优先级见文末。
 server_name localhost;
 
    #charset koi8-r;
 
    #access_log logs/host.access.log main;
 
    #location / {
    #  root  html;
    #  index index.html index.htm;
    #}
 
##location 语法： location [=|~|~*|^~] /uri/ { ... }
# location的使用实例见文末。
#注意：location时有顺序的，当一个请求有可能匹配多个location时，实际上这个请求会被第一个location处理。
 location / {
 proxy_pass http://192.168.1.60;
    }
 
    #error_page 404       /404.html;
 
    # redirect server error pages to the static page /50x.html
    #
    error_page  500 502 503 504 /50x.html;
    location = /50x.html {
      root  html;
    }
 
    # proxy the PHP scripts to Apache listening on 127.0.0.1:80
    #
    #location ~ \.php$ {
    #  proxy_pass  http://127.0.0.1;
    #}
 
    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    #
    #location ~ \.php$ {
    #  root      html;
    #  fastcgi_pass  127.0.0.1:9000;
    #  fastcgi_index index.php;
    #  fastcgi_param SCRIPT_FILENAME /scripts$fastcgi_script_name;
    #  include    fastcgi_params;
    #}
 
    # deny access to .htaccess files, if Apache's document root
    # concurs with nginx's one
    #
    #location ~ /\.ht {
    #  deny all;
    #}
  }
 
 
 
  # another virtual host using mix of IP-, name-, and port-based configuration
  #
  #server {
  #  listen    8000;
  #  listen    somename:8080;
  #  server_name somename alias another.alias;
 
  #  location / {
  #    root  html;
  #    index index.html index.htm;
  #  }
  #}
 
 
  # HTTPS server
  #
  #server {
  #  listen    443 ssl;
  #  server_name localhost;
 
  #  ssl_certificate   cert.pem;
  #  ssl_certificate_key cert.key;
 
  #  ssl_session_cache  shared:SSL:1m;
  #  ssl_session_timeout 5m;
 
  #  ssl_ciphers HIGH:!aNULL:!MD5;
  #  ssl_prefer_server_ciphers on;
 
  #  location / {
  #    root  html;
  #    index index.html index.htm;
  #  }
  #}
 
}
`````



