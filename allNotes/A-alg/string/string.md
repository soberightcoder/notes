# 

#  字符串 的算法

> 关于字串的滑动窗口
>
>

---



## 滑动窗口

>先移动 右指针，然后不满足，然后移动左指针直到满足情况，返回结果；

**滑动窗口算法的思路是这样：**

*1*、我们在字符串 S 中使用双指针中的左右指针技巧，初始化 left = right = 0，把索引闭区间 [left, right] 称为一个「窗口」。

*2*、我们先不断地增加 right 指针扩大窗口 [left, right]，直到窗口中的字符串符合要求（包含了 T 中的所有字符）。

*3*、此时，我们停止增加 right，转而不断增加 left 指针缩小窗口 [left, right]，直到窗口中的字符串不再符合要求（不包含 T 中的所有字符了）。同时，每次增加 left，我们都要更新一轮结果。

*4*、重复第 2 和第 3 步，直到 right 到达字符串 S 的尽头。

这个思路其实也不难，**第 2 步相当于在寻找一个「可行解」，然后第 3 步在优化这个「可行解」，最终找到最优解。**左右指针轮流前进，窗口大小增增减减，窗口不断向右滑动。





```php
## 伪代码的模板;
//
string s, t;
// 在 s 中寻找 t 的「最小覆盖子串」
int left = 0, right = 0;
string res = s;
// 先移动 right 寻找可行解
while(right < s.size()) {
    window.add(s[right]); 
    right++;
    // 找到可行解后，开始移动 left 缩小窗口
    while (window 符合要求) {
        // 如果这个窗口的子串更短，则更新结果
        res = minLen(res, window);
        window.remove(s[left]);
        left++;
    }
}
return res;
```



### 计算长度

从0,或者1开始计算长度 等于 \$right - \$left + 1  ？？？？  这是怎么计算出来的？//todo 

````php
````





---

## 案例：

>滑动窗口

````php
##
/**
 * leetcode - 3. 无重复字符的最长子串
 */
/**
 * leetcode - 3. 无重复字符的最长子串
 * time O(n)  // 遍历一遍
 * space O(n) //set 来判断是重复；
 */

class Solution {

    /**
     * @param String $s
     * @return Integer
     */

    function lengthOfLongestSubstring($s) {

        $len = strlen($s);
//        if ($len == 0) return 0;
        $left = $right = 0;
        $max = 0;
        $set = [];// O(n)

        while ($right <= $len - 1) {
            //提前结束
            if ($max + $left >= $len) {
                break;
            }
            // repeat
            if (isset($set[$s[$right]])) { //这里有问题；
                //从左边 移除；
                //移除数组
                unset($set[$s[$left]]);
                $left++;//会一直有问题
            } else {
                // 只有增加的收才会发现 有没有最大值；
                $max = max($right - $left + 1,$max);
                $set[$s[$right]] = 1;
                $right++;
            }
        }
        return $max;
    }

}
$str = "abcabcbb";
$obj = new Solution();
echo $obj->lengthOfLongestSubstring($str);
````







````php
# --leetcode  209
````

