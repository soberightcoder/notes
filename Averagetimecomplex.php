<?php
/**
 * Class Averagetimecomplex
 * 平均时间复杂度  最好时间复杂度 最坏时间复杂度
 * 当相同的代码在不同的情况会表现不同的时间复杂度量级，那么就需要用这些情况；
 */
ini_set("display_errors","On");
ini_set("error_reporting","E_ALL");

//class Averagetimecomplex
//{
//    public function main($arr,$val){
//        $len = count($arr);
//        $pos = -1;
//        for($i=0;$i<$len;$i++){
//           if($arr[$i] == $val){
//               $pos = $i;
//               break;
//           }
//        }
//        return $pos;
//    }
//}
///**
// * 找到一个数组中相同的那个值  然后返回key
// */
//$arr = [2,3,4,5,6];
//$obj =new Averagetimecomplex();
//echo $obj->main($arr,6);
//时间复杂度的计算：
// 相同的代码在不同的情况下，会表现不同的时间复杂度量级
//当最好情况 在第一个位置的时候  直接就可以找到 时间复杂度是O(1)
//当遇到最坏的情况 当整个值 不存在的时候 时间复杂度是O(n)
// 平均时间复杂度：
//落在 数组内和数组外的概率都是1/2
//当落在数组内的时候 当第一个可以找到的时候 需要执行1次 当n的时候 就是n次
//所以 平均时间复杂度 就是 1/2n + 2/2n ... + n/2n  + n/2
// = (1+n)n/2*2n +n/2  = (3n+1)/4  所以平均时间复杂度也是O(n)s
//数组 重复数
//function duplicate( $numbers )
//{
    // write code here
//    if(!is_array($numbers)) return -1;
//    $len = count($numbers);
//    $tmp = [];
//    for($i=0;$i<$len;$i++){
//        if(isset($tmp[$numbers[$i]])){
//            $tmp[$numbers[$i]]+=1;
//            break;
//        }else{
//            $tmp[$numbers[$i]] = 1;
//        }
//    }
//    return $tmp[count($tmp)];
//    foreach($tmp as $key=>$val){
//        if($val >= 2){
//            echo $key;
//            break;
//        }
//    }
//    $len = count($numbers);
//    if(empty($numbers)) return -1;
//    if(!is_array($numbers)) return -1;
    //重组数组
//    foreach($numbers as $key=>$val){
//        if($val == $key){
//            continue;
//        }else{
//            if($numbers[$val] == $val){
//                return $val;
//            }else{
//                $tmp = $numbers[$val];
//                $numbers[$val] = $val;
//                $numbers[$key] = $tmp;
//            }
//        }
//    }
//    /**
//     *时间复杂度 是O(n)  空间复杂度是O(1) 原地操作；
//     */
//    for($i = 0;$i < $len;){
//       if($i == $numbers[$i]){
//           $i++;
//           continue;
//       }else{
//           if($numbers[$i] == $numbers[$numbers[$i]]){
//               return $numbers[$i];
//           }else{
//               $tmp = $numbers[$numbers[$i]];
//               $numbers[$numbers[$i]] = $numbers[$i];
//               $numbers[$i] = $tmp;
//           }
//       }
//    }
//    //  没有重复的值；
//    return -1;
//}
//$arr =[2,1,3,1,4];
//echo duplicate($arr);
//continue  跳出本次循环；
//break 是跳出整个循环体；
//foreach($arr as $key=>$val){
//    echo $key,$val;
//}
//$ceshiarr = [0,1,2];
//foreach($ceshiarr as $val){
//    var_dump(current($ceshiarr));
//}
//foreach($ceshiarr as $key=>$val){
//    var_dump(Current($ceshiarr));
//}

//foreach($ceshiarr as $key => $val){
//    $ceshiarr[$key] = 1;
//    var_dump($val);
//}
//var_dump($ceshiarr);
// 指针操作；
//1.key();从关联数组中取得键名，没有取到返回NULL
//
//2.current();返回数组中当前单元
//
//3.next();将数组中的内部指针向前移动一位
//
//4.prev();将数组的内部指针倒回一位
//
//5.reset();将数组的内部指针指向第一个单元
//
//6.end();将数组的内部指针指向最后一个单元
/**
 *array 1 two-sums  https://leetcode-cn.com/problems/two-sum/
 */
