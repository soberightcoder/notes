# limit

> 语法上面的优化！！

---

## 语法 的实现 limit；

>limit 1,1;  第一个数是offset，第二个是取的元素个数；

在 SQL 中，`LIMIT 1, 2` 表示从查询结果中跳过第一个行，然后返回接下来的两行。第一个数字表示要跳过的行数，第二个数字表示要返回的行数。

这种用法通常在需要分页显示查询结果时非常有用。例如，如果你希望从第三行开始返回两行结果，可以使用 `LIMIT 1, 2`。

以下是示例：

```mysql
CopyOpenSELECT column1, column2
FROM table
LIMIT 1, 2;
```



----

## group by

 > **group by  默认对后面的字段来做顺序排序；**

````mysql
#默认是group by column_name asc；默认是做升序排序的；  所以 group by 会做排序；一般都是默认做排序的；

## 删除排序  不去做排序；
group by column_name order by null;

## 逆序排序 逆序排序；
group by column_name desc;
````



