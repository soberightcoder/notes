#nginx----try_file



在nginx中 try_files 的的作用一般用户url的美化,或者是伪静态功能:



```bash
location / {
            try_files $uri $uri/ /index.php?$query_string;
}
location ~ .*\.(php|php5)?$
{
            fastcgi_pass  127.0.0.1:9000;
            fastcgi_index index.php;
}
```

当用户请求 [http://localhost/example](https://links.jianshu.com/go?to=http%3A%2F%2Flocalhost%2Fexample) 时，这里的 $uri 就是 /example。

try_files 会到硬盘里尝试找这个文件。如果存在名为 /![root/example（其中](https://math.jianshu.com/math?formula=root%2Fexample%EF%BC%88%E5%85%B6%E4%B8%AD)root 是项目代码安装目录）的文件，就直接把这个文件的内容发送给用户。

显然，目录中没有叫 example 的文件。然后就看 ![uri/，增加了一个 /，也就是看有没有名为 /](https://math.jianshu.com/math?formula=uri%2F%EF%BC%8C%E5%A2%9E%E5%8A%A0%E4%BA%86%E4%B8%80%E4%B8%AA%20%2F%EF%BC%8C%E4%B9%9F%E5%B0%B1%E6%98%AF%E7%9C%8B%E6%9C%89%E6%B2%A1%E6%9C%89%E5%90%8D%E4%B8%BA%20%2F)root/example/ 的目录。

又找不到，就会 fall back 到 try_files 的最后一个选项 /index.php，发起一个内部 “子请求”，也就是相当于 nginx 发起一个 HTTP 请求到 [http://localhost/index.php](https://links.jianshu.com/go?to=http%3A%2F%2Flocalhost%2Findex.php)

这个请求会被 location ~ .*.(php|php5)?$ { ... } catch 住，也就是进入 FastCGI 的处理程序。而具体的 URI 及参数是在 REQUEST_URI 中传递给 FastCGI 和 PHP 程序的，因此不受 URI 变化的影响。







# [nginx配置选项try_files详解](https://www.cnblogs.com/jedi1995/p/10900224.html)

 

**一.**

try_files是[nginx](https://so.csdn.net/so/search?q=nginx&spm=1001.2101.3001.7020)中http_core核心模块所带的指令，主要是能替代一些rewrite的指令，提高解析效率。官网的文档为http://nginx.org/en/docs/http/ngx_http_core_module.html#try_files

**二.**

 1.try_files的语法规则：

　　　　格式1：**try_files** `*file*` ... `*uri*`; 格式2：**try_files** `*file*` ... =`*code*`;

　　　　可应用的上下文：server，location段

 2.try_files的语法解释：(先贴出官方的解释，楼主再解释下)

Checks the existence of files in the specified order and uses the first found file for request processing; the processing is performed in the current context. The path to a file is constructed from the `*file*`parameter according to the [root](http://nginx.org/en/docs/http/ngx_http_core_module.html#root) and [alias](http://nginx.org/en/docs/http/ngx_http_core_module.html#alias) directives. It is possible to check directory’s existence by specifying a slash at the end of a name, e.g. “`$uri/`”. If none of the files were found, an internal redirect to the `*uri*` specified in the last parameter is made. 

　　关键点1：按指定的file顺序查找存在的文件，并使用第一个找到的文件进行请求处理

　　关键点2：查找路径是按照给定的root或alias为根路径来查找的 

　　关键点3：如果给出的file都没有匹配到，则重新请求最后一个参数给定的uri，就是新的location匹配

　　关键点4：如果是格式2，如果最后一个参数是 = 404 ，若给出的file都没有匹配到，则最后返回404的响应码

 3.举例说明：

 **try_files 文件 目录 uri**

```
location /images/ {
    root /opt/html/;
    try_files $uri   $uri/  /images/default.gif; 
}
比如 请求 127.0.0.1/images/test.gif 会依次查找 1.文件/opt/html/images/test.gif   2.文件夹 /opt/html/images/test.gif/下的index文件  3. 请求127.0.0.1/images/default.gif

4.其他注意事项
1.try-files 如果不写上 $uri/，当直接访问一个目录路径时，并不会去匹配目录下的索引页  即 访问127.0.0.1/images/ 不会去访问  127.0.0.1/images/index.html 
```

 

三.

其他用法：

```
location / {
    try_files /system/maintenance.html
              $uri $uri/index.html $uri.html
              @mongrel;
}

location @mongrel {
    proxy_pass http://mongrel;
}
```

 

以上中若未找到给定顺序的文件，则将会交给location @mongrel处理（相当于匹配到了@mongrel来匹配）





