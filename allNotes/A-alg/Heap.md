# Heap

> ---
>
> cornor case 边界条件；
>
> 利用堆的有序性；可以迅速的找到最大值和最小值；ding
>
> 定义： 任意一个子树的结点都大于或者小于他的头结点，分为小顶堆和大顶堆；
>
> **注意这里和数组里面的值是有序的有很大的区别，注意和单调队列的区别！**
>
> ---
>
> 
>
> 堆的定义：
>
> pd = priority queue  应用； 底层就是堆来实现的；优先队列；
>
> 优先队列 priority queue； 
>
> 优先队列还是用数组来保存的；比较节约内存；也就是index = 0 的位置就是最大值或者是最小值；
>
> 
>
> **我们平常说的优先队列，一般就是大顶堆或者小顶堆；删除的时候只能删除0的 位置的数组； 毕竟是一个队列； 优先队列；队列只能做 push 和shift的操作；**
>
> 当有数据插入的时候需要堆化，自下往上的堆化；过程；当栈顶删除的时候，需要自上往下的堆化；注意这两种的堆化方式基本就掌握了堆；



### 堆结构

**前置知识：**

**二叉树**：每一个节点都分为左右节点；

**满二叉树**：除了叶子节点，每一个节点都会有左右节点；

**完全二叉树：满二叉树+叶子节点靠左排序；如果一个树是完全二叉树，那么使用数组存储方式是最节约内存的；**

<font color=red>  除了叶子节点树是一个满二叉树，并且叶子节点靠左排序；</font>



---



**存储：完全二叉树的存储；**

 **一般用数组来保存；节约内存； 因为是完全二叉树；**

<font color=red>**规律： i是node结点；左：i*2+1 ；右：i\*2+2 ;                         父结点： i-1/2(默认是向下取整)**</font>

**完全二叉树 可以使用 数组来存储 节约内存 会节省2/3的内存；**  指针的大小是8个字节；







堆的概念：大根堆或者是小根堆； 堆是一个完全二叉树；

堆 特殊的树

很重要的定义：堆是有序性的，是有序的；

**大根堆：完全二叉树中每一颗子树的最大值值都是头节点值；**  每一颗子树都满足这个条件； 大于等于也不违规；

**小根堆：完全二叉树中每一颗子树的最小值都是头**；小于等于也不违规；



**注意： 大根堆和小根堆都是一个完全二叉树，所以添加数据元素的时候要从左边到右边的添加，并且有一个干父的逻辑；**

**大根堆干父逻辑（和父亲比较大于父亲就交换，直到我比父亲小）直到0或者干不过了位置；**灭爸原理；霜之哀伤；



<font color=red>用数组来实现一个堆结构：</font>

**最坏的情况递归树变成了线性表；这时候时间复杂度是O(n^2)**