// 时间复杂度是O(n^2) 空间复杂度是O(1)
//function twoSum($nums, $target) {
//    $len = count($nums);
//    for($i = 0; $i<$len;$i++){
//       $ob = $target - $nums[$i];
//       for($j=$i+1;$j < $len;$j++){
//           if($nums[$j] == $ob){
//               return [$i,$j];
//           }
//       }
//    }
//}
//php 函数，使用了数组函数 ，因为php数组的实质就是一个哈希表，所以这里的时间复杂度是O(n)空间复杂度是O(1)
//function twoSum($nums,$target){
//    $len = count($nums);
//    for($i=0;$i<$len;$i++){
//       $ob = $target - $nums[$i];
//       $nums_index = array_search($ob,$nums);
//       //注意这里 因为弱语言的关系，区分开0 和 false 的方法 就是 全等
//       if($nums_index !== false && $nums_index != $i){
//           return [$i,$nums_index];
//        }
//    }
//}
//var_dump(twoSum([3,3],6));

//  哈希表形式的计算；


//$map=[];//哈希查找表
//$nums = [2,34,5,5,3];
//foreach($nums as $key=>$item){
//    $map[$item]=$key;
//}
//var_dump($map);
// 哈希表的形式 时间复杂度是O(n) 空间也是O(n) 最优解决方案把 但是也浪费了空间；
// function twoSum($nums,$target){
//     $map = [];
//     $len = count($nums);
//     for($i=0;$i<$len;$i++){
//         $map[$nums[$i]] = $i;
//     }
//     for($i=0;$i<$len;$i++){
//         $ob = $target - $nums[$i];
//         if(isset($map[$ob]) && $map[$ob] != $i){
//             return [$i,$map[$ob]];
//         }
//     }
// }
/**
 *array 70  https://leetcode-cn.com/problems/climbing-stairs/ 爬楼梯
 * 递归的问题 就是寻找 f(n) 和 f(n-1)的关系；最后一次和前一次的关系；
 * n 代表的是阶级个数；
 * f(n) = f(n-1)+f(n-2);
 */
// 递归；时间复杂度是O(2^n) 所以效率很低
// 这里对递归做了一个缓存；
//时间复杂度是O(n) 就像一个二叉树一样，不走缓存直接走遍历是2^n的时间复杂度
//function climbStairs($n) {
//    if($n == 1 || $n ==2) return $n;
//    if(isset($cache[$n])){
//        return $cache[$n];
//    }
//    if($n > 2){
//        $res = climbStairs($n - 1) + climbStairs($n - 2);
//        $cache[$n] = $res;
//    }
//    return $res;
//}
/**
 * @param $n
 * 直接使用遍历
 * 时间复杂度是O(n);
 */
//function climbStairs($n){
//    if($n == 1 || $n ==2) return $n;
//    $a = 1;
//    $b = 2;
//    for($i = 3;$i <= $n; $i++){
//        $c = $a + $b;
//        $a = $b;
//        $b = $c;
//    }
//    return $c;
//}
//
//function climbStairs($n){
//
//}
//echo climbStairs(44);

/**
 * 283 https://leetcode-cn.com/problems/move-zeroes/
 *移动零
 * 两种常见的改变元素位置的操作，覆盖和交换；
 * https://leetcode-cn.com/problems/move-zeroes/solution/guan-yu-shuang-zhi-zhen-de-si-kao-by-che-cvau/
 */
//覆盖索引
/**
 * @param $nums
 * 向前覆盖；
 * 时间复杂度是 O(n)
 * 空间复杂度是 O(1)
 */
//function moveZeroes(&$nums) {
//    $j = 0;
//    $len = count($nums);
//    for($i = 0;$i < $len;$i++){
//         if($nums[$i] != 0){
//             $nums[$j] = $nums[$i];
//             if($i != $j){
//                 $nums[$i] = 0;
//             }
//             $j++;
//         }
//    }
//}
/**
 * 三数之和
 * 15 https://leetcode-cn.com/problems/3sum/
 */
/**
 * @param $nums
 * 暴力求解
 * php 的数组  是真牛皮
 * 利用set 集合来去重；php 函数 array_unique():
 *sort() 也是对 值的排序；  不保留索引关系； 时间复杂度是O(nlogn); 是对原数组的排序；
 * rsort(); 就是 反序，不会保留索引关系；
 * asort() 对值进行排序 会保留索引关系
 * array_map(); 对数组的val 做一个处理；
 */
