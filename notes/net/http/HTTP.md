# HTTP

>  header  body

**请求行** 

请求方法  url http版本

**相应行**

版本 状态码 状态码的描述



**header**

>**content-type 既可以代表请求头也可以代表响应头的请求体内容类型；**
>
>application：
>
>在IT术语中，application表示某种技术、系统或者产品的应用。
>
>text 是文本的意思？？应该就是请求的doc的意思把；

| request                                                      | response                          |
| ------------------------------------------------------------ | --------------------------------- |
| accept application<br />可以接收的（**响应的内容类型content-type**）<br />text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9<br />accept；  请求的数据类型；可以接收的数据类型； | content-type 一般是内容类型；     |
| host  http1.1 出现的字段，必须要有  不然会出现 400 bad request 错误； |                                   |
| accept-encoding  gzip压缩？gzip的压缩； 对body体的压缩；     | cache-control 第一次请求          |
| accept-language                                              | set-cookie                        |
| cookie                                                       | charset                           |
| connection keep-alive                                        | location 可以 进行跳转；          |
| cache-control                                                | connection :keepalive             |
| if-modify-since  last-modified                               | **access_control_allow_origin:*** |
| if-none-match  etag                                          |                                   |
| expire  max-age                                              | cache-control                     |
| <font color=red>User-Agent: Mozilla/5.0 (Windows NT 10.0; <br />Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) <br />Chrome/96.0.4664.45 Safari/537.36 <font color=red>UA</font> 一般还有 浏览器的类型和版本<br />操作系统的版本等等信息；<br />用户标识；就是一个用户标识；</font> |                                   |
| <font color=red>referer</font>    **告诉服务器 该网页从那个页面链接过来的；做防盗链和数据统计；** |                                   |
| origin 这里要看一下  cors  *********  options 发送给服务器来判断是否跨域；origin 本地的域名；<br />The Origin HTTP Header Request header specifies the origin of the request 请求来源<br /><font color=red>Origin请求头表示  引起请求的来源（方案、主机名和端口）。</font> |                                   |
| content-type  可以是请求头，比如 application/x-www-for-urlencod 或者 multipart/from-data; |                                   |

##  content -type = application/x-www-for-urlencode 测试

>也是属于documents；文档；还是文档性质的；

![d68fb9a0bd3b817f726e49176a33352](HTTP.assets/d68fb9a0bd3b817f726e49176a33352.png)

![image-20230401232742458](HTTP.assets/image-20230401232742458.png)

**httpbody体的物种形式**

1. multipart/from-data

    form 表单的形式提交 key value的形式提交；主要是**上传文件**可以用这个格式；
    
       	![image-20211205231559438](HTTP.assets/image-20211205231559438.png)
    
2. application/x-www-from-urlencoded  以键值对的数据格式提交；

   ​    ![image-20211205231504262](HTTP.assets/image-20211205231504262.png)

