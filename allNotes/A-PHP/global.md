# global 特性





```php
/**
 * global 的违法性
 *函数内要想访问外部变量只能通过 global  $GLOBALS
 */


$aglobal = 1;
// 外部变量
$bglobal = 2;

function globaltest() {
    global $aglobal;// 通过指针来实现的；ptr；
    $aglobal = 3;
    $middle = 2;

    $aglobal = &$middle; // 可以去改变指向；
    $GLOBALS['bglobal'] =  &$middle;

    $middle = 5;

    echo $GLOBALS['bglobal'];  //5;
    echo "\n";
    echo $aglobal;  //5
}

globaltest();
//  3,5
echo $aglobal; // 3
echo "\n";
echo $bglobal; // 5
```





##<font color=red>**这也是为什么全局变量使用 \$GLOBALS的原因；**</font>