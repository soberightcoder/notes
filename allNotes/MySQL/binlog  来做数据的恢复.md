#  binlog 来做数据的恢复

---

>from https://blog.csdn.net/weixin_47055136/article/details/131283567

---



##sql语句

````sql
# 查询 binlog 的信息；
show variables like '%log_bin%'
##----------------------------------------------------------------------------
mysql> show master status;
+------------------+----------+--------------+------------------+-------------------+
| File             | Position | Binlog_Do_DB | Binlog_Ignore_DB | Executed_Gtid_Set |
+------------------+----------+--------------+------------------+-------------------+
| mysql_bin.000007 |      711 |              |                  |                   |
+------------------+----------+--------------+------------------+-------------------+
1 row in set (0.00 sec)

mysql> show variables like '%log_bin%';
+---------------------------------+--------------------------------+
| Variable_name                   | Value                          |
+---------------------------------+--------------------------------+
| log_bin                         | ON                             |
| log_bin_basename                | /var/lib/mysql/mysql_bin       |
| log_bin_index                   | /var/lib/mysql/mysql_bin.index |
| log_bin_trust_function_creators | OFF                            |
| log_bin_use_v1_row_events       | OFF                            |
| sql_log_bin                     | ON                             |
+---------------------------------+--------------------------------+
6 rows in set (0.30 sec)

mysql> sshow master status;
ERROR 1064 (42000): You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'sshow master status' at line 1
mysql> show master status;
+------------------+----------+--------------+------------------+-------------------+
| File             | Position | Binlog_Do_DB | Binlog_Ignore_DB | Executed_Gtid_Set |
+------------------+----------+--------------+------------------+-------------------+
| mysql_bin.000007 |      711 |              |                  |                   |
+------------------+----------+--------------+------------------+-------------------+
1 row in set (0.00 sec)

##--------------------------------------------------------------------------------------------------
# 查询 BINLOG 格式
show VARIABLES like 'binlog_format';

# 查询 BINLOG 位置
show VARIABLES like 'datadir';

# 查询当前数据库中 BINLOG 名称及大小
show binary logs;

# 查看 master 正在写入的 BINLOG 信息
show master status\G;

# 通过 offset 查看 BINLOG 信息
show BINLOG events in 'mysql-bin.000034' limit 9000,  10;

# 通过 position 查看 binlog 信息
show BINLOG events in 'mysql-bin.000034' from 1742635 limit 10;

##查看binlog的文件格式！！
##STATEMENT：这是最简单的格式，它记录每个执行的 SQL 语句。
##ROW：这个格式记录每个受影响的行的变化。它可以更精确地重现数据更改，但会产生更多的日志。
##MIXED：这个格式是 STATEMENT 和 ROW 的混合。它根据具体情况选择使用哪种格式。

mysql> show variables like 'binlog_format';
+---------------+-------+
| Variable_name | Value |
+---------------+-------+
| binlog_format | ROW   |
+---------------+-------+
1 row in set (0.00 sec)


````



## mysqlbinlog 命令

> 提取sql
> 根据步骤一确定的位置导出 SQL 文件，相关命令：

**根据position**

```sql
mysqlbinlog --no-defaults --base64-output=decode-rows -v \
 --start-position "xxxxx" --stop-position "xxxxx" \
 --database=beifen  binlog_file \ > /HLW/JSZX/HLWdata/xxxx.sql
 # 这个可以看到做的sql语句操作！！
```

其中， start_position 和 stop_position 是在步骤1中记录的binlog位置，binlog_file 是在步骤1中记录的binlog文件名，/HLW/JSZX/HLWdata/xxxx.sql是保存SQL语句的文件路径。

**根据时间**

````sql
mysqlbinlog --no-defaults --base64-output=decode-rows -v \
 --start-position "xxxxx" --stop-position "xxxxx" \
 --database=beifen  binlog_file \
 > /HLW/JSZX/HLWdata/xxxx.sql
 
 mysqlbinlog --no-defaults --base64-output=decode-rows -v \
 --start-datetime="2023-04-03 17:00:00" --stop-datetime="2023-04-03 19:00:00" \
 --database=beifen  mysql-bin.000002 \
 /HLW/JSZX/HLWdata/xxxx.sql
