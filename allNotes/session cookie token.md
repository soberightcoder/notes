# session cookie

>session cookie token
>
>total：http无状态的问题；
>
>*鉴权*（authentication）是指验证用户是否拥有访问系统的权利。
>

---



http请求无状态的回答

如何理解HTTP协议是无状态的，如何让其有状态

**面试回答：**

**http协议呢，是一种超文本传输协议，而为什么说http协议是无状态的呢，是因为当浏览器第一次发送数据给服务器时，服务器响应了；如果同一浏览器，向服务器第二次发送请求时，它还是会响应，但服务器并不知道你就是刚才那个浏览器。简而言之，服务器是不会记住你是谁的，所以是无状态的。**

**而如果要使http协议有状态，就可以使浏览器访问服务器时，加入cookie，这样，只要你在请求时有了这个cookie，服务器就能够通过cookie知道，你就是之前那个浏览器，这样的话，http协议就有状态了。**

******

**会话** （session）

**访问一个网站,只要不关闭该浏览器，不管该用户点击多少个超链接(访问同一个网站；)，访问多少资源，直到用户关闭浏览器，整个这个过程我们称为一次会话**.**（同一个服务器，不然就属于不同服务器的一次会话了）**



********



**cookie**

1. 存在于客户端；
   * php不能直接操作cookie，需要http协议“通知”浏览器，然后浏览器去修改，也就是说第一次请求cookie是null；
   * php获取的$_COOKIE,也是http通过header，COOKIE：传递过来的；
2. cookie的有效期，根据<font color=red>expire</font>（application）分为两类：
   * session 代表的是会话，当关闭浏览器的时候过期，数据存储在内存；不设置过期时间 <font color=red>setcookie('ceshi','qq.com')</font><font>;关闭页面不行的；
   * 日期，setcookie(key,value,expire,path)，设置了过期时间，数据存在硬盘； setcookie('name','qiuqiu',time()+60,'/'); 
   
3. cookie具有不可跨域性；一个网站是否可以操作另外一个网站cookie根据的<font color=red>域名</font>；
4. cookie的域名：domain（application）属性决定cookie的域名，<font color=red>是否跨域</font>由域名来决定； 可以实现单点登录，可以使用cookie跨域；domain设置同一个域名例如：ww.qq.com www.ew.qq.com www.ss.sa.qq.com  可以设置为.qq.com 来实现单点登录；
5. cookie的属性path，来决定目访问cookie的路径，默认是‘/’（当前路径）；
6. cookie 与服务端的通信是基于 HTTP 的，所以 cookie 的上行下载对带宽的消耗较高。
7. 保存在客户端，安全性差；
8. cookie中会保存sessionID，php中就是PHPSESSION，服务端可以使用session_name(),sesssion_id();来获取；
9. cookie 只能保存字符串；session 可以保存对象；
10. cookie<font color=red>设置，修改和过期</font>的问题；setcookie();都需要这个参数来设置，这个参数的<font color=red>原理就是修改header头</font>；
11. setcookie(name,value,expires,path,domain,secure,httponly); 七个参数
    1. name 键
    2. value 值
    3. **expires 过期时间** 
    4. **path 路径**
    5. **domain 域名**
    6. **secure 安全，只能在https传输**
    7. **httponly cookie 无法通过js脚本来获取，可以减少csrf攻击，这个地方其实没啥用，还是可以获取；**
12. 实例：
    1. 单点登录；
    2. 长久登录 7天免登录啥的都是 cookie；

******

**session**

1. 存在于服务端，后端是跨页面的，但是对于不同的会话，访问到的session数据是不一样的；同一个域名所以访问到的数据就是一样的；

2. session id 存在于客户端；

3. session设置过期时间

   `````php
   session_start();//只有打开了 session_start(); 将sessionid保存于cookie中；必须打开session_start(); 才能用$_SESSION  不然 都不知道取内存的那个变量；根据不同的会话会有不同的$_SESSION;
   //修改;
   $_SESSION['name'] = 'qiuqiu';
   //设置过期时间； session.gc_maxlifetime 指定过了多少秒之后数据就会被视为“垃圾”并被清除
   session_start();
   $mid = session_get_cookie_params();
   //要让session过期必须要让，cookie 过期和 session的数据也要销毁；同时达到这两个目的；
   setcookie(session_name(),'',time()-1,$mid['path'],$mid['domain'],$mid['secure'],$mid['httponly']);
   session_destroy();
   `````
   
4. session 可以存储对象;

5. 当禁用了cookie ，可以通过重写url来传递PHPSESSION 或者body体都可以传递；

6. session存在于服务端，所以比较安全；

7. 实例：是否登录的判断；

********

鉴权问题：

* cookie鉴权密码放在客户端肯定是不可能的，很不安全；cookie 一般只会放一些不敏感的信息，用户轨迹等等，购物车之类的；x

