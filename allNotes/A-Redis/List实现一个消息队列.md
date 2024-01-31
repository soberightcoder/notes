# List 实现一个消息队列

>> 使用Redis的List(列表)命令实现消息队列，生产者使用lPush命令发布消息，消费者使用rpoplpush命令获取消息，同时将消息放入监听队列，如果处理超时，监听者将把消息弹回消息队列
>
>

----



秒杀 逻辑 好好看一下把    

https://blog.csdn.net/weixin_42260789/article/details/105456144

## 先减库存  然后去创建订单，创建订单失败 我们会用监听队列去不断的尝试；当继续失败需要人工的介入；



**为了保证创建订单和减库存的一致性 就需要不断重试或者是使用分布式事务；**

##我们这里使用的是**重试**；





## list 就是个队列呀，当减掉库存，请求入队列list的时，那么就会给用户返回成功；社工下的创建订单就是消费者的事情了；



## 几大问题；



限流： lua来限流，限制ip和用户；<font color=red>lua怎么限制用户id，限制只能一个用户访问；？？？？ 这里初心是用redis set 来做一个qu'chong</font> setnx 来限制用户多次的请求；

减库存的问题： 需要用lua脚本来保证原子性来实现；

重复消费的问题：  就是怎么保证幂等性？  其实我们前边lua做过一个去重了；这边为了防止消费者消费失败，但是插入数据库成功了，watchlist 删除失败了，重试的过程；我们插入的业务逻辑为了保证他的幂等性，我们还需要

消费失败的问题：list 消费失败数据丢失的问题，我们是使用的是brpoplpush 来实现；然后用lindex 来不断的重试； 这里有一个监听队列，仅仅是为了不阻塞list主队列；



``````nginx
# 限流模块 https://github.com/openresty/lua-resty-limit-traffic/blob/master/lib/resty/limit/req.md  
# 官网的配置；
# ngx.req.get_headers()["token"] 获取 header 中的token；

http{
    # 处于http层，http  lua_shared_dict  my_limit_req_zone 10m;
	lua_shared_dict my_limit_req_store 100m;
    
    
    server{
        location / {
     access_by_lua_block {
                  local limit_req = require "resty.limit.req"
                  local lim, err = limit_req.new("my_limit_req_store", 1, 0)
                  # nil false  not nil false  就是真； not lim 一般代表有问题出错了；
                  if not lim thenZ  
                    ngx.log(ngx.ERR, "failed to instantiate a resty.limit.req object: ", err)
                    return ngx.exit(500)
                  end

                 local key = ngx.var.binary_remote_addr
                 local delay, err = lim:incoming(key, true)
                 ngx.say(delay)
                 ngx.say(err)
                  #delay = ni err = rejected 就是超时了；
                  # 没有超过速率 就是 0
                 if not delay then
                 #超时了
                    if err == "rejected" then
                        return ngx.exit(503)
                    end
                 ngx.log(ngx.ERR, "failed to limit req: ", err)
                 return ngx.exit(500)
                 end
                  if delay >= 0.001 then
                     local excess = err
                     ngx.sleep(delay)
                  end
            }
        }
    }
}
``````



## 解决对用户的限流；



`````nginx
#https://www.freesion.com/article/3603496575/
#用户限流的实现；
#1024*1024*10 /20  每一个token的长度大约是 20字节； 那么保证100w就行了；
# 先用  验证token的有效性 直接走网关就可以了把？？？？
set_by_lua_block $user_id 'retrun ngx.req.get_headers()["token"]';
limit_req_zone $user_id zone=userid_limit:20m rate=1r/s;
limit_req zone=iplimit burst=2 nodelay;
   
`````



## 1.用到的List(列表)命令

| 命令      | 作用                                                     |
| :-------- | -------------------------------------------------------- |
| lPush     | 将一个或多个值插入到列表头部                             |
| rpoplpush | 弹出列表最后一个值，同时插入到另一个列表头部，并返回该值 |
| lRem      | 删除列表内的给定值                                       |
| lIndex    | 按索引获取列表内的值                                     |







## 2.队列的组成

| 名称   | 职责                                                         |
| ------ | ------------------------------------------------------------ |
| 生产者 | 发布消息                                                     |
| 消费者 | 获取并处理消息                                               |
| 监听者 | 监听超时的消息，弹回原消息队列，确保消费者挂掉后或处理失败后消息能被其他消费者处理  **watchQueue** |





## 3.php实现代码

生产者`Producter.php`

```php
<?php
try {
    //声明消息队列-list的键名
    $queueKey = 'testQueueKey';
    $redis = new Redis();
    $redis->connect('ip', 6379);
    //向列表中push10条消息
    for ($i = 0;$i < 10;$i++){
        //为消息生成唯一标识 -- 这里可以使用-- 雪花算法，来生成请求的唯一id；
        $uniqid = uniqid(mt_rand(10000, 99999).getmypid().memory_get_usage(), true);
        $ret = $redis->lPush($queueKey, json_encode(array('uniqid' => $uniqid, 'key' => 'key-'.$i, 'value' => 'data')));
        var_dump($ret);
    }

} catch (Exception $e){
    echo $e->getMessage();
}
//
```

消费者`Consumer.php`

