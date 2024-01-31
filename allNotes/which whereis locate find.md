#which whereis locate find  四个查找命令的区别

>查找；

---



### which 命令的查询

是根据环境变量PATH来进行的查询；

----



###whereis 文件或者目录名称的查询

-m  文件

-b 二进制可执行文件

-s source 源文件；



优点：这个也是根据数据库来进行查询的；所以速度比较快

缺点数据库并不是实时更新；所以在刚删除或者刚刚创建的时候查询不到的问题；

find 需要遍历硬盘来查询，所以效率自然低；



----



### locate 

也是创建数据库 

需要手动更新数据库 updatedb 

和find -name 查询类似

查询效率比find快；

locate -i  忽视大小写的查询；

---



### find  硬盘的遍历去查询；速度比较慢；消耗内存；实时性比较好·；

find <指定目录><指定条件><指定动作>

```shell
find / -name 1.txt -print0|xargs -0 ls -al
-size  大小 +10M 大于 10M的文件  j
-type f  d  文件和 目录  来区分  文件类型的查找；
-ctime -1    change  文件权限和内容都可以修改 一天之内的修改；   +1 代表的是 一天之前的修改；
-mtime    modify   仅仅修改了文件的内容
-cmin  分钟；
-atime access 读过那些文件 access 访问过的；

-maxdepth 3  文件的深度 是3；
-print0|xargs -0

#xargs 把标准输入转换成参数
```







