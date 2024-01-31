# php 唯一id



关于生成唯一数字ID的问题，是不是需要使用rand生成一个随机数，然后去数据库查询是否有这个数呢？感觉这样的话有点费时间，有没有其他方法呢？

当然不是，其实有两种方法可以解决。

  `````php
  //  uniqid  +  加随机数；
  `````



\1. 如果你只用php而不用数据库的话，那时间戳+随机数是最好的方法，且不重复；

``````php
md5(uniqid(mt_rand(), true));
``````



\2. 如果需要使用数据库，即你还需要给这个id关联一些其他的数据。那就给MySQL数据库中的表的id一个AUTO_INCREMENT（自增）属性，每次插入一条数据时，id自动+1，然后使用mysql_insert_id()或LAST_INSERT_ID()返回这个自增后的id。

``````
``````



当然，这个问题已经有现成的解决方法了，使用php uuid扩展就能完美解决这个问题，这个扩展能生成唯一的完全数字签名。。

如果你不使用composer请参考https://github.com/lootils/uuid，

如果你的项目是基于composer搭建的，那么请参考https://github.com/ramsey/uuid

具体的源码我就不搬运了，小伙伴们自己取下来就可以直接使用了

PHP生成唯一标识符代码示例：

```php

//生成唯一标识符  
//sha1()函数， "安全散列算法（SHA1）"  
function create_unique() {  
$data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']  
.time() . rand();  
return sha1($data);  
//return md5(time().$data);  
//return $data;  
}
```