````


  ### 其它查看方式 less & more & grep
 **less**

````sql
mysqlbinlog --no-defaults --base64-output=decode-rows -v \
 --start-datetime  "2023-04-03 14:00:00" \
 --database sync_test  mysql-bin.000034 | less
````



 **more grep**

````sql
mysqlbinlog --no-defaults --database=jiangbei_construction \
--start-datetime="2023-04-03 14:00:00" \
/var/lib/mysql/mysql-bin.000044 |grep jb_purchase_enroll |more 
````

**mysqlbinlog 常用参数说明：**
**–database 仅仅列出配置的数据库信息**
**–no-defaults 读取没有选项的文件, 指定的原因是由于 mysqlbinlog 无法识别 BINLOG 中的 default-- character-set=utf8 指令**
–offset 跳过 log 中 N 个条目
–verbose 将日志信息重建为原始的 SQL 陈述。
	-v 仅仅解释行信息
	-vv 不但解释行信息，还将 SQL 列类型的注释信息也解析出来
–start-datetime 显示从指定的时间或之后的时间的事件。
接收 DATETIME 或者 TIMESTRAMP 格式。
–base64-output=decode-rows 将 BINLOG 语句中事件以 base-64 的编码显示，对一些二进制的内容进行屏蔽。
	AUTO 默认参数，自动显示 BINLOG 中的必要的语句
	NEVER 不会显示任何的 BINLOG 语句，如果遇到必须显示的 BINLOG 语言，则会报错退出。
	DECODE-ROWS 显示通过 -v 显示出来的 SQL 信息，过滤到一些 BINLOG 二进制数据。

四、执行SQL语句
将步骤3中保存的SQL语句文件复制到恢复后的MariaDB服务器上，并使用以下命令将SQL语句导入到数据库中：

````sql
## 执行sql语句！！！  直接导入 sql就好了呀；
mysql -u root -p < /path/to/output/file.sql
##也可以用source来恢复； 来做数据的恢复；
source /path/to/output/file.sql

````




## fllush logs

**二、临时库准备**
**主库执行flush logs，然后将相关binlog和最近一份全量备份文件拷贝至临时库,并在临时库导入最近一次全量备份文件。**

在执行数据恢复前，如果操作的是生产环境，会有如下的建议：
使用 flush logs 命令，替换当前主库中正在使用的 binlog 文件，好处如下：

可将误删操作，定位在一个 BINLOG 文件中，便于之后的数据分析和恢复。
避免操作正在被使用的 BINLOG 文件，防止发生意外情况。
数据的恢复不要在生产库中执行，先在临时库恢复，确认无误后，再倒回生产库。防止对数据的二次伤害。



![image-20231203172441681](./binlog%20%20%E6%9D%A5%E5%81%9A%E6%95%B0%E6%8D%AE%E7%9A%84%E6%81%A2%E5%A4%8D.assets/image-20231203172441681.png)

```sql
## mysql8 来做数据的恢复；
##  mysqlbinlog /path/to/binlog | mysql -u <username> -p  
## 这将解析二进制日志文件并将其中的 SQL 语句应用到 MySQL 实例中，从而恢复数据。
```



## 备份

````mysql
#mysql innodb  全量备份；
mysqldump -uroot -p --single-transaction <database_name> > backup.sql

mysqldump -u <username> -p --single-transaction --all-databases > backup.sql
mysqldump -u <username> -p --single-transaction --flush-logs > backup.sql
````





---



## 实际操作 ；比如我们做误删操作；

`````sql
##本质就是把误删的sql语句转换为 insert into 语句就可以了！！ // 当然 这样做起来 需要对sql语句自己做替换，还是比较麻烦的； 下面的方法 全量备份+ binlog 来做恢复是最好的；

## 这里需要用全量备份 + binlog来做恢复！！  一般都是用这样的方式来做恢复！！！

`````