`````php
$heapsize = 0; // 数组的index = 0无元素； 代表heap的长度！！！！

// 大根堆结构；
//堆两个操作                 的时间复杂度 
// heapInsert   上浮；		logn === 树高有关 只跟父亲比 其实logn不是固定的；会发生变化的，并不一定会升上去；
// heapify  下沉； 		logn === 树的高度有关；只跟左右孩子中最大的孩子比较；仅仅是添加了一个小常数的操作；
//
// heapSort 时间复杂度是O(nlogn)  上下限都是nlogn  空间复杂度是O(n)  //需要额外额内存O(1)； 稳定；

 //堆是不稳定的，当有一个栈顶输出之后，后面的相同的数值会到栈顶；而不是第二个；
//堆排序是不稳定的：
//比如：3 27 36 27，
//如果堆顶3先输出，则，第三层的27（最后一个27）跑到堆顶，然后堆稳定，继续输出堆顶，是刚才那个27，这样说明后面的27先于第二个位置的27输出，不稳定。
//我举一个比较极端的例子。如果数组中的数据原来已经是有序的了，比如 1，3，5，6，8。如果我们每次选择最后一个元素作为 pivot（中心点），那每次分区得到的两个区间都是不均等的。我们需要进行大约 n 次分区操作，才能完成快排的整个过程。每次分区我们平均要扫描大约 n/2 个元素，这种情况下，快排的时间复杂度就从 O(nlogn) 退化成了 O(n2)。
//// 快排是一个前序递归；
// 上面是快排的退化！！！ 什么情况会回退到O(n^2)的情况！为什么是O(n^2)? 
// 上面为什么是O(n^2)的解答：数的高度变成了 n  不再是Logn 但是每层的时间复杂度是n，都需要遍历，所以时间复杂度是n^2 ;仅仅是树的高度变高了而已；

//  归并是一个后序递归；// 归并有一个merge的过程；也就是有序数组的合并；//所以需要额外O(n) 去做有序数组的合并；
 
/**
 * 堆的结构和堆排序；
 */

class Heap
{
    protected $heap = [];
    protected $heapSize = 0;//index  可以用于软删除 -1 null 代表的是存储的数据个数  注意但是 数组存储数据是从0开始的；
                            // heapsize 下一个要add的数组的key；也是 数组的长度；
    
    protected $is_full;  // 在计算topk的时候需要；  
    
    public function __construct($heap = []，$heapSize) {
        $this->heap = $heap;
        $this->heapSize
    }

    public function add($num) {
        //  这里必须要这样 因为需要覆盖；
        $this->heap[$this->heapSize] = $num;
        $this->heapSize++;
        $this->heapInsert($this->heapSize - 1);// heapSize 新添加的元素的index；
    }

    /**
     * @param $index
     * *** 上浮的过程；
     * 新添加的值的index索引；
     * 灭爸原理；大于父亲就要灭爸；
     * 上浮的过程；
     *  
     */
    public function heapInsert($index) {
        //index == 0 也满足 不会出现0 的情况 index = 0的时候也停止循环；
        // 确实不如我的父亲大 ，也会停止；
        // 只有大于的时候才会交换；等于的时候不交换 ，所以堆排序是稳定的；
        // 为了保证稳定性 只需要大于的时候 交换就好了；
        while ($this->heap[($index - 1)/2] < $this->heap[$index]) {
            swap($this->heap[($index - 1)/2],$this->heap[$index]);
            $index = ($index - 1)/2;
        }
    }

    /**
     *  *** heapify  下沉的过程；
     * 注意要配和heapsize  数组的大小；
     * 先比较孩子 拿最大的那个孩子和父亲交换；
     * 停止跳条件，最大的孩子没有我大，或者没有孩子了；
     */
    public function heapify($index) {
        $left = $index * 2 + 1;
        // todo  $left < $this->>heapSize ;
        while ($left < $this->heapSize) {
            // 孩子的最大值; 较大孩子的坐标给largest
            $largest = $left + 1 < $this->heapSize && $this->heap[$left + 1] > $this->heap[$left] ? $left + 1 : $left;
            // 孩子和父亲的比较  孩子和父亲较大的坐标给largest；
            $largest = $this->heap[$largest] > $this->heap[$index] ? $largest : $index;
            // 相等； 直接退出；
            if ($largest == $index) {// 不需要向上堆化了；
                break;
            }
            // index  和  较大孩子互换；
            swap($this->heap[$largest],$this->heap[$index]);

            // 循环的增量条件
            $index = $largest; // 下沉；
            $left = $index * 2 + 1;

        }
    }

    /**
     * @return mixed
     * 获取 heap的而最大值；堆顶的数值；
     */
    public function peek() {
        return $this->heap[0];
    }

    /**
     * 删除 max  并返回 最大值；
     * 这里需要调整堆；
     * pop最大值   而且剩下的还可以维护成堆；
     */
    public function deleteGetMax() {
        $max = $this->heap[0];
        swap($this->heap[0],$this->heap[$this->heapSize - 1]);
        $this->heapSize--;  // 软删除 // 实际上并没有删除 添加的时候需要去覆盖；
        $this->heapify(0);// max 也就是0
        return $max;
    }

   // 查看 heap // 软删除 // client 访问的heap
    public function lookHeap() {
//        var_dump($this->heap);die;
        for ($i = 0; $i < $this->heapSize; $i++) {
            echo $this->heap[$i] . '------';
        }
    }

    /**
     * @param $heaparr
     * heapSort
     */
    public function heapSort($heaparr) {
        $len = count($heaparr);
        // 生成一个大根堆 // 时间复杂度是O(nlogn)
        for ($i = 0; $i < $len;$i++) {
            $this->add($heaparr[$i]);
        }

        while ($this->heapSize) {  // nlogn
            $this->deleteGetMax();// 仅仅是一个软删除
        }
        var_dump($this->heap);//
    }
}

// 添加元素
$obj= new Heap();
//$obj->add(10);
//$obj->add(11);
//$obj->add(9);
//$obj->add(12);
//$obj->add(10);
//echo $obj->peek();
//echo "\n";
////$obj->lookHeap();
//echo "\n";
//$obj->deleteGetMax();
//$obj->lookHeap();
//echo "\n";
//echo $obj->peek();
//// 覆盖测试 软删除
//$obj->add(19);
//echo "\n";
//echo $obj->peek();
//echo "\n";
//$obj->lookHeap();

/**
 * 堆排序 heap sort
 *
 *  就是形成一个大根堆；然后 heap[0]  和 heap[size-1]  交换  size--  直到size=0
 */
$heaparr = [1,2,34,55,5,8,10];
$obj->heapSort($heaparr);

/**
 * heap end
 * 上浮下沉过程 只能发生一个；当有数据的add时；
 */






class Heap
{
    // 注意堆是保存在数组里面
    public $heap = [];
    public $heapIndex = 0;  // index 从-1 开始比较好；正好是数组的index  -1  代表没有树， 0 就代表
    //  index =0 代表是要添加的元素index
    public $is_full = 10;

    public function __construct($heap = [],$heapIndex = 0) {
         $this->heap = $heap;
         $this->heapIndex = $heapIndex;
    }

    public function add($num) {

        $this->heap[$this->heapIndex] = $num;
        $this->heapIndex++;
        // 因为上面做了加++操作；
        $this->upheapify($this->heapIndex - 1);
    }
    // 大根堆
    // 自下向上的堆化的过程中；就是灭霸的过程；
    public function upheapify($index) {
        // 只要大于父节点就往上
        //数组直接交换就可以了！
        while ($this->heap[$index] > $this->heap[($index - 1)/2]) {
            $this->swap($this->heap[$index],$this->heap[($index - 1)/2]);
            //父节点
            $index = ($index - 1)/2;
        }
    }

    public function swap(&$a,&$b)  {
        [$a,$b] = array($b,$a);
    }
    //栈顶元素
    public function peek() {
        return $this->heap[0];
    }
    //删除栈顶 需要的下浮的过程；
    //
    public function deleteGetMax() {
        // 数组删除前面的数组 千万不要删除前面的元素 会存在数组的搬迁，
        $max = $this->heap[0];
        $this->swap($this->heap[0],$this->heap[$this->heapIndex - 1]);
        $this->heapIndex--;// 软删除  下一次直接覆盖就行

        $this->heapifydown(0);
        return $max;
    }
    /**
     * 下沉的过程
     * 这个交换元素下沉 一直下沉
     * 堆化  是结点从面的操作把 node 插入到合适的位置；
     */
    public function heapifydown($index) {
        $leftson = $index * 2 + 1;
        while ($leftson < $this->heapIndex) {
            //儿子左右节点比较
            $large = $leftson + 1 < $this->heapIndex && $this->heap[$leftson + 1] > $this->heap[$leftson] ? $leftson + 1 : $leftson;
            //儿子最大值和父亲比较
            $large = $this->heap[$large] > $this->heap[$index] ? $large : $index;
            //就是不需要下沉了找到了位置；
            if ($large == $index) {
                break;
            }
            $this->swap($this->heap[$large],$this->heap[$index]);

            $index = $large;
            $leftson = $index * 2 + 1;
        }
    }

    public function lookHeap() {
        //真实的heap
        for ($i = 0;$i < $this->heapIndex;$i++) {
            echo $this->heap[$i]."---";
        }
    }

    /**
     * @param $heap
     * @param $len
     * @return mixed
     * 时间复杂度 就是nlogn
     * 空间复杂度是O(1)
     * 稳定性是稳定的；
     */
    public function heapSort($heap,$len) {
        if ($len == 0 || $len == 1) return $heap;
        //根据数组 重建堆的过程，时间复杂度是nlogn
        $this->buildMaxHeap($heap,$len);
//        return;
        //交换
        while ($this->heapIndex > 0) {
            $this->swap($this->heap[0],$this->heap[$this->heapIndex - 1]);
            $this->heapIndex --;
            $this->heapifydown(0);
        }

    }
    // 这里怎么原地构建一个大根堆 ，根据一个数组构建一个大根堆；

    /**
     * @param $arr
     * 怎么根据一个数组创建一个初始堆
     */
    public function buildMaxHeap($arr,$len) {
        //赋值;  这里完全可以new的时候赋值
        $this->heap = $arr;
        $this->heapIndex = $len;
        //堆化// floor是向下；
        $start = floor(($len) >> 1);
        /// 只需呀堆化一般就好了；
        for ($i = $start; $i >= 0; $i--) {
            //自下网上的堆化；
            $this->heapifydown($i);
        }
    }
}

$heapObj = new Heap();

//$heapObj ->add(10);
//$heapObj ->add(11);
//$heapObj ->add(9);
//$heapObj ->add(12);
//$heapObj ->add(10);

//var_dump($heapObj->heap);die;
//$heapObj->deleteGetMax();

//$heapObj->lookHeap();
//$arr = [1,2,3,4,6,5,2,3];
//echo $len;
//var_dump($arr);

//$heapObj->heapSort($arr,$len);
//var_dump($heapObj->heap);die;
//$heapObj->lookHeap();
//$heapObj->buildMaxHeap($arr,$len);
//$heapObj->lookHeap();
//die;
//var_dump($heapObj->heap);die;
$a = 5;
$b = 2;
//echo (int)($a/$b);

`````



