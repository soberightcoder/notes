# nginx.conf



```nginx

#user  nobody;
#2核
#worker_processes 2;
#worker_cpu_affinity 01 10;
# 4核
worker_processes  4;
#绑定cpu
worker_cpu_affinity 0001 0010 0100 1000;

#error_log  logs/error.log;

#error_log  logs/error.log  notice;

#error_log  logs/error.log  info;

#pid        logs/nginx.pid;


events {
    worker_connections  1024;
}

http {
    include       mime.types;
    default_type  application/octet-stream;
    
	server_names_hash_bucket_size 128;

	#请求行+请求头的标准大小

​	client_header_buffer_size 16k;

	#请求行+请求头的最大大小 4*16k

​	large_client_header_buffers 4 16k;

    #log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '

    #                  '$status $body_bytes_sent "$http_referer" '

    #                  '"$http_user_agent" "$http_x_forwarded_for"';
#access_log  logs/access.log  main;
**sendfile        on;**
#tcp_nopush     on;

#keepalive_timeout  0;
keepalive_timeout  65;

#gzip  on;
```



```nginx
# another virtual host using mix of IP-, name-, and port-based configuration
#
#server {
#    listen       8000;
#    listen       somename:8080;
#    server_name  somename  alias  another.alias;

#    location / {
#        root   html;
#        index  index.html index.htm;
#    }
#}
#include vhosts.conf;
#include vhosts/*.conf;
# HTTPS server
#
#server {
#    listen       443 ssl;
#    server_name  localhost;

#    ssl_certificate      cert.pem;
#    ssl_certificate_key  cert.key;

#    ssl_session_cache    shared:SSL:1m;
#    ssl_session_timeout  5m;

#    ssl_ciphers  HIGH:!aNULL:!MD5;
#    ssl_prefer_server_ciphers  on;

#    location / {
#        root   html;
#        index  index.html index.htm;
#    }
#}
server {
    listen       8085;   
	server_name  localhost dev.heating.com;
    
	location /man {
        proxy_pass http://127.0.0.1:8405/;
		proxy_set_header       X-Real-IP $remote_addr;  
		proxy_set_header       X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header       X-Forwarded-For $http_x_forwarded_for;
    }
    
	location /fs {
		proxy_pass http://127.0.0.1:8080/;
		proxy_set_header       X-Real-IP $remote_addr;  
		proxy_set_header       X-Forwarded-For $proxy_add_x_forwarded_for;
		proxy_set_header       X-Forwarded-For $http_x_forwarded_for;
	}
    location / {
        root   D:\heating\dist;
        index  index.html index.htm;
    }
      		
}
client_max_body_size 50m;
}
```
