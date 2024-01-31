

# shell and exec

>两种CMD的格式！！！
>
>要想不出错，最好使用exec格式，也就是json格式！！

----

````dockerfile
CMD ["tail","-f","xxx.txt"] == >主进程就是tail -f xxx.txt
# exec 模式，不会通过shell调用，注意：因此并不会替换命令中的shell变量$HOME之类的shell变量；
cmd tail -f xxx.txt  ==> /bin/bash -c tail -f xxx.txt 主进程是/bin/bash -c .fork 出子进程然后执行tail -f xxx.txt;
#shell 模式，使用/bin/bash -c 来启动进程tail -f xxx.txt,这带来的影响是，容器的信号优先发送到sh,所以导致无法优雅的退出！！
# 注意 第一中就是exec 模式
# 第二种是shell形式，这种产生的容器，docker stop container_name 会失败；你需要使用 docker kill container_name
#  因为我们sto'p信号是发给的是bash，tail -f xxx.txt没有接收到，所以只能使用强硬手段，杀死！！来结束容器；
````

