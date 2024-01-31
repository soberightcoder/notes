# windows 修改hosts的脚本

>运行 后缀；.bat  或者是cmd；  batch 代表的是批量处理脚本；
>
>*批处理(Batch),也称为批处理脚本*
>
>windows批量处理脚本！！



## 后缀

可以是.bat 或者是.cmd 都是可以的；

````cmd
@echo off
“echo off” ：关闭脚本的显示（不显示命令）。
“@” ：使命令也适用于自己。
````



## code

`````cmd
$ cat addhosts.cmd
@echo off   不要显示命令 只显示结果；
## 下面是  $1  合 shell一样
echo %1 >> C:\Windows\System32\drivers\etc\hosts

##直接这样添加就行；

`````



## more

`````php
@echo off
set tmp=%1

if defined tmp (
    	echo "modify is %tmp%"
        echo %tmp% >> C:\Windows\System32\drivers\etc\hosts
) else (
        echo "not have parameters"
        exit /b 2
)

echo "success"
##  windows 查看变量 使用的是 %var%   echo %var%
`````

## call 

> 这里是执行一个函数；调用一个函数
>
>想执行一个外部命令，直接写就好了；
>
>ls
>
>

`````bat
::调用外部命令；
:: 
`````

## 注释

`````bat
::注释
::双冒号 来表示注释！
`````



## exit

格式：

```css
      EXIT [/B] [exitCode]
```

- /B    退出batch script,而不是CMD.exe；否则整个CMD.exe窗口都退出。
- exitCode   退出值；这个值在caller可以使用变量%ERRORLEVEL%查看。

例如

```bash
c:\>type test.bat
@echo off
echo Hello World!
exit /b 1

c:\>test.bat
Hello World!

c:\>echo %errorlevel%
1
c:\huishen\test>
```





#  DOS

dos(磁盘操作系统)命令,是dos操作系统的命令,*是一种面向磁盘的操作命令,主要包括目录操作类命令、磁盘操作类命令、文件操作类命令和其它命令*。

磁盘操作系统（Disk Operating System）

`````.bat
@dir>1.txt /s/a/b h:\*.mp4
`````

![img](./windows%20%E4%BF%AE%E6%94%B9hosts%E7%9A%84%E8%84%9A%E6%9C%AC.assets/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L0NoYW9ZdWVfbWlrdQ==,size_16,color_FFFFFF,t_70.png)
