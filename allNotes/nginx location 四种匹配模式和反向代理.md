# nginx location 四种匹配模式和反向代理

>四种匹配模式 优先级

**location匹配模式**

context： server`, `location；
**注意这几个优先级 这里仅仅包含优先级**  

**=/ceshi**             

**^~/ceshi**

**~/ceshi**

**/ceshi**   

<font color=red>注意 ：同一个优先级，从都能匹配的到的location里面选择匹配度最长的；匹配度最高的；</font>

`````nginx
#location [=|~|~*|!~|^~] /uri/{
}
# 下面都是关于~的模糊匹配
# ~   区分大小写的匹配 模糊匹配
# ~*  不区分不小写
# !~  区分大小写 不等于的匹配
# !~* 不区分大小写 不等于匹配
#优先级：下面从高到低；
#完全匹配 
location =/{
    
}
#以什么开头正则匹配 ；
location ^~ /{
    
}
# 正则匹配  !~ ~* 
location ~ /{
}
#优先级最低  普通匹配  匹配全部，前缀匹配；
# 都能匹配得到选择更长的；
# 匹配所有以 / 开头的请求。但是如果有更长的同类型的表达式，则选择更长的表达式。如果有正则表达式可以匹配，则
# 优先匹配正则表达式。
location / {  
    
}

#注意这里 \. 是对.做了转义
location ~ \.php$ {
    root /html/path/
    index a.html
    proxy_pass; # 反向代理
}

location 匹配的问题
location /ceshi/{
    
}

proxy_pass www.demo.com/  整个是匹配的是相对路径 需要把 location 后面的路径加上 www.demo.com/ceshi/
proxy_pass www.demo.com  整个是绝对路径 ，就是匹配 www.demo.com
`````



event;

http 定义整个全部的虚拟主机  所有的http请求；

server 定义的是一个虚拟主机 

location 定义的是某一个页面



`````nginx
#rewrite是实现URL重定向的重要指令
#https://www.cnblogs.com/brianzhu/p/8624703.html
rewrite regex replacement [flag]
#flag  last break redirect（302） permanent（301）
#last	本条规则匹配完成后继续向下匹配新的location URI规则
#break 本条规则匹配完成后终止，不在匹配任何规则

#total:
# 调整用户浏览的URL，看起来规范
#为了让搜索引擎收录网站内容，让用户体验更好
#网站更换新域名后
#根据特殊的变量、目录、客户端信息进行跳转

#应用位置：server、location、if
#eg z
rewrite ^/(.*) http://www.baidu.com/ permanent;
#直接进行跳转就可以
 location  /static/
       {
        rewrite ^  http://www.abc.com break;      
       }


location / {
  if (!-e $request_filename){
  rewrite ^/(.*)$ /index.php?s=/$1 last;
  }
}

pathinfo 的问题  直接用 PATH_INFO 参数会有安全问题；
cgi.fix_pathinfo =1  解析 phpinfo ；
`````

`````shell
#Syntax:	proxy_set_header field value;
#Default:	
#proxy_set_header Host $proxy_host;
#proxy_set_header Connection close;
#不能在if中；
#Context:	http, server, location

#先走反向代理把
location ~ \.(jpg|gif|jpeg|png)$
        {		
        		#给上游服务器添加header
                proxy_set_header Host $http_host;
                proxy_set_header X-Status 'from-proxy';
                # 只有文件不存在话才会解析；
                if (!-e $request_filename) {
                      
                        #proxy_set_header Host $http_host;
                        proxy_pass https://ip:443;
                }
                index  index.php index.html index.htm;

      }
      
      这里是reponsej
      
      add_header "access-control-allow-origin" "*";
      
      
`````

