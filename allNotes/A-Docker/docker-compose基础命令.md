# docker-compose 基础操作和命令

>docker-compose.yml 
>
>**基础格式：**
>
>**字典格式(:) 和 数组格式(-) 后面都要加一个 空格**
>
> `````compose.yml
> image: nginx
> 
> volumes: 
> - ./ceshi:/ceshi/
> - ./ceshi1:/ceshi1/
> `````
>
> 

Compose 中有两个重要的概念： 服务 ( service )：一个应用的容器，实际上可以包括若干运行相同镜像的容器实例。 项目 ( project )：由一组关联的应用容器组成的一个完整业务单元，在 dockercompose.yml 文件中定义。



## 安装

``````php
 # 安装 docker-compose
 sudo curl -L https://github.com/docker/compose/releases/download/1.17.1/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
$ sudo chmod +x /usr/local/bin/docker-compose
``````



##  compose 命令	

> <font color=red>**对于 Compose 来说，大部分命令的对象既可以是项目本身，也可以指定为项目中的服务或者**
> **容器。**</font>
>
> <font color=red>**如果没有特别的说明，命令对象将是项目，这意味着项目中所有的服务都会受到命令**
> **影响。**</font>

`````php

执行 docker-compose [COMMAND] --help 或者 docker-compose help [COMMAND] 可以查看具体某
个命令的使用格式。
docker-compose 命令的基本的使用格式是
docker-compose [-f=<arg>...] [options] [COMMAND] [ARGS...]
    
#命令选项 options 
-f, --file FILE 指定使用的 Compose 模板文件，默认为 docker-compose.yml ，可以
多次指定。
 // 前缀名字
-p, --project-name NAME 指定项目名称，默认将使用所在目录名称作为项目名。
    
--x-networking 使用 Docker 的可拔插网络后端特性
--x-network-driver DRIVER 指定网络后端的驱动，默认为 bridge
--verbose 输出更多调试信息。
-v, --version 打印版本并退出。
    

#command 
 command
覆盖容器启动后默认执行的命令。
command: echo "hello world"   
    
#config   ## 查看格式问题，那里的问题；
验证 Compose 文件格式是否正确，若正确则显示配置，若格式错误显示错误原因。
    
# down
此命令将会停止 up 命令所启动的容器，并移除网络
    
# #restart
格式为 docker-compose restart [options] [SERVICE...] 。
重启项目中的服务。
    
#stop 
格式为 docker-compose stop [options] [SERVICE...] 。
命令说明
停止已经处于运行状态的容器，但不删除它。通过 docker-compose start 可以再次启动这些
容器。

#images
列出 Compose 文件中包含的镜像。
    
#kill
格式为 docker-compose kill [options] [SERVICE...] 。
通过发送 SIGKILL 信号来强制停止服务容器。
支持通过 -s 参数来指定发送的信号，例如通过如下指令发送 SIGINT 信号。
$ docker-compose kill -s SIGINT

#logs
格式为 docker-compose logs [options] [SERVICE...] 。
 
#pause
格式为 docker-compose pause [SERVICE...] 。
暂停一个服务容器。
    
#unpause
格式为 docker-compose unpause [SERVICE...] 。
恢复处于暂停状态中的服务。

#ps
格式为 docker-compose ps [options] [SERVICE...] 。
列出项目中目前的所有容器。
选项：
-q 只打印容器的 ID 信息。
    
#rm
# docker-compose rm -v container_name
rm
格式为 docker-compose rm [options] [SERVICE...] 。
删除所有（停止状态的）服务容器。推荐先执行 docker-compose stop 命令来停止容器。
选项：
-f, --force 强制直接删除，包括非停止状态的容器。一般尽量不要使用该选项。
-v 删除容器所挂载的数据卷。
    
 #top
查看各个服务容器内运行的进程。
    
# run   #运行服务上的某一个容器  在上面运行命令；
格式为 docker-compose run [options] [-p PORT...] [-e KEY=VAL...] SERVICE [COMMAND]
[ARGS...] 。
在指定服务上执行一个命令。
例如：
$ docker-compose run ubuntu ping docker.com
将会启动一个 ubuntu 服务容器，并执行 ping docker.com 命令。
默认情况下，如果存在关联，则所有关联的服务将会自动被启动，除非这些服务已经在运行
中。
该命令类似启动容器后运行指定的命令，相关卷、链接等等都将会按照配置自动创建。
两个不同点：
给定命令将会覆盖原有的自动运行命令；
不会自动创建端口，以避免冲突。
如果不希望自动启动关联的容器，可以使用 --no-deps 选项，例如
$ docker-compose run --no-deps web python manage.py shell
将不会启动 web 容器所关联的其它容器。
选项：
-d 后台运行容器。
--name NAME 为容器指定一个名字。
--entrypoint CMD 覆盖默认的容器启动指令。
-e KEY=VAL 设置环境变量值，可多次使用选项来设置多个环境变量。
-u, --user="" 指定运行容器的用户名或者 uid。
--no-deps 不自动启动关联的服务容器。## depend依赖或者关联的服务；
--rm 运行命令后自动删除容器， d 模式下将忽略。
-p, --publish=[] 映射容器端口到本地主机。
--service-ports 配置服务端口并映射到本地主机。
-T 不分配伪 tty，意味着依赖 tty 的指令将无法运行。
    
# scale
 scale
格式为 docker-compose scale [options] [SERVICE=NUM...] 。
设置指定服务运行的容器个数。
通过 service=num 的参数来设置数量。例如：
$ docker-compose scale web=3 db=2
将启动 3 个容器运行 web 服务，2 个容器运行 db 服务。
一般的，当指定数目多于该服务当前实际运行容器，将新创建并启动容器；反之，将停止容
器。
选项：
-t, --timeout TIMEOUT 停止容器时候的超时（默认为 10 秒）。
    
#up
格式为 docker-compose up [options] [SERVICE...] 。
#该命令十分强大，它将尝试自动完成包括构建镜像，（重新）创建服务，启动服务，并关联服务相关容器的一系列操作。
    
链接的服务都将会被自动启动，除非已经处于运行状态。
可以说，大部分时候都可以直接通过该命令来启动一个项目。
默认情况， docker-compose up 启动的容器都在前台，控制台将会同时打印所有容器的输出信
息，可以很方便进行调试。
当通过 Ctrl-C 停止命令时，所有容器将会停止。
 
###===================================================================================================
#如果使用 docker-compose up -d ，将会在后台启动并运行所有的容器。一般推荐生产环境下使用该选项。 
#默认情况，如果服务容器已经存在， docker-compose up 将会尝试停止容器，然后重新创建（保持使用 volumes-from 挂载的卷），以保证新启动的服务匹配 docker-compose.yml 文件的最新内容。
#如果用户不希望容器被停止并重新创建，可以使用 docker-compose up --no-recreate 。这样将只会启动处于停止状态的容器，而忽略已经运行的服务。
#如果用户只想重新部署某个服务，可以使用 docker-compose up --no-deps -d <SERVICE_NAME> 来重新创建服务并后台停止旧服务，启动新服务，并不会影响到其所依赖的服务。
    
## 现在 只需要 docker-compose up -d  并不会重建容器；如果文件修改之后，那么容器将会重新创建；
    
##---------------------------------------------------------------------------------------------------
  -d 在后台运行服务容器。
--no-color 不使用颜色来区分不同的服务的控制台输出。
#--no-deps 不启动服务所链接的容器。
--force-recreate 强制重新创建容器，不能与 --no-recreate 同时使用。
--no-recreate 如果容器已经存在了，则不重新创建，不能与 --force-recreate 同时使
用。
--no-build 不自动构建缺失的服务镜像。
-t, --timeout TIMEOUT 停止容器时候的超时（默认为 10 秒）。
   
    
##### docker-compose --version
    
## docker-compose exec -it 也是进入某一个容器；
`````



