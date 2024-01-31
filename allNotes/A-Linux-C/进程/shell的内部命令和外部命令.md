

# shell的内部命令和外部命令

>**type -t command**
>
>* **file  磁盘属于外部命令；**
>*  **alias 取别名；**
>* **builtin  builtin builtin 内部建设的命令！！内建命令，因为一直在内存中，所以执行效率比较高！！**



## 概念

Linux命令有内部（内建）（内置）命令和外部命令之分，内部命令和外部命令功能基本相同，但有些细微差别。

所谓的内部和外部其实是相对Shell自身来讲。Linux系统为了提高系统运行效率，将经常使用的轻量的命令在系统启动时一并加载这些命令到内存中供Shell随时调用，这部分命令即为内部命令。

反之，系统层调用的较重的命令只有当被调用时才会硬盘加载的这部分命令即为外部命令。

## 内部命令

内部命令实际上是Shell程序的一部分，由 Shell 软件内部进行实现的命令，其中包含的是一些比较简单的linux系统命令，这些命令由shell程序识别并在shell程序内部完成运行，通常在linux系统加载运行时shell就被加载并驻留在系统内存中。内部命令是Shell本身的重要组成部分。内部命令嵌入在Shell程序中，并不单独以磁盘文件的形式存在于磁盘上。内部命令是写在bashy源码里面的，其执行速度比外部命令快，因为解析内部命令shell不需要创建子进程，它们都运行在 Shell 进程当中。比如：exit，history，cd，echo，fg，cd、source、export、time等。

## 外部命令

外部命令是linux系统中的实用程序部分，是一个独立的外部可执行程序，因为实用程序的功能通常都比较强大，所以其包含的程序量也会很大，在系统加载时并不随系统一起被加载到内存中，而是在需要时才将其调用内存。通常外部命令的实体并不包含在Shell中，但是其命令执行过程是由Shell程序控制的。当外部命令被调用时，本质就是调用了另外一个程序，首先 Shell 会创建子进程，然后在子进程当中运行该程序。Shell程序管理外部命令执行的路径查找、加载存放，并控制命令的执行。外部命令是在bash之外额外安装的，通常放在/bin，/usr/bin，/sbin，/usr/sbin……等等。可通过“echo $PATH”命令查看外部命令的存储路径。常见外部命令比如：/bin/ls、vi、tee、tar等。

## 为什么要分内部命令和外部命令

**内部命令其实是SHELL程序的一部分，其中包含的是一些比较简练和日常经常会被用到的命令。这些命令通常系统启动时就调入内存，且常驻内存的，由SHELL程序识别并在SHELL程序内部运行，之所以这样做的原因只有一个就是：为了最大化执行效率，提升系统性能。而外部命令通常是系统的软件功能，该部分程序功能通常较为强大，但包括的程序量也很大，因此并不随系统启动一并加载，只在用户需要时才从硬盘中读入内存。**

## 判断某个命令为外部命令或内部命令

type命令用来显示指定命令的类型，判断给出的指令是内部指令还是外部指令。

**语法格式：**type [参数] [命令]

常用的三个参数：

> -t对应-type
> -a对应-all
> -p对应-path

使用：type [-a | -t | -p] name 或 type [-all | -type | -path] name。

- （1）没有参数的状况下，它会显示出shell如何解译name做为命令。

- （2）如果有”-type”，它将会显示alias、 keyword、function、builtin或file。

- - file：表示为外部指令；
  - alias：表示该指令为命令别名所设定的名称；
  - builtin：表示该指令为 bash 内建的指令功能。

- （3）如果有”-path”的参数，它将会显示该命令的完整档名(外部指令)或显示为内建指令，找不到的话，不显示任何东西。

- （4）如果有”-all”的参数，会将由PATH变量定义的路径中所有含有name指令的路径都列出来，即显示所有可执行name的可能路径。

**输出：**

| lias        | 别名                     |
| ----------- | ------------------------ |
| keyword     | 关键字，Shell保留字      |
| function    | 函数，Shell函数          |
| **builtin** | 内建命令，Shell内建命令  |
| file        | 文件，磁盘文件，外部命令 |
| unfound     | 没有找到                 |





````shell
###eg:
[root@fce7a0a3deef process]# type -t ls
alias
[root@fce7a0a3deef process]# type -t cd
builtin
[root@fce7a0a3deef process]# type -t which
alias
[root@fce7a0a3deef process]# type -a which
which is aliased to `alias | /usr/bin/which --tty-only --read-alias --show-dot --show-tilde'
which is /usr/bin/which
which is /bin/which
[root@fce7a0a3deef process]# type -t /bin/which 
file
````

