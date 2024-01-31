# snowflake

>雪花算法 snow flake；雪花算法；

----



`````shell
composer require godruoyi/php-snowflake:2.2.4
`````





----





Snowflake 是一种网络服务，用于通过一些简单的保证大规模生成唯一 ID 号。

第一位是未使用的符号位。
第二部分由41位时间戳（毫秒）组成，其值是当前时间相对于某个时间的偏移量。

````php
//usleep(1); //微妙级别的；
//microtime(true);// 也是微妙级别的； 但是这里的12位时间戳要求的是毫秒级别的。所以用microtime(); 需要*1000；才可以；
//usleep() 函数延迟执行当前脚本若干微秒（一微秒等于一百万分之一秒）。
````

第三部分和第四部分的5位分别代表数据中心和工作人员，最大值为2^5 -1 = 31。
最后一部分由12位组成，表示每个工作节点每毫秒生成的串行号的长度，同一毫秒最多可以生成2^12 -1 = 4095个ID。

在分布式环境中，5位数据中心和worker意味着可以部署31个数据中心，每个数据中心最多可以部署31个节点。
41位的二进制长度最多为2^41 -1毫秒=69年。所以雪花算法最多可以使用69年，为了最大化算法的使用，你应该为它指定一个开始时间。



要知道，雪花算法生成的ID并不能保证唯一。例如，当两个不同的请求同时进入同一个数据中心的同一个节点，且该节点生成的串行相同时，生成的ID就会重复。

如果要使用雪花算法生成唯一的ID，必须保证： 同一节点的同一毫秒内生成的sequence-number是唯一的。基于此，我们创建了这个包并将多个串行号提供进程集成到其中。

RandomSequenceResolver（随机）
FileLockResolver（PHP文档锁fopen/flock，并发安全）
RedisSequenceResolver（基于redis psetex和incrby，并发安全）
LaravelSequenceResolver（基于redis psetex和incrby）
SwooleSequenceResolver（基于swoole_lock）
每个提供商只需要保证同一毫秒内生成的串行号不同即可。您可以获得一个唯一的ID。

警告 RandomSequenceResolver 不保证生成的 ID 是唯一的，如果您想生成唯一的 ID，请改用其他解析器。

----

## 用redis的就行

用redis lua 来保证原子性；



---

## lua 为啥要保证原子性；

虽然是保证命令的原子性；

