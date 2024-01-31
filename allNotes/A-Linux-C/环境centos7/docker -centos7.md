

# docker-centos7

>docker - centos7 C语言环境搭建！！！



````dockerfile
FROM centos:7
LABEL maintainer="qsw"
WORKDIR /linuxc/

RUN  sed -i 's/^tsflags/#tsflags/g' /etc/yum.conf \
     && install="vim strace man-pages man-db man make gdb gcc" \
     && yum install -y $install

# docker build -t centos7c:1 .

````

`````shell
docker build -t centos7c:1 .  # 创建一个镜像！！linuxc练习的镜像；
`````



````shell
#创建一个容器 centos7支持多线程的容器！！！  linux 上，支持的多线程！！！！
docker run -tid --name centos7c --restart=always -v G:\cwebsite\linuxc\:/linuxc/ --cap-add=SYS_PTRACE --security-opt seccomp=unconfine centos7c:1 bash 
## windwos for docker
docker run -tid --name centos7c --restart=always -v G:\cwebsite\linuxc\:/linuxc/  --cap-add=SYS_PTRACE centos7c:1 bash 
````



```shell
# 容器支持多线程的写法； // 这是linux的写法！！！！！！
docker run --cap-add=SYS_PTRACE --security-opt seccomp=unconfine
```



`````c
docker-compose.yml
security_opt:
  - seccomp:unconfined
cap_add:
  - SYS_PTRACE
`````



## docker run 来实现， 只用dockerfile 就行了！！ 省的下一次再用类似的镜像！！！

>summary：doker-compose 不能一直作为容器一直运行，centos 已经运行完了，已经结束了！！！
>
>centos 要一直运行，需要docker run -ti 来实现的一直运行，需要交互，才会一直运行；

If your Dockerfile doesn't do anything (for example a webserver to listen on port 80), it will be discarded as soon as it finishes running the instructions. Because [Docker containers should be "ephemeral"](https://docs.docker.com/engine/articles/dockerfile_best-practices/).

If you just want to start a container and interact with it via terminal, don't use `docker-compose up -d`, use the following instead:

```yaml
docker run -it --entrypoint=/bin/bash [your_image_id]
```

This will start your container and run `/bin/bash`, the `-it` helps you keep the terminal session to interact with the container. When you are done doing your works, press `Ctrl-D` to exit.



## ssh

服务器安装 ssh 需要暴露 22端口才能链接；
