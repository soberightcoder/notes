# php对象传递的是引用 

>不需要返回这个值；我们也可以接收到；
>
>



`````php
/**
 * z注意 php 传输的是引用
 */


class Ceshi456
{
    public $name;
}
$obj = new Ceshi456;
//传递的是引用； 不需要返回数据的；
function ceshi($obj) {
    $obj->name = 'aaaa';
}
ceshi($obj);
echo $obj->name;  // aaaa




//  引用 不需要用return 来传递数值； 不需要回数据； 我们调用函数也不需要接收数据；

/**
 * z注意 php 传输的是句柄；
 *句柄就是操作 对象的权限；通过这个句柄就可以操作对象；
 */


class Ceshi456
{
    public $name;
}
$obj = new Ceshi456;
//传递的是引用； 不需要返回数据的；
function sum($obj) {
    $sum = 0;
    for ($i=1; $i <=10; $i++) {
        ceshi($obj);//引用
        $sum = $sum + $obj->name;
    }
    return $sum;
}

function ceshi($obj) {
    $obj->name = rand(1,200);
}
var_dump(sum($obj));die;  //1062;
`````



