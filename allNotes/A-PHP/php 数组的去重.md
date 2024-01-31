# php 数组的去重

>可以看到，通过两次翻转，重复的值被去除，得到了一个去重后的数组。
>
>需要注意的是，这种方法只适用于值是唯一的情况。如果数组中存在重复的值，只有第一个出现的值会被保留，后续的重复值会被忽略。
>
>`````php
>array_flip() //两次翻转来实现去重！！
>//两次翻转确实会达到这个效果！！
>`````
>
>

`````php
##使用array_flip 对数组翻转,翻转后的值就是不重复的值得index，unset掉原数组这些index,剩下的就是重复的了

##不引新的变量

microtime();
function findDuplicates($nums) {
    foreach(array_unique($nums) as $k => $v)
    {
        unset($nums[$k]);
    }
    return $nums;
}
//找到重复的数值；
## array_unique在处理数据上性能不好，就用array_flip替代了


 ## 求重复的数值；求重复的；// 很别出心裁；
// 注意求重复的；把不重复的去掉剩下的就是重复的；
function findDuplicates($nums) {
    foreach(array_flip($nums) as $k => $v)
    {
        unset($nums[$v]);
    }
    return $nums;
}
$arr1 = [1, 2, 3, 3];
#------------------------------------------
// var_dump(array_flip($arr1));die;
function findDuplicate($arr1)
{
    foreach (array_flip($arr1) as $k => $v) {
        unset($arr1[$v]);
    }
    //重复两个的可以试试！！！三个就算了！！！！
    return $arr1;
}
var_dump(findDuplicate($arr1));
#----------------------------------------------
// 测试
//直接去重就行了；
// 时间复杂度是O(n)
// 空间复杂度是O(n)
$len = count($arrf);
for ($i = 0; $i < $len; $i++) {
    $arrres[$arrf[$i]] = 1;
}

var_dump($arrres);
var_dump(array_keys($arrres));die;
    
 ##  

`````