// 函数去重 移除数组中重复的值；仅仅是对值的处理 跟 key 没有任何的关系；会保留以前的key索引；
//$ceshi = [[1,0,-1],[1,0,-1],[-1,0,1],[2,-1,-1]];
//$ceshi = ['a'=>'red','red','blue','b'=>'blue'];
//$res = array_unique($ceshi,SORT_REGULAR);
////sort($ceshi);
//asort($ceshi);
//var_dump($res);
//var_dump($ceshi);
//for($i=1;$i<=3;$i++){
//    $set[] = [$i];
//}
//var_dump($set);
//die;
//时间复杂度是O(n^3)
// 空间复杂度  O(n)
//function threeSum($nums) {
//    $len = count($nums);
//    if($nums == null || $len <=2) {
//        return [];
//    }
//    sort($nums);
//    for($i=0;$i<$len;$i++){
//       for($j=$i+1;$j<$len;$j++){
//           for($k=$j+1;$k<$len;$k++){
//               if($nums[$i]+$nums[$j]+$nums[$k]==0){
//                   $set[] = [$nums[$i],$nums[$j],$nums[$k]];
//               }
//           }
//       }
//    }
//    if(empty($set)){
//        return [];
//    }
//    return array_unique($set,SORT_REGULAR);
//}

/**
 * l两层循环 加哈希
 */
//function threeSum($nums) {
//    $len = count($nums);
//    if($nums == null || $len <=2) {
//        return [];
//    }
//    $map = [];
//
////    sort($nums);
//    foreach($nums as $key => $val){
//        $map[$val] = $key;
//    }
//    for($i=0;$i<$len;$i++){
//       for($j=$i+1;$j<$len;$j++){
//               if(isset($map[-$nums[$i] -$nums[$j]]) && $map[-$nums[$i] -$nums[$j]] !=$i && $map[-$nums[$i] -$nums[$j]] != $j){
//                   $mid = [$nums[$i],$nums[$j],$nums[$map[-$nums[$i] -$nums[$j]]]];
//                   sort($mid);
//                   $str = implode('.',$mid);
//                   $set[$str] = true;
//               }
//       }
//    }
//    if(empty($set)){
//        return [];
//    }
//    $set = array_keys($set);
//    var_dump($set);
//   return array_map(function ($val){
//       return explode('.',$val);
//    },$set);
//    var_dump($set);
//    return array_unique($set,SORT_REGULAR);
//}

//$test = [];
//$str = '';
//空数组 和null 并不是全等的；
//if($test == null){
//    echo "空数组是null";
//}
// 并不全等；
//if($str == null){
//    echo "str is null";
//}
//// undefined;
//if($unde === null){
//    echo 'undefined';
//}
//die;

/**
 * @param $nums
 * 双指针；
 * 左指针；$i  右指针  $j
 * 1. 排序
 * 2. $nums[$k] > 0  []    去重 重复 contiue
 * 3. 双指针 夹逼  夹逼条件  $j > $i
 * 4. 最后 $i $j 的去重；
 * 时间复杂度是O(n^2)   空间复杂度是O(n)
 */


//function threeSum($nums) {
//    $len = count($nums);
//    if(empty($nums) || $len < 3){
//        return [];
//    }
//    sort($nums); // 用有序 来进行去重；有序的
//    $res = []; //初始值当是[0,1,1] 那么显示的就是
//    for($k=0;$k<$len;$k++){
//        // 当$nums[$k] > 0 肯定不可能成功的；
//        $i = $k + 1;
//        $j = $len -1;
//        if($nums[$k] > 0) break;
//        // 重复进行下一次循环；这次循环和上一次是相同的直接跳过；
//        if($k > 0 && $nums[$k] == $nums[$k - 1]) continue;
//        while($j > $i){
//           $sum = $nums[$k] + $nums[$i] + $nums[$j];
//           if($sum == 0){
//               $res[] = [$nums[$k],$nums[$i],$nums[$j]];
//               // 去重
//
////               while($j > $i && $nums[$i] == $nums[++$i]);
////               while($j > $i && $nums[$j] == $nums[--$j]);
////                 while (left < right && nums[left] == nums[left-1])  left++;
////                 while (left < right && nums[right] == nums[right+1])    right--;
//               while($j > $i){
//                   $i++;
//                   if($nums[$i] == $nums[$i -1]){
//                      continue;
//                   }
//                   break;
//               }
//               while($j > $i){
//                   $j--;
//                   if($nums[$j] == $nums[$j+1]){
//                       continue;
//                   }
//                   break;
//               }
//           }elseif($sum > 0){
//               $j--;
//           }else{
//               $i++;
//           }
//        }
//    }
//    return $res;
//}
//$ceshi = [-1,0,1,2,-1,-4];
//var_dump(threeSum($ceshi));

