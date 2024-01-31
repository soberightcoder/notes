# explain

[官网](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html)   

innodb_page_size innodb 数据页的大小   默认是16k 可以去修改

## 打开 slow query日志

```mysql

# slow query
# long_query time

mysql> show variables like 'long_query_time';

mysql> set global  slow_query_log =1;#slow query log 

mysql> show variables like 'slow_query_log';  #  开启慢查询；

mysql> show variables like 'slow_query_log_file';

#• log_output
# ◦ 慢查询日志的栺式，[FILE | TABLE | NONE]，默认是FILE；版本 >=5.5
# ◦ 如果设置为TABLE，则记录的到 mysql.slow_log

```







应该在链接的条件列上加索引，并且链接的条件列需要在索引的首位（表所有索引中的第一个索引列：最左匹配原则），使用此方法完成索引修改之后，速度瞬间提升了，以前要10多秒的也提升到了毫秒级；



5,6 之前需要extended  5.7之后直接用 extended就好了！！！！！ 会显示partition filtered；这两个字段；

 todo搞清楚这里要干什么！！！



**表 8.1 EXPLAIN 输出列**   

| 柱子                                                         | JSON 名称       | 意义                                      |
| :----------------------------------------------------------- | :-------------- | :---------------------------------------- |
| [`id`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_id) | `select_id`     | `SELECT`标识符_                           |
| [`select_type`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_select_type) | 没有任何        | `SELECT`类型_                             |
| [`table`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_table) | `table_name`    | 输出行的表                                |
| [`partitions`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_partitions) | `partitions`    | 匹配的分区                                |
| [`type`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_type) | `access_type`   | 联接类型                                  |
| [`possible_keys`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_possible_keys) | `possible_keys` | 可供选择的索引                            |
| [`key`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_key) | `key`           | 实际选择的索引                            |
| [`key_len`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_key_len) | `key_length`    | 所选密钥的长度                            |
| [`ref`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_ref) | `ref`           | 与索引比较的列                            |
| [`rows`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_rows) | `rows`          | 估计要检查的行数                          |
| [`filtered`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_filtered) | `filtered`      | 按表条件过滤的行百分比     过滤的百分比； |
| [`Extra`](https://dev.mysql.com/doc/refman/5.7/en/explain-output.html#explain_extra) | 没有任何        | 附加信息                                  |

## id  select 的标识符 __

<font color=red>标志位 谁的数值高 谁先运行，如果相同在上面的 先运行；</font>



| `select_type`价值                                            | JSON 名称                    | 意义                                                         |
| :----------------------------------------------------------- | :--------------------------- | :----------------------------------------------------------- |
| `SIMPLE`                                                     | 没有任何                     | 简单[`SELECT`](https://dev.mysql.com/doc/refman/5.7/en/select.html)（不使用 [`UNION`](https://dev.mysql.com/doc/refman/5.7/en/union.html)或子查询） |
| `PRIMARY`                                                    | 没有任何                     | 最外层[`SELECT`](https://dev.mysql.com/doc/refman/5.7/en/select.html) |
| [`UNION`](https://dev.mysql.com/doc/refman/5.7/en/union.html) | 没有任何                     | 中的第二个或以后[`SELECT`](https://dev.mysql.com/doc/refman/5.7/en/select.html)的语句 [`UNION`](https://dev.mysql.com/doc/refman/5.7/en/union.html) |
| `DEPENDENT UNION`                                            | `dependent`( `true`)         | a 中的第二个或后面[`SELECT`](https://dev.mysql.com/doc/refman/5.7/en/select.html)的语句 [`UNION`](https://dev.mysql.com/doc/refman/5.7/en/union.html)，取决于外部查询 |
| `UNION RESULT`                                               | `union_result`               | 的结果[`UNION`](https://dev.mysql.com/doc/refman/5.7/en/union.html)。 |
| [`SUBQUERY`](https://dev.mysql.com/doc/refman/5.7/en/optimizer-hints.html#optimizer-hints-subquery) | 没有任何                     | 首先[`SELECT`](https://dev.mysql.com/doc/refman/5.7/en/select.html)在子查询中 |
| `DEPENDENT SUBQUERY`                                         | `dependent`( `true`)         | 首先[`SELECT`](https://dev.mysql.com/doc/refman/5.7/en/select.html)在子查询中，依赖于外部查询 |
| `DERIVED`                                                    | 没有任何                     | 派生表                                                       |
| `MATERIALIZED`                                               | `materialized_from_subquery` | 物化子查询                                                   |
| `UNCACHEABLE SUBQUERY`                                       | `cacheable`( `false`)        | 一个子查询，其结果无法缓存，必须为外部查询的每一行重新计算   |
| `UNCACHEABLE UNION`                                          | `cacheable`( `false`)        | [`UNION`](https://dev.mysql.com/doc/refman/5.7/en/union.html) 属于不可缓存子查询 的第二个或以后的选择（请参阅 参考资料`UNCACHEABLE SUBQUERY`） |

##select_type

---



查询中每个select子句的类型.

1. simple: 简单的select, 不适用union或子查询等. 例如: `SELECT * from t_member where member_id = 1;`
2. primary: 子查询中最外层查询, 查询中若包含任何复杂的子部分, 最外层的select被标记为primary. 例如: `SELECT member_id from t_member where member_id = 3 UNION all SELECT member_id from t_member`
3. union: union中的第二个或后面的select语句. 例如: `SELECT member_id from t_member where member_id = 3 UNION all SELECT member_id from t_member`
4. dependent union: union中第二个或后面的select, 取决于外层的查询. 例如`SELECT tm.* from t_member as tm where member_id in (SELECT member_id from t_member where member_id = 3 UNION all SELECT member_id from t_member)`
5. union result: union的结果集
6. **subquery: 子查询中的第一个select. 例如: `SELECT * from t_member where member_id = (SELECT member_id from t_member where member_id = 5)`**
7. **dependent subquery: 子查询中的第一个select, 取决于外面的select. 例如: `SELECT tm.* from t_member as tm where member_id in (SELECT member_id from t_member where member_id = 3 UNION all SELECT member_id from t_member)`**
8. **derived: 派生表的select(from子句的子查询). 例如: `SELECT * from (SELECT * from t_member where member_id = 1) tbl`**

---



* 简单的查询   SIMPLE  不使用union或者子查询

* 复杂查询

  * PRIMARY 最外层的select；
  * SUBQUERY    子查询   （子查询，在字段或者where条件之后的子查询）；
  * DERIVED  派生表   from之后的子查询；
  * DEPENDENT SUBQUERY    相关子查询；
  * UNION   第二个select；
  * UNION result union的结果；

  

  ````mysql
  mysql> explain select * from Products limit 1 union select * from Products limit 2;
  +----+--------------+------------+------+---------------+------+---------+------+------+-------+
  | id | select_type  | table      | type | possible_keys | key  | key_len | ref  | rows | Extra |
  +----+--------------+------------+------+---------------+------+---------+------+------+-------+
  |  1 | PRIMARY      | Products   | ALL  | NULL          | NULL | NULL    | NULL |    8 |       |
  |  2 | UNION        | Products   | ALL  | NULL          | NULL | NULL    | NULL |    8 |       |
  | NULL | UNION RESULT | <union1,2> | ALL  | NULL          | NULL | NULL    | NULL | NULL |       |
  +----+--------------+------------+------+---------------+------+---------+------+------+-------+
  3 rows in set (0.00 sec)
  
  # subquery derived
  mysql> explain select (select max(score) from student) from (select * from student) as stu;
  +----+-------------+------------+------+---------------+------+---------+------+------+-------+
  | id | select_type | table      | type | possible_keys | key  | key_len | ref  | rows | Extra |
  +----+-------------+------------+------+---------------+------+---------+------+------+-------+
  |  1 | PRIMARY     | <derived3> | ALL  | NULL          | NULL | NULL    | NULL |    6 |       |
  |  3 | DERIVED     | student    | ALL  | NULL          | NULL | NULL    | NULL |    6 |       |
  |  2 | SUBQUERY    | student    | ALL  | NULL          | NULL | NULL    | NULL |    6 |       |
  +----+-------------+------------+------+---------------+------+---------+------+------+-------+
  3 rows in set (0.00 sec)
  

````
  
## type

````mysql
#system > const > eq_ref>ref >range>index>all

#system 是const的一种特殊情况  本身表里面只有一条数据; 本身表的结果集只有一条数据；

#const  一般是唯一索引或者是主键索引  直接用 =  找到数据；

#注意当关联的时候第一张表肯定ALL 是全表扫描的 第二张表可以使用索引；一定都要加索引；

#eq_ref  关联的时候使用的是主键索引或者使用唯一索引来做关联；一般出现在join里面    reference  关联的意思，equal  相同的；

#ref  使用了索引，普通索引；查询了某个值之后还需要往后继续查找；可以查询到多个记录值；  也有可能是用的是联合索引的部分，或者是唯一索引的最左前缀原则，只有部分，也可能是ref；普通索引 ==   等值查询

#range 范围查询 in between >  >= < <=的范围查询  有索引的范围查询； 肯定会用索引；查询的数据还是很多的所以效率并不高；


#index  二级索引 因为只包含部分数据，所以比较小（或者说树低）所以随机IO口次数比较少；所以会使用二级索引遍历数据；而不是用主键索引；扫描全部的索引，不是从根结点遍历，而是从叶子节点的扫描，速度还是比较慢，这种查询一般都是使用索引覆盖；
#遍历索引；如果不去回表，那么一般扫描二级索引，二级索引比较小；会快一些；随机IO口会少一些；

#all 全表扫描，扫描的你聚簇索引的所有的叶子节点；都需要去遍历；整张表的所有的数据，聚簇索引；

````





## possible key  可能使用的索引



## key 执行sql的时候使用到的索引



## key_len   主要是联合索引使用了那个索引，是否都是用了索引；

 char(n) = n字节

varchar(n)   3n+2个字节；

**这个字段允许为null，那么会有一个字节记录是否允许为null；**



## rows  扫描的行数    仅仅是一个预估值 ；



## extra



`````mysql
#Using index  使用覆盖索引；减少回表； 查询的方式；你查找的字段在二级索引树里面全部都是包含的；
#一般使用联合索引来进行覆盖索引；进而减少回表；

#Using where  使用where查询，并且查询的列，没有被索引覆盖；一般要使用优化；


#Using index condition     Using index condition  叫作    Index Condition Pushdown Optimization (索引下推优化)。  使用了索引条件来过滤；

#using temporary 使用了临时表  可以使用 索引来做优化=>using index   distinct  使用了临时表 去重，肯定是没有索引；要加索引；有了索引，直接就可以把重复的去掉；分组也是如果有索引那么直接 就分好了，因为是有序的；

#using filesort 文件排序 order by  使用了sort_buffer 进行排序；2M 当超过2M的时候需要使用外部磁盘进行排序；

#using join buffer join关联字段没有使用索引，所以需要使用join buffer 做一个优化；这里的优化 可以给using join bffer 加一个索引；

`````





**下面来简单的介绍一下这三者的区别**

**using index ：使用覆盖索引的时候就会出现**

**using where：在查找使用索引的情况下，需要回表去查询所需的数据**

**using index condition：查找使用了索引，但是需要回表查询数据**

**using index & using where：查找使用了索引，但是需要的数据都在索引列中能找到，所以不需要回表查询数据**



using where 是啥东西呀，我需要啥优化呀？？？//todo







explain mysql 语句，在extra栏里出现 Using index condition 很好奇为什么呢？ 是好还是不好？

首先 肯定答案： 是好的！

解释：

   Using index condition 叫作  Index Condition Pushdown Optimization (索引下推优化)。

　 Index Condition Pushdown (ICP)是MySQL使用索引从表中检索行的一种优化。如果没有ICP，存储引擎将遍历索引以定位表中的行，并将它们返回给MySQL服务器，服务器将判断行的WHERE条件。在启用ICP的情况下，如果可以只使用索引中的列来计算WHERE条件的一部分，MySQL服务器就会将WHERE条件的这一部分推到存储引擎中。然后，存储引擎通过使用索引条目来评估推入的索引条件，只有当满足该条件时，才从表中读取行。ICP可以减少存储引擎必须访问基表的次数和MySQL服务器必须访问存储引擎的次数。

　 ICP的适用性取决于以下条件:

​      1.当需要访问整个表行时，ICP用于range、ref、eq_ref和ref_or_null访问方法。

​      2.ICP可以用于InnoDB和MyISAM表，包括分区的InnoDB和MyISAM表。

​      3.对于InnoDB表，ICP仅用于二级索引。ICP的目标是减少全行读取的数量，从而减少I/O操作。对于InnoDB聚集索引，完整的记录已经被读取到InnoDB缓冲区中。在这种情况下使用ICP并不会减少I/O。

​      4.在虚拟生成的列上创建二级索引不支持ICP。InnoDB支持在虚拟生成的列上建立二级索引。 

​      *5.*引用子查询的条件不能下推。

​      6.引用存储函数的条件不能下推。存储引擎无法调用存储函数。
​      7.触发的条件不能被压制。

 

   要理解 ICP 这种优化是如何工作的，首先考虑当没有使用ICP时索引扫描是如何进行的:

​     1.获取下一行，首先通过读取索引元组，然后使用索引元组定位和读取整个表行。 

​     2.检查WHERE条件中应用于此表的部分。根据检查结果接受或拒绝行。

   使用ICP,则会变成下面这样：

​     1.获取下一行的索引元组(但不是整个表行)。 

​     2.检查应用于此表的WHERE条件的部分，仅使用索引列即可进行检查。如果条件不满足，则进入下一行的索引元组。（因为索引条件下推到了存储引擎层）*
*

​      3.如果条件满足，则使用index元组定位和读取整个表行。
​     4.测试应用于此表的WHERE条件的其余部分。根据测试结果接受或拒绝行

 

  例子：

​    假设一个表包含关于人员及其地址的信息，并且该表有一个定义为index (zipcode, lastname, firstname)的索引。如果我们知道一个人的zipcode值，但不确定他的姓氏，我们可以这样搜索：

```
SELECT * FROM people
  WHERE zipcode='95054'
  AND lastname LIKE '%etrunia%'
  AND address LIKE '%Main Street%';
```

　　MySQL可以使用索引扫描邮编为'95054'的人。第二部分(lastname LIKE '%etrunia%')不能用于限制必须扫描的行数，因此如果没有ICP，该查询必须检索zipcode='95054'的所有人的完整表行。使用ICP，MYSQL在读取全部行表时，可以先检查 

lastname LIKE '%etrunia%' 的部分，这样避免了那部分多的数据的返回。

 





