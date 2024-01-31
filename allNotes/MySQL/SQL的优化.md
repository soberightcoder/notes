# SQL的优化

>group by;distinct;limit;order by;
>
>注意一点的是 limit order by union 都是对存储层结果集的处理；
>
>分组 必定会做排序，必定会有filesort？？？？

----



**临时表** 需要注意的是 主要用于一些中间数据的暂存，一般处于内存中，速度比较快；  常用于  union 或者子查询呀 group by呀 ；

使不使用磁盘，由 tmp_table_size =16M 来决定大于16M肯定需要使用磁盘；
	max_heap_table_size=16M；

group by  当**没有索引**的时候需要临时表和filesort一个文件索引的排序；

**默认会有排序** 所以会用到filesort；



````mysql
mysql> explain select * from Products group by vend_id;
+----+-------------+----------+------+---------------+------+---------+------+------+---------------------------------+
| id | select_type | table    | type | possible_keys | key  | key_len | ref  | rows | Extra
 |
+----+-------------+----------+------+---------------+------+---------+------+------+---------------------------------+
|  1 | SIMPLE      | Products | ALL  | NULL          | NULL | NULL    | NULL |    8 | Using temporary; Using filesort |
+----+-------------+----------+------+---------------+------+---------+------+------+---------------------------------+
1 row in set (0.00 sec)
````



group by column_name order by null;  不使用排序

````mysql
mysql> explain select * from Products group by vend_id order by null;
+----+-------------+----------+------+---------------+------+---------+------+------+-----------------+
| id | select_type | table    | type | possible_keys | key  | key_len | ref  | rows | Extra           |
+----+-------------+----------+------+---------------+------+---------+------+------+-----------------+
|  1 | SIMPLE      | Products | ALL  | NULL          | NULL | NULL    | NULL |    8 | Using temporary |
+----+-------------+----------+------+---------------+------+---------+------+------+-----------------+
1 row in set (0.00 sec)
````

使用文件排序来进行分组 SQL_BIG_RESULT   

````mysql
mysql> explain select sql_big_result * from Products group by vend_id;
+----+-------------+----------+------+---------------+------+---------+------+------+----------------+
| id | select_type | table    | type | possible_keys | key  | key_len | ref  | rows | Extra          |
+----+-------------+----------+------+---------------+------+---------+------+------+----------------+
|  1 | SIMPLE      | Products | ALL  | NULL          | NULL | NULL    | NULL |    8 | Using filesort |
+----+-------------+----------+------+---------------+------+---------+------+------+----------------+
1 row in set (0.00 sec)
````



**distinct  也是一样 当没有索引的时候需要临时表 来进行去重；**



order by  （buffer_sort_size  ==2M 默认是2M 分块进行排序的；当合并的块太多了话，就可以修改buffer_sort_size 大小）

当order没有索引的话就需要一个索引文件的排序；using filesort；根据sort_buffer 的大小来决定是否外部磁盘；







**limit** 有一个头疼的问题，当偏移量很大的情况；**其实是offset的问题**，导致mysql会扫描大量不需要的行，然后进行抛弃；



其实遍历 叶子节点时间复杂度是O(n) 速度比较慢，但产生速度慢的主要原因还是，回表的问题；可以使用索引覆盖，或者使用索引下推；



解决

慢的原因：需要进行回表，主键索引树；

**使用一个子查询；减少io口的访问，回表的数据变少；从10010条变成了10条，自然效率变高了；**

<font color=red>**这个子查询不行的， in 里面的数据增多的时候数据查询会变慢；效率会变慢；**</font>

select xx,xx from table_name where id in (select id form table where second_index=xxx limit 10000,10 );

**避免深分页** **上一次查询的id值；大于 不要用>=**
select * from my_table where id>**上次查询的数据id值** limit 100 ；**这个使用了索引下推的方式优化；**

**延迟关联 避免大量回表** 索引覆盖的形式；

SELECT * FROM my_table t1,(select id from my_table where col_c=1 limit 1000,100) t2 where t1.id=t2.id



// join的计算原则，首先外层的是做一个all的查询，内层的是一个索引ref；所以，



**select * from my_table t1 join (select id from my_table where col_c=1 limit 1000,100) t2 on t2.id=t1.id;**



//mysql> explain SELECT vend_name, prod_name, prod_price FROM Vendors INNER JOIN Products  ON Vendors.vend_id = Products.vend_id;

+----+-------------+----------+------+---------------+------------+---------+----------------------+------+-------+
| id | select_type | table    | type | possible_keys | key        | key_len | ref                  | rows | Extra |
+----+-------------+----------+------+---------------+------------+---------+----------------------+------+-------+
|  1 | SIMPLE      | Vendors  | ALL  | PRIMARY       | NULL       | NULL    | NULL                 |    6 |       |
|  1 | SIMPLE      | Products | ref  | vend_index    | vend_index | 10      | demo.Vendors.vend_id |    1 |       |
+----+-------------+----------+------+---------------+------------+---------+----------------------+------+-------+
2 rows in set (0.00 sec)



<font color=red>上面的联表，都是外部的是ALL，内部是走的是索引；ref；就是先查询外部的，内部可以使用关联字段的索引进行筛选；所以效率会比较高；如果不适用索引筛选，那么就需要使用join buffer 来做筛选，效率会比较低；</font>>

