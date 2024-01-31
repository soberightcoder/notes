# location

**定位一个页面；**



http 是http请求； http请求可以到达很多服务器；

​	server  是一个服务； 一个服务器；

​			location 就是一个页面；  对应着一个页面；

​				if 就是页面里面的操作； 页面里面的操作；

 ```nginx
if (!-e $request_filename) {
	proxy_pass http://ceshi/
}
 ```





