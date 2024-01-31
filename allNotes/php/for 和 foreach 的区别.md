#for 和 foreach 的区别

### for特性；

1. 执行速度快；
2. 可以控制index；
3. 可以控制起始循环；
4. 只能对索引数组进行遍历；

----

### foreach 特性；

1. 可以遍历关联数组；
2. 不可以控制index；
3. 是一个迭代器； 执行速度比for慢；
4. php7 特性： foreach： 1. 内部指针不再起作用；2. 按照值进行循环，在循环过程中对数组修改不会影响循环3.引用循环，对数组的修改会影响循环；

### 迭代器

php提供了一个语法结构用于遍历数组和对象

**foreach**

遍历数组用法

[![复制代码](for 和 foreach 的区别.assets/copycode.gif)](javascript:void(0);)

```
1 <php
2 //定义一个数组
3 $arr = array("1","2","3","4","5");
4 //用foreach遍历
5 foreach($arr as $key => $value){
6     echo '键名：'.$key.'键值：'.$value."<br>";
7 }8 ?>    
```

[![复制代码](for 和 foreach 的区别.assets/copycode.gif)](javascript:void(0);)

输出结果：

*键名：0键值：1*
*键名：1键值：2*
*键名：2键值：3*
*键名：3键值：4*
*键名：4键值：5*

而foreach则不能直接遍历对象里面的属性，需要通过迭代器（预定义接口）

最基本的迭代器接口是Iterator

Iterator里面规范了如下方法：

[![复制代码](for 和 foreach 的区别.assets/copycode.gif)](javascript:void(0);)

```php
1 Iterator extends Traversable {
2 /* 方法 */php
3 abstract public mixed current ( void )//返回当前元素
4 abstract public scalar key ( void )//返回当前元素的键
5 abstract public void next ( void )//向前移动到下一个元素
6 abstract public void rewind ( void )//返回到迭代器的第一个元素
7 abstract public boolean valid ( void )//检查当前位置是否有效
8 }
```

[![复制代码](for 和 foreach 的区别.assets/copycode.gif)](javascript:void(0);)

要进行遍历的类必须实现Iterator里面的抽象方法。



举个例子

**//主要是要有这三个参数**

**position  位置；**

**arr 数组 数组副本**（php7 后是数组的副本；）

**next 下一个元素**

**异常 length 来判断是否结束迭代；**



[![复制代码](for 和 foreach 的区别.assets/copycode.gif)](javascript:void(0);)

```php
 1 class Season implements Iterator{
 2     private $position = 0;//指针指向0
 3     private $arr = array('春','夏','秋','冬');
 4     public function rewind(){
 5         return $this -> position = 0;
 6     }
 7     public function current(){
 8         return $this -> arr[$this -> position];
 9     }
10     public function key(){
11         return $this -> position;
12     }
13     public function next() {
14         ++$this -> position;
15     }
16 
17     public function valid() {
18         return isset($this -> arr[$this -> position]);
19     }
20 }
21 $obj = new Season;
22 foreach ($obj as $key => $value) {
23     echo $key.':'.$value."\n";
24 }
25 ?>
```

[![复制代码](for 和 foreach 的区别.assets/copycode.gif)](javascript:void(0);)

结果：

*0:春*
*1:夏*
*2:秋*
*3:冬*

 

php有对数组指针的操作，可不用定义$position 

1.key();从关联数组中取得键名，没有取到返回NULL

2.current();返回数组中当前单元

3.next();将数组中的内部指针向前移动一位

4.prev();将数组的内部指针倒回一位

5.reset();将数组的内部指针指向第一个单元

6.end();将数组的内部指针指向最后一个单元

 