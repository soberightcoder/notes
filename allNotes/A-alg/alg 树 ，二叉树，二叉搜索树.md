# alg 树 ，二叉树，二叉搜索树(bst二维数据结构，查询效率是 O（logn)

> 为了提高查询效率，所以我们做了升维，例如跳表，进行了升维，所以查询效率从O(n) 提高到了O(logn);



树和图的区别：图会含有闭环，树不会；



三个相似度很高的概念：**高度（height） 深度（depth） 层（level）** 



**高度和深度都是从0开始的，3210，0123；**  层是从根节点开始，从1开始的；

**<font color=red>注意二叉树的节点树的多少是跟树的高度有关系的； 2^h代表的是叶子节点的节点数；</font>**



**二叉树**：每一个节点都分为左右节点；可以是null，也可以存在数值；

**满二叉树**：除了叶子节点，每一个节点都会有左右节点（左右节点不是null）；

**完全二叉树：满二叉树+叶子节点靠左排序；如果一个树是完全二叉树，那么使用数组存储方式是最节约内存的；**

当我们讲到堆和堆排序的时候，你会发现，堆其实就是一种完全二叉树，最常用的存储方式就是数组。？？？？先了解；



**如何存储一颗树？**

**链表存储**方式：每一个节点分为左右指针，然后串联起来；会有**很多的指针**；

**顺序存储**方式：

`````php
//设父节点i；那么左节点就是2*i  右节点 2*i+1
//Math.floor(i / 2) 已经知道子节点求父节点；
// 如果是完全二叉树，只浪费数组0这个空间，空间是链表存储的小三倍；一个结点会包含两个指针，指针的大小是8个字节；
`````





**二叉树的遍历：**

**中节点所处的位置**

遍历的时间复杂度因为大约每一个节点都经历了两次所以**时间复杂度是O(n)** 每个节点都遍历过了，所以时间复杂度是O(n)

其实都是一个**递归**的问题：

前序遍历：中  左 右  根节点  左子树  右子树

`````php
function preOrder($root){
    if($root == null) return;
    print $root;// 打印节点
    preOrder($root->left);
    preOrder($root->right);
}


// 只要关注 a 和其子问题（左右节点）的关系就可以了，并且子问题假设都是已经解决的；
   function preorderTraversal($root) {
        if($root==null)//递归终止条件
            return [];

        $a[]=$root->val;//前序操作
        $b=$this->preorderTraversal($root->left);//递归左子树
        $c=$this->preorderTraversal($root->right);//递归右子树
        return array_merge($a,$b,$c);
    }  

`````



中序遍历：左 中 后  左子树  根节点  右子树

`````php
function midOrder($root){
    if($root == null) return;
    preOrder($root->left);
    print $root;// 打印节点
    preOrder($root->right);
}
`````



后序遍历：左 右 中  左子树  右子树  中节点

`````php
function midOrder($root){
    if($root == null) return;
    preOrder($root->left);
    preOrder($root->right);
    print $root;// 打印节点
}
`````

### 二叉查找树 二叉搜索树（ bst  binary search tree） bst 就是为了查询存在的二叉树；

>**就是为了快速查找而生**；支持快速的查找，删除，查找；
>
>定义：**要求任意一个节点，左子树中的每一个节点的值都小于这个节点的值，右子树中的每一个节点的值都大于这个节点的值；**
>
>**左右子树的深度差1；** **这里是平衡二叉树，主要是为了解决查询树的最糟糕的时间复杂度的情况；树退化成时间复杂度是O**
>
>**(n)的问题；**
>
>时间复杂度是O(logn)
>
>中序二叉查找树，会得到一个有序数列，时间复杂度是O(n)；会得到一个有序的序列；



#### search  bst

`````php
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
function findBinary($a,$val){
    if($a == null) return null;
    while($a != null){
       if($val > $a->val){
           $a = $a->right;
       }elseif($val < $a->val){
           $a = $a->left;
       }else{
           return $a;
       }
    }
    return null;
}
var_dump(findBinary($a,10));

`````

####logn === 树的height（高度） 公式验证；其实一眼就看出来了；



`````php
// 假设 M是数据的总数  N 代表n叉树  h带表树高；
//  在b+树种 mysql 我们可以控制树高 通过 控制索引的大小 index 或者innodb_page_size 来设置树的高度  默认是16kB
//  对数和指数的互换  y = a^x;  x= logay;
N^0 + N^1 + N^2 +....N^h = M
计算了 N^h 自然就是logn的时间复杂度  也就是树的高度；bst；二分法；
//  看最后一层就可以
N^h = M		//h代表的是树的高度，也就是search的时间复杂度；
h = logNM;  //所以N越大那么那么树的高度越低，随机IO口的消耗就会变小，那么mysql的效率就会变高；
# 这里不是这么简单；
`````





####  insert  bst

`````php
/**
 * 二叉树的插入 bst insert
 * 插入某一个j节点
 */
$newNode = new TreeNode(18);
function insertBst($root,$newNode){
    while ($root != null) {
        if ($root->val < $newNode->val) { // 大于
            if (!isset($root->right)) {// 右节点是null
                $root->right = $newNode;
                break;
            } else {
                $root = $root->right;
            }
        } else { // 小于等于 往左子树去插入
            if (!isset($root->left)) {//左边是null
                $root->left = $newNode;
                break;
            } else {
              $root = $root->left;
            }
        }
    }
    // 遍历 返回bst  需要自己遍历
}

inorderTravel($root);// 前序遍历
echo "\n";
// 注意 注意这里是传递的是对象 传递的是句柄，可以直接对对象直接操作；
insertBst($root,$newNode);
inorderTravel($root);// 前序遍历
`````











