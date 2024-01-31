# Redis 

>  配置是 config/database.php 默认读取的default 配置的redis 文件；



`````php
如上所述，你可以在 Redis facade 上调用任意 Redis 命令。Laravel 使用魔术方法将命令传递给 Redis 服务器，因此只需传递 Redis 命令所需的参数即可：

#Redis::set('name', 'Taylor');

#$values = Redis::lrange('names', 5, 10);
或者，你也可以使用 command 方法将命令传递给服务器，它接受命令的名称作为其第一个参数，并将值的数组作为其第二个参数：


#$values = Redis::command('lrange', ['name', 5, 10]);
使用多个 Redis 连接
你可以通过 Redis::connection 方法获得 Redis 实例：

#$redis = Redis::connection();
这会返回一个默认的 Redis 实例。你可以传递连接或者集群名称给 connection 方法来获取在 Redis 配置中特定服务或集群：

3$redis = Redis::connection('my-connection');

管道命令
//就是原子操作；pipeline 管道批量操作；
当你需要在一个操作中给服务器发送很多命令时，推荐你使用管道命令。 pipeline 方法接受一个 Redis 实例的 闭包。你可以将所有的命令发送给 Redis 实例，它们都会在一个操作中执行完成：
Redis::pipeline(function ($pipe) {
    for ($i = 0; $i < 1000; $i++) {
        $pipe->set("key:$i", $i);
    }
});

`````

