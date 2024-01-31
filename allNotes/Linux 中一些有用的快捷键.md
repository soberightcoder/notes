#Linux 中一些有用的快捷键

cd   直接回到家目录 ；

cd -  回到上一个目录 ；



ctrl +e  到命令的结尾；

ctrl +a 到命令的开始；

ctrl +z  前台服务后台运行 ；

jobs 查看命令号

fg %命令号  前台运行

bg %后台运行





history 

history 3 最近使用的三个命令；

!!执行上一个命令；

!command 运行一下最近运行的命令，开头是command的命令；



用 alias ll=’ls-al'; vim .bashrc 

永久的修改 vi .bashrc 

alias ll='ls -alh'

source .bashrc



/etc/profile 

~.bashrc

source filename  === . filename 



source  



####[source ./ 和 . 的区别](https://www.cnblogs.com/relax1949/p/9229248.html)



- `./script` 作为一个可执行文件来运行脚本，启动一个**子shell**来运行它，当执行完脚本之后，又回到了**父shell**中，所以在**子shell**中执行的一切操作都不会影响到**父shell;**
- `source script` 在**当前shell**环境中从文件名读取和执行命令。

注意：./script 不是 . script ，但是 . script 类似于source script 

 

使用./ 运行脚本的时候，系统变量不会受到影响，而使用source的时候，会影响到系统当前的环境变量。



####**环境变量**



所有用户的全局配置脚本

/etc/profile

个人用户的配置脚本

~/.bash_profile



登录 shell 会话的 启动文件

/etc/bash.bashrc

~/.bashrc

用source 来激活我们的修改；

source .bashrc



**.bash_profile 文件的内容：**

[root@27d40a3f1787 ~]# cat .bash_profile | grep -v '#'

if [ -f ~/.bashrc ]; then
        . ~/.bashrc
fi

**PATH=$PATH:$HOME/bin**

**export PATH**



**那么 移动命令到~/bin 那么就会这样 你就可以在全局使用自己定制的命令了；**



**使PATH 变成环境变量可以被子进程使用；**



####shell 解决多行复制问题

:set paste  黏贴模式；

:set nopaste 消除黏贴模式；



####**查看环境变量：**

环境变量：

export  有序

env  无序



自定义变量：

declare 有序

set 无序

