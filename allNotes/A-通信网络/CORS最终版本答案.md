# CORS 最终版本答案；





`````php
<?php
/**
 * 用超全局变量$_SERVER['REQUEST_METHOD'] 来获取请求方式是什么样子的；请求的REQUEST_URI
 *  $_SERVER ['REQUEST_METHOD'].' '. $_SERVER ['REQUEST_URI'].' '. $_SERVER ['SERVER_PROTOCOL'].
 * 
 * 
 */
/*
//access-control-allow-headers: x-log-apiversion,x-log-bodyrawsize
//access-control-allow-methods: POST
//access-control-allow-origin: *
//access-control-max-age: 86400
//access-control-allow-credentials: true
*/
header("Access-Control-Allow-Origin:http://laravel.com");
header('access-control-allow-headers: a');
echo 'aaa';
// return 'aaa';
// echo $_SERVER['REQUEST_METHOD'];


/*
最好先打开laravel.com网址（我自己的测试网址），然后查看源代码，在console fetch();来发送请求；
//注意 你在那个url打开源代码，就是代表的是你使用那个网站的url为origin来发送信息；
fetch('http://demo.com/index10.php');
*/
/*

fetch(url, {
  // options
}).then(function(response) {
  //response
}, function(error) {
  //error
});

*/
/*
//用这个方式 来进行普通的请求；
fetch('http://demo.com/index10.php').then(function(res) {
    return res.text();
}).then(function(data) {
    console.log(data);
});
*/
/*
fetch('http://demo.com/index10.php', { 
    headers: {
        a: 1,
    },
}).then(function(res) {
    return res.text();
}).then(function(data) {
    console.log(data);
});
*/

/**
 * 跨域问题：
 * 协议，域名，端口不同都会产生跨域问题；
 * 同源策略，源就是上面协议端口，域名都一样的url; 
 * 同源策略产生的根源就是浏览器，其实服务器已经返回数据了，但是被浏览器做了拦截是，所以cors的根本就是浏览器；而反向代理没有浏览器的参与所以也可以解决跨域；
 *  */ 
/*

    跨域 资源共享 Cors的过程；
    你把他分为三部分就可以了， 用户（客户端） google（浏览器 ） 服务器（server）
    简单请求：客户端发送请求（带有origin字段），然后到服务器，服务器返回信息（会带有那几个字段 access-control-allow-oringin headers method ），给浏览器，
    浏览器判断是否允许跨域，允许跨域的话，就给客户端返回信息；不允许跨域，浏览器就给你拦截服务器返回的信息；
    非简单请求，就是先发送不带body的预检请求options，如果允许跨域，就继续发送正常的非简单请求，如果不允许跨域那么就不在发送非简单请求；
*/

/*
简单请求：
请求方式： get  post head 
header 字段，是一些基础字段，只要不是自定义字段就可以了；
content-type字段：text/plain application/x-www-form-urlencoded  appplication/form-data
其他的方式都是一非简单请求；application/json 也是非简单请求；
*/

// if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){ 
//     // options
//     // httpStatus(405);
// }

function httpStatus($num){//网页返回码
    static $http = array (
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        203 => "HTTP/1.1 203 Non-Authoritative Information",
        204 => "HTTP/1.1 204 No Content",
        205 => "HTTP/1.1 205 Reset Content",
        206 => "HTTP/1.1 206 Partial Content",
        300 => "HTTP/1.1 300 Multiple Choices",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        305 => "HTTP/1.1 305 Use Proxy",
        307 => "HTTP/1.1 307 Temporary Redirect",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        402 => "HTTP/1.1 402 Payment Required",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        406 => "HTTP/1.1 406 Not Acceptable",
        407 => "HTTP/1.1 407 Proxy Authentication Required",
        408 => "HTTP/1.1 408 Request Time-out",
        409 => "HTTP/1.1 409 Conflict",
        410 => "HTTP/1.1 410 Gone",
        411 => "HTTP/1.1 411 Length Required",
        412 => "HTTP/1.1 412 Precondition Failed",
        413 => "HTTP/1.1 413 Request Entity Too Large",
        414 => "HTTP/1.1 414 Request-URI Too Large",
        415 => "HTTP/1.1 415 Unsupported Media Type",
        416 => "HTTP/1.1 416 Requested range not satisfiable",
        417 => "HTTP/1.1 417 Expectation Failed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        504 => "HTTP/1.1 504 Gateway Time-out"
    );
    header($http[$num]);
    exit();
}
`````

---

## 同源策略

> 怎么去检验，只有校验通过才会把数据返回给客户端，或者说用户；

![image-20240129131005784](./CORS%E6%9C%80%E7%BB%88%E7%89%88%E6%9C%AC%E7%AD%94%E6%A1%88.assets/image-20240129131005784.png)

---

## 简单请求

````php
// 请求header 只会带有一个字段；Origin字段； 代表的是源；
// 就一个origin字段； 在header头里面；

有access-control-allow-origin  // 字段响应返回就可以了；

````

![image-20240129130202950](./CORS%E6%9C%80%E7%BB%88%E7%89%88%E6%9C%AC%E7%AD%94%E6%A1%88.assets/image-20240129130202950.png)

​	

----

## 非简单请求

`````php
//options请求里会带有一些header；
Origin: http://my.com
Access-Control-Request-Method: POST
Access-Control-Request-Headers: a , b , content-type
`````



![image-20240129125532205](./CORS%E6%9C%80%E7%BB%88%E7%89%88%E6%9C%AC%E7%AD%94%E6%A1%88.assets/image-20240129125532205.png)