```php
<?php
try {
    //声明消息队列-list的键名
    $queueKey = 'testQueueKey';
    //声明监听者队列-list的键名
    $watchQueueKey = 'watchQueueKey';
    $redis = new Redis();
    $redis->connect('ip', 6379);
    //队列先进先出，弹出最先加入的消息，同时放入监听队列
    while (true){
        $ret = $redis->rpoplpush($queueKey, $watchQueueKey);
        if ($ret === false){
            sleep(1);
        } else {
            $retArray = json_decode($ret, true);
            //将唯一id写入缓存设置有效期
            $redis->setex($retArray['uniqid'], 60, 0);
            
            //模拟失败
            $rand = mt_rand(0,9);
            if ($rand < 3){
                echo "failure:".$ret."\n";
            } else {
                //todo
                //处理成功移除消息
                $redis->lRem($watchQueueKey, $ret, 0);
                echo "success:".$ret."\n";
            }
        }
    }

} catch (Exception $e){
    echo $e->getMessage();
}
```

监听者`Watcher.php`

```php
<?php
try {
    //声明消息队列-list的键名
    $queueKey = 'testQueueKey';
    //声明监听者队列-list的键名
    $watchQueueKey = 'watchQueueKey';
    $redis = new Redis();
    $redis->connect('ip', 6379);

    while (true){
        //取出列表尾部的一个值  // 这里是用lIndex 来做的；
        $ret = $redis->lIndex($watchQueueKey, -1);
        //如果不存在则休眠1秒
        if ($ret === false){
            sleep(1);
        } else {
            
            $retArray = json_decode($ret, true);
            
            $idCache = $redis->get($retArray['uniqid']);
            
            if ($idCache === false){
                //如果已过期，表示任务超时，弹回原队列
                $redis->rpoplpush($watchQueueKey, $queueKey);
                echo "rpoplpush:".$ret."\n";
            } else {
                //处理中，继续等待
                sleep(1);
            }
        }
    }

} catch (Exception $e){
    echo $e->getMessage();
}
```

## 4.执行队列

开启监听者`php Watcher.php`
开启消费者`php Consumer.php`
执行生产者`php Producter.php`
生产者输出

```bash
int(1)
int(2)
int(3)
int(4)
int(5)
int(6)
int(7)
int(8)
int(9)
int(10)
```

监听者输出

```bash
rpoplpush:{"uniqid":"28580267323642245c4bde640dd8f3.30292468","key":"key-1","value":"data"}
rpoplpush:{"uniqid":"10258267323642245c4bde640e1cd9.95656605","key":"key-4","value":"data"}
rpoplpush:{"uniqid":"43356267323642245c4bde640e88e9.50566706","key":"key-5","value":"data"}
rpoplpush:{"uniqid":"59823267323642245c4bde640e98b5.51512314","key":"key-6","value":"data"}
rpoplpush:{"uniqid":"83293267323642245c4bde640ed753.04622366","key":"key-9","value":"data"}
rpoplpush:{"uniqid":"59823267323642245c4bde640e98b5.51512314","key":"key-6","value":"data"}
```

消费者输出

```bash
success:{"uniqid":"47280267323557445c4bde640dbfb4.78962728","key":"key-0","value":"data"}
failure:{"uniqid":"28580267323642245c4bde640dd8f3.30292468","key":"key-1","value":"data"}
success:{"uniqid":"39394267323642245c4bde640de992.34641654","key":"key-2","value":"data"}
success:{"uniqid":"41335267323642245c4bde640df980.38466514","key":"key-3","value":"data"}
failure:{"uniqid":"10258267323642245c4bde640e1cd9.95656605","key":"key-4","value":"data"}
failure:{"uniqid":"43356267323642245c4bde640e88e9.50566706","key":"key-5","value":"data"}
failure:{"uniqid":"59823267323642245c4bde640e98b5.51512314","key":"key-6","value":"data"}
success:{"uniqid":"43817267323642245c4bde640ec189.44008738","key":"key-7","value":"data"}
success:{"uniqid":"69276267323642245c4bde640ecb91.04877522","key":"key-8","value":"data"}
failure:{"uniqid":"83293267323642245c4bde640ed753.04622366","key":"key-9","value":"data"}
success:{"uniqid":"28580267323642245c4bde640dd8f3.30292468","key":"key-1","value":"data"}
success:{"uniqid":"10258267323642245c4bde640e1cd9.95656605","key":"key-4","value":"data"}
success:{"uniqid":"43356267323642245c4bde640e88e9.50566706","key":"key-5","value":"data"}
failure:{"uniqid":"59823267323642245c4bde640e98b5.51512314","key":"key-6","value":"data"}
success:{"uniqid":"83293267323642245c4bde640ed753.04622366","key":"key-9","value":"data"}
success:{"uniqid":"59823267323642245c4bde640e98b5.51512314","key":"key-6","value":"data"}
```

我们看到消费者第一次执行时失败的消息，超时后又被弹回了消息队列，消费者有了再次执行的机会，监听者的职责就是确保消费者执行失败或挂掉后消息还能再弹回原队列得到再次执行



## 遇到的两个问题

??

消费失败   rpoplpush lai



重复消费 创建订单的幂等性怎么去保证？？？？

if (select )