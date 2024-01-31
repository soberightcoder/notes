#alg 栈 和队列；操作受限制的线性表数据结构；

---



### 栈 stack

> 栈有保护现场的作用，比如函数调用栈，浏览器的回退和前进（两个栈来组成）；
>
> 无论是**顺序栈**还是**链式栈 **删除和增加的时间复杂度都是O(1); 在末尾进行操作；
>
> **只需要一个栈顶指针就可以了；top；**

先入后出，first in last out，删除和增加的时间复杂度是O(1),但是查询是O(n),因为无序的所以只能进行遍历；



---



###队列 queue 

> deque分类：arraydeque   concurrentlinkdeque （并发队列） linkedblockingdeque（阻塞队列） linkedlist 链表
>
> 按照是实现方式：顺序队列和链式队列；区别：**链式队列式无限的，顺序队列会有长度限制；**
>
> **队列需要两个指针（顺序队列也是需要这两个指针的；用来判断队列满和null）**，head tail；head 来删除，  tail在增添，往右移动；
>
> 对于**大部分的有限的资源**，当没有**空闲的资源**的时，基本上都是通过 **队列** 来实现请求排队；



----

**顺序队列**

先进先出，first in first out，删除和删除的时间复杂度都是O(1),但是查询时间复杂度是O(n)，也就是会存在**数据搬移**;顺序队列；

**php 中的，array_push(); O(1)的时间复杂度array_shift();  O(n)的时间复杂度；**

---

**链式队列**  tail  head  n 链表的长度；

**普通链表，**增加：**tail->next = new_node; tail = tail->next;**  **队尾添加**
删除  **head = head->next;**   **对头删除；**

空队列：head == tail

满队列 ： tail == n；

---

**循环队列**  (主要是为了解决**，顺序队列存在的数据搬移的问题**；使**用循环队列肯定不存在数据搬移**；**但是会浪费一个空间**)

**空队列： head == tail**
**满队列：（tail + 1） % n = head （  增加1 后 在循环队列的位置）  （求m在循环列表的位置 就是求余数 n代表的循环队列容量 m%n  注意求余的取值范围是 （0 -- n-1））** 

**增加 ： tail = (tail + 1)  % n ; 增加一个后 在循环队列中的位置；**

**删除 ： head = （head + 1) % n; 删除一个后 head 在循环队列的位置**

---

**阻塞队列**

当 n == null 时候队列是null 会阻塞消费；

当 tail == n 的时候，队列满的时候阻塞生产；

**阻塞队列可以有效的协调生产和消费的速度；也可以协调生产者个数和消费者的个数来提高数据的处理效率；**

---

 **双端队列(deque 双端队列的缩写) double-end queue** （O(1)删除和插入，O(n) 查询）

一般用的是双端队列，其实就是php的数组：

````php
#其实这边就是一个双端队列；
# 末尾操作； 出栈 和入栈 
array_push();  入栈；
array_pop(); 	出栈；

# 开头操作；
array_shift(); 数组开头移出
array_unshift(); 数组开头插入；
````

----

----

**优先队列 p'riority deque**

>按照 优先级 进行取出 所以 取出的时间复杂度变高；

1. **插入操作 是O(1)**
2. **取出操作 是O(logn)** - **按照元素的优先级取出**
3. 底层实现的数据结构较为多样和复杂；  heap  bst treap  (一般这里是用 bst **binary search tree 二叉搜索树** )
4. 当然你也可以使用数组来实现，但是数组，取出操作时间复杂度是O(n)，当然你也可以在插入之后用sort对数组来进行排序，那么插入操作会变成n(nlogn) 取出是O(1);





### 数组和链表实现栈和队列

`````php
class NormalStack
{
    public $stack = [];
    public $minStack = [];
    public $dataTop = 0;
    public $minTop = 0;

    public function push($data) {
        array_push($this->stack, $data);
        if (empty($this->minStack)) {
            array_push($this->minStack, $data);// min
        } else {//
            if ($data <= ($this->getMin())) {
                array_push($this->minStack, $data);
            } else {
                //
                array_push($this->minStack, $this->getMin());
            }

        }
        $this->minTop++;
        $this->dataTop++;
    }

    public function pop() {
        array_pop($this->stack);
        array_pop($this->minStack);
        $this->dataTop--;
        $this->minTop--;
    }

    public function getMin() {
        //minstack  保存最小值 $top 表示的是将要push的；这里一定要减1；很重要；
        return empty($this->minStack) ? null : $this->minStack[$this->minTop - 1];
    }
}

$stackObj = new NormalStack();
//var_dump($stackObj->getMin());

//$stackObj->push(2);
//$stackObj->push(1);// 出错了；/
//echo $stackObj->getMin();
//$stackObj->push(4);
//$stackObj->push(0);
//echo $stackObj->getMin();
//$stackObj->push(7);
//echo $stackObj->getMin();
//$stackObj->pop();
//$stackObj->pop();
//echo $stackObj->getMin();
//$stackObj->pop();
//$stackObj->pop();
//var_dump($stackObj->minStack);
//var_dump($stackObj->stack);die;
`````