/**
 * 11  https://leetcode-cn.com/problems/container-with-most-water/
 * 暴力求解o
 * 时间复杂度是O(n^2)
 * 空间复杂度是O(1)
 */

//function maxArea($height) {
//    $len = count($height);
//    $res = 0;
//    if(!$height && $len < 2) return [];
//    // 注意这边的 $len -1  如果是$len 那么还会内循环的判断；
//    for($i = 0;$i < $len - 1;$i++){
//        for($j = $i + 1;$j < $len;$j++){
//            $sum = ($j - $i) * min($height[$i],$height[$j]);
//            if($sum > $res) $res = $sum;
//        }
//    }
//    return $res;
//}

/**
 * 双指针 夹逼
 * 选两边即是 宽度最长的，如果高度也比我低 那么肯定会比我小；
 * 指针移动问题，较小的去移动；
 *  夹逼 使用 while 还是很多的 但是完全可以和 for 来进行替换
 * 时间复杂度是 O(n)
 * 空间复杂度是O(1)
 */

//function maxArea($height) {
//    $len = count($height);
//    $max = 0;
//    if(!$height && $len < 2){
//        return $max;
//    }
//    $left = 0;
//    $right = $len - 1;
//    while($right > $left){
//        $min_height = $height[$left] > $height[$right] ? $height[$right--] : $height[$left++];
//        $res = ($right - $left + 1) * $min_height;
//        $max = max($max,$res);
//    }
//    return $max;
//}

// 空对象 不存在空对象这个说法；
//class Obj{
//
//}
//$obj = new Obj();
//var_dump($obj);
//unset($obj); // unset 对象变为null 对象；
//if($obj == null){
//    echo "k空对象";
//}
//die;


/**
 *206  https://leetcode-cn.com/problems/reverse-linked-list/
 * 反转链表；
 * $head 是一个head 指针；
 * 迭代的方法
 * 时间复杂度是O(n)
 * $prev 分别代表两个链表的当前结点；
 */
//function reverseList($head) {
//    $curr = $head;
//    $prev = null;
//    while($curr != null){
//       $next = $curr->next;
//       $curr->next = $prev;
//       $prev = $curr;
//       $curr = $next;
//    }
//    return $prev;
//}
/**
 * 递归
 *
 */
//function reverseList($head) {
//    // head == null 链表  只有一个元素的链表 就是反序的  $head->next == null
//    if($head == null || $head->next == null) return $head;
//    // head 后面问题的递归，这个$p 代表 反正完成反序的链表；
//    $p = reverseList($head->next);
//    $head->next->next = $head;
//    $head->next = null;
//    return $p;
//}

/**
 * 141 https://leetcode-cn.com/problems/linked-list-cycle/
 * 判断一个链表是否有环； hascycle
 * 时间复杂度是O(n)
 * 因为需要一个map 所以空间复杂度是O(n)
 */
//class Ceshi{
//
//}
//$obj = new Ceshi;
//$ceshi = [];
//$n1 = 'cunzai';
// // debug-isset
//if(isset($ceshi[$obj])){
//    echo "cunzai";
//}else{
//    echo "bu cunzai ";
//}
//if(isset($ceshi[$n1])){
//    echo "exist";
//}

//die;
// php中 不能使用实例化的对象，作为数组的索引； key 不能使用 数组 或者对象；
// Illegal offset type in XXX
//php提示错误：Illegal offset type in XXX，导致这个错误的原因是不能使用实例化的对象来作为数组的索引，请检查数组变量的键名是否使用了实例化的对象变量或数组。

