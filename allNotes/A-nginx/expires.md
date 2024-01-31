# 缓存模块

- [ngx_http_headers_module](http://nginx.org/en/docs/http/ngx_http_headers_module.html)



###expires   cache-control  强制缓存  时间没到期之前 不访问服务器 直接去缓存去拿

添加强制缓存模块；

context ：http`, `server`, `location`,`if in location

> 缓存，加速访问；
>
> Cache-Control:  max-age=86400 24小时  max-age >0 直接访问缓存加快访问；
>
> 协商缓存 起码回去服务端问一下 有没有改变 ，当没有发生改变的时候是304；会少了文件的传输过程；

````nginx
expires    24h;
expires    modified +24h;
expires    @24h;
expires    0;
expires    -1;
expires    epoch;
expires    $expires;
add_header Cache-Control private;
````





###add_header  http 应该对所有的请求；  

 >这是对所有的响应加字段吗？
 >Yes, the `add_header` directive in Nginx is used to add a header to the response sent to the client. 

add_header name value [always]

context（语境）:`http`, `server`, `location`, `if in location`

```nginx
 #add_header "content-type" "application/octet-stream";
```



如果`always`指定了参数（1.7.5），则无论响应(reponse)代码如何，都会添加标头字段。

如果响应代码等于 200、201 (1.3.10)、204、206、301、302、303、304、307 (1.1.16、1.0.13) 或 308 (1.13)，则将指定字段添加到响应标头.0)。参数值可以包含变量。
