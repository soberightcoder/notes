# docker-kafka

````php
version: "2"

services:
  zookeeper:
    image: docker.io/bitnami/zookeeper:3.8
#    ports:
#      - "2181"
    environment:
      - ALLOW_ANONYMOUS_LOGIN=yes
    volumes:
      - zookeeper_data:/bitnami/zookeeper

  kafka-0:
    image: docker.io/bitnami/kafka:3.3
    container_name: kafka-0
    hostname: kafka-0
#    ports:
#      - "9092"
    environment:
      - KAFKA_CFG_ZOOKEEPER_CONNECT=zookeeper:2181
      - KAFKA_CFG_BROKER_ID=0
      - ALLOW_PLAINTEXT_LISTENER=yes
      - KAFKA_CFG_LISTENER_SECURITY_PROTOCOL_MAP=INTERNAL:PLAINTEXT,EXTERNAL:PLAINTEXT
      - KAFKA_CFG_LISTENERS=INTERNAL://:9092,EXTERNAL://0.0.0.0:9093
      - KAFKA_CFG_ADVERTISED_LISTENERS=INTERNAL://kafka-0:9092,EXTERNAL://localhost:9093
      - KAFKA_CFG_INTER_BROKER_LISTENER_NAME=INTERNAL
    volumes:
      - kafka_0_data:/bitnami/kafka
    depends_on:
      - zookeeper

  kafka-1:
    image: docker.io/bitnami/kafka:3.3
    container_name: kafka-1
    hostname: kafka-1
#    ports:
#      - "9092"
    environment:
      - KAFKA_CFG_ZOOKEEPER_CONNECT=zookeeper:2181
      - KAFKA_CFG_BROKER_ID=1
      - ALLOW_PLAINTEXT_LISTENER=yes
      - KAFKA_CFG_LISTENER_SECURITY_PROTOCOL_MAP=INTERNAL:PLAINTEXT,EXTERNAL:PLAINTEXT
      - KAFKA_CFG_LISTENERS=INTERNAL://:9092,EXTERNAL://0.0.0.0:9094
      - KAFKA_CFG_ADVERTISED_LISTENERS=INTERNAL://kafka-1:9092,EXTERNAL://localhost:9094
      - KAFKA_CFG_INTER_BROKER_LISTENER_NAME=INTERNAL
    volumes:
      - kafka_1_data:/bitnami/kafka
    depends_on:
      - zookeeper

  kafka-2:
    image: docker.io/bitnami/kafka:3.3
    container_name: kafka-2
    hostname: kafka-2
#    ports:
#      - "9092"
    environment:
      - KAFKA_CFG_ZOOKEEPER_CONNECT=zookeeper:2181
      - KAFKA_CFG_BROKER_ID=2
      - ALLOW_PLAINTEXT_LISTENER=yes
      - KAFKA_CFG_LISTENER_SECURITY_PROTOCOL_MAP=INTERNAL:PLAINTEXT,EXTERNAL:PLAINTEXT
      - KAFKA_CFG_LISTENERS=INTERNAL://:9092,EXTERNAL://0.0.0.0:9095
      - KAFKA_CFG_ADVERTISED_LISTENERS=INTERNAL://kafka-2:9092,EXTERNAL://localhost:9095
      - KAFKA_CFG_INTER_BROKER_LISTENER_NAME=INTERNAL
    volumes:
      - kafka_2_data:/bitnami/kafka
    depends_on:
      - zookeeper

  nginx:
    container_name: nginx-kafka
    hostname: nginx
    image: nginx:1.22.0-alpine
    volumes:
    - ./nginx/nginx.conf:/etc/nginx/nginx.conf:ro
    ports:
    - "9093-9095:9093-9095"
    depends_on:
      - kafka-0
      - kafka-1
      - kafka-2


volumes:
  zookeeper_data:
    driver: local
  kafka_0_data:
    driver: local
  kafka_1_data:
    driver: local
  kafka_2_data:
    driver: local

````









-----

## linux  虚拟机 要关闭防火墙；



docker启动时出现open() “/usr/local/openresty/nginx/conf/nginx.conf“ failed (13: Permission denied)

2020/07/03 16:03:06 [emerg] 1#1: open() "/usr/local/openresty/nginx/conf/nginx.conf" failed (13: Permission denied)
可是看nginx.conf的权限, 所有人都有读权限啊:

[root@anti-03 config]# ls -l
total 20
-rw-rw-rw-. 1 root root 6450 Jul 3 15:59 nginx.conf
-rw-r--r--. 1 root root 4483 Nov 2 2019 nginx.conf.all_proxy
-rwxr-xr-x. 1 root root 266 Nov 2 2019 switch_conf.sh
一番百度,发现是enforce没有关闭导致的. 可以用下面命令临时关闭

**setenforce 0**

防火墙要关闭；

如果要永久关闭,可以

修改/etc/selinux/config 文件

将SELINUX=enforcing改为SELINUX=disabled

重启机器即可

----