* session的鉴权：
  * 是否登录状态保存在客户端；比较安全；每24分钟需要重新登录一下；
  * 缺点：在分布式中每次访问不同服务器的session共享问题，需要建立redis，但是redis也有一个缺点，redis存储在内存如果有问题那么就完蛋了；服务器集群，负载均衡，ip的粘连，粘连也存在服务器崩溃的问题；最后又出现了一致性哈希；
  
* token的鉴权：

* token 是有状态的 还是无状态的？ 

* 什么是token
  token 是服务器端生成的串字符串，以作客户端进行请求的一个令牌，当第一次登陆后，服务器生成一个Token便将此Token返回给客户端，以后客户端只需带上这个Token青睐请求数据即可，无需再次带上用户名和密码。

  
  
  token的用处
  Token 完全由应用管理，所以它可以避开同源策略
  Token 可以避免 CSRF 攻击
  Token 可以是无状态的，可以在多个服务器间共享（负载均衡；）

  
  
  Token 是在服务端产生的。如果前端使用用户名/密码向服务端请求认证，服务端认证成功，那么在服务端会返回 Token 给前端。前端可以在每次请求的时候带上 Token 证明自己的合法地位。如果这个 Token 在服务端持久化（比如存入数据库），那它就是一个永久的身份令牌。
  
  
  
  **基于Token的身份验证**
  使用基于token的身份验证方法，在服务端不需要存储用户的登记记录。流程是这样的：
  客户端使用用户名和密码请求登录
  服务端收到请求，去验证用户名与密码
  验证成功后，服务端会签发一个Token，再把这个Token发送给客户端
  客户端收到Token以后可以把他存储起来，比如放在Cookie里或者Local Storage里
  客户端每次想服务器端请求资源的时候后需要带上服务器签发的Token
  服务端收到请求，然后去验证客户端请求里面带着的Token，如果验证成功，就向客户端返回请求的数据
  APP登录的时候发送加密的用户名和密码到服务器，服务器验证用户名和密码，如果成功，以某种方式比如随机生成32位的字符串作为token，存储到服务器中，并返回token到APP，以后App请求的时，凡是需要验证的地方都要带上token，然后服务器端验证token，成功返回所需要的结果，失败返回错误信息。其中服务器上token设置一个有效期，每次app 请求的时候都验证token和有效期。
  
  
  
  **token的优势**
  无状态、可扩展：在客户端存储的token是无状态的，并且能够被扩展。基于这种无状态和不存储session信息，负载均衡器能够将用户信息从一个服务传到其他服务器上。如果我们将已验证用户的信息保存在session中，则每次请求都需要用户想已验证服务器发送验证信息。用户量大时，可能会造成一些拥堵 
  
  
  
  **最主要原因还是session存储在服务器的磁盘上；**
  
  降低服务器的压力，数据保存在客户端，降低服务器的压力！！！
  
  安全性：请求中发送token而不再是发送cookie能够防止跨站请求伪造。
  可扩展性
  多平台跨域
  基于标准
  
  
  
  在使用无状态 Token 的时候，有两点需要注意：
  Refresh Token 有效时间较长，所以它应该在服务器端有状态，以增强安全性，确保用户注销时可控
  应该考虑使用二次认证来增强敏感操作的安全性



## token

### 目录

- 缘起
- 原理
- 优势
- 认证流程
- 注意事项

------

### 缘起

Token 的出现源于整个 Web 的发展历史：

1. Web 最初出现只是为了浏览文档，从 HTTP 协议名称（HyperText Transfer Protocol，超文本传输协议）中便可看出，HTTP 1.0 版本起初即被设计为无状态。



1. 随着 Web 交互式应用的兴起（如：在线购物），HTTP 协议无状态性的局限很快被发现，为了管理会话并保留期间的状态信息，很快想出了一个办法，即服务端为每个客户端生成一个**会话标识（Session ID）**，此**会话标识（Session ID）**是个随机字符串，每个客户端收到的不一样，后续每个客户端再发起请求时必须连同此**会话标识（Session ID）**一起发送，这样服务端便可根据不同的**会话标识（Session ID）**区分请求来自于哪个客户端。



1. 虽然通过

   会话标识（Session ID）

   已经能够区分不同的客户端请求，但是随着应用规模的增加，服务端面临了几个挑战：

   - 因为服务端需要保存**会话标识（Session ID）**，因此一旦客户端数量非常大时，服务端存储开销巨大；
   - 当需要通过集群方案扩展服务端能力时，**会话标识（Session ID）**的共享又成了一个问题，因为客户端的请求可能会被转发到不同的服务端节点，譬如第一次请求转发到服务端节点 A，下一次请求被转发到服务器节点 B，那么 A 和 B 之间必须实现**会话标识（Session ID）**的共享，否则客户端在 A 已经认证通过后，转发到 B 后又要重新认证。尽管可以通过不同的负载均衡算法保证一个客户端的请求始终转发到一个固定的服务节点，但一旦 IP 发生改变则很可能又要进行重新认证。考虑到**会话标识（Session ID）**在多节点间复制的同步效率问题，通常会使用 Redis 等分布式系统集中缓存方案统一存放**会话标识（Session ID）**，但这仍然依赖于 Redis 的可靠性，且存储空间消耗的问题也未解决。

