# 算法 algorithm(剑指offer)

---

##位运算

````php
// 位运算  & | ^ >> <<
#编写一个函数，输入是一个无符号整数（以二进制串的形式），返回其二进制表达式中数字位数为 '1' 的个数（也被称为 汉明重量).）。
# 判断 一个数值是奇数或者偶数直接和1进行&就行 如果是1那么就是奇数 是0就是偶数，一个整数的最后一位决定了这个数是奇数或者是偶数
#时间复杂度：O(n) 空间复杂度:O(1)
class Alg{

    public function ammingWeight($weight){
        $count=0;
        while ($weight){
            if($weight & 1) $count++;
            $weight = $weight>>1;
        }
        return $count;
    }
}
$ceshi = new Alyin
echo $ceshi->ammingWeight(5);
````

