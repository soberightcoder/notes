# Linux 命令



**文件处理的命令：**

---

  1.**cut** 分割    **这里完全可以用awk呀；**

​    -d 分隔符    **delimiter  分隔符**    --delimiter=DELIM 

​	-f 第几列  field    -f, --fields=LIST   

​	 cut -d ":" -f 1 /etc/passwd | wc -l

----



2. **sort** 排序（字典序，ascII排序）sort -nrk2 最出名的；

   -r  反序

   -n 自然数形式排序

   **-t 分隔符      -t, --field-separator=SEP**  

   -k 第几个key 排序

   **-f 不区分大小写       -f, --ignore-case           fold lower case to upper case character**s

   ````shell
   # 根据出现的次数来进行排序
   sort config | uniq -c | sort -r  
   sort -t ":" -k 3 -f config
   ````

   ----

   

3. uniq  去重 需要和 sort 联合使用
   ****-c 计算重复出现的次数  count 
   -d 只显示重复的行  显示重复的行  ***  --repeated   only print duplicate lines, one for each group**
   -u 只显示不重复的行**      *******    -u, --unique          only print unique lines

   ```shell
   # 根据出现的次数进行排序
   sort config | uniq -c | sort -r
   ```

   

4. wc word count
   -l 计
   -w 单词数
   -c 字节数    -c, --bytes            print the byte counts

5. cat more less head tail 查看文件
   cat  -n 显示行号 还有文件的合并 多个文件合并到一起 经常和split 来一起使用
   more 空格往下翻 不能返回  最好用more来查看；more 去查看比较安全；
   **less space 往下翻 b返回 q 退出； 很明显要把文件全部加载到内存中 所以不能查看过大的文件；**
   head -n 
   tail -n
   tail -f 动态查看

----



2. split 分割  大文件的分割；  这个需要注意一下；
   -number 以多少行作为分割 

   -c  字节数的分割；

   ```php
   split [--help][--version][-<行数>][-b <字节>][-C <字节>][-l <行数>][要切割的文件][输出文件名]
   -C 切割  保证数据的完整性
   ```

3. grep  文本的过滤 注意后面的awk sed 文件的处理；
   -i  忽略大小写  ****
   -n 显示行号
   -w 精确匹配 
   -v 反向匹配
   -A after 匹配到的后5行 -A5
   -C context 上下文 -C5 上下文5行

   -B before 前5行；

   ```shell
   grep -v "#" man_db.conf  >> 1.txt  可以把注释选项给省略掉
   docker inspect nginx | grep -i -C5 cmd
   ```

   <font color=red>注意  ：xargs 把标准输入转换成参数  一般配合 | 来使用；</font>eg : echo 1 2 3 4 4 | xargs touch

   

   **文件系统的处理：**

   ---

   

4. mkdir -p 遍历创建文件夹  其他的遍历操作都是 -r 

   ```
   mkdir -p /ceshi/ceshi1
   ```

   

5. df 文件系统磁盘 磁盘使用状况 -h 人性化显示 MB 不是字节数；

  ---

  

6. 链接 （创建链接） 详细 可以看ln详解篇  
  ln 源文件 硬链接目标文件  hard link 
  ln -s 源文件 软链接目标文件  symbolic link

7. du disk usage 磁盘使用状况
   -h 易读性比较好
   -s 总结  sum 总计

   -a 文件下的所有文件全部遍历；

   ````shell
   du -sh .
   du -sh * 
   du -sh *|sort -nr
   ````

8. free  内存使用状况
   -h  human
   -s 多少秒刷新一次
   **free -h -s 3** 
   参数：M total used free shared cache/buffer aviliable 一般
             swap 

9. alias ll='ls -al'  取别名； type ll 

10. 压缩文件 zip 

   <font color=red> **tar -czvf 目标文件 源文件** </font>
   解压： tar -xzvf 目标文件** 

   v : 显示详情；verbose;

   f ： 指定文件；     -f, --file=ARCHIVE         use archive file or device ARCHIVE
   c ：create  archive ;创建一个文档，也就是压缩；

   x :extract;   extract files from an archive

   **注意这个命令可以使用 --exclude  可以排除一部分文件；**

   ````php
   //tar -czvf    // tar.gz ;
    tar -czvf  /ceshi/ceshi.tar \ 
        --exclude=/ceshi/ceshi.log \
        /opt/web/suyun_web  
   ````

   

11. **ps -ef 进程管理  快照的形式显示进程；**
    **-e 全部进程**
    **-f 显示进程之间的关系 pid 和ppid**
    **ps -aux 显示进程的详细信息；占用的cpu 资源呀  或者内存资源 进程的状态**；



2. top 动态显示进程；

    

3. 这个是**windows**  netstat -anop  -a 全部  -n 数字显示端口号和ip地址 -o 显示进程号 pid -p 显示协议 tcp 或者udp协议

4. source . ./  执行脚本；
  权限操作 

----



2. chmod -R 777 filename  chmod u+x filename  ugo(other)    rwx  组合 添加权限；go=
   **文件的rwx 分别代表 打开文件读文件  修改写入文件  执行文件**
   **目录的rwx 查看文件内容 必须是x的前提下，w文件的修改和重命名也必须在x的前提下，x允许打开目录；**

   ----

   

2. ping 发送一个icmp

3. traceroute  查看经过的路由数

4. wget 非交互式网络下载器

5. 

6. 

7. 

8. 

9. 

10. 

11. 

12. 

13. 

14. 

15. 

16. 

17. 

18. 

   ​    

