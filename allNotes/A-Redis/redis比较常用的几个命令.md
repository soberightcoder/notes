# redis比较常用的几个命令

>redis的所有的命令都是原子性的；
>
>redis
>
>**redis-cli monitor 监控redis 使用的命令；**

**Redis单线程，命令顺序执行；**



**redis 是单线程，多路复用IO模型；**

**redis6.0 的io多线程只负责处理IO的解包或者协议的转换；但是对数据的处理一直都是单线程；**



**但是在高并发下，代码的执行顺序，和代码的执行顺序是不一样的；所以一般需要lua来保证原子性；**



`````php
# redis 为什么这么快？

1. Redis的所有数据都放在内存中;是nm级别的操作；
2. Redis是C语言实现的；
3. Redis是单线程的，**预防了多线程可能存在的竞争问题**；**没有上下文的切换；**
4. epoll IO模型；异步非阻塞模型；
  
`````





**注意：key=>value 是一种hash  value又可以分为多种数据结构来提高查询效率；**

redis-server 

**redis-cli -h -p /etc/redis.conf**

// 查看redis的版本

redis-server -v
Redis server v=4.0.8 sha=00000000:0 malloc=jemalloc-4.0.3 bits=64 build=51ec49f06079b708



shutdown 还有一个参数，代表的是在关闭Redis之前是否生成 持久化文件；



redis-cli shutdown nosave/save 

redis-server /etc/redis.conf

----



## key 操作



127.0.0.1:6379> keys *  不要使用keys \*

del key [keys...]  // 可以批量删除；

exists key

expire key seconds  //设置key的过期时间；

type key  数据类型；

object encoding key  **（value的数据格式 编码格式）**  底层的数据格式；

ttl key  

**scan cursor [math pattern] [count number]** math 匹配模式 默认是*  count 每次返回的数据条数(默认是10条)  游标cursor



---



## string



####string  （动态字符串）

* int : 8个字节的长整型；（-2^64 - 2^64-1）   **整型；int** 

* embstr : 小于等于44个字节的字符串； **小于44个字节的字符串；**

* raw : 大于44个字节的字符串；  **大于44个字节的字符串；**

  ---

  

set 

get  不存在的时候是nil

mset key [key...]   

mget  key [key...]

incr key 

decr key  

setnx  键不存在，才会设置成功。用于添加； setmx key value；

setex  setex key seconds value；



set key value ex 60 nx;     //// 这一个命令一定要注意；这个是分布式锁必须要用到的命令；//分布式锁；



incrby key increment

strlen key

---

实例：

1. ​	当有请求的时候先请求Redis，缓存hit(缓存命中)，则直接return数据给web服务端，当缓存miss就去访问MySQL，write cache到Redis，并且返回数据到web服务端；

   ~~~php
   //伪代码
   $key = "cache:user:".$uid;
   if(isexists $key != null){
   	return get $key;
   }
   $mysqlData = mysql->get($key);
   if(!empty($mysqlData)){
   	set $key $mysqlData ex 3000; //setnx $key 3000 $MysqlData
   }
   return $mysqlData;
   ~~~

   

 2. **计数**    

    就是利用Redis的单线程，来实现计数，使用命令incr key；

  3. **共享Session**

     分布式服务器中存在的问题，当使用负载均衡的时候，有可能会因为均衡会发送请求到不同的服务器，那么就会出现用户退出的问题，这个地方可以使用Redis对用户的登录数据来进行统一管理；当然也可以使用ip_hash来解决每次访问的都不是同一个服务器的问题；

4. **限速** （限制一个请求在某一定时间内的请求次数，防止被频繁请求）

   本书的例子是：一分钟内如果请求次数超过5次那么就要被限制速度；

   ~~~php
   //伪代码
   $key = "message:limit:".$phone; 
   $isExists = set key value ex 60 nx; //已经存在还去set 返回的是nil  不存在才能去设置； value =0； // 从0开始；访问过一次；
   if($isExists != null || $key <= 5){
       //不限速
       incr key;  // +1;
   }else{//$isExists = null && $key>5 那么就限速 一分钟之内请求5次
       //限速
   }   
   ~~~



