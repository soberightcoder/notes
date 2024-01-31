# group by 和 partition by的区别

>partition by 会保留全部的数据；
>
>mysql 8.0 才会支持 partition by；？？//todo
>
>---
>
>
>
>####区别：
>
>* **group by 只会返回聚合列；**
>
>* **partition by 会返回所有的聚合列；**
>
>**group by column_name 和partition by column_name 都会对结果级的排序；order by  column_name；**
>
>**注意上面的结果集排序   和  over 窗口里面的order有很大的区别！！！over里面order by 是对窗口分区内的排序；**
>
>------------------
>
>

----

````mysql
##  group by 也会默认排序  
mysql> select num,max(num) from logs group by num;
+-----+----------+
| num | max(num) |
+-----+----------+
|   1 |        1 |
|   2 |        2 |
+-----+----------+
2 rows in set (0.01 sec)

mysql> select num,max(num) from logs group by num order by num desc;
+-----+----------+
| num | max(num) |
+-----+----------+
|   2 |        2 |
|   1 |        1 |
+-----+----------+
2 rows in set (0.00 sec)
###---------------------------------------------------------------------------------------------------------
mysql> select max(salary) from employee1;
+-------------+
| max(salary) |
+-------------+
|       90000 |
+-------------+
1 row in set (0.00 sec)
select * from employee1 group by departmentid;  ## 这个肯定是错误的；因为是一个集合，没法显示；

#### group 就决定了 最高和最低 min() max() 并不能看到 组的里面；必须和聚集函数来配合；必须要和 聚集函数来配合使用；
## 主要执行顺序 where 在聚集函数之前执行；所以where的时候还没有聚集函数，所以where不能使用聚集函数；

#-----------------------------------------------------------------------------------------------------------
+--------------+-------------+
| departmentid | max(salary) |
+--------------+-------------+
|            3 |       70000 |
|            1 |       90000 |
|            2 |       80000 |
+--------------+-------------+
3 rows in set (0.00 sec)

mysql> select salary,max(salary) from employee1 group by departmentid;
ERROR 1055 (42000): Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'demo.employee1.salary' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by

##  group  by 只能返回聚合列 和分组的字段； 其他的返回就会报错；//多加注意；


## partition 的默认排序  也会默认排序；

mysql> select *,row_number() over(partition by num) from logs order by num desc;
+----+-----+-------------------------------------+
| id | num | row_number() over(partition by num) |
+----+-----+-------------------------------------+
|  4 |   2 |                                   1 |
|  6 |   2 |                                   2 |
|  7 |   2 |                                   3 |
|  1 |   1 |                                   1 |
|  2 |   1 |                                   2 |
|  3 |   1 |                                   3 |
|  5 |   1 |                                   4 |
+----+-----+-------------------------------------+
7 rows in set (0.01 sec)
````





---



### 二、查询结果

partition by 相比较于group by，**能够在保留全部数据的基础上**，只对其某些字段做分组排序；

而group by则保留参与分组的字段和[聚合函数](https://so.csdn.net/so/search?q=聚合函数&spm=1001.2101.3001.7020)的结果，类似excel中的透视表；

## 执行顺序

from > where > group by > having > order，而partition by应用在以上关键字之后，可以简单理解为就是在执行完select之后，在所得结果集之上进行partition by分组

## goup by

``````mysql


##  
mysql> select * from employee1 group by departmentid;
ERROR 1055 (42000): Expression 
#1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'demo.employee1.id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by
mysql> select max(salary) from employee1 group by departmentid;
+-------------+
| max(salary) |
+-------------+
|       90000 |
|       80000 |
+-------------+
2 rows in set (0.00 sec)

mysql> select max(salary) from employee1 group by departmentid asc;  # 肯定排序了 根据 departmentid 来进行排序了；
+-------------+
| max(salary) |
+-------------+
|       90000 |
|       80000 |
+-------------+
2 rows in set, 1 warning (0.00 sec)

## 
mysql> select max(salary) from employee1 group by departmentid desc;
+-------------+
| max(salary) |
+-------------+
|       80000 |
|       90000 |
+-------------+
2 rows in set, 1 warning (0.00 sec)

## group by m1,m2;  必须这两个相等才能放在一起；


``````