为了避免服务端存储**会话标识（Session ID）**，Token 应运而生。



------

### 原理

如果服务端不存储**会话标识（Session ID）**，那么如何保证客户端请求中带的**会话标识（Session ID）**是有效的呢？如何避免伪造？Token 的关键在于其**不可伪造**。
 Token 生成过程：

1. 服务端认证通过客户端身份后，利用部分有效数据组成一段明文，如：`{"username":"admin"}`；
2. 服务端使用一种加密算法加上一个只有自己才知道的密钥对以上数据进行签名，生成签名字符串：`XXXXXX`；
3. 将明文和签名字符串组合成一个文本：`{"username":"admin"}XXXXXX`；
4. 对组合后的文本执行 `BASE64` 编码即得到 Token；
5. 将此 Token 直接返回给客户端，不在服务端保存；
6. 客户端再次发送回请求后，取出其中的 Token，首先执行 `BASE64` 解码，然后分离出明文段和签名段，使用第 2 步中相同的加密算法和密码生成签名字符串，与解码后得到的签名段进行比较即可判断 Token 是否有效。



Token 实际上是一种 **时间换空间** 的方案，即利用 CPU 加密的计算时间换取 **会话标识（Session ID）**的存储空间。没有了 **会话标识（Session ID）**的负担，服务端的水平扩展便无需考虑集中存储的瓶颈，只需增减服务器数量即可。

------

### 优势

- 安全性
   请求中发送 Token 而不再是发送 Cookie 能够防止 CSRF（跨站请求伪造），即使客户端使用 Cookie 存储 Token，此时的 Cookie 也只是用于存储而非认证。
   Token 具备时效性，也可以撤回，通过 Revocation 可以使一个特定 Token 或一组有相同认证的 Token 失效。
- 无状态
   Token 是无状态的，无需服务端存储。
- 可扩展
   使用 Token 可以提供一定范围的权限给第三方服务，可以开放独立的 API 和特殊权限 Token 给第三方服务访问。
- 多平台跨域
   通过将服务器属性设置为 `Access-Control-Allow-Origin: *` 可实现数据和资源能够被任何域请求。
- 基于标准
   参考：[JSON Web Tokens](https://links.jianshu.com/go?to=https%3A%2F%2Fjwt.io%2F)

------

### 认证流程

1. 客户端发送含有用户名和密码的身份认证请求；
2. 服务端接收到请求后验证用户名和密码；
3. 验证成功后服务端会生成一个 Token 并返回给客户端；
4. 客户端将请求存储在 Cookie、或 LocalStorage 中，客户端在后续所有请求中都附带上该 Token；
5. 服务端接收到请求后通过过滤器验证 Token 有效性。

------

### 注意事项

- Token 中的明文数据不能存放敏感信息。
- Token 应该放在 HTTP 的头部，这样才保证了 HTTP 请求的无状态。
- 注意服务器属性设置：`Access-Control-Allow-Origin: *`，让服务器能够接受来自所有域的请求。





---

是的，PHP 的会话（session）机制可以存储对象数据类型。会话是一种在服务器端存储和跟踪用户状态的机制，它允许在不同的页面和请求之间保持数据的持久性。

PHP 的会话机制使用 `$_SESSION` 超全局变量来存储会话数据。`$_SESSION` 是一个关联数组，可以存储各种类型的数据，包括对象。

要在会话中存储对象，你需要确保对象是可序列化的。可序列化的对象是指可以将其转换为字节流以便存储或传输的对象。在 PHP 中，对象需要实现 `Serializable` 接口才能进行序列化。

以下是一个示例，演示如何将对象存储在 PHP 会话中：

```php
CopyOpen// 定义一个可序列化的对象
class Person implements Serializable {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function serialize() {
        return serialize($this->name);
    }

    public function unserialize($data) {
        $this->name = unserialize($data);
    }

    public function getName() {
        return $this->name;
    }
}

// 启动会话
session_start();

// 创建一个对象并存储在会话中
$person = new Person('John Doe');
$_SESSION['person'] = $person;

// 从会话中获取对象并使用
$storedPerson = $_SESSION['person'];
echo $storedPerson->getName(); // 输出 "John Doe"
```

在这个示例中，我们定义了一个 `Person` 类，它实现了 `Serializable` 接口。该类具有 `serialize()` 和 `unserialize()` 方法，用于将对象序列化为字符串和从字符串反序列化为对象。我们将一个 `Person` 对象存储在 `$_SESSION` 数组中，并在后续请求中从会话中获取并使用该对象。

需要注意的是，存储在会话中的对象在每个请求之间会自动进行序列化和反序列化。这意味着你可以在会话中存储对象，并在不同的页面和请求之间保持对象的状态。