3. raw 

   选择text，则请求头是： text/plain

   选择javascript，则请求头是： application/javascript
   **选择json，则请求头是： application/json (如果想以json格式传参，就用raw+json就行了)**
   **选择html，则请求头是： text/html**
   选择application/xml，则请求头是： application/xml

   选择 图片的 iamge/jpeg|gif/png 

   **default_type  application/octet-stream;  这里是流的概念也就是说 是可以下载的；字节流的概念；字节流;**   下载；

   **在[电脑](https://zh.wikipedia.org/wiki/電腦)领域里，一个octet是指八个比特（bit）为一组的单位，中文称作八字节。**

   -----

   

   octet  [ɑːkˈtet]  字节流；

   在[电脑](https://zh.wikipedia.org/wiki/電腦)领域里，一个**octet**是指八个比特（bit）为一组的单位，中文称作字节。

   在[法国](https://zh.wikipedia.org/wiki/法國)和[罗马尼亚](https://zh.wikipedia.org/wiki/羅馬尼亞)， *octet* 这个字通常是指一个[字节](https://zh.wikipedia.org/wiki/位元组)（byte）的意思；当我们称一兆字节（megabyte，MB），在这些地区会称作 *megaoctet*。 *bit* 和 *byte* 在法语里是异义同音字。

   *Octet* 除了下面提到的唯一例外之外，都是指一个具有八个比特的实体。因此在电脑网络标准中，在*byte*容易引起混淆的地方都仅使用*Octet*。

   ----

   

   **当浏览器在请求资源时，会通过http返回头中的content-type决定如何显示/处理将要加载的数据，如果这个类型浏览器能够支持(其实就是请求头里面的accept 整个字段，如果content-type 在这个字段里面那么就直接显示；)阅览，浏览器就会直接展示该资源，比如png、jpeg、video等格式。**

   

   **在某些下载文件的场景中，服务端可能会返回文件流，并在返回头中带上Content-Type:application/octet-stream，告知浏览器这是一个字节流，浏览器处理字节流的默认方式就是下载。**

4.    binary

   二进制 可以传图片啥的，一般用的不多；

https://blog.csdn.net/qq_41063141/article/details/101505956

**gzip压缩；**

nginx.conf

**gzip on;**



**压缩的好处**

http压缩对纯文本可以压缩至原内容的40%, 从而节省了60%的数据传输。

 

**Gzip的缺点**

JPEG这类文件用gzip压缩的不够好。

对HTTP传输内容进行压缩是改良前端响应性能的可用方法之一，大型网站都在用。但是也有缺点，就是压缩过程占用cpu的资源，客户端浏览器解析也占据了一部分时间。但是随着硬件性能不断的提高，这些问题正在不断的弱化。





**1、multipart/form-data**

以表单形式提交，主要是上传文件用它，在http中格式为

![img](HTTP.assets/723212-20200114153241518-1384315665.png)

 

 

![img](HTTP.assets/723212-20200114153329703-1799181840.png)

 

 

 

 

 **2、application/x-www-from-urlencoded**

以键值对的数据格式提交，当action为post时，浏览器将form数据封装到http body中，然后发送server。这个格式不能提交文件

 

 

 

![img](HTTP.assets/723212-20200114154852191-2084542829.png)

 

 

 ![img](HTTP.assets/723212-20200114154900551-180602897.png)

 

 

 

 **3、raw 可以上传任意格式的文本，**（**就是流  原生的意思，php 可以i使用 file_get_contents('php://input')**）;;;

选择text，则请求头是：text/plain

选择JavaScript，则请求头是：application/javascript

选择json，则请求头是：application/json(如果想以json格式传参，就用raw+json就行了)

选择HTML，则请求头是：text/html

选择application/xml，则请求头是：application/xml

![img](HTTP.assets/723212-20200114161223043-325613581.png)

 



 

**4、binary**

相当于Content-Type:application/octet-stream,从字面意思得知，只可以上传二进制数据，通常用来上传文件，由于没有键值，所以，一次只能上传一个文件。（一般用的不多）

![img](HTTP.assets/723212-20200114162239427-1373644578.png)

 

 **5、postman中Params和Body的区别**

Params它会将参数放入url的？后面提交到后台（带到请求的接口链接里），用于Get请求。

![img](HTTP.assets/723212-20200114162622510-1411186005.png)

 

 Body是放在请求体里面，用于Post请求

![img](HTTP.assets/723212-20200114162855121-565005554.png)





**put  body体里面的内容 也可以用  php://input的形式来接收信息；**



**在cmder 中使用ctrl + n（数字来切换屏幕，ctrl+p来进行分屏；）**



**@file_get_contents('file_get_contents'); // 错误抑制符；@错误抑制符；**







## php://input的简介；



php://input 可以抓取所有的请求

所有的content-type类型；

\$_POST  \$\_GET  只能抓取到GET POST的；

\$_POST  只能抓取 post的  from-data and x-www-for-urlencode 的类型；表单的类型；

**put  raw的xml  json的数据格式 都需要 我们去用php://input  来获取；**





##  注意一些浏览器的设置



一 简介
Content-Type是HTTP的请求头（也是响应头），英文直译是内容类型的意思。但专业的讲是媒体类型，也就是MMIE，主要是描述请求体和响应体的数据是什么类型。

二 常见请求头使用问题
如果是GET请求，请求参数会被编码进url，所以传Content-Type没有意义

如果是POST请求，默认的的请求头是text-plain,这种请求方式，后台形式参数若不添加@RequestBody不能接收到数据

如果POST请求，请求头Conetent-Type:application/x-www-form-urlencoded，如果后台又没有特殊指定，会按照key-value的形式去解析数据，但后台如果做了特殊指定，则按照后台指定的方式去解析，例如SpringMVC给请求参数添加@RequestBody注解则会将请求数据当作整体去处理

POST请求，请求头Conetent-Type:application/json
1 后台的形式参数是String，则无论请求参数是否符合json格式都会接收到数据
2 后台形式参数是Map或Bean，则必须符合JSON格式

POST请求，请求头Conetent-Type:application/xml
1SpringMVC框架必须要给后台形式参数添加@RequestBody注解，则会将请求数据当作整体去处理即使不是xml格式字符也会处理
2若想将xml转换成对象，添加@RequestBody注解 接收到xml字符，然后将xml转成Bean，参考https://www.cnblogs.com/XL-Liang/archive/2013/03/22/2974987.html

三 总结
请求参数为key-value格式表单数据则请求头Conetent-Type采用Conetent-Type:application/x-www-form-urlencoded
请求参数为json格式字符，Conetent-Type:application/json，并且后台形式参数添加@RequestBody注解则会将请求数据当作整体去处理
请求参数为xml格式字符，则Conetent-Type:application/xml，并且后台形式参数添加@RequestBody注解则会将请求数据当作整体去处理



 origin