## docker-compose 模板指令

><font color=red>**注意一下，数字,false,true,yes,no 都需要加双引号；不然有可能会报错；**</font>
>
><font color=red>理解一下，数组和字典的两种模式</font>>
>
>* 字典：  通过 ： 来区别；前面不需要加-；
>
>* 数组： 通过 -  来区别，如果存在key=value的形式需要用=；
>
>  **数组和字典那里有案例；**
>
>----
>
>

`````php

#build  dockerfile 来创建一个模板就可以了

指定 Dockerfile 所在文件夹的路径（可以是绝对路径，或者相对 docker-compose.yml 文件
的路径）。 Compose 将会利用它自动构建这个镜像，然后使用这个镜像。
version: '3'
services:
webapp:
build: ./dir
你也可以使用 context 指令指定 Dockerfile 所在文件夹的路径。
使用 dockerfile 指令指定 Dockerfile 文件名。
使用 arg 指令指定构建镜像时的变量。
Compose 模板文件
171
version: '3'
services:
webapp:

build:
context: ./dir
dockerfile: Dockerfile-alternate
args:
buildno: 1
使用 cache_from 指定构建镜像的缓存
build:
context: .
cache_from:
- alpine:latest
- corp/web_app:3.14

# command 容器的执行命令
覆盖容器启动后默认执行的命令。
command: echo "hello world"
#depends_on
#解决容器的依赖、启动先后的问题。以下例子中会先启动 redis db 再启动 web
 version: '3'
services:
web:
build: .
depends_on:
- db
- redis
redis:
image: redis
db:
image: postgres
#注意： web 服务不会等待 redis db 「完全启动」之后才启动。

#container_name  容器名字
 指定容器名称。默认将会使用 项目名称_服务名称_序号 这样的格式。
container_name: docker-web-container
#注意: 指定容器名称后，该服务将无法进行扩展（scale），因为 Docker 不允许多个容器具有相同的名称。

#environment
 environment
#设置环境变量。你可以使用数组或字典两种格式。
只给定名称的变量会自动获取运行 Compose 主机上对应变量的值，可以用来防止泄露不必要的数据。
    
environment:
RACK_ENV: development
SESSION_SECRET:
environment:
- RACK_ENV=development
- SESSION_SECRET
 
#如果变量名称或者值中用到 true|false，yes|no 等表达 布尔 含义的词汇，最好放到引号里，避免 YAML 自动解析某些内容为对应的布尔语义。这些特定词汇，包括Compose 模板文件
#y|Y|yes|Yes|YES|n|N|no|No|NO|true|True|TRUE|false|False|FALSE|on|On|ON|off|Off|OFF

# expose
#暴露端口，但不映射到宿主机，只被连接的服务访问。
#仅可以指定内部端口为参数
expose:
- "3000"
- "8000"
    
#ports 
orts
暴露端口信息。
Compose 模板文件
使用宿主端口：容器端口 (HOST:CONTAINER) 格式，或者仅仅指定容器的端口（宿主将会随机
选择端口）都可以。
ports:
- "3000"
- "8000:8000"
- "49100:22"
- "127.0.0.1:8001:8001"
###注意：当使用 HOST:CONTAINER 格式来映射端口时，如果你使用的容器端口小于 60 并且没放到引号里，可能会得到错误结果，因为 YAML 会自动解析 xx:yy 这种数字格式为 60 进制。为避免出现这种问题，建议数字串都采用引号包括起来的字符串格式。
    
#image
指定为镜像名称或镜像 ID。如果镜像在本地不存在， Compose 将会尝试拉去这个镜像。
image: ubuntu
image: orchardup/postgresql
image: a4bc65fd
    
#labels
为容器添加 Docker 元数据（metadata）信息。例如可以为容器添加辅助说明信息。
labels:
com.startupteam.description: "webapp for a startup team"
com.startupteam.department: "devops department"
com.startupteam.release: "rc3 for v1.0"

 #links  使用 networks 来通信；
注意：不推荐使用该指令。

 #network_mode
设置网络模式。使用和 docker run 的 --network 参数一样的值。
network_mode: "bridge"
network_mode: "host"
network_mode: "none"
network_mode: "service:[service name]"
network_mode: "container:[container name/id]"
    
#networks
配置容器连接的网络。
version: "3"
services:
some-service:

networks:
- some-network
- other-network
    
networks:
some-network:
other-network:
#-----------------------------
networks:
      ruoyi_net:
        ipv4_address: 172.30.0.92
 
networks:
  ruoyi_net:
    driver: bridge
    ipam:
      config:
        - subnet: 172.30.0.0/16
#-------------------------------
 ##volumes
 volumes
数据卷所挂载路径设置。可以设置宿主机路径 （ HOST:CONTAINER ） 或加上访问模式（ HOST:CONTAINER:ro ）。
 ##该指令中路径支持相对路径。
volumes:
- /var/lib/mysql
- cache/:/tmp/cache
- ~/configs:/etc/configs/:ro
`````





