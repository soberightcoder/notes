# docker run -tid 这个三个参数的作用

> **t 开启一个终端，你要去显示数据；**
>
> **i  交互，不仅有输出而且还有输入**
>
> **d  后台运行,就是不阻塞当前的bash进程！！**
>
> **ti一般都是成对出现的！！！**
>
> **d 就是后台运行** 
>
> **注意和长久运行的区别！！！ 是否长久运行跟，CMD有关！！！跟是否加d无关！！！**

----



`````c
//这个很重要就是为容器分配一个伪终端。tty;并且打开终端的输入；
services:
  name:
    stdin_open: true
    tty: true
// 终端都是历史遗留问题！！！
 // 多个用户共用一个计算机资源！！
 // 所以就给每一个用户分配一个终端；
  // 每一个计算机的使用者，可以通过终端输入自己需要计算的数据，计算机反馈给你结果！！！
  //所以 t 是给你分配一个终端，在一个就是打开输入；才能进行交互！！！
`````



docker新建并启动容器命令docker run -it centos中it指的是什么
网上全是废话，找不到一个解释的o(￣︶￣)o

1. it指的是啥

-i：以交互模式运行容器
-t：为容器重新分配一个伪输入终端

2. 伪输入终端
单纯输入-t参数时

[root@VM-20-7-centos ~]docker run -t centos
[root@db3209a7a830 /]

会出现一个可以输入的命令行，但是在命令行中输入信息不会有回应（无法交互），不会处理执行命令，输入exit也不会退出
所以-t的伪输入终端指的应该是应该可以输入命令行的东西，但是不会处理命令，需要加上-i参数才可以

3. 交互模式
单纯输入-i参数时
不会出现可以输入命令行的东西，但是依旧可以执行命令，例如ls或者exit等

exit
[root@VM-20-7-centos ~]bing

总结
-it中 i 是主体，输入 i 可以执行命令，t 更像是起到一种美化的功能





## 长久运行

`````shell
## 仅仅是把输入打开！！！ 不能交互！！！ 也不是后台运行！！！ 所以
G:\cwebsite\docker\dockerfile 
$ docker run -t centos:7
[root@20ece3fe1721 /]#
### 打开了终端但是没有打开输入所以it要一起存在！！！！！

# 并不会长久运行； 是否长久运行，是由命令来决定的！！！
##单独的
#docker run centos:7 并不会长久运行，必须配合 it；
G:\cwebsite\docker\dockerfile 
$ docker run centos:7

## 这种相当于 主进程 推出了 ，相当于docker attach 
G:\cwebsite\docker\dockerfile 
$ docker run -ti centos:7     
[root@8aeb9924b76c /]# exit
exit

##再一种就是不会阻塞到当前bash 进程！！！
docker run -tid centos:7
docker exec -it centos:7 bash 并不会影响到主进程！！！

## docker run -i centos:7 打开了输入但是没打开终端！！！每一个输入都是一个终端！！！
G:\cwebsite\docker\dockerfile 
$ docker run -i centos:7
hhhhhshshs
/bin/bash: line 1: $'hhhhhshshs\r': command not found

/bin/bash: line 2: $'\r': command not found
hhh
ls
/bin/bash: line 7: $'ls\r': command not found
`````



````shell
### docker exec container_name  是创建一个进程然后进去；退出并不会影响到主进程的运行！！！！
````