---



##HASH  



##（两种内部编码：

1. ziplist 当哈希元素个数小于512个(field <512)，同时value值小于64字节，Redis会使用Ziplist实现哈希，**连续储存，比较节省内存O(n)**；
2. hashtale ，当数据比较多的时候（field >=512），读写效率会提高到O(1);

##）

---



#### HASH 哈希表 （键值对数据结构）（hash，ziplist） value值： Hash类型的映射关系叫做  **field-value**         key 是哈希表的名字；哈希表的命令是对field的操作；对key的操作可以使用del key；

**hset key field value**

**hget key field**

hdel key field ...[field]



hlen key       field 的个数



**hmset key field value field value ....**  //设置多个field value...

**hgetall key**   // 获取key的所有的field 和 value值；



hincr key field

hstrlen key field



----

###案例：

**保存用户数据或者订单数据（比较常见）**

​	主要有三种缓存用户数据的方式：

 1. 原生字符串类型，每一个属性一个键；

    ~~~
    set user:1:name qq
    set user:1:age 18
    set user:1:city bj
    ~~~

     优点：简单直接，更新简单，每一个属性都支持更新操作；

    缺点：占用内存比较多，用户信息的内聚性(同一行userid数据，age，name，city，关联性比较差，只有看到key的数据，才知道他们同属于userid=1的数据)比较差，所以此种方案一般不会在生产中使用；

    

    2. 序列化字符串类型，将用户的信息序列化后用一个键保存；
    
    ~~~
    set user:1 serialize($userInfo)
    ~~~

    优点：占用内存比较少，比较简单；

    缺点：每次对数据进行更细，都必须全部取出数据unserialize，更新，最后序列化再更新到，如果你仅仅想取一个字段，那么需要取出所有的数据反序列化查看；

    
    
    3. 哈希类型 每一个用户属性都要对应一个field-value，但是只用一个键来保存；

    ~~~
    hmset user:1 name qq age 18 city bj [key name..age.. city..]
    ~~~
    
    优点： 占用内存比较少；
    
    缺点：当Redis数据的数量发生变化的时候内部编码会再Ziplist和Hashtable之间进行转换，所以需要控制这种转换，Hashtable会消耗更多的内存；

---



## LIST

####LIST 列表（有序的字符串，允许有重复的元素，能通过下标来获取数据 lrange ）（ziplist，双向链表，quicklist）



#### 内部编码

* ziplist（压缩列表）列表的元素个数要小于512个，元素的值要小于64字节，主要是为了减少内存；

* linkedlist (链表) 双向链表；

  注意: **Redis3.2 出现了quicklist集合了两者的特点;**



列表用来存储**多个有序字符串**；

列表中的每一个字符串称为**元素，**一个列表可以最多可以储存**2^32 -1** 个元素，列表是一种灵活的数据结构，可以当作栈或者队列来使用；



列表包含的两个特点:

* **列表中的元素是有序的,可以通过下标来获取元素或者范围元素列表;**
* **列表中的元素是可以重复的;**

---



push key [value...]  lpush  rpush

pop key [value...] lpop rpop 



**lrange key start end    左右 0->N-1  右到左 -1-> -N  lrange key 0 -1 全部** 



**blpop key [key...] timeout 阻塞 是null 那么一直阻塞；阻塞的超时时间timeout； 一定要设置timeout =0  就是当为null的时候一直阻塞；**

**brpop  key [key...] timeout  为了防止空转浪费cpu ，所以这边会使用，所以会使用阻塞的方式，防止浪费cpu资源；**



---



Brpoplpush  阻塞 从右边弹出，左边入队列；阻塞的；可以做一个可靠队列；

需要两个队列 runingtasklist；可靠队列；

一个就是等待队列；waittasklist；

----

**案例：**

1. 阻塞队列

* 使用lpush和brpop来实现阻塞队列，生产者客户端使用lpush从列表左边侧插入元素,多个消费者客户端brpop阻塞抢尾部的元素,多个客户端来保证了消费的负载均衡和高可用;

