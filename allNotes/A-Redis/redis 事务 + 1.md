# 事务 + 1



# 【知识点】Redis如何实现事务？为什么不建议用redis自带事务！！！

By [一零](https://www.onezero.cc/author/hquzyl/) | 8月 2, 2022

[0 Comment](https://www.onezero.cc/2022/08/02/database/redis/1155/#respond)

![img](redis 事务 + 1.assets/20200315Redis-660x382.png)

### 什么是事务？

事务,简单理解就是,一组动作,要么全部执行,要么就全部不执行.从而避免出现数据不一致的情况

[![img](redis 事务 + 1.assets/20200315Redis.png)](https://www.onezero.cc/wp-content/uploads/2022/08/20200315Redis.png)

### **redis事务**

基本原理为乐观锁，多个client对操作的key进行watch，一旦有一个client进行了exec，那么其它client的exec就会失效。，可以理解为一组命令的批量执行。

```
127.0.0.1:6379> multi     #开启事务
OK
127.0.0.1:6379> set name onezero
QUEUED
127.0.0.1:6379> set age 10
QUEUED
127.0.0.1:6379> get age
QUEUED
127.0.0.1:6379> set age 11
QUEUED
127.0.0.1:6379> exec    #执行事务
1) OK
2) OK
3) "10"
4) OK
127.0.0.1:6379> get age
"11"
127.0.0.1:6379>
```

***eg:***

可以看到set命令一开始返回的结果是QUEUED,代表命令并没有真正执行,只是暂时存在redis中.只有当exec执行了.这组命令开始执行，然后可以看到每一条命令的执行结果。

如果事务中的命令出现错误，比如说语法错误, set写成了sest，整个的事务将无法执行

```
127.0.0.1:6379> multi
OK
127.0.0.1:6379> sest name onezero
(error) ERR unknown command `sest`, with args beginning with: `name`, `onezero`,

127.0.0.1:6379>
```

众所周知，数据库的事务具有原子性，要么执行，要么不执行，如果中间失败就会回滚

**所以说redis不支持事务中的回滚特性.无法实现命令之间的逻辑关系计算。**

## 5个命令

****watch [key1] [key2]：监视一个或多个key，在事务开始之前如果被监视的key有改动，则事务被打断**
  **multi：标记一个事务的开始**
  **exec：执行事务**
  **discard：取消事务的执行**
  unwatch：取消监视的key**
  注意：
    a.执行取消事务命令（discard）后，再进行事务的执行（exec）,那么事务是不会执行的；
    b.事务中的命令出现命令性错误(例如：命令语法错误)，执行事务时，所有的命令都不会被执行；
    c.事务中出现执行时错误（类似Java的运行时异常），执行事务时，部分命令会被执行成功，也即是不保证原子性；
    进一步说明：假设该事务有三步修改操作，就算在步骤1出现了执行时错误，步骤2、3依然会继续执行的；
    d.使用watch监视key在事务之前被改动，所有命令正常执行；
    e.使用watch监视key，此时在事务执行前key被改动，事务将取消不会执行所有命令；

在开发中,还可以采用lua脚本来实现事务的,简单理解:使用lua语言编写脚本传到redis中执行.

------

## redis事务的缺点

> **不支持业务逻辑，和不支持回滚特性；**
>
>业务逻辑 可以使用lua去实现，并且保证一系列命令的原子性；

在Redis中，事务是通过**MULTI、EXEC、DISCARD和WATCH**命令来实现的。事务允许一次性执行多个命令，保证这些命令在执行过程中不会被其他客户端的命令所打断。

**虽然Redis事务提供了原子性的保证，但是它的确不支持自定义逻辑。事务中的命令会按顺序执行，Redis不支持在事务中使用条件判断、循环等自定义逻辑。**

**如果您需要在Redis中实现复杂的逻辑，可能需要在应用程序层面进行处理，或者考虑使用Lua脚本来实现更复杂的操作。Lua脚本可以通过`EVAL`和`EVALSHA`命令在Redis中执行，它们允许您在Redis服务器端执行自定义的Lua脚本，从而实现更灵活的逻辑处理。**



## 关于业务逻辑；

`````php
#php+mysql 事务可以实现简单的业务逻辑，肯定是做了优化的；
#php+redis 事务内也是可以实现业务逻辑，但是单独的redis事务不能实现业务逻辑；
`````



在php的mysql事务中是存在业务逻辑的；并且在php的redis中也是存在于业务逻辑的；这是一个正常现象；

````mysql
UPDATE products
SET stock = 
  CASE 
    WHEN stock > 0 THEN stock - 1
    ELSE stock
  END
WHERE product_id = 123;

## mysql的事务中是可以带有业务逻辑的！！！
##redis的事务内不能带有业务逻辑运算！！！
````



---



## lua脚本

基本原理为使脚本相当于一个redis命令，可以结合redis原有命令，自定义脚本逻辑

## 两者相同点

**很好的实现了、隔离性（单线程，就是队列的形式，一个事务执行完，然后指向下一个事务，所以可以看成是mysql中的串行化的；）和持久性（AOF和RDB），但没有实现原子性和一致性，无论是redis事务，还是lua脚本，如果执行期间出现运行错误，之前的执行过的命令是不会回滚的。原子性和一致性需要程序员自己去保证！！！ 执行失败就无法保证一致性和原子性！！！**



## Lua脚本的优点

**1.lua脚本是作为一个整体执行的，所以中间不会被其他命令插入，无需担心并发;**

**2.lua脚本把多条命令一次性打包，而代码实现的事务需要向Redis发送多次请求，所以可以有效减少网络开销;**

**3.lua脚本可以常驻在redis内存中，所以在使用的时候，可以直接拿来复用。**

## **Lua的语法**

 从 Redis 2.6.0 版本开始，通过内置的 Lua 解释器，可以使用 EVAL 命令对 Lua 脚本进行求值。

  **脚本语法：**EVAL script numkeys key [key …] arg [arg …]
  **参数说明：**
    \1) script 参数是一段 Lua 脚本程序，它会被运行在 Redis 服务器上下文中，这段脚本不必(也不应该)定义为一个 Lua 函数。
    \2) numkeys 参数用于指定键名参数的个数。
    \3) 键名参数 key [key …] 从 EVAL 的第三个参数开始算起，表示在脚本中所用到的那些 Redis 键(key)，这些键名参数可以在 Lua 中通过全局变量 KEYS 数组，用为基址的形式访问( KEYS[1] ， KEYS[2] ，以此类推)。
    \4) 附加参数 arg [arg …] ，可以在 Lua 中通过全局变量 ARGV 数组访问，访问的形式和 KEYS 变量类似( ARGV[1] 、 ARGV[2] ，诸如此类)。
  示例：