// 判断一个对象是否是相等的问题  ==  和 全等===的问题
//class Ceshiprev
//{
//    public $prev = 0;
//}
//class Ceshi{
//    public $age;
//    public $prev;
//    public function __construct($age,$obj) {
//      $this->age = $age;
//      $this->prev = $obj;
//    }
//    public function test(){
//       echo "ceshi";
//    }
//}
//$objprev = new Ceshiprev;
//$obj0 = new Ceshi(10,$objprev);
//$obj1 = new Ceshi(10,$obj0);
////$obj2 = $obj1;
//$obj2 = new Ceshi(10,$obj0);
//if($obj1 !== $obj2){
//    echo "不相等";
//}else{
//    echo "相等";
//}
//if($obj1 != $obj2){
//    echo "no 相等";
//}else{
//    echo " 相等";
//}
//$obj1= new Ceshi(10);
//$obj2 = new Ceshi(10);
//var_dump($obj1);
//var_dump($obj2);
//if($obj1 != $obj2){
//    echo "budengyu";
//}
//if($obj1 == $obj2){
//   echo "obj1 == obj2";
//}elseif($obj1 === $obj2){
//    echo "obj1 === obj2";
//}else{
//    echo "wuguan";
//}
//$obj3 = $obj1;
//if($obj3 === $obj1){
//    echo 'obj1 === obj3';
//}
//die;
////function hasCycle($head) {
//    // 不能实现的原因 php 不能把 对象当成索引；
//    //map的索引；不能是对象 in_array();  array_search();  然后都不行 ，因为php数组 中  不能把数组 或者一个对象当成索引；
//    $set = [];
//    if($head->next == null || $head == null) return false;
//    while($head != null){
//        if(isset($set[$head])) return true;
//        $set[$head->val] = $head;
//        $head = $head->next;
//    }
//    return false;
//}
/**
 * 双指针，快慢指针；
 * 来解决有没有环的问题；
 * php 就用这个方法把
 *   如果两个对象共享一个属性作为其值，PHP将在这些属性对象之间进行相同的==比较。现在，只要这些属性对象是递归的(例如，自引用对象)，比较也会向下递归，直到达到最大嵌套级别
 *   就是自引用对象相互比较的时候要是使用 === 代替 ==  引用对象比较的时候需要用 === 来代替 ==
 */
// 数组
// Fatal error: Nesting level too deep - recursive dependency?
//$arr0 = [1,2,3,4];
//$arr1  = ['1',2,3,&$arr0];
//$arr2 = [1,2,3,&$arr0];
//// 数组 这里不能比较；循环嵌套引用；
//if($arr1 === $arr2){
//   echo "相等";
//}else{
//    echo "不相等";
//}
//if($arr1 == $arr2){
//    echo "相等";
//}

//测试 对象的比较 == 属性数据类型不相同 会发生什么
//class Ceshi111
//{
//    public $num;
//    public function __construct($num) {
//        $this->num = $num;
//    }
//}
//$obj11 = new Ceshi111(1);
//$obj22 = new Ceshi111('1');
//if($obj11 === $obj22){
//    echo "相等";
//}else{
//    echo "不相等；";
//}
//die;
// int bool str float 数组  对象 资源 null
//function hasCycle($head) {
//    if($head->next == null || $head == null) return false;
//    $low = $head;
//    $fast = $head->next;
//    // 相遇  只有 === 才会回到原点 === 全等才代表回到了原点； ==  可能不是原点；
//    //  $fast = $fast->next->next;  注意这里别再写错了；；；
//    while($low !== $fast){
//        if($fast == null || $fast->next == null ) return false;
//        $fast = $fast->next->next;
//        $low = $low->next;
//    }
//    return true;
//}


/**
 * 142 --- https://leetcode-cn.com/problems/linked-list-cycle-ii/
 * 问题 ：1.链表是否有环； 2. 链表有环的入口；
 **** 注意相遇点 并不是环的入口
 *  对象与对象的比较 需要用  ===  但是 对象与null的比较完全没必要用 ===
 *
 */

//function detectCycle($head) {
//    $low = $head;
//    $fast = $head;
//    while($fast != null && $fast->next != null){
//        $fast = $fast->next->next;
//        $low = $low->next;
//        if($low === $fast){
//            $index1 = $fast;
//            $index2 = $head;
//            while($index2 === $index1){
//                $index1 = $index1->next;
//                $index2 = $index2->next;
//            }
//        }
//    }
//    return null;
//}

