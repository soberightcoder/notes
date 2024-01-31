# gzip--压缩模块

>文件压缩的原理：把文件中信息的重复部分被一个符号替换掉；
>
>解压就是一个逆操作；替换符号；



<font color=red>**total：使文件传输前进行压缩，提升传输的效率；**</font>

传输效率变高了，但是需要运算 ，肯定会消耗cpu；



### 语法：

`````nginx
gzip on | off;
#压缩级别；级别越高，压缩后的体积越小，但是压缩所需要的时间越长，占用cpu越高；
gip_comp_level 1; (1-9)
#gzip 压缩的版本；
gzip_http_version 1.1 | 1.0;
#压缩的内容；
gzip_types text/plain application/javascript application/x-javascript text/css application/xml text/javascript application/x-httpd-php image/jpeg   image/png image/gif 
#jpeg 其实就是jpg的encoding压缩
#静态压缩开启；
gzip_static on;
`````



accept_encoding:gzip;压缩；



### 应用：

大的文件还是需要进行压缩一下的；

**大文件压缩还是比较明显的；**

**图片（已经被压缩过了，所以一般不会有很大的变化；） 或者 js配，或者大的css，或者， 文件之类的；**

用户看到的效果就是响应速度变快了；不是需要转圈很久才会出来；

