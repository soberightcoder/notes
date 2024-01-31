# list的删除

>单链表删除需要知道上一个元素；
>
>如果头元素也有可能被删除的话 ，就搞一个虚拟结点；

`````php
/**
 * Class ListNode
 * 2.list Node
 */

class ListNode
{
    public $val = 0;
    public $next = null;


    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}
//head 直接 指向的就是 头结点；
//变量名 其实就是一个地址；在php中 变量名 通过 active_symbol 转换成地址，进一步得到对象；
//  这里了解一下；
$head = new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5)))));
$middle = new ListNode(1, new ListNode(2, new ListNode(3, new ListNode(4, new ListNode(5, new ListNode(6))))));

// 因为有可能要删除头结点 所以要搞一个虚拟结点；



/**
 * 代码中的类名、方法名、参数名已经指定，请勿修改，直接返回方法规定的值即可
 *
 * 
 * @param head ListNode类 
 * @param val int整型 
 * @return ListNode类
 */
function deleteNode( $head ,  $val )
{
    // head 是一个引用；// 赋值是传递的是引用；//--- 
    // write code here

    $dummy = new ListNode(-1);
    
    $dummy->next = $head;
    $stage = $dummy;

    while ($dummy->next != null) {
        if ($dummy->next->val == $val) {
            $middle = $dummy->next->next;
            $dummy->next = $middle;
            break;
        }
        $dummy = $dummy->next;
    }
    
    return $stage->next;

}

deleteNode($head,3);
`````