/***
 * @param $head
 * @return null
 * leetcode  z这个题就有问题；
 */
//function detectCycle($head) {
//    if($head->next == null || $head == null) return null;
//    $low = $head;
//    $fast = $head->next->next;
//    // 相遇  只有 === 才会回到原点 === 全等才代表回到了原点； ==  可能不是原点；
//    //  $fast = $fast->next->next;  注意这里别再写错了；；；
//    while($low !== $fast){
//        if($fast == null || $fast->next == null ) return null;
//        $fast = $fast->next->next;
//        $low = $low->next;
//    }
//
//    $fast = $head;
//    while($low !== $fast){
//       $fast = $fast->next;
//       $low = $low->next;
//    }
//    return $fast;
//}
/***
 * 20  https://leetcode-cn.com/problems/valid-parentheses/
 * 有效的括号
 * 典型的栈操作
 * 时间复杂度是 O(n)  空间复杂度是O(n)  + 使用哈希表占用的时间复杂度；
 */
//function isValid($s) {
//    $len = strlen($s);
//    if($len == 0) return true;
//    $brack = [')'=>'(',"}"=>"{","]"=>"["];
//    $stack = [];
//    $top = -1;  // 来记录栈顶index 索引；
//    for($i = 0;$i < $len ;$i++){
//        if(!empty($stack) && $brack[$s[$i]] == $stack[$top]) {
//            array_pop($stack);
//            $top--;
//        }else{
//            array_push($stack,$s[$i]);
//            $top++;
//        }
//    }
//
//    return empty($stack) ? true : false;
//}
//$ceshi = "";
//var_dump(isValid($ceshi));

/**
 * 155 - https://leetcode-cn.com/problems/min-stack/
 * 最小栈的问题；  栈 最小值的问题 ，当栈内的元素删除的时候 删除的那个有可能是一个最小值，所以这里用了辅助栈，最顶端的就是最小值，
 */

//class MinStack
//{
//    public $stack = [];
////    public $top = -1;
//    // 辅助栈
//    public $minstack = [];
////    public $mintop = -1;
//
//    /**
//     */
//    function __construct() {
//    }
//
//    /**
//     * @param Integer $val
//     * @return NULL  NULL 是没有返回
//     */
//    function push($val) {
//        array_push($this->stack, $val);
//        if (empty($this->minstack) || $this->minstack[count($this->minstack) - 1] >= $val) { //沙雕；
//            array_push($this->minstack, $val);
//        }
//
//    }
//
//    /**
//     * @return NULL
//     */
//    function pop() {
//        if (!empty($this->stack)) {
//            $out = array_pop($this->stack);
//            if ($this->minstack[count($this->minstack) - 1] == $out) {
//                array_pop($this->minstack);
//            }
//        }
//
//    }
//
//    /**
//     * @return Integer
//     */
//    function top() {
//        return $this->stack[count($this->stack) - 1];
//    }
//
//    /**
//     * @return Integer
//     */
//    function getMin() {
//        return $this->minstack[count($this->minstack) - 1];
//    }
//}

/**
 * 239  https://leetcode-cn.com/problems/sliding-window-maximum/
 * 滑动窗口问题，固定的滑动窗口；
 */
//$ceshi = [];
//echo count($ceshi);
//die;
// 执行效率太低了
//
//function maxArr($arr){
//   $len = count($arr);
//   $max = $arr[0];
//   if($len == 1) return $max;
//   for($i = 1; $i<$len ;$i++){
//        if($arr[$i] > $max){
//           $max = $arr[$i];
//        }
//    }
//   return $max;
//}
//function maxSlidingWindow($nums, $k) {
//    if(empty($nums)) return null;
//    $len = count($nums);
//    $head = 0;
//    $tail = $k -1;
//    $res = [];
//    if($len <= $k){
//        sort($nums);
//        $res[] = $nums[$len -1];
//        return $res;
//    }
//    for($i = 0; $i<$k; $i++){
//        $queue[] = $nums[$i];
//    }
//    $res[] = maxArr($queue);
//    while($tail + 1 <= $len -1){
//        $tail = $tail + 1;
//        $head = $head + 1;
//        array_shift($queue);
//        array_push($queue,$nums[$tail]);
//        $res[] = maxArr($queue);
//    }
//    return $res;
//维护一个单调 递减的双端队列；
//维护一个单调递减的双端队列