2. 文章列表

   **因为是有序的，所以可以使用文件的列表；**

* 假如每一篇文章都是用哈希结构存储，每一篇文章有三个属性:title,timestamp,content：

  ~~~
  127.0.0.1:6380>  hmset acticle:1 title xx timestamp 234 content xx
  OK
  ~~~

* 向用户的文章列表中插入文章；

  ~~~
  lpush user:1:acticles acticle1 acticle2 acticle3...
  ~~~

* 获取id=1的用户的前10篇文章；

  ~~~php
  //伪代码
  $acticle_keys = lrange user:1:acticles 0 9  //前十篇文章
  foreach($acticle_keys as $acticle){
     $info = hgetall($acticle);
  }
  ~~~

  实际上列表使用的场景很多：

  * lpush + lpop = Stack（栈）
  * lpush + rpop = Queue（队列）
  * lpush + ltrim = Capped Collection (有限集合)
  * lpush + brpop = Message Queue （消息队列）

  

####SET 集合（互异性（不重复），确定性（可以判断某个元素是否在集合内），无序性；集合没有顺序；）(hash，intset（整数数组）)

#### 内部编码

两种内部编码：

*  intset(整数集合)：当集合中元素都是整数，并且元素个数小于512个；减少内存的适合用；
*  hashtable(哈希表)：无法满足intset条件的时候；

`````php
#这里要把整数单独数来，就是因为整数去做比对的时候比较简单；！！
##字符串 去比对是一个时间复杂度比较高的操作！！！就算使用了kmp算法也是O(n)的时间复杂度；
`````



集合（set）类型用来保存多个字符串元素，但是和列表相比较，集合中不能允许存在重复的元素， 并且元素是无序的，不能通过索引下标来获取元素；

**注意 ：****一个集合最多存储2^32-1个元素**；Redis支持集合的增删改查，同时还支持多个集合的交集，并集，差集

---



sadd key element [element...]

srem key element [element...]

**scard key 元素个数**

scard 的时间复杂度是O(1)；很明显直接从Redis内部变量中取出来的，并不是遍历元素个数；

**sismember key element  确定性**   是否在集合中；

**smembers key 全部元素**

**注意：**smember是比较重的命令，如果元素过多存在Redis阻塞的可能性，可以使用sscan来实现；

srandmember key [count]   //count 是参数默认值是1  随机返回数值





集合特性：交集，并集，差集

**sinter key1 [key...]**

**sunion key1 [key...]**

**sdiff key1 [key...]**



---

案例：

#### 使用场景

sadd = Tagging(标签) 集合 标签呀；

spop/srandmember = Random Item(随机抽奖)； 

sadd+sinter = s'ocial Graph（社交需求，共同好友）;

----



#### ZSET 有序集合（可以重合，score，有序，确定性）（skiplist，ziplist）

有序集合保留了元素不能重复的特性，又通过score来引入了有序的概念；列表的有序是通过下标引入；

#### 内部编码

~~~
object encoding key
~~~

* ziplist(压缩列表)：当有序集合的元素个数小于128个，每个元素的值都是小于64字节；Redis会选择ziplist作为有序集合的内部实现，可以减少内存的使用；
* skiplist(跳表)：当ziplist条件不满足的时候，ziplist的读写效率会下降，所以内部使用skiplist来实现；

---



**withscores 显示scores分数；**



zadd key score member [score member...] 

zcard key+-

**zscore key member**   获取分数 zscore key member  



**zrank key member 从低到高的排名 0 -N-1**   // 获取排名；

**zrevrank key member  从高到低的排名 N-1 0**  // 获取反序的排名；



**zrem key member 删除**



//这里是根据排名；

**zrange key start end [withscores]**      // 排行榜  start  end 就是 0  -1 ；  所有都排序；

**zrevrange key start end [withscores] 排行榜从高到低100名； 0 99**             // 排行榜；



// 根据分数来筛选；

