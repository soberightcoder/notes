#  mysql 大纲 最重要的几部分！！



---



----

![image-20231201183410605](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201183410605.png)



----



## 底层数据是如何存储的！！

### 行结构

> 行与行之间是通过 指针来进行连接的，比如头部信息下一个记录的指针！！！

![image-20231201183649612](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201183649612.png)



### 页结构！！

![image-20231201183851644](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201183851644.png)





![image-20231201184140287](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201184140287.png)



![image-20231201184256480](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201184256480.png)

**pageDirectory 把在页内查询的复杂度降低为logn；相当于是有序数组的查询；使用了分组的方法；**

![image-20231201184600686](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201184600686.png)



**页里面记录的数据是有序的；**

**记录1 和记录2  在磁盘上并不一定是挨着的；并不一定是物理磁盘上挨着的；**

插入数据 分为两种方式；

* 更新变长 字段的时候，我们一般都是先删除然后再添加！！！！！
* int 字段 从 11 -》 56 还是int 类型占用4个字节；只需要在当前位置更新就好了！！



页满的时候：

发生页分裂！！

页的分裂是怎么的过程；

**在数据插入的情况下，当前的页数据是满的，剩下的空间已经不足以存下插入的数据了，就会产生一个分页！！！！**

---

## 索引 B加树

>page 页内查询的方式是使用的二分查找的方法！！
>
>但是怎么找到那个页这就需要索引了！！！



![image-20231201185622619](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201185622619.png)

### 聚簇索引（又叫主键索引）  和  二级索引（非聚簇索引）  多叉搜索树！！

````php
//叶子节点保存了完整的数据！！！
//聚簇索引，最大的特点就是他是以主键作为b+树的比较字段，叶子节点存储了完整了数据；
//二级索引最大的特点：以其他字段来做排序，叶子节点没有存储行的所有数据，只保存了索引字段和主键的数据！！！只能找到主键和二级索引的值，所以需要进行回表；

````

### 联合索引 （也是一种二级索引！！）

````php
//非叶子节点也会存储所有的索引！！！
//叶子节点中，保存的是联合索引和主键；也是需要回表的；
````

### 比较条件

> **先比较第一列，然后相等，然后再比较第二列！！！！**
>
>因为a 不等的额时候，b的数据是无序的所以肯定用不到索引！！！
>
>**这个就是需要满足最左匹配原则，是不是；**
>
>![image-20231201190655210](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201190655210.png)

![image-20231201190527879](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201190527879.png)

上面的比较方式，先比较a，a相等的时候再去比较b，a不相等，会一直比较a；



减少io操作！！

### 索引下推

````php
//先根据索引对数据做过滤，然后再做回表；mysql5.6出现的新特性；
//eg: where a > 1 and a < 10 and b = 1;
//如果是以前肯定会筛选出所以的a>1 and a < 10的所有数据然后做回表，然后在做数据的筛选(b =1 )；所以效率会高很多！！
````



### 索引覆盖

````php
//需要的字段信息 只需要索引和主键索引！！
//select * from t where a > 10;  //索引是index and id;  
//上面肯定是需要回表的呀；
//那我们肯定可以换这样
//select id,a from t where a > 10; //这样就不需要回表了；
//或者创建一个联合索引；那么二级索引里面就会这个数据，也就不需要回表了；
````





## buffer pool

> 一般每次都是读取一个页到内存中；
>
>缓存作用！！！来减少io操作；

---

会分为多个链表；

一个就是free链表，来保存的是空闲的页。可以直接拿来用！！；

flush 链表 就是磁盘和内存数据不一样的，就是脏页！！！

clean 链表，就是干净页，内存和磁盘数据是一样的，就是干净页！！

---

## LRU  最近最少使用！！







----

# Mysql log

>bin log   server 服务级别的；
>
>下面两个都是存储引擎级别的； 只有innodb 含有这两个日志！
>
>redo log
>
>undo log

