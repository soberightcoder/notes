# php基础操作kafka





https://blog.csdn.net/qq_19634033/article/details/115337987



本文对php操作kafka的方法做一个记录，备忘。

 

一、搭建kafka集群
下载kafka并解压：

tar -xzf kafka_2.13-2.7.0.tgz
搭建单机集群：


cd kafka_2.13-2.7.0
#创建两个broker配置并修改端口
cp config/server.properties config/server-1.properties 
cp config/server.properties config/server-2.properties
编辑拷贝的两个配置文件以下配置：

````shell
config/server-1.properties: 
    broker.id=1 
    listeners=PLAINTEXT://:9093 
    log.dir=/tmp/kafka-logs-1

config/server-2.properties: 
    broker.id=2 
    listeners=PLAINTEXT://:9094 
    log.dir=/tmp/kafka-logs-2
#通过不同配置运行三个brocker
````


#启动zookeeper
bin/zookeeper-server-start.sh config/zookeeper.properties &

#启动broker
bin/kafka-server-start.sh config/server.properties &
bin/kafka-server-start.sh config/server-1.properties &
bin/kafka-server-start.sh config/server-2.properties &
在集群上创建新的topic，备份设置为3

bin/kafka-topics.sh --create --zookeeper localhost:2181 --replication-factor 3 --partitions 1 --topic test-topic
生产消息：





````shell
bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test-topic
 ...

> my test message 1
> my test message 2
> ^C
> 消费消息：
# --bootstrap-server 引导程序 
> bin/kafka-console-consumer.sh --bootstrap-server localhost:9092 --from-beginning --topic test-topic
>  ...
> my test message 1
> my test message 2
> ^C
````



##二、php操作kafka
安装kafka-php，纯php客户端，无需安装rdkafka扩展

composer require nmred/kafka-php
##编写生产者：

`````php
<?php

require '../vendor/autoload.php';
date_default_timezone_set('PRC');

$config = \Kafka\ProducerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);

// 必须设置所有broker地址，否则会报错
$config->setMetadataBrokerList('localhost:9092,localhost:9093,localhost:9094');

$config->setBrokerVersion('1.0.0');
$config->setRequiredAck(1);
$config->setIsAsyn(false);
$config->setProduceInterval(500);
$producer = new \Kafka\Producer(
    function() {
        return [
            [
                'topic' => 'my-replicated-topic',
                'value' => 'test....message1.',
                'key' => 'testkey',
            ],
        ];
    }
);
$producer->success(function($result) {
    var_dump($result);
});
$producer->error(function($errorCode) {
    var_dump($errorCode);
});
$producer->send(true);
`````

##编写消费者：



```php
<?php

require '../vendor/autoload.php';
date_default_timezone_set('PRC');
$config = \Kafka\ConsumerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);
$config->setMetadataBrokerList('localhost:9092');
$config->setGroupId('test');
$config->setBrokerVersion('1.0.0');
$config->setTopics(['my-replicated-topic']);
$config->setOffsetReset('earliest');
$consumer = new \Kafka\Consumer();
$consumer->start(function($topic, $part, $message) {
    var_dump($message);
});
#经测试，代码运行正常，更多操作方式请参考 nmred/kafka-php 的pacagist或github官方说明
```





