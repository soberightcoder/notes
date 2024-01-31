## binlog 进行数据的恢复



---



一、binlog日志基本概念
   binlog是MySQL sever层维护的一种二进制日志，binlog是记录所有数据库表结构变更（例如CREATE、ALTER TABLE、DROP等）以及表数据修改（INSERT、UPDATE、DELETE、TRUNCATE等）的二进制日志。不会记录SELECT和SHOW这类操作，因为这类操作对数据本身并没有修改。

作用主要有：

- 主从复制：在MySQL的Master节点开启binlog，Master把它的二进制日志传递给slaves并回放来达到master-slave数据一致的目的。
- 数据恢复：通过mysqlbinlog工具来恢复数据

二、开启binlog日志记录
2.1、查看binlog日志记录启用状态
MySQL安装完成后，MySQL5.7版本binlog默认是不开启的，MySQL8默认开启binlog，登录MySQL后，可以通过SHOW VARIABLES LIKE '%log_bin%';命令查看是否开启binlog。

````mysql
# 登录 mysql
mysql -h127.0.0.1 -P3306 -uroot -p123456

````



````mysql
# 查看是否开启binlog
mysql> SHOW VARIABLES LIKE '%log_bin%';

````

![在这里插入图片描述](./binlog%E7%9A%84%E6%95%B0%E6%8D%AE%E6%81%A2%E5%A4%8D.assets/07260900ed7f4a3ab318d708e32bf180.png)

log_bin 的Value如果为ON代表开启，如果为OFF代表关闭，我这里使用的是MySQL8.0默认是开启的，如果没有开启可以通过下面方式开启：



#### 2.2、开启配置binlog日志

修改MySQL配置文件，linux中配置文件为my.conf，window下为my.ini，下面以centos为例演示：

- 编辑配置文件

  ````mysql
  # 在centos中mysql的配置文件一般都在/etc/mysql目录下，如果不在可以通过 find / -name "my.cnf" 查找
  vi /etc/mysql/my.cnf
  ````

  - 添加配置

  ````mysql
  # 服务ID
  server-id=1
  # binlog 配置 只要配置了log_bin地址 就会开启
  log_bin = /var/lib/mysql/mysql_bin
  # 日志存储天数 默认0 永久保存
  # 如果数据库会定期归档，建议设置一个存储时间不需要一直存储binlog日志，理论上只需要存储归档之后的日志
  expire_logs_days = 30
  # binlog最大值
  max_binlog_size = 1024M
  # 规定binlog的格式，binlog有三种格式statement、row、mixad，默认使用statement，建议使用row格式
  binlog_format = ROW
  # 在提交n次事务后，进行binlog的落盘，0为不进行强行的刷新操作，而是由文件系统控制刷新日志文件，如果是在线交易和账有关的数据建议设置成1，如果是其他数据可以保持为0即可
  sync_binlog = 1
  ````

  

----

## 使用mysqlbinlog 来进行数据的恢复！！！

---

### 查看binlog

`````mysql
show binlog events; # 查看所有的binlog 事件；
show master logs；## 查看server-id=1的binlogs；

#  查看 binlog 保存的路径和名字；
show variables like '%log_bin%';

##
mysql> show variables like '%log_bin%'
    -> ;
+---------------------------------+-----------------------------+
| Variable_name                   | Value                       |
+---------------------------------+-----------------------------+
| log_bin                         | ON                          |
| log_bin_basename                | /var/lib/mysql/binlog       |
| log_bin_index                   | /var/lib/mysql/binlog.index |
| log_bin_trust_function_creators | OFF                         |
| log_bin_use_v1_row_events       | OFF                         |
| sql_log_bin                     | ON                          |
+---------------------------------+-----------------------------+
6 rows in set (0.01 sec)

###/var/lib/mysql/binlog/会看到很多的binlog文件；用来记录数据库的变化；
-rwxr-xr-x 1 mysql mysql      434 Dec  2 03:02  binlog.000007
`````



### mysqlbinlog  来进行数据的恢复！！！

````php
//
````



----

## 备份；

````mysql
#mysqldump 


````





##  为啥修改完配置完 要做一个重启；

> **因为他只有在生成这个进程的时候才会读取整个配置； 所以进程需要重启！！！**

````php
// 因为一个进程在读取配置的时候一般都是在进程最开始！！
//启动的时候会读取配置，他不能一直在循环去读取配置；
// 所以 修改配置，需要重启进程，让进程重新读取配置；让配置生效！！
````





## docker-compose

```php
## up -d      create  services and start services; docekr-compose.yml发生了修改要重新生成容器呀； 有容器就启动容器，没有启动的容器就生成容器；
##up          Create and start containers是否 重新生成容器，需要看配置有么有修改！！！
##start       Start services
##stop        Stop service
##restart     重启 服务就可以了，修改了配置运行这个就行！！！
##ps          List containers
##build       Build or rebuild services  生成image 镜像！！！  重新生成 build 镜像！！！
##config      Parse, resolve and render compose file in canonical format 查看 docker-compose 配置；

## 会重新创建容器；
##down        Stop and remove containers, networks down 不仅会删除 容器 还会删除网络！！！
##--force-recreate  create      Creates containers for a service.重新创建容器！！！



########    docker-compose up 命令在以下场景下会重新创建容器：
//初次运行：当你第一次运行 docker-compose up 命令时，它会创建并启动所有在 docker-compose.yml 文件中定义的服务的容器。
//配置更改：如果你对 docker-compose.yml 文件进行了更改，例如修改了容器的配置或添加了新的服务，再次运行 docker-compose up 命令会重新创建受影响的容器。
//强制重新创建：你可以使用 --force-recreate 参数来强制重新创建所有容器。这将会停止并删除现有的容器，然后重新创建它们。相当于是一个down + up -d  
//显式指定服务名称：如果你只想重新创建特定的服务容器，可以在 docker-compose up 命令后面指定服务名称。例如，docker-compose up service1 service2 只会重新创建 service1 和 service2 两个服务的容器。
//请注意，重新创建容器会导致容器内的数据丢失，因此在进行这些操作之前，请确保你已经备份了重要的数据。 注意多用数据卷 --volumes
    
    
    
//docker-compose up 命令在某些情况下可以具有重启容器的效果。具体取决于容器的状态和配置。

//当你运行 docker-compose up 命令时，它会检查已经存在的容器并根据需要执行以下操作：
//如果容器已经在运行状态：docker-compose up 不会重启容器，而是保持容器的运行状态不变。所以对于运行的容器 需要用 restart来进行重启；
//如果容器已经停止：docker-compose up 会重新启动停止的容器。
//如果容器的配置发生更改：如果你对容器的配置进行了更改（例如，修改了环境变量或挂载的卷），docker-compose up 会重新创建容器，并使用新的配置启动它。
//需要注意的是，docker-compose up 命令不会删除已经存在的容器。如果你想要删除并重新创建容器，可以使用 docker-compose up --force-recreate 命令。

```

