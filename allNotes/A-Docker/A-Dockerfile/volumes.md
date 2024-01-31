# dockerfile --- volumes

>volumes 数据卷！！！
>
>-v的两种形式
>
>* 路径绑定  path bind
>* 数据卷挂载  volume mount 

---

## test

````dockerfile
# 
#test
FROM busybox
LABEL 
VOLUME ["/data1","/data2"]  #开启了两个数据卷！！
#docker build -t test:1 .
````





````shell
  docker run  -tid test:1
  "Mounts": [
            {
                "Type": "volume",
                "Name": "67bf06684efaa7380aeea182d4de33135ab0b950f2b9028143f4a3350f930f46",
                "Source": "/var/lib/docker/volumes/67bf06684efaa7380aeea182d4de33135ab0b950f2b9028143f4a3350f930f46/_data",
                "Destination": "/data1",
                "Driver": "local",
                "Mode": "",
                "RW": true,
                "Propagation": ""
            },
            {
                "Type": "volume",
                "Name": "5a4c79b3c8111975465c11c1911c4d04c943c21e2b2ae7efc98424405218de1f",
                "Source": "/var/lib/docker/volumes/5a4c79b3c8111975465c11c1911c4d04c943c21e2b2ae7efc98424405218de1f/_data",
                "Destination": "/data2",
                "Driver": "local",
                "Mode": "",
                "RW": true,
                "Propagation": ""
            }
            
 # 因为没有进行宿主机的映射，所以这是一个匿名的数据卷！！！
 # 
````



````shell
G:\website\docker-lnmp
$ docker stop 6737
6737
#停止
````



```shell
 docker run -tid test:1
```

````shell
   "Mounts": [
            {
                "Type": "volume",
                "Name": "819f4de9d6cea3f3fd94db2e11032c02cd51efd82
                "Source": "/var/lib/docker/volumes/819f4de9d6cea3f
                "Destination": "/data2",
                "Driver": "local",
                "Mode": "",
                "RW": true,
                "Propagation": ""
            },
            {
                "Type": "volume",
                "Name": "a8e397d399aa9d1a17e68fcc9fc14dde28b90bedc
                "Source": "/var/lib/docker/volumes/a8e397d399aa9d1
                "Destination": "/data1",
                "Driver": "local",
                "Mode": "",
                "RW": true,
                "Propagation": ""
            }
           # 不同的挂载！！！name都是不一样的；
           G:\cwebsite\docker\dockerfile 
$ docker exec -it  ec4fc72ffd77 sh
/ # ls
bin    data1  data2  dev    etc    home   proc   root   sys    tmp    usr    var
/ # cd data1/
/data1 # ls
/data1 # ls
/data1 # 
## 并不是同一个数据卷！！！  所以data1下面并不会有内容！！！！
````



````shell
$ docker volume ls
DRIVER              VOLUME NAME
local               2948e36adb4fb09128840b182b6d8b7ffa3a8a63282e760a7545d39695db6d1a
local               53eb7cf2ea99d55eefe7715e9ebe91ba8577ea861a1df4d1c88a6546afd15197
local               5a4c79b3c8111975465c11c1911c4d04c943c21e2b2ae7efc98424405218de1f
local               67bf06684efaa7380aeea182d4de33135ab0b950f2b9028143f4a3350f930f46
local               7618518cfa3b6bc019c853254b1c4438344ef95c3bfffc05622cb5794a17830c
local               819f4de9d6cea3f3fd94db2e11032c02cd51efd82e147f50b931a4ca2f23c9e4
local               9482fff304caf178857b904a66089e9f30cae20d78ebf97bb10d9d3e179d6673
local               a8e397d399aa9d1a17e68fcc9fc14dde28b90bedc0090cdf8d77c36408ddea5d
local               c26cb29d648830ebba846e1da0fe78d09e7d02a6344354c1a61c41aba9480388
local               eef5190d7848b053c1ba6dc7bbe8d18b20cb2672953b2f374c6c927099bbcc10
local               kafka_kafka_0_data
local               kafka_kafka_1_data
local               kafka_kafka_2_data
local               kafka_zookeeper_data
local               linuxc
# 然后我在创建一个容器 这个容器 会继承，第一个test:1容器的数据卷，看一下  我第一个test:1容器的数据卷数据还存不存在？？？
$ docker run -tid -v 67bf06684efaa7380aeea182d4de33135ab0b950f2b9028143f4a3350f930f46:/data1 test:1
# 使用的是第一个test 容器的数据卷，所以，

$  docker exec -it b91435fd080c sh
/ # ls
bin    data1  data2  dev    etc    home   proc   root   sys    tmp    usr    var
/ # cd data
sh: cd: can't cd to data: No such file or directory
/ # cd data1/
/data1 # ls
data1    
/data1 # 

//可以看到data1
````





`````shell
# 可以看到 
docker run -tid -v testv:/data1 test:1

$ docker volume ls
DRIVER              VOLUME NAME
local               2948e36adb4fb09128840b182b6d8b7ffa3a8a63282e760a7545d39695db6d1a
local               53eb7cf2ea99d55eefe7715e9ebe91ba8577ea861a1df4d1c88a6546afd15197
local               5a4c79b3c8111975465c11c1911c4d04c943c21e2b2ae7efc98424405218de1f
local               67bf06684efaa7380aeea182d4de33135ab0b950f2b9028143f4a3350f930f46
local               7618518cfa3b6bc019c853254b1c4438344ef95c3bfffc05622cb5794a17830c
local               819f4de9d6cea3f3fd94db2e11032c02cd51efd82e147f50b931a4ca2f23c9e4
local               8eee1273aac2af43165fd89ad3e7511ad410a1b2cbf169a20c7c933102c0d0af
local               9243a9700f19cc1da58a7409138f6e42977311a5671b4aa1fc2007be420cecd7
local               9482fff304caf178857b904a66089e9f30cae20d78ebf97bb10d9d3e179d6673
local               a8e397d399aa9d1a17e68fcc9fc14dde28b90bedc0090cdf8d77c36408ddea5d
local               c26cb29d648830ebba846e1da0fe78d09e7d02a6344354c1a61c41aba9480388
local               eef5190d7848b053c1ba6dc7bbe8d18b20cb2672953b2f374c6c927099bbcc10
local               kafka_kafka_0_data
local               kafka_kafka_1_data
local               kafka_kafka_2_data
local               kafka_zookeeper_data
local               linuxc
local               testv
# -v 可以给一个数据卷起名字，也可以做到宿主机目录的映射！！！ 

## 也可以通过--volumes-from container_name 多个容器共享数据卷！！！ eg 在下面；
`````







## docker-compose

````shell
//也可以给数据卷起一个名字；在docker-compose 中；   
// 具体可以看看docker-kafka 那一章节的内容！！！
### 生成容器的时候才可以给 数据卷起名字对吗？？？？
###docker run -v 就是给容器起一个名字；
volumes:
      - kafka_1_data:/bitnami/kafka  
          volumes:
  zookeeper_data:
    driver: local
  kafka_0_data:
    driver: local
  kafka_1_data:
    driver: local
  kafka_2_data:
    driver: local
        
        docker-compose ports
       # 才是真正的向外暴漏的端口；
       # expose 仅仅是声明；
      #    ports:
#      - "2181"

##启动的依赖性：
depends_on :
	- zookeeper
````





## 容器之间挂载点的共享！！

**三、容器共享卷（挂载点）**

docker run --name test1 -it myimage /bin/bash

上面命令中的 myimage是用前面的dockerfile文件构建的镜像。 这样容器test1就有了 /data1 和 /data2两个挂载点。

下面我们创建另一个容器可以和test1共享 /data1 和 /data2卷 ，这是在 docker run中使用 --volumes-from标记，如：

可以是来源不同镜像，如：

docker run --name test2 -it --volumes-from test1 ubuntu /bin/bash

也可以是同一镜像，如：

docker run --name test3 -it --volumes-from test1 myimage /bin/bash

上面的三个容器 test1 , test2 , test3 均有 /data1 和 /data2 两个目录，且目录中内容是共享的，任何一个容器修改了内容，别的容器都能获取到。

 

**四、最佳实践：数据容器**

如果多个容器需要共享数据（如持久化数据库、配置文件或者数据文件等），可以考虑创建一个特定的数据容器，该容器有1个或多个卷。

**其它容器通过--volumes-from 来共享这个数据容器的卷。**

因为容器的卷本质上对应主机上的目录，所以这个数据容器也不需要启动。

如： docker run --name dbdata myimage echo "data container"
