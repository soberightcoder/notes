#linux 重定向

> **理解重定向，即IO的重定向，输入输出的重定向，eg：ls 以前是输出到屏幕，现在可以利用> >> 重定向到文件中；**
>
> 

追加写

```shell
ls -l /usr/bin >> logbin.txt
```

覆盖写

````
ls -l /usr/bin > logbin.txt 
````



0 1 2  文件描述符的 标准输入 标准输出 和 标准错误；



把错误输出到文件中去；2紧挨重定向操	作符，代表重定向错误到文件中；

````shell
ls -l /bin/usr 2> errorlog.txt
````

如果需要把 错误和标准输入都要输出到一个文件；  

````shell
ls -l /bin/usr > errorlog.txt 2>&1  

#  最新版本 &>    1  and   2都输入；
ls -l /bin/usr &> errorlog.txt 
````



### 如果是命令呢？代表的就是标准输入和标准输出；命令就是一个进程 输入就是标准输入 输出就是标砖输出  2>&1  错误也输出；

ping -c 3 -w 1 -i 0.1 ww.baidu.com >/dev/null 2>&1 错误也输出到

**那么就是标准输入**

sh < check.sh

sh << check.sh



**sh > 那么就是标准输出；**



代表 **标准输入和标准输出；**

**cat >  覆盖写  cat >>追加写；**

cat >> config <<EOF
ceshi;

ceshi1;

EOF



config<<EOF 必须是两个



<font color=red>**<<EOF表示后续的输入作为子命令或子Shell的输入，直到遇到EOF为止，再返回到主Shell。**</font>

