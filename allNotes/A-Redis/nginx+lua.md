# nginx +lua



说明：
1、连接redis失败后或者cache:set_timeouts(300, 300, 300)直接跳出脚本，不能影响访问。操作redis不能太长时间

2、redis会创建5个key
1) ip_forum_edittopic： 每个ip的访问总量
2) time： ip创建时间
3) ban：结合time和 ip_forum_edittopic写入，如果有此字段，说明达到限制已经限制访问了
4) whitelist：白名单
5) blacklist：黑名单

3、变量
1） connect_count 最大访问次数
2） ip_time_out 在一段时间内
比如ip_time_out=600、connect_count=3000，在600秒之内如果访问次数达到3000就被限制访问

4、限制之后的跳转
现在直接返回403，可以做验证策略

5、redis每次创建连接性能问题

**看了一些实现方式，感觉有点麻烦，然后用apache ab测试发现1c1g每秒钟2500连接还是没啥问题(cpu负载1.2左右，只是简单搞了一下)，网站访问不高或者硬件资源高可以直接用。量大的话还是建议使用类似连接池**

6、限制是对api接口的统计，没有对前段页面进行统计

7、ttl值一定要注意，ip和time字段一定时间会自动清除



````nginx
access_by_lua_block
{
local redis = require 'resty.redis'  
local cache = redis.new()
cache:set_timeouts(300, 300, 300)
local ok ,err = cache.connect(cache,'192.168.6.147','6379')
-- 如果连接失败，跳转到label处  
if not ok then  
  goto label 
end

-- 白名单  
is_white ,err = cache:sismember('whitelist',ngx.var.remote_addr)  
if is_white == 1 then  
  goto label  
end  

-- 黑名单  
is_black ,err = cache:sismember('blacklist',ngx.var.remote_addr)  
if is_black == 1 then  
  ngx.exit(ngx.HTTP_FORBIDDEN)  
  goto label  
end  


-- -- 查询ip是否在封禁时间段内，若在则跳转到验证码页面  
is_ban , err = cache:get('ban:' .. ngx.var.remote_addr)  
if tonumber(is_ban) == 1 then 
  -- source携带了之前用户请求的地址信息，方便验证成功后返回原用户请求地址  
  --local source = ngx.encode_base64(ngx.var.scheme .. '://' .. ngx.var.host .. ':' .. ngx.var.server_port .. ngx.var.request_uri)  
  --local dest = 'http://127.0.0.1:5000/' .. '?continue=' .. source  
  --ngx.redirect(dest,302)
  --ngx.status = ngx.HTTP_FORBIDDEN;
  --ngx.say("403 Forbidden<br>"..now);
  --ngx.exit(ngx.HTTP_FORBIDDEN);
  -- 直接返回403
  return ngx.exit(403)
  --goto label  
end


if string.find(ngx.var.request_uri, "^/api") then
  ip_forum_edittopic, err = cache:get('ip_forum_edittopic:' .. ngx.var.remote_addr)  
  if ip_forum_edittopic == ngx.null then  
    res , err = cache:set('ip_forum_edittopic:' .. ngx.var.remote_addr, 1)
		res , err = cache:expire('ip_forum_edittopic:' .. ngx.var.remote_addr, 100)
  else
    res , err = cache:incr('ip_forum_edittopic:' .. ngx.var.remote_addr)
  end

  -- ip访问频率计数最大值  
  connect_count = 4000
  -- 120s内达到45次就ban
  ip_time_out = 600

  -- ip记录时间key  
  start_time , err = cache:get('time:' .. ngx.var.remote_addr)  
  -- ip计数key
  ip_count , err = cache:get('ip_forum_edittopic:' .. ngx.var.remote_addr)

	----时间段内的最大访问量

  if start_time == ngx.null or os.time() - tonumber(start_time) > ip_time_out then  
    res , err = cache:set('time:' .. ngx.var.remote_addr , os.time())  
		res , err = cache:expire('time:' .. ngx.var.remote_addr, 100)
    res , err = cache:set('ip_forum_edittopic:' .. ngx.var.remote_addr , 1)
		res , err = cache:expire('ip_forum_edittopic:' .. ngx.var.remote_addr, 100)
  end
  if tonumber(ip_count) >= connect_count then
    res , err = cache:set('ban:' .. ngx.var.remote_addr , 1)
    res , err = cache:expire('ban:' .. ngx.var.remote_addr, 86400) -- 24h重制
  end
end

::label::

local ok , err = cache:close()
}


````







**Nginx+Lua+Redis 对请求进行限制**

**一、概述**

需求：所有访问/myapi/**的请求必须是POST请求，而且根据请求参数过滤不符合规则的非法请求(黑名单), 这些请求一律不转发到后端服务器(Tomcat)

实现思路：通过在Nginx上进行访问限制，通过Lua来灵活实现业务需求，而Redis用于存储黑名单列表。

相关nginx上lua或redis的使用方式可以参考我之前写的一篇文章:

# openresty(nginx)、lua

**1.lua代码**

本例中限制规则包括(post请求，ip地址黑名单，请求参数中imsi,tel值和黑名单)

```nginx
 1 -- access_by_lua_file '/usr/local/lua_test/my_access_limit.lua';
 2 ngx.req.read_body()
 3 
 4 local redis = require "resty.redis"
 5 local red = redis.new()
 6 red.connect(red, '127.0.0.1', '6379')
 7 
 8 local myIP = ngx.req.get_headers()["X-Real-IP"]
 9 if myIP == nil then
10    myIP = ngx.req.get_headers()["x_forwarded_for"]
11 end
12 if myIP == nil then
13    myIP = ngx.var.remote_addr
14 end
15         
16 if ngx.re.match(ngx.var.uri,"^(/myapi/).*$") then
17     local method = ngx.var.request_method
18     if method == 'POST' then
19         local args = ngx.req.get_post_args()
20         
21         local hasIP = red:sismember('black.ip',myIP)
22         local hasIMSI = red:sismember('black.imsi',args.imsi)
23         local hasTEL = red:sismember('black.tel',args.tel)
24         if hasIP==1 or hasIMSI==1 or hasTEL==1 then
25             --ngx.say("This is 'Black List' request")
26             ngx.exit(ngx.HTTP_FORBIDDEN)
27         end
28     else
29         --ngx.say("This is 'GET' request")
30         ngx.exit(ngx.HTTP_FORBIDDEN)
31     end
32 end
```



**2.nginx.conf**

location / {
root html;
index index.html index.htm;

access_by_lua_file /usr/local/lua_test/my_access_limit.lua;

proxy_pass http://127.0.0.1:8080;
client_max_body_size 1m;
}

**3.添加黑名单规则数据**

\#redis-cli sadd black.ip '153.34.118.50'
\#redis-cli sadd black.imsi '460123456789'
\#redis-cli sadd black.tel '15888888888'

可以通过redis-cli smembers black.imsi 查看列表明细

**4.验证结果**

\#curl -d "imsi=460123456789&tel=15800000000" "http://www.mysite.com/myapi/abc"