# redis的超时处理







# [phpRedis超时梳理(转)](https://www.cnblogs.com/huanxiyun/articles/5702797.html)



如果phpRedis的connect的timeout参数设置了值，getTimeout()和getReadTimeout()都是这个值。

subscribe()的超时，会是这个值的2倍。

如果connect的timeout设置了0，永不超时，subscribe()的超时为php.ini里面的default_socket_timeout的两倍。

如果在超时时间内，没有publish到channel的话，subscribe就会报read error on connection。

所以，应该在connect的时候，timeout为小值，比如0.2，在subscribe前，

**$redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);**







设置为-1，0是不管用的。奇怪的是connect的时候timeout默认为0表示时间不限

如果connect的timeout传递了0，但是subscribe超时还是由default_socket_timeout说了算。

只有在
$redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);

或

default_socket_timeout设置为-1
时，才不会超时。