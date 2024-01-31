# PHP Heap

> php heap

---



### 一 、基本数据结构

##### 堆：

- 堆是一棵完全二叉树，
- 根节点的值总是不大于或者不小于子节点的值

> 将根结点最大的堆叫做最大堆、大顶堆或大根堆，根结点最小的堆叫做最小堆、小顶堆或小根堆。常见的堆有二叉堆、斐波那契堆
>  通常堆顶节点都是最大或者最小的，在解决特殊问题时，先弹出堆顶元素非常有优势

##### 栈：

先进后出（FILO），就像一个敞口向上的容器，只能将后进入容器的先弹出。

##### 队列：

先进先出（FIFO），跟栈相反，队列就像一根上下贯通的水管，只能将先流入水管的水流出去。

### 二、优先级队列

> **SplHeap底层的数据结构就是一个二叉树；**
>
>**SplPriorityQueue   底层实现是一个什么？  The SplPriorityQueue class provides the main functionalities of a prioritized queue, implemented using a max heap.  也是使用大根堆来实现的呀；**
>
>

优先队列也是一种数据结构，通过加权值进行排序，PHP核心库提供了[SplPriorityQueue](https://links.jianshu.com/go?to=https%3A%2F%2Fwww.php.net%2Fmanual%2Fzh%2Fclass.splpriorityqueue.php%23class.splpriorityqueue)对象来实现。
 优先队列内部是用**Heap：堆**这种数据结构来实现的，默认是大顶堆（MaxHeap）。

##### 1. 常规用法（大顶堆）



```php
$queue = new SplPriorityQueue;

// 插入堆，并自动筛选和排序
// 接受2个参数，insert(值, 优先级)
$queue->insert('A', 3);
$queue->insert('B', 9);
$queue->insert('C', 2);
$queue->insert('D', 5);

// 堆中元素的个数
$count = $queue->count(); // 此时为4

// 返回堆顶的节点
$top = $queue->top(); // 堆不变

/**
* 设置元素出队模式
* SplPriorityQueue::EXTR_DATA 仅提取值
* SplPriorityQueue::EXTR_PRIORITY 仅提取优先级
* SplPriorityQueue::EXTR_BOTH 提取数组包含值和优先级
*/
$queue->setExtractFlag(SplPriorityQueue::EXTR_BOTH);

// 从堆顶提取元素，并重新筛选和排序
$queue->extract(); // 此时B被取出，堆顶元素重置为D
$queue->extract(); // 此时D被取出，堆顶元素重置为A
$queue->extract(); // 此时A被取出，堆顶元素重置为C
$queue->extract(); // 此时C被取出，堆中元素全部取出

// 判断堆是否为空
$status = $queue->isEmpty(); // 结果为true

// 迭代指针相关

// 因为优先队列是堆实现的，所以rewind实际没什么用，他永远指向堆顶指针，current也永远等于堆顶的值
// 故而extract相当于current(返回当前节点)和next(指向下一个节点)两个操作

// 返回当前节点
$current = $queue->current();

// 指针指向下一个节点
$queue->next();

// 返回堆中堆中是否还有节点
while ($queue->valid()) {
    $current = $queue->current();
    $queue->next();
}
```

##### 2. 改成小顶堆（MinHeap）

优先队列改成小顶堆，需要重写compare方法，将比较值对调，即可切换小顶堆和大顶堆。



```php
/*
 * 小顶堆
 */
class MyMinHeap extends SplPriorityQueue {
    function compare($value1, $value2) {
        // if ($value1 === $value1) return 0;
        // return $value1 < $value2 ? -1 : 1; 
        // return $value1 - $value2; // 高优先级优先
        return $value2 - $value1; // 低优先级优先
    }
}

$queue = new MyMinHeap;

// 插入堆，并自动筛选和排序
// insert接受2个参数，key在前，value在后，vaue为排序的权重值
$queue->insert('A', 3);
$queue->insert('B', 9);
$queue->insert('C', 2);
$queue->insert('D', 5);

$queue->extract(); // 此时C被取出，堆顶元素重置为A
$queue->extract(); // 此时A被取出，堆顶元素重置为D
$queue->extract(); // 此时D被取出，堆顶元素重置为B
$queue->extract(); // 此时B被取出，堆中元素全部取出

$status = $queue->isEmpty(); // 结果为true
```

### 三、堆、大顶堆和小顶堆

堆就是为了实现优先队列而设计的一种数据结构，它分为大顶堆和小顶堆，PHP核心库提供了**大顶堆SplMaxHeap**和**小顶堆SplMinHeap**两种类可供直接使用，他们都是由SplHeap抽象类实现的。

- **简单数据**



```php
/**
 * 自定义：最小堆/小顶堆
 * 低优先级优先弹出
 * 等同于系统自带的SplMinHeap
 */
class MyMinHeap extends SplHeap
{
    // 比较元素，以便在筛选时将它们正确地放在堆中，
    // 如果value1大于value2则为正整数，如果相等则为0，否则为负整数
    function compare($value1, $value2) { 
        return $value2 - $value1;
    } 
}

/**
 * 自定义：最大堆/大顶堆
 * 高优先级优先弹出
 * 等同于系统自带的SplMaxHeap
 */
class MyMaxHeap extends SplHeap
{
    // 比较元素，以便在筛选时将它们正确地放在堆中，
    // 如果value1小于value2则为正整数，如果相等则为0，否则为负整数
    function compare($value1, $value2) { 
        return $value1 - $value2;
    } 
}

$minHeap = new MyMinHeap;
// 插入元素，insert(值)
$minHeap->insert(3);
$minHeap->insert(2);
$minHeap->insert(4);
$minHeap->insert(1);
// 取出元素
$minHeap->extract(); // 1被取出
$minHeap->extract(); // 2被取出
$minHeap->extract(); // 3被取出
$minHeap->extract(); // 4被取出

$maxHeap = new MyMaxHeap;
// 插入元素
$maxHeap->insert(3);
$maxHeap->insert(2);
$maxHeap->insert(4);
$maxHeap->insert(1);
// 取出元素
$maxHeap->extract(); // 4被取出
$maxHeap->extract(); // 3被取出
$maxHeap->extract(); // 2被取出
$maxHeap->extract(); // 1被取出
```

- **复杂数据**



```php
/**
 * 自定义：最小堆/小顶堆
 * 低优先级优先弹出
 * 等同于系统自带的SplMinHeap
 */
class MyMinHeap extends SplHeap
{
    function compare($arr1, $arr2) { 
        $value1 = array_values($arr1);
        $value2 = array_values($arr2);
        if ($value2[0] === $value1[0]) return 0;
        return $value2[0] < $value1[0] ? -1 : 1;
    } 
}

/**
 * 自定义：最大堆/大顶堆
 * 高优先级优先弹出
 * 等同于系统自带的SplMaxHeap
 */
class MyMaxHeap extends SplHeap
{
    function compare($arr1, $arr2) { 
        $value1 = array_values($arr1);
        $value2 = array_values($arr2);
        // if ($value2[0] === $value1[0]) return 0;
        // return $value2[0] > $value1[0] ? -1 : 1;// 高优先级优先弹出
        return $value1[0] - $value2[0];
    } 
}

$minHeap = new MyMinHeap;
// 插入元素，insert(值)
$minHeap->insert(['A' => 3]);
$minHeap->insert(['B' => 2]);
$minHeap->insert(['C' => 4]);
$minHeap->insert(['D' => 1]);
// 取出元素
$minHeap->extract(); // D被取出
$minHeap->extract(); // B被取出
$minHeap->extract(); // A被取出
$minHeap->extract(); // C被取出

$maxHeap = new MyMaxHeap;
// 插入元素
$maxHeap->insert(['A' => 3]);
$maxHeap->insert(['B' => 2]);
$maxHeap->insert(['C' => 4]);
$maxHeap->insert(['D' => 1]);
// 取出元素
$maxHeap->extract(); // C被取出
$maxHeap->extract(); // A被取出
$maxHeap->extract(); // B被取出
$maxHeap->extract(); // D被取出
```

总结：

- 优先队列SplPriorityQueue的insert接受两个参数，第一个参数为值，第二个参数为权重
- **大顶堆SplMaxHeap和小顶堆SplMinHeap均实现了SplHeap抽象类，通过重写compare方法来区分大/小顶堆**
- **大顶堆和小顶堆只接受一个参数，需要注意传不同类型的数据时，compare方法的写法需要对应地进行修改**

作者：江月照我眠
链接：https://www.jianshu.com/p/9b6202980da2
来源：简书
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。