```
127.0.0.1:6379> eval "return {KEYS[1],KEYS[2],ARGV[1],ARGV[2]}" 2 key1 key2 one
two
1) "key1"
2) "key2"
3) "one"
4) "two"
```

  **说明：**
    a. “return {KEYS[1],KEYS[2],ARGV[1],ARGV[2]}”   是被求值的 Lua 脚本；
    b. 数字 2 指定了键名参数的数量；
    c. key1 和 key2 是键名参数值,分别使用 KEYS[1] 和 KEYS[2] 访问；
    d. one和 two 则是附加参数，可以通过 ARGV[1] 和 ARGV[2] 访问；

  **redis.call()、redis.pcall() 函数**

```
127.0.0.1:6379> eval "return redis.call('set',KEYS[1],'Jeck')" 1 name
OK

127.0.0.1:6379> eval "return redis.call('get','name')" 0
"Jeck"
127.0.0.1:6379>
#如下示例错误场景
127.0.0.1:6379> eval "return redis.call(ARGV[2],KEYS[1])" 1 key get
(error) ERR Error running script (call to f_7a3acf3a58256aab79c670cac4ca3427cf1c
5f83): @user_script:1: @user_script: 1: Lua redis() command arguments must be st
rings or integers
127.0.0.1:6379> eval "return redis.pcall(ARGV[2],KEYS[1])" 1 key get
(error) @user_script: 1: Lua redis() command arguments must be strings or intege
rs
```

 redis.call()与redis.pcall()的区别：
      redis.call() 在执行命令的过程中发生错误时，脚本会停止执行，并返回一个脚本错误，错误的输出信息会说明错误造成的原因。
      redis.pcall() 出错时并不引发(raise)错误，而是返回一个带 err 域的 Lua 表(table)，用于表示错误

