# MySQL的时间函数

>时间函数

| 函数                              | 作用                                                         | eg   |
| --------------------------------- | ------------------------------------------------------------ | ---- |
| CURRENT_DATE() <br />curdate()    | 当前日期                                                     |      |
| CURRENT_TIME()                    | 当前时间                                                     |      |
| CURRENT_TIMESTAMP()               | 当前时间戳 ==  now不是时间戳呀；哥！！！                     |      |
| NOW()                             | 当前日期+时间；                                              |      |
| UNIX_TIMESTAMP()                  | 返回一个时间戳  日期转换成时间戳  <font color=red>重要</font> |      |
| FROM_UNIXTIME()                   | 把时间戳转换成日期+ 时间<font color=red>重要</font>          |      |
| DATE_FORMAT()                     | 修改 日期的格式 %w 日期%ymd his 分别是年月日 时分秒 （''%Y-%m-%d %H:%i:%s"）一般都是这个形式；<font color=red>重要</font>  判断两个date 是否是同一天或者同月同一个小时 |      |
| DATE()                            | 提取时间表达式的日期部分                                     |      |
| DAY()                             | 提取天数                                                     |      |
| HOUR()                            | 提取小时                                                     |      |
| MONTH()                           | 提取月份                                                     |      |
| TIME()                            | 提取时间                                                     |      |
| YEAR()                            | 提取年                                                       |      |
| TO_DAYS()                         | 返还的是天数，从'1970-01-01 00:00:00' 以来的天数；<font color=red>重要</font>判断两个日期是同一天  //  判断是否是同一天！！！ |      |
| WEEKDAY                           | 看看日期是周几  0 星期一 1星期二 以此类推6是星期日           |      |
| YEARWEEK                          | 年份加周    一年的第几周 可以用来判断两个日期是是否在同一周  <font color=red>重要</font> | 来   |
| DATEDIFF()                        | 两个日期的差    <font color=red>重要</font>                  |      |
| DATE_SUB(date,INTERVAL expr unit) | 从日期（date ）中减去时间值（间隔）<font color=red>重要</font> |      |
| DATE_ADD(date,INTERVAL expr unit) | 从日期中加上时间值（间隔）<font color=red>重要</font> 用来查询从现在这个日起开始计算的一周 或者一天，一个月的时间范围内的数据查询 |      |
| CONCAT(field1,'(',field2,')')     | 拼接 concat 拼接两个字段；field   <font color=red>重要</font> |      |
| substring(str,start,length)       | start 可以是负数；也就是从末尾来开始                         |      |
| length(str)                       | 字符串的长度                                                 |      |
| group_concat(column_name,y);      | y代表的使用什么隔离 ，一般和group by 一起使用；就是来显示group组内的内容； |      |
| replace(str,totalstr,replacestr)  | str 由目标文件totalstr 替换成replacestr                      |      |

1. DAY()

````mysql
mysql> select DAY('2021-10-25 10:13:57')
    -> ;
+----------------------------+
| DAY('2021-10-25 10:13:57') |
+----------------------------+
|                         25 |
+----------------------------+
````

2. HOURS()

`````mysql
mysql> select HOUR('2021-10-25 10:13:57');
+-----------------------------+
| HOUR('2021-10-25 10:13:57') |
+-----------------------------+
|                          10 |
+-----------------------------+
`````

3. MONTH

````mysql
mysql> select MONTH('2021-10-25 10:13:57');
+------------------------------+
| MONTH('2021-10-25 10:13:57') |
+------------------------------+
|                           10 |
+------------------------------+
````

4. DATE()

````mysql
mysql> select DATE('2021-10-25 10:13:57');
+-----------------------------+
| DATE('2021-10-25 10:13:57') |
+-----------------------------+
| 2021-10-25                  |
+-----------------------------+
````

5. TIME()

`````mysql
mysql> select TIME('2021-10-25 10:13:57');
+-----------------------------+
| TIME('2021-10-25 10:13:57') |
+-----------------------------+
| 10:13:57                    |
`````

6. DATE_FORMAT()  

  >这个命令可以实现上面所有的提取命令
  >
  >**参数可以是时间戳也可以是 datetime的数据类型，都是可以的！！！**

