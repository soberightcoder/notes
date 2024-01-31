# try_files

Syntax:	try_files file ... uri;
try_files file ... =code;
Default:	—
**Context:	server, location**

---



**@的作用；只能内部调用不能外部访问；**  内部访问’



**@ 符号, 用于定义一个Location块，且该块不能被外部Client所访问，只能被Nginx 内部配置指令所访问，比如 try_files 或 error_page.**



```nginx
# 默认照片；
location /images/ {
    try_files $uri /images/default.gif;
}

location = /images/default.gif {
    expires 30s;
}

location / {
    try_files $uri $uri/index.html $uri.html =404;
}
Example in proxying Mongrel:
#$url.html  其实就是拼接 而已  和shell的拼接一模一样；
location / {
    try_files /system/maintenance.html
              $uri $uri/index.html $uri.html
              @mongrel;
}

location @mongrel {
    proxy_pass http://mongrel;
}

Example for Drupal/FastCGI:

location / {
    try_files $uri $uri/ @drupal;
}

location ~ \.php$ {
    try_files $uri @drupal;

    fastcgi_pass ...;

    fastcgi_param SCRIPT_FILENAME /path/to$fastcgi_script_name;
    fastcgi_param SCRIPT_NAME     $fastcgi_script_name;
    fastcgi_param QUERY_STRING    $args;

    ... other fastcgi_param's
}


location @drupal {
    fastcgi_pass ...;

    fastcgi_param SCRIPT_FILENAME /path/to/index.php;
    fastcgi_param SCRIPT_NAME     /index.php;
    fastcgi_param QUERY_STRING    q=$uri&$args;

    ... other fastcgi_param's
}


```