zrangebyscore key min max [withscores] [limit offest count]  //从低到高  多少分数范围内；
zrevrangebyscore key min max [withscores] [limit offest count] //从高到低



// 增加分数  

 zincrby key increment element 

----

案例：

1. * 排行榜系统

     例如一个集赞系统:

     1. 发布你的作品

        ~~~
        zadd  user:acticle:2020_07_15 0 tom_user_name
        ~~~

        ~~~
        127.0.0.1:6380> zadd user:acticle:2020_07_15 0 tom_user_name
        (integer) 1
        ~~~

     2. 点赞数的增加

        ~~~
        zincrby user:acticle:2020_07_15 1 tom_user_name  //+1
        ~~~

        ~~~
        127.0.0.1:6380> zincrby user:acticle:2020_07_15 1 tom_user_name
        "1"
        ~~~

     3. 删除这次的作品

        ~~~
        zrem key member
        ~~~

        ~~~
        127.0.0.1:6380> zrem user:acticle:2020_07_15 tom_user_name
        (integer) 1
        ~~~

     4. 获取排名比如 点赞数前十名

        ~~~
        zrevrange user:acticle:2020_07_15 0 9 withscores  //从高到低 zrevrange
        ~~~

     5. 展示用户的分数和用户信息，排名名次；

        ~~~
        hgetall usere:info:tom_user_name   //从哈希中取出用户数据
        zscore user:acticle:2020_07_15 tom_user_name   //分数
        zrank user:acticle:2020_07_15 tom_user_name    //排名 名次
        ~~~





| 数据结构 |    是否允许重复元素     | 是否有序 | 有序的实现方式 |
| :------: | :---------------------: | :------: | :------------: |
|   List   |           是            |    有    |      下标      |
|   Set    |           否            |    否    |       无       |
|   Zset   | 否（score是有可能重复） |    有    |     score      |





## bitmap

````shell
## 应用 
## 1.可以做用户登陆统计，占用的内存会比较少；
## 2.也可以做数量比较大的，精确去重；set 数量级别会受限制；可以做精确去重；数据量比较大的数据去重；
## value的值只能是1或者0；
setbit key offset value
## bitadd  user_login  user_id(offset) value  就是偏移量是不是呀；
bitcount  user_login # 统计登陆用户的多少！！
## value 只能是1或者0；
>> setbit user_login 8881 1
(integer) 0
>> bitcount

(error) wrong number of arguments for 'bitcount' command
>> bitcount user_login

(integer) 2
````



## hyperloglog

`````shell
#基数估算，估算集合内的不重复元素的个数； hyperloglog 是去做基数估算的；

## 准确的方法，准备一个map 或者set ，在map或者set中就是基数不变，如果不在就添加到map 和set中，SUM++ ，但是这样去计算时间复杂度会非常的高！！时间复杂度是O(n)

pfadd 
pfcount 
`````





````php
* 1. **设置值**

  ~~~
  set key value [ex seconds] [px milliseconds] [nx|xx]
  ~~~

  * ex seconds :为键设置秒级的过期时间
  * px milliseconds: 为键设置毫秒级别的过期时间；
  * nx:键必须不存在，才能设置成功，用于添加; 当存在则为nil； not exists ；
  * xx: 键必须是存在，才能设置成功，用于更新；

  ~~~php
  setex key seconds value    //设置key的秒级别的过期时间
  setnx key value           //当key不存在的时候才能设置成功
  ~~~

  **注意:**以setnx命令为例子，由于**redis是单线程命令处理机制**，如果多个客户端请求，只有一个客户端可以设置成功；

  **分布式锁的实现；     **   **就是用setnx**
      
````





## 仔细看一下quickllist   和 skiplist



ziplist 其实就是一个数组把？？？



## bitmap

## stream 消息队列；

异步  解耦 削峰；



**使用一个消息队列，其实就分为三大块：生产者、队列中间件、消费者。**



**如果你的业务场景足够简单，对于数据丢失不敏感，而且消息积压概率比较小的情况下，把 Redis 当作队列是完全可以的。**