`````mysql
mysql> select DATE_FORMAT('2021-10-25 10:13:57','%Y-%m-%d %H:%i:%s');
+--------------------------------------------------------+
| DATE_FORMAT('2021-10-25 10:13:57','%Y-%m-%d %H:%i:%s') |
+--------------------------------------------------------+
| 2021-10-25 10:13:57                                    |
+--------------------------------------------------------+
mysql> select DATE_FORMAT('2021-10-25 10:13:57','%H');
+-----------------------------------------+
| DATE_FORMAT('2021-10-25 10:13:57','%H') |
+-----------------------------------------+
| 10                                      |
+-----------------------------------------+
1 row in set (0.00 sec
 -- now() 就是日期的格式；            
 mysql> select DATE_FORMAT(now(),'%Y-%m-%d %H:%i:%s');
+----------------------------------------+
| DATE_FORMAT(now(),'%Y-%m-%d %H:%i:%s') |
+----------------------------------------+
| 2022-07-24 16:57:50                    |
+----------------------------------------+
1 row in set (0.00 sec)
              

select date_format(current_timestamp,'%Y-%m-%d %H:%i:%s'); # 这个也是可以的，可以是参数shi'jian'chu
`````

7. YEARWEEK()

`````mysql
mysql> select YEARWEEK(now());
+-----------------+
| YEARWEEK(now()) |
+-----------------+
|          202143 |
+-----------------+
1 row in set (0.00 sec)


mysql>  select YEARWEEK(now());
+-----------------+
| YEARWEEK(now()) |
+-----------------+
|          202230 |
+-----------------+
1 row in set (0.00 sec)
`````

9. DATEDIFF()

````mysql
mysql> select DATEDIFF('2021-10-24 10:13:57','2021-10-29');
+----------------------------------------------+
| DATEDIFF('2021-10-24 10:13:57','2021-10-29') |
+----------------------------------------------+
|                                           -5 |
+----------------------------------------------+
1 row in set (0.00 sec)
````

10. DATE_SUB(date,INTERVAL expr unit)

`````mysql
mysql> select DATE_SUB('2021-10-24 10:13:57',INTERVAL 1 day);
+------------------------------------------------+
| DATE_SUB('2021-10-24 10:13:57',INTERVAL 1 day) |
+------------------------------------------------+
| 2021-10-23 10:13:57                            |
+------------------------------------------------+
1 row in set (0.00 sec)

mysql> select date_sub(now(),interval 1 day);
+--------------------------------+
| date_sub(now(),interval 1 day) |
+--------------------------------+
| 2022-07-23 17:03:13            |
+--------------------------------+
1 row in set (0.00 sec)
`````

11. CONCAT()

`````mysql
mysql> select concat(vend_name,'(',vend_country,')') from Vendors order by vend_name;   
+----------------------------------------+                                              
| concat(vend_name,'(',vend_country,')') |                                              
+----------------------------------------+                                              
| Bear Emporium(USA)                     |                                              
| Bears R Us(USA)                        |                                              
| Doll House Inc.(USA)                   |                                              
| Fun and Games(England)                 |                                              
| Furball Inc.(USA)                      |                                              
| Jouets et ours(France)                 |                                              
+----------------------------------------+                                              
`````

12.时间戳和日期的转换

```mysql
mysql> select from_unixtime(unix_timestamp(now()));
+--------------------------------------+
| from_unixtime(unix_timestamp(now())) |
+--------------------------------------+
| 2021-11-11 11:27:33                  |
+--------------------------------------+
1 row in set (0.00 sec)
```

13

````mysql
#默认是以，来隔开；
mysql> select group_concat(vend_id) from Products group by vend_id;
+-------------------------+
| group_concat(vend_id)   |
+-------------------------+
| BRS01,BRS01,BRS01       |
| DLL01,DLL01,DLL01,DLL01 |
| FNG01                   |
+-------------------------+
3 rows in set (0.01 sec)

````

14 WEEKDAY



// 这四个问题 一定要回呀；

问题1：

``````mysql
#查询在今天创建的数据
select create_time,order_id from Orders where TO_DAYS(create_time)=TO_DAYS(NOW());
# 可以使用 date_format(); 转换成一个Y-m-d 
``````

问题2：

`````mysql
# 查询在本周创建的数据
select create_time,order_id from Orders where YEARWEEK(DATE_FORMAT(create_time,"%Y-%m-%d")) = YEARWEEK(now());
`````

问题3：

```````mysql
# 查询在本月的创建的订单数据
select create_time,order_id from Orders where DATE_FORMAT(create_time,"%Y-%m") = DATE_FORMAT(now(),"%Y-%m")
```````

问题4：

`````mysql
#查询24小时以前到现在的订单数据
select create_time,order_id from Orders where create_time >= DATE_SUB(now(),INTERVAL 1 DAY);
`````



