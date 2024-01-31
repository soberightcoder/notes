# 代理模块



---



### 代理



#### 反向代理 隐藏服务器  用户是无感知的；反代服务器是面对客户的；我们访问的ip其实就是代理服务器（反代说不定会有很多个）；业务服务器是隐藏的；

ngx_http_proxy_module  代理模块

| Syntax                        | default                   | Context                  | comment                                                      |
| ----------------------------- | ------------------------- | ------------------------ | ------------------------------------------------------------ |
| proxy_pass URL;               | -------                   | location  if in location | 业务服务器的url；                                            |
| proxy_buffering on \| off;    | -------                   | http server location     | 缓冲区开启；                                                 |
| proxy_buffer_size size;       | proxy_buffer_size 4k\|8k; | http server location     | 缓冲区大小；                                                 |
| proxy_buffer number size;     | proxy_buffer 8 4k;        | http server location     | 缓冲区数量；                                                 |
| proxy_busy_buffer_size size;  | 8k\|16k;                  | http server location     | 忙碌缓冲区的大小；                                           |
| proxy_set_header field value; |                           | http server location     | 头信息  设置客户端的真实地址；不然业<br />机收到的全部是代理服务器的ip地址； |
| proxy_connection_timeout time | 60s                       | http server location     | 监视双方，连接超时 会关闭连接；                              |
|                               |                           |                          |                                                              |





````nginx
location ~ \.(jpg|gif|jpeg|png)$
        {		
        		#给上游服务器添加header
                proxy_set_header Host $http_host; 真实服务器；
                proxy_set_header X-Status 'from-proxy';
    			proxy_set_header X-Real-IP $remote_addr;  客户端的真实ip；
   				proxy_set_header X-Forward-For $proxy_add_x_forwarded_for; 代理服务器的真实ip； z；
                # 只有文件不存在话才会解析；
                if (!-e $request_filename) {
                      
                        #proxy_set_header Host $http_host;
                        proxy_pass https://ip:443;
                }
                index  index.php index.html index.htm;

      }
      
````





#### 正向代理  隐藏客户端； 梯子； 代理客户端去访问外网； squid 乌贼 ；



