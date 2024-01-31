# content-type



Content-Type，从名字上可以理解为内容类型，但在互联网上专业术语叫“媒体类型”，即MediaType，也叫MIME类型，主要是用来指明报文主体部分内容属于何种类型，比如html，json或者xml等等。

但是content-type一般只存在于Post方法中，因为Get方法是不含“body”的，它的请求参数都会被编码到url后面，所以在Get方法中加Content-type是无用的。

常见的类型包括以下几种

类型	格式
text/html	HTML格式
text/plain	纯文本格式
text/xml	XML格式
image/gif	gif图片格式
image/jpeg	jpg图片格式
image/png	png图片格式

application/xhtml+xml	XHTML格式
application/xml	XML数据格式
application/atom+xml	Atom XML聚合格式
application/json	JSON数据格式
application/pdf	pdf格式
application/msword	Word文档格式
application/octet-stream	二进制流数据（如常见的文件下载）

application/x-www-form-urlencoded	表单提交中默认的encType
multipart/form-data	在表单中文件上传时，就需要使用该格式
这个content-type同时用在请求和响应中，位于头部中，它的内容决定了浏览器或服务端的处理方法；

post 的 content-type 常用的有 ：

application/x-www-form-urlencoded 
这种就是一般的文本表单用post传地数据，只要将得到的data用querystring解析下就可以了

multipart/form-data ，用于文件上传，此时form的enctype属性必须指定为multipart/form-data。请求体被分割成多部分，每部分使用—boundary分割。

application/json，将数据以json对象的格式传递



form-data

就是http请求中的multipart/form-data,它会将表单的数据处理为一条消息，以标签为单元，用分隔符分开。既可以上传键值对，也可以上传文件。当上传的字段是文件时，会有Content-Type来表名文件类型；content-disposition，用来说明字段的一些信息；

由于有boundary隔离，所以multipart/form-data既可以上传文件，也可以上传键值对，它采用了键值对的方式，所以可以上传多个文件。

x-www-form-urlencoded

就是application/x-www-from-urlencoded,会将表单内的数据转换为键值对，比如,name=java&age = 23

multipart/form-data与x-www-form-urlencoded区别

multipart/form-data：既可以上传文件等二进制数据，也可以上传表单键值对，只是最后会转化为一条信息；

 x-www-form-urlencoded：只能上传键值对，并且键值对都是间隔分开的。
————————————————





---

https://blog.csdn.net/tajon1226/article/details/121819809

https://blog.csdn.net/u013827143/article/details/86222486?spm=1001.2101.3001.6661.1&utm_medium=distribute.pc_relevant_t0.none-task-blog-2%7Edefault%7ECTRLIST%7Edefault-1-86222486-blog-121819809.pc_relevant_multi_platform_whitelistv3&depth_1-utm_source=distribute.pc_relevant_t0.none-task-blog-2%7Edefault%7ECTRLIST%7Edefault-1-86222486-blog-121819809.pc_relevant_multi_platform_whitelistv3&utm_relevant_index=1



urlencode；

可以看到http的header为

 Content-Type: application/x-www-form-urlencoded\r\n



还有post的数据区只有一条信息，组成规则

键名1=值1& 键名2=值2





form-data 上传文件



规则是：

Content-Disposition: form-data; name="**键名**"; filename="**文件名**"\r\n

Content-Type: image/jpeg\r\n\r\n + **JPG二进制数据**







一条数据组成：Content-Disposition: form-data; name="**键名**" + **2个换行符** + **值**

Content-Disposition: form-data; name="键名"\r\n\r\n值

