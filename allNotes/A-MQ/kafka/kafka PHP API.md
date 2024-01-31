#  kafka php API

>Rdkafka API；

`https://github.com/arnaud-lb/php-rdkafka`

https://arnaud.le-blanc.net/php-rdkafka-doc/phpdoc/book.rdkafka.html



---



源码安装
下载地址： http://pecl.php.net/package/rdkafka
本次安装PHP5.6、PHP7.4的扩展，使用的rdkafka4.1

`````
git clone https://github.com/arnaud-lb/php-rdkafka.git
cd php-rdkafka
/data/soft/php56/bin/phpize # 如果只跑一个版本php直接运行 phpize, 多版本需要指定phpize
make && make install
`````

````php
php.ini 添加配置
extension=rdkafka.so
````





`````
重启php-fpm
ps -ef | grep php-fpm | grep master

# 平滑重启

kill -SIGUSR2 ${pid}
`````



php -m | grep rdkafka
-----------------------------------
PHP rdkafka扩展安装




---





