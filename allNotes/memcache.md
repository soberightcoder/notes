# memcached

>特性：
>
>**第一部分：知其然**
>
>关于memcache一些基础特性，使用过的小伙伴必须知道：
>
>（1）mc的**核心职能**是KV内存管理，**value存储**最大为1M，它不支持复杂数据结构（哈希、列表、集合、有序集合等）；
>
>（2）mc不支持持久化；
>
>（3）mc支持key过期；
>
>（4）mc持续运行很少会出现内存碎片，速度不会随着服务运行时间降低；
>
>（5）mc使用非阻塞IO复用网络模型，使用监听线程/工作线程的多线程模型；

---

## 基础命令操作

### 环境

`````shell
$ docker run -d -p 11211:11211 --name memcache_t memcached
`````



### 基础命令操作

`````shell
# 连接；
telnet  127.0.0.1 11211 
Trying 127.0.0.1...
Connected to 127.0.0.1.
Escape character is '^]'.

#set set：存储一个 key/value set key value exptime


#add：当 key 不存在时，存储这个 key/value；
### set key flags exptime bytes

#replace 与 add 相反，当存在的时候修改，不存在的时候不能修改！！

#get：获取key的flag及value

#delete：删除一个 key

#incr/decr：对一个无符号长整型数字进行加或减

### flush_all  清空缓存中的所有数据。
`````



---

