# head 和options

> http的请求方法之一；
>

//  都挺不错的；--------------------------------------------------------------------------------------------------------

https://cloud.tencent.com/developer/article/1882610

https://blog.csdn.net/demo_yo/article/details/123596028

# Head 和 Options 请求



## head （获取响应的header头，而不需要返回报文中的响应体；）

head请求是http1.0约定的三种请求方式之一，与get请求相似，但是响应报文中没有响应体，只有响应头。



**我们可以通过响应头中的content-length、last-modifed、etag来判断资源实体是否发生了变化。**

HEAD：向服务器索要与GET请求相一致的响应，只不过响应body将不会返回。这一方法可以在不必传输整个响应内容的情况下，就可以获取不包含在响应消息头中的元信息



## options （检查服务端是否）

options请求是http1.1新增的请求方式，用于查询服务端性能，比如查询服务端支持的请求方式、查询服务端是否支持跨域等。 

**常见于客户端发送非简单请求和跨域请求之前的预检。**





### 非简单请求 都需要预检；

满足以下条件之一即为非简单请求：

- **请求方式不为get、post、head**
- **请求头包含accept、accept-language、content-type、content-language accept-encoding 之外的字段**
- **content-type不为application/x-www-form-urlencoded、multipart/form-data、text/plain**



#### 为什么发送非简单请求之前要进行预检？

http是不断发展的，新增的请求方式和字段不一定被老的[服务器](https://cloud.tencent.com/product/cvm?from=10680)系统所支持，因此需要先发送预检请求去询问一下服务端是否支持这种请求。



### 跨域   CORS  跨域 共享资源    *跨域资源共享*CORS(Cross-Origin Resource Sharing)

在进行跨域时，get请求只需要发送一次请求，而post则需要发送两次。

post请求之前会先发送一个options请求，**请求头中包含origin字段**，标识客户端所在的域，这次请求并不发送请求体。

服务端在收到options请求后，会查看请求头中origin标识的域是否在自己Access-Control-Allow-Origin配置的域中，如果在的话则表示允许跨域，并向客户端返回状态码100 Continue。

之后，客户端发送post请求，将请求体传到服务端。