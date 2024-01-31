# PDO

>**获取到pdo对象；剩下的操作都是可以用PDO来进行处理；**

`````php
    /**
     * getpdo()//获取到pdo对象；可以设置自己的属性和业务场景；
     */
    $pdo = DB::getpdo(); // PDO对象
    dump($pdo);
    $res = $pdo->query('select * from t');//这个只能看到sql语句 //PDOstatement对象；
    dump($res);
    $res = $res->fetchAll(); //二维数组的形式取数据；
    dump($res);

`````

