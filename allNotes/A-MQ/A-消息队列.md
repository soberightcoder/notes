# 消息队列 message-queue



## 目的

* 异步

* 削峰

* 解耦 

  

---



## 消息队列的满足的几个条件

* 是否可以阻塞等待拉取消息；防止cpu空转；当队列重没有数据的时候阻塞；
* **支持订阅和发布，支持多个消费者消费同一批数据**；      list 不满足的；
* **当消费者消费失败（消费者重启之类的），消息不丢失；**
* 消息可以堆积的处理方案；（解决方案，1.限制生产者生产的速率，2.丢弃消息（消息会丢失；超出内存））
* **宕机之后，重启，消息不可以丢失；（消息丢失 ）数据可持久化，AOF；**  **这边可以用 always 的落盘策略；** 来保证数据丢失的问题； 
* 怎么解决多个消费者竞争的问题！！！???? 
* 保证数据只有一条！！！  消息只消费一条；

---

## 消费失败

list 使用的是 lindex 来实现的；只有一个消费者可以去实现； 如果只有一个消费者，消费失败会阻塞到后面的；

但是高并发肯定有多个消费者；

rpoplpush 

---



## 秒杀 防止单个用户刷单

可以使用uid  + set 来去判断，有没有刷单；集合具有互异性；  set  直接用集合把；

``````php
$cript 
# redis 的去重；  $key1  = stock 库存   $key2 = activity:id:set:uid; uid 来保证唯一性；
redis.call()
$sript = <<<EOF
	if redis.call('get',$KEYS[1]) > 0
        then
        	if redis.call('sadd',$KEYS[2],$ARGV[1])  // 插入失败；那么就代表重复插入了；插入成功那么就去减decr
            then
                redis.call('decr',$KEYS[1])
        		return 1;
			else
                return -1;
            end 
        else 
            return 0;
     end   
	EOF;

# 超卖 不用去重就可以了;//
  $str = <<<Lua
        local key   = KEYS[1];
        local redis_stock = redis.call('get', key);
        if (tonumber(redis_stock) > 0)
        then
            redis.call('decr', key);
            return true;
        else
            return false;
        end
        Lua;

//重复消费的问题；
// select* from order where order_id = 123 and activityid = 2;
//if exists
//then
//	return true;
//else 
//    return false;
//end
``````



---

## 消费失败  重复消费 幂等性问题



网络问题；没有去 del key 删除数据；

或者是宕机之类的；



---



## 高并发量并不适合DB 去操作

 一个是高并发量会把mysl的线程池沾满，而不能去处理到后面的操作；

DB 读写数据会牵扯到IO的操作，所以效率不是特别高；

所以不要把高并发量打到数据库； 很容易就把数据库打崩溃了；或者是那种没有加索引的数据查询；每次都需要all，去遍历数据查询，

IO瓶颈之后把数据干废了；



---

##为什么QPS 很高的时候需要扩展服务器；



为什么 并发量很多那么需要使用负载均衡；扩展需要扩展服务器；

如果不扩展服务器，负载均衡，那么每一个请求的rt响应时间会很大，那么可用性基本gg了；

然后就是资源的问题；内存或者硬盘资源，cpu资源问题；一台计算机肯定不够的；

distributed denial  service

那么只能用 