---



### 堆排序

````php
#堆排序
#很简单的逻辑
#给一个无序数组做排序
#看上面heapsort；

// 时间复杂度是
    /**
     * @param $heap
     * @param $len
     * @return mixed
     * 时间复杂度 就是nlogn
     * 空间复杂度是O(1)
     * 整个排序过程，包括初建堆、交换顶底元素、重建堆，未用到其他多余的空间，主要进行比较与交换工作，所以空间复杂度是O(1)
     * 堆排序不是一种稳定的排序方法。因为堆调整的过程中，关键字进行比较和交换的所走路线是沿着根结点到叶子结点，因此对于相同的关键字可能存在后面的先被交换到前面，因而堆排序不是稳定的。
     */
    public function heapSort($heap,$len) {
        if ($len == 0 && $len == 1) return $heap;
        //根据数组 重建堆的过程，时间复杂度是nlogn
        $this->buildMaxHeap($heap,$len);
//        return;
        //交换
        while ($this->heapIndex > 0) {
            $this->swap($this->heap[0],$this->heap[$this->heapIndex - 1]);
            $this->heapIndex --;
            $this->heapifydown(0);
        }

    }
    // 这里怎么原地构建一个大根堆 ，根据一个数组构建一个大根堆；

    /**
     * @param $arr
     * 怎么根据一个数组创建一个初始堆
     *  建堆  -- 注意这里创建堆，是所有的node；
     */
    public function buildMaxHeap($arr,$len) {
        //赋值;  这里完全可以new的时候赋值
        $this->heap = $arr;
        $this->heapIndex = $len;
        //堆化
        $start = floor(($len) >> 1); //创建堆；
        
        for ($i = $start; $i >= 0; $i--) {
            //自下网上的堆化；
            $this->heapifydown($i);
        }
    }