## 数组 和字典

数组：数组用方括号（[]）表示，里面的每一项用逗号（,）隔开。python允许数组里面任意的放置数字和字符串。数组下表是从0开始，所以，list[0]会输出数组中的第一项。

```
1 lists = [1,2,3,'a',5]
2 lists
3 [1,2,3,'a',5]
4 
5 list[0] 
6 1
```

 

字典：字典用花括号（{}）表示，里面的项成对出现，一个key对应一个vaule。key和value之间用冒号（:）分隔，不用项之间用逗号（,）分隔。

```
1 dicts = {"username":"zhangsan","password":123456}
2 dicts.keys()
3 {"username","password"}
```



`````php
#docker-compose  -  代表的就是关联数组 索引数组；
#key:value  代表的是字典，就是php中的关联数组；

#environment:
	-ceshi=ceshi1
	-ceshi1=ceshi2
#environment:
      ceshi:ceshi
      ceshii:ceshi
    
`````



## depends_on的深度理解

``````php
#depends_on
#depends_on

#解决容器的依赖、启动先后的问题。以下例子中会先启动 redis db 再启动 web
``````



## 深度解析 doceker-compose up -d

`````php
docker-compose up -d

    docker-compose up 命令在以下场景下会重新创建容器：

//初次运行：当你第一次运行 docker-compose up 命令时，它会创建并启动所有在 docker-compose.yml 文件中定义的服务的容器。

//配置更改：如果你对 docker-compose.yml 文件进行了更改，例如修改了容器的配置或添加了新的服务，再次运行 docker-compose up 命令会重新创建受影响的容器。

//强制重新创建：你可以使用 --force-recreate 参数来强制重新创建所有容器。这将会停止并删除现有的容器，然后重新创建它们。
//--build 需要重新创建 dockerfile   build       Build or rebuild services
显式指定服务名称：如果你只想重新创建特定的服务容器，可以在 docker-compose up 命令后面指定服务名称。例如，docker-compose up service1 service2 只会重新创建 service1 和 service2 两个服务的容器。

//请注意，重新创建容器会导致容器内的数据丢失，因此在进行这些操作之前，请确保你已经备份了重要的数据。
`````





##  字典（map）和数组

>字典就是map  php中的关联数组；
>
>php中的关联数组，底层实质就是哈希表；
>
>平常我们说的数组，仅仅是c语言中的数组，只能保存同一种数据类型的数组；
>
>php的索引数组，可以保存php中的不同数据类型，但是在c层面来说，都是zval这种结构体，属于同一种数据类型；