//function maxSlidingWindow($nums, $k) {
//    if(empty($nums)) return null;
//    $len = count($nums);
//    if($len  < $k) {
//        sort($nums);
//        return $nums[$len - 1];
//    }
//
//}
//maxSlidingWindow([1,2,33,4],8);





/**
 * 242 - - https://leetcode-cn.com/problems/valid-anagram/description/
 * 哈希表
 *  空间复杂度相对高了一些 其实维护一个26个小写字母的hashmap就可以了
 *s
 */
//直接 i++  就可以了
//$ceshi++;
//$ceshi1--;
//var_dump($ceshi1); // null  还是null  输出还是null的 但是  一开始是null可以++的； 很坑。。。。
//echo $ceshi; //  1   结果是1
//if( null == 0){
//    echo "相等的";
//}
//die;
//function isAnagram($s, $t) {
//    $lens = strlen($s);
//    $lent = strlen($t);
//    $smap = [];
//    $tmap = [];
//    for($i = 0;$i<$lens;$i++){
////       if(isset($smap[$s[$i]])){
//           $smap[$s[$i]]++ ;
////       }else{
////           $smap[$s[$i]] = 1;
////       }
//    }
//    for($j = 0;$j<$lent;$j++){
////        if(isset($tmap[$t[$j]])){
//            $tmap[$t[$j]]++;
////        }else{
////            $tmap[$t[$j]] = 1;
////        }
//    }
//    return $tmap == $smap ? true : false;
//}
/**
 * @param $s
 * @param $t
 * 维护一个哈希表；上面的空间有点浪费 维护了两个长度是26符号表；
 */
//function isAnagram($s, $t) {
//    $map = [];
//    $lens = strlen($s);
//    $lent = strlen($t);
//    if($lens != $lent) return false;
//    for($i=0;$i<$lens;$i++){
//       $map[$s[$i]] ++;
//    }
//    for($j=0;$j<$lent;$j++){
//        if(isset($map[$t[$j]])){
//            $map[$t[$j]]--;
//        }else{
//            $map[$t[$j]] = -1;
//        }
//    }
//    $lenm = count($map);
//    //关联变量的遍历一定要用  foreach
//    foreach($map as $value){
//        if($value != 0) return false;
//    }
//    return true;
//}
//$s = "anagram";
//$t = "nagaram";
//$s = "rat";
//$t = "car";
//var_dump(isAnagram($s,$t));
//xdebug_var_dump(isAnagram($s,$t));
//echo memory_get_usage();
/**
 * 49 --- https://leetcode-cn.com/problems/group-anagrams/
 *  字母的异位词分组；
 *
 */
// 把每一个字母都划分成在一个数组内 一般配合sort 使用 然后  implode 再转化为字符串就是对字符串的排序；
//$ceshi = "ceshi";
//var_dump(str_split($ceshi));
////var_dump($ceshi);
//die;
//function groupAnagrams($strs) {
//    $map = [];
//    foreach($strs as $val){
//        $arr = str_split($val);
//        sort($arr);
//        $tmp_str = implode("",$arr);
//        $map[$tmp_str] = $val;
//    }
//    return array_values($map);
//}
/**
 * 实现阶乘 n!
 *   1.递归结束的条件
 *  2. a 与 子问题的bcd的关系 假设子问题已经解决(factorial($n -1 )  == (n-1)!)  也就是  n 与 n-1  这个子问题的关系；
 * 3.   输出 结果 return
 */
//function factorial($n){
//    if($n == 1 || $n == 0) return $n;
//    return $n*factorial($n -1);
//}

//echo factorial(5);
//echo factorial(1);
//echo factorial(3);
//echo factorial(0);
/**
 * array_merge(): 索引数组重新排列；相同的key 后面的会替换前面的；
 * array+ array;  //  不论索引和关联 相同的key保留前面的；
 * array_combine();
 */

//$ceshi = [1,3,3,4];
//$ceshi1 = [1,2,3,4,5];
////var_dump(array_merge($ceshi,$ceshi1));
//var_dump($ceshi + $ceshi1);
/**
 * bst binary search tree
 * find  查找
 */