---

## laravel 8

````php
//bash-4.4# cat /proc/version 
Linux version 6.4.16-linuxkit (root@buildkitsandbox) (gcc (Alpine 12.2.1_git20220924-r10) 12.2.1 20220924, GNU ld (GNU Binutils) 2.40) #1 SMP PREEMPT_DYNAMIC Thu Nov 16 10:55:59 UTC 2023
 //
vi /etc/apk/repositories  #配置apk镜像源

apk search xxx  #查询xxx相关的软件包

apk add xxx  #安装一个软件包

apk del xxx  #删除已安装的xxx软件包

apk --help  #获取更多apk包管理的命令参数

apk update   #更新软件包索引文件
````

---



## bin log

>mysql5.7 的配置文件是my.ini  
>
>MySQL 8 的配置文件是**一个文本文件**,它包含了许多用于控制数据库的参数。该文件位于服务器的安装目录下,通常为/etc/mysql/my.cnf 或者 /etc/my.cnf。
>
>server 级别的
>
>记录执行的sql语句
>
>事务提交了才会写binlog；

## BIN_LOG



查看bin_log  是否打开！！！

![image-20231201225942826](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231201225942826.png)

### 去my.ini 打开log_bin  

```php
//my.ini 5.7的

//mysql8.0 可以直接在my.cnf 开启；


```

![image-20231202005507571](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202005507571.png)







### 查看binlog的文件内容

````php
//所有的写操作都会记录到 bin-log 里面！！！除了 select 和show 都会记录；
//show binlog events 显示所有的记录！！！
//打开binlog日志的方法；
//mysqlbinlog --no-defaults  用这个命令来转成 sql文件
````

![image-20231202005813083](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202005813083.png)

![image-20231202010242148](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202010242148.png)

### 文件格式  

#### statement   

记录sql语句；

````php
now();//函数之类的问题，会报错；
````



####  row

#### 保留sql前和sql后两条数据！！1

mixed 两者做一个集合；

## redo log

>也是记录数据变动的；
>
>记录的是脏页的即可！！！
>
>存储引穹级别的日志！！

![image-20231202010628218](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202010628218.png)



![image-20231202011456172](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202011456172.png)

## undo log



![image-20231202011922678](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202011922678.png)

回退到那个版本由mvcc来决定！！

**undo log 来记录对数据的操作历史记录！！！**

可以通过这个来实现事务的回滚！！！

几个重要的字段 trx_id  和  row_id  roll_pointer 回滚的事务id；

![image-20231202012556923](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202012556923.png)



## mysql事务概念的解释！！



## 查看锁



![image-20231202020706641](./mysql%20%E5%A4%A7%E7%BA%B2.assets/image-20231202020706641.png)





----



##docker-compose来创建一个mysql8 容器；

````php
//docker-compose 里面的东西叫服务；servers
//关于 docker-compose up -d 
//会去拉取镜像，创建服务，启动服务；
//当docker-compose.yml启动的容器没有做修改的时候 docker-compose up -d  还是运行以前创建的容器；
// 当docker-compose.yml 做了修改他会删除这个容器并且重新启动一个容器；
// docker-compose up -d

//该命令十分强大，它将尝试自动完成包括构建镜像，（重新）创建服务，启动服务，并关联服务相关容器的一系列操作。
//链接的服务都将会被自动启动，除非已经处于运行状态。
 
//docker-compose up -d命令用于启动已经存在的服务容器,如果服务容器不存在则会自动创建。-d参数表示以守护进程的方式运行容器

````



````my.cnf
##默认的一些配置！！
datadir：数据库文件的存储路径
log-bin：二进制日志文件的名称和路径
max_connections：在同一时间内允许的最大连接数限制
innodb_buffer_pool_size：InnoDB引擎使用的缓存池的大小
join_buffer_size：用于连接操作的缓冲区的大小
````





---