````



---



###PQ    priority queue  优先队列，TOPK的问题 ，这个完全就是堆；



优先队列特性：不再是队列的先进先出，出列按照优先级来，优先级高的先出列；

<font color=red>注意：堆，删除栈顶元素，自上而下堆化，和插入元素，都是时间复杂度是O(logn);</font>



---



#### topK： 在一个包含n个数据的数组中，查找前k大的数据；



**TopK的问题：可以维护一个headSize= k的数组；当每有一个数值插入的时候 需要和堆顶元素比较，如果大于栈顶那么就替换；**     **动态数据的处理；**

时间复杂度分析：nlogn  遍历数组的插入是n 堆化的时间复杂度是O(logn) 

//

这类型的题目分为两部分：静态数据，还有一个动态数据类型（后面会为这个堆添加新的数据）；



---

**排序算法的稳定性**

假定在待排序的记录序列中，存在多个具有相同的关键字的记录，若经过排序，这些记录的相对次序保持不变，即在原序列中，r[i]=r[j]，且r[i]在r[j]之前，而在排序后的序列中，r[i]仍在r[j]之前，则称这种[排序算法](https://baike.baidu.com/item/排序算法/5399605?fromModule=lemma_inlink)是稳定的；否则称为不稳定的。





---

map 就是哈希表 来统计出现的频率

topk的问题；我们只需要维护前k个数据就可以了，所以这里比较适合用堆；控制堆的大小；

就没有必要对所有的元素进行排序；

`````php
// 优先队列 priority queue的使用 ，大顶堆和小顶堆；
`````



----

### 建堆的两种方式



现在常有两种建堆的方法，而这两种方法又有着不同的[时间复杂度](https://so.csdn.net/so/search?q=时间复杂度&spm=1001.2101.3001.7020)。下面分别陈述：

（1）自顶向下的建堆方式

一个个插入的方式 insert 的方式； 

这种建堆的方法具有O(n*log2n)的时间复杂度。从根结点开始，然后一个一个的把结点插入堆中。当把一个新的结点插入堆中时，需要对结点进行调整，以保证插入结点后的堆依然是大根堆。

其中h = log2(n+1)-1，第k层结点个数为2k个(当然最后一层结点个数可能小于2h)。第k层的一个结点插入之后需要进行的比较(移动)次数为k。于是总的比较(移动)次数为∑k*2k(k = 0,1,2,…,h)。可以求得∑k*2k(k = 0,1,2,…,h)=(log2(n+1)-2)*(n+1)+2 = O(n*log2n)

（2）自下向上的建堆方式

就是build_heap 的方式；时间复杂度是O(n)

这种建堆的方法具有O(n)的时间复杂度。如下图所示，从第一个非叶子结点开始进行判断该子树是否满足堆的性质。如果满足就继续判断下一个点。否则，如果子树里面某个子结点有最大元素，则交换他们，并依次递归判断其子树是否仍满足堆性质。

因为调整根结点以及其左右孩子的位置的复杂度是O(1),再加上对其子树的递归判断是否满足堆性质需O(h),而在任意高度h上，至多有[n/2^(h+1)]个结点。则总共的时间复杂度为∑h*(n)/(2(h+1)).根据调和级数的积分公式可得，时间复杂度为O(n)。



---

## 时间复杂度分析

````php
# 主要包含四个方法的时间复杂度：
// insert  logn 
// extract logn 
// build_heap n  创建堆 从叶子结点开始向下堆化；
// heapsort nlogn 

### 注意一下 上浮和下沉的方法内部方法
// upheapify  insert 会调用这个方法

//downheapify  extract  and  heapsort build_heap 都需要调用这个私有方法；
// heapsort 为什么是nlogn  就是因为要extract 所有的值，所以时间复杂度是n；
````



---

数组中的第 k 大的数字 --leetcode 剑指offer 076

`````php
class Solution {

    /**
     * @param Integer[] $nums
     * @param Integer $k
     * @return Integer
     */
    function findKthLargest($nums, $k) {
        $heap = new SplMinHeap();
        foreach($nums as $val) {
            if ($heap->count() < $k) {
                $heap->insert($val);
            } else {
                if ($heap->top() < $val) {
                    $heap->extract();
                    $heap->insert($val);
                }
            }
        }
        //
        return $heap->top();
    }
}
`````

