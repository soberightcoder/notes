# nginx 总述

> **为啥要用nginx**？
>
> **nginx -V查看的内容补充  查看模块**
>
> 其实这里安装openstry也是带有很多扩展模块的nginx服务器；基于nginx的服务器；



nginx 是一个**高性能的http**（解决C（connection）10k的问题）和**反向代理服务器**，**动静分离**，也是**邮局服务器**（SMTP/POP3）；

**服务器：apache  nginx**



流量变现：人多；广告；

---



### apache  

>当有一个请求连接的时候会创建一个先**线程（pthread）**去处理；

* 多线程模型，当一个线程出问题，那么会影响到整个进程；

  

###nginx优势在我：

* 高并发；占用内存比较小，并发能力强；
* IO多路复用；
* epoll异步非阻塞IO模型；  **不会被IO口阻塞住；异步应该是通知的方式；**
* 多进程，架构，一个master进程和多个work进程；master也是管理和调度工作进程；
* 静态服务器；

---



#### 多路复用：

> total : 

*  IO多路复用；  一个进程来处理多个请求； select poll epoll 

* 时分多路复用； 

  cpu 时分复用,例如： 把一秒分为 1000份，也就是一个时间片就是1ms，每一个进程运行的一个时间片也就是1ms，如果进程越多分得的时间片越多，也就运行的越快，如果开启的进程越多，分的的时间片越少，这是cpu不够的时候移动鼠标都会一卡卡的，说明分给他的时间片太少了，无法完成整个基础的移动鼠标的操作；

* 频分多路复用；

​	 不同的频率电话线和网线用同一根



#### 连接 和 请求 注意区别



TCP连接 注意 ：connection 

因为是keepalive  长连接；







#### 防盗链 了解一下

**主要是用**

**http_referer  就是访问照片的网站是什么，是不是在自己的允许的网站范围内，如果是在允许的范围内，那么就可以访问照片；不然就不可以访问；**

**防盗链的原理；**







### root 和 alias 的区别  Module ngx_http_core_module 这个模块 

>**root 是代表的是上层目录，alias是一个目录的别名；**
>
>**注意 三者  location  \$uri  \$request_filename 之间的区别**；

<font color=red>**root**:**查找方式是root+\$uri的方式来访问；**</font>



root html;   #   /usr/local/nginx/html



echo \$uri;

echo \$request_filename;



**注意一下：**

url   http://192.168.146.29/ceshiceshi/a.html



**\$uri  /ceshiceshi/a.html**    **request 请求的目录uri**；



**\$request_filename  ===> /usr/local/nginx/ceshi/ceshiceshi/a.html**    基于root（根） 和别名 + 请求的uri；



<font color=red>**alias**:</font>

#### alias    Defines a replacement for the specified location.  替换location；

<font color=red>**别名的意思，用alias的别名来代替，root + location 部分；**</font



Syntax   alias path；

context location；

**alias： <font color=red>查找alias +（uri-location）</font>  注意要在alias后面加/ 或者location /ceshi/  这样的location 不然遇到  uri**

**是/ceshiaaa.html  location /ceshi 访问的就是/usr/local/nginx/aliasaaa.html   就会出现404 的情况；**



location /ceshi {

​	allias alias;  

​	echo \$uri;

​	echo \$request_filename;

}

http://192.168.146.29/ceshi/

index index.html;默认访问index.html;

\$uri    /ceshi
\$reques_filename  /usr/local/nginx/alias/



````nginx
nginx新手配置$document_root

nginx配置php老是出错，最后才发现是$document_root的设置问题。

            location ~ \.php$ {
            root           html;  # 默认是html默认是 /etc/nginx/html/   所以修改root

            fastcgi_pass   127.0.0.1:9000;

            fastcgi_index  index.php;

            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;

            include        fastcgi_params;

        }


这个用出现找不到php的错误。因为$document_root 的参数是由root html那一行定义的，默认是在/etc/nginx/html/ 所以把 html换成站点根目录就正常了。

  location ~ \.php$ {
            root           /usr/share/nginx/html;

            fastcgi_pass   127.0.0.1:9000;

            fastcgi_index  index.php;

            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;

            include        fastcgi_params;

        }
````







### rewrite  proxy try_files的区别



##### proxy 

proxy_pass 





#####rewrite   

rewrite origin target 





flag不写的话如果是内部path和proxy_pass就没区别，只不过proxy_pass支持upstream写法。

**但是如果是外部链接比如baidu啥的，那不写也是302会改变浏览器url的。**   **反向代理的时候都是外部系统，所以proxy_pass就是反向代理的最佳选择，而rewrite就是用来内部url跳转的最佳选择。**
**ps: 也是个好问题，但是我其实没想展开讲这么多nginx的。**



本质上是rewrite origin target中target如果是/xxx的话，还能继续匹配location继续走ngx内部的生命周期，就去处理了，而如果target是https://www.xxx.com的话，那就没办法了，ngx只能给浏览器个302，让浏览器自己跳转寻找自己的真爱去了







#####try_files 

try_files主要是去解决  当本地 没有就去目标服务器访问



try_files \$uri \$uri/ www.demo.com/









### location  /ceshi/  和 location /ceshi的区别

* **/ceshi/**      主要是就是直接匹配目录
* **/ceshi**     /ceshi/ceshi.html   直接有/ceshi 都会匹配