#### delete  删除 bst

`````php
/**关于二叉查找树的删除操作，还有个非常简单、取巧的方法，就是单纯将要删除的节点标记为“已删除”，但是并不真正从树中将这个节点去掉。这样原本删除的节点还需要存储在内存中，比较浪费内存空间，但是删除操作就变得简单了很多。而且，这种处理方法也并没有增加插入、查找操作代码实现的难度。**/


function deleteBst($root,$val){
    if ($root == null) return;

    if ($root->val > $val) {
        $root->left = deleteBst($root->left,$val); 
    } else if ($root->val < $val) {
        $root->right = deleteBst($root->right,$val);
    } else { // 找到root->val = $val
        if ($root->left == null) {
            return $root->right;
        } else if ($root->right == null) {
            return $root->left;
        } else { //
            $root->val = minBst($root->right);
            $root->right = deleteBst($root->right,$root->val);
        }
    }
    return $root;
}
inorderTravel($root);
echo "\n";
$res = deleteBst($root,9);
inorderTravel($res);die;

#非递归
#第一种情况是，如果要删除的节点没有子节点，我们只需要直接将父节点中，指向要删除节点的指针置为 null。
#第二种情况是，如果要删除的节点只有一个子节点（只有左子节点或者右子节点），我们只需要更新父节点中，指向要删除节点的指针，让它指向要删除节点的子节点就可以了。
# 第三种情况是，如果要删除的节点有两个子节点，这就比较复杂了。我们需要找到这个节点的右子树中的最小节点，把它替换到要删除的节点上。然后再删除掉这个最小节点，因为最小节点肯定没有左子节点（如果有左子结点，那就不是最小节点了）;

`````

**时间复杂度的分析：**   

局限性bst：当退化成链表的时候时间复杂度是最糟糕的情况，也就是说时间复杂度是O(n); 也就是说 在极度不平衡的条件下，不会满足我们的要求，下面需要介绍如何保持bst的平衡性，也就是我们需要了解的平衡而二叉树；

**平衡二叉树的时间复杂度很稳定，接近于logn，和树的高度成正比；**





我们在散列表那节中讲过，散列表的插入、删除、查找操作的时间复杂度可以做到常量级的 O(1)，非常高效。而二叉查找树在比较平衡的情况下，插入、删除、查找操作时间复杂度才是 O(logn)，相对散列表，好像并没有什么优势，那我们为什么还要用二叉查找树呢？我认为有下面几个原因：

**第一，散列表中的数据是无序存储的，如果要输出有序的数据，需要先进行排序。而对于二叉查找树来说，我们只需要中序遍历，就可以在 O(n) 的时间复杂度内，输出有序的数据序列。**

**第二，散列表扩容耗时很多，而且当遇到散列冲突时，性能不稳定，尽管二叉查找树的性能不稳定，但是在工程中，我们最常用的平衡二叉查找树的性能非常稳定，时间复杂度稳定在 O(logn)。**

**第三，笼统地来说，尽管散列表的查找等操作的时间复杂度是常量级的，但因为哈希冲突的存在，这个常量不一定比 logn 小，所以实际的查找速度可能不一定比 O(logn) 快。加上哈希函数的耗时，也不一定就比平衡二叉查找树的效率高。**

**第四，散列表的构造比二叉查找树要复杂，需要考虑的东西很多。比如散列函数的设计、冲突解决办法、扩容、缩容等。平衡二叉查找树只需要考虑平衡性这一个问题，而且这个问题的解决方案比较成熟、固定。**



### 平衡二叉树（AVL）（为了去解决bst的局限性，当多次插入和删除操作之后，会进行退化，进而会影响时间复杂度；）为了保持稳定性，所以出现了avl

>定义：**任意一个节点的左右子树高度差不超过1；**
>
>**严格的平衡的BST；那么旋转次数会很多**





### 红黑树

>是一种二叉查找树；
>
>**红黑树是一种弱平衡二叉树（在相同的节点情况下，AVL的高度低于红黑树），相对于要求严格平衡的AVL树来说，红黑树旋转次数也更少；**
>
>对于搜索查找删除操作多的情况下，我们就用红黑树
>
>定义：
>
>1. 根节点是黑色的；
>2. 叶子节点都是黑色的空节点（NULL），也就是叶子不存储数据；
>3. 任意一个节点到叶子节点的所有路径，包含的黑色节点数是相同的；
>4. 任意相邻的节点不能同时为红色；也就是说红色的节点肯定会被黑色节点隔开；
>
>其实上面这么多条件主要是为了满足，**最长路径长度不超过最短路径长度的2倍；**
>
>**左右树的深度差一倍以内；** 平衡条件更加宽松；
>
>

**时间复杂度分析：**

最好的情况 全部都是黑色节点： 那么时间复杂度是h = log4N   h = log2N/log24 约等于 h=logn； 所以时间复杂度还是logn

当最坏的情况是 ：红白相间的，那么高度为了原先的两倍，所以是h = 2logn；

为什么用红黑树不用平衡二叉树，因为二叉树为了这个严格的平衡付出的代价太高了，需要旋转，而红黑树不需要严格的平衡，旋转的次数少i，而且时间复杂度还是logn到2logn的级别，所以会选择红黑树；

**红黑树的时间复杂度分析：**





### 堆的概念

>定义：
>
>1. 堆是一个完全二叉树；
>2. 堆中每一个节点的值都必须大于等于（或小于等于）其子树（左右子树）中每个节点的值；
>
>他的存储结构肯定是数组，因为是完全二叉树，所以顺序存储，比较节约空间；