class TreeNode
{
   public $val;
   // 这两个节点 分别用来保存 节点对象;
   public $left;
   public $right;
   public function __construct($val) {
       $this->val = $val;
   }
}
//             13
//        10         16
//    9      11   14
$a = new TreeNode(13);
$b = new TreeNode(10);
$c = new TreeNode(16);
$d = new TreeNode(9);
$e = new TreeNode(11);
$f = new TreeNode(14);
// root == $a;
$a->left =  $b;
$b->left = $d;
$b->right = $e;
$a->right = $c;
$c->left = $f;
/**
 * @param $root
 * bst的中序遍历 会是一个有序的数组
 */
//function inorderTraversal($root){
//   static $res = [];
//   if($root == null) return [];
//   inorderTraversal($root->left);
//   $res[] = $root->val;
//   inorderTraversal($root->right);
//   return $res;
//}
//var_dump(inorderTraversal($a));
//die;

function inorderTraversal($root){
    if($root == null) return [];
    inorderTraversal($root->left);
    echo $root->val."--";
    inorderTraversal($root->right);
}
//inorderTraversal($a);



/**
 * find  查找  search
 * //注意这个问题 一定不要用 回调 因为他不会一直 因为找到的时候 直接返回；
 * z注意 treeNode 仅仅是一个节点；
 * 类似于 二分查找 时间复杂度是logn == height
 */

//警戒自己 一定不要用 递归；因为这个 只需要递的过程就可以得到结果；
//if($a instanceof TreeNode){
//    echo  " instance of ";
//}
//die;
//function findBinary($a,$val){
//    if($a == null) return null;
//    while($a != null){
//       if($val > $a->val){
//           $a = $a->right;
//       }elseif($val < $a->val){
//           $a = $a->left;
//       }else{
//           return $a;
//       }
//    }
//    return null;
//}
//var_dump(findBinary($a,10));
// 递归的方式
//function findBinary($root,$val){
//    if($root == null) return null;
//    if($root->val > $val) return findBinary($root->left,$val); // 大于$val 从左子树找到
//    if($root->val < $val) return findBinary($root->right,$val); //小于从右子树找到；
//    return $root;  // == 就是root点；
//}
//var_dump(findBinary($a,10));
/**
 * insert bst  不存在重复的数据
 * c
 */
//$new_node = new TreeNode(17);
//function insertBinary($a,$val){
//    while($a != null){
//        if($val->val >= $a->val ){
//           if(!isset($a->right)){
//              $a->right = $val;
//              break;
//           }else{
//               $a = $a->right;  //存在节点检查下一个节点
//           }
//        }else{
//           if(!isset($a->left)){
//               $a->left = $val;
//               break;
//           }else{
//               $a = $a->left;
//           }
//
//        }
//    }
//}
//insertBinary($a,$new_node);
////查看一下中序遍历是否是有序的；
//插入的递归操作
//function insertBinary($root,$val){
//    if($root == null) return new TreeNode($val);// 没有左节点 或者没有右节点；
//
//    if($root->val > $val) $root->left = insertBinary($root->left,$val); //返回的是root->left 子树
//    if($root->val < $val) $root->right =  insertBinary($root->right,$val);
//    //这边仅仅是一个输出而已；
//    return $root;  //  其实这个retrun  确实运行了很多次；除了叶子节点其他的都需要用这个；
//}
//insertBinary($a,17);
//inorderTraversal($a);
/**
 * 删除 bst delete
 */

// 不递归 一定要明白 root 仅仅是一个节点；
//inorderTraversal($a);
/**
 *  得到递归树的最大值；
 */
//function maxBst($root){
//   while($root->right != null){
//       $root = $root->right;
//   }
//  return $root;
//}
//var_dump(maxBst($a));
//die;
//function deleteBst($root,$val){
//   while($root != null){
//       if($root->val == $val){
//          if($root->left == null && $root->right == null){
//             $root = null;
//             break;
//          }
//          if($root->left == null && $root->right != null){
//              $root = $root->right;
//          }
//       }elseif($root->val > $val){
//          $root = $root->left;
//       }else{
//          $root = $root->right;
//       }
//   }
//}


/**
 * 迭代法 来实现二叉树的遍历
 * 94 ---- https://leetcode-cn.com/problems/binary-tree-inorder-traversal/
 */
//function inorderTraversaldie($root) {
//    if($root == null) return null;
//    $stack = [$root];
//    if()
//
//}