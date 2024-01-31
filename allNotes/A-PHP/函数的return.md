#  函数的return

>**return 代表的是函数的结束；** 
>
>**函数运行完 ： 默认返回的是return null；**
>
>**在递归的时候 当函数运行完也就是默认返回了NULL；**
>
>

`````php
/**
 *  return
 */

function  rest() {
    return 123;
}
function ret2() {//return null;//默认会返回 NULL

}
var_dump(rest());
var_dump(ret2());// null

`````

