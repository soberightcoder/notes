# php7

> php7
>
> ****语言构造由解析器理解和处理。内置函数虽然由语言提供，但在解析之前被映射和简化为一组语言结构。****

**complier:编译**： 其实就是翻译，把高级语言翻译成汇编语言或者机器语言的过程；

https://www.bilibili.com/video/BV1zW411t7YE?p=2

分为：前端部分和后端部分；中间代码起到一个桥梁的部分；

就好像英语翻译成汉语，中间码可以是一系列图片，可以翻译成任何的语言，（汉语德语，法语等等都可以）

主要分为几部分：源代码=》词法分析=》token（种别码，值）=》语法分析（语义分析）=》ast（abstract syntax trees 抽象语法树）=》opcode=》中间码的优化=》目标语言（汇编语言和机器语言）；

**种别码的分类：**

**关键字 if else then**

**标识符  变量名 数组名 记录名**

**常量** 

**运算符**

**界限符**

诶, 所谓语句,语言结构, 就是说, 是语言本身支持的语句, 标识符.
比如, for, foreach, continue 等等, 它们在语法分析的时刻就被”抹掉”(逻辑上替代了)了.
让我们看看isset这个语句在语法分析的过程中, 是如何被”抹掉”的.

\1. 首先, 在词法分析的时候, isset会被识别为T_ISSET标识符.
\2. 而在语法分析阶段, isset($var)这个指令, 会被分析成一条Opcode:ZEND_ISSET_ISEMPTY_VARS.

你可以理解isset就想C语言里面的宏, 在编译/执行之前已经被展开了.



**uri 和url的区别：**

**uri uniform resource identify**

**uri = url+urn**  

要标志一个资源uri有很多方式，url（定位（地址的形式））或者使用urn（name 名字的方式）；

在网络中，uri就是通过url（地址方式）来标志一个资源；

就好像一个身份证一样你肯定不能通过一个地址来区分一个人（说不定这个地址会有叫同一个名字的人），但是可以通过身份证号（urn）来定位一个人；所以在人口统计里面 uri就是通过urn来实现的；







**语言结构和函数区别：**

 echo、print、die、isset、unset、include、require、array、list、empty

opcode operate code 操作码







动态编译：在运行的进行解释，一条一条的解释执行源语言；

静态语言：把源代码编译成目标语言，然后执行；

JIT：某一段代码第一次被执行时候需要编译，而后不需要编译直接执行；为动态编译的一种；









cgi：老的网关协议，特征是每一个请求都会fork一个独立新进程来处理，所以效率比较低；

fast-cgi ： 去掉fork过程，改为多个进程去循环处理，但仍然每个请求独立； 





**词法分析，语法分析，语义分析：**

https://www.cnblogs.com/zyrblog/p/6885922.html





这比我预期的要长；请耐心等待。）

大多数语言由称为“语法”的东西组成：该语言由几个定义明确的关键字组成，您可以用该语言构建的完整表达式范围是从该语法构建的。

例如，假设您有一个简单的四函数算术“语言”，它只接受一位数的整数作为输入并且完全忽略运算顺序（我告诉过你这是一种简单的语言）。该语言可以由语法定义：

```php
// The | means "or" and the := represents definition
$expression := $number | $expression $operator $expression
$number := 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9
$operator := + | - | * | /
```

根据这三个规则，您可以构建任意数量的个位数输入算术表达式。然后，您可以为此语法编写一个解析器，将任何有效输入分解为其组件类型（`$expression`、`$number`、 或`$operator`）并处理结果。例如，表达式`3 + 4 * 5`可以分解如下：

```php
// Parentheses used for ease of explanation; they have no true syntactical meaning
$expression = 3 + 4 * 5
            = $expression $operator (4 * 5) // Expand into $exp $op $exp
            = $number $operator $expression // Rewrite: $exp -> $num
            = $number $operator $expression $operator $expression // Expand again
            = $number $operator $number $operator $number // Rewrite again
```

现在我们有一个完全解析的语法，在我们定义的语言中，用于原始表达式。一旦我们有了这个，我们就可以通过编写一个解析器来找到所有组合的结果`$number $operator $number`，并在只剩下一个时吐出一个结果`$number`。

请注意，`$expression`原始表达式的最终解析版本中没有留下任何构造。那是因为`$expression`在我们的语言中总是可以简化为其他事物的组合。

PHP 大致相同：语言结构被认为等同于我们的`$number`or `$operator`。它们**不能被简化为其他语言结构**；相反，它们是构建语言的基本单位。**函数和语言结构之间的主要区别在于：解析器直接处理语言结构。它将函数简化为语言结构。**

语言构造可能需要也可能不需要括号的原因以及一些具有返回值而另一些没有返回值的原因完全取决于 PHP 解析器实现的特定技术细节。我不太熟悉解析器的工作原理，所以我无法具体解决这些问题，但请想象一下以这样开头的语言：

```php
$expression := ($expression) | ...
```

实际上，这种语言可以自由地使用它找到的任何表达式并去掉周围的括号。PHP（在这里我使用纯粹的猜测）可能会对其语言结构采用类似的方法：`print("Hello")`可能会减少到`print "Hello"`解析之前，反之亦然（语言定义可以添加括号也可以去掉括号）。

这就是为什么你不能重新定义像`echo`或 之类的语言结构的根源`print`：它们被有效地硬编码到解析器中，而函数被映射到一组语言结构，并且解析器允许你在编译或运行时将该映射更改为替换您自己的一组语言结构或表达式。

归根结底，构造和表达式之间的内部区别在于：

**语言构造由解析器理解和处理。内置函数虽然由语言提供，但在解析之前被映射和简化为一组语言结构。**

更多信息：

- [Backus-Naur 形式](http://en.wikipedia.org/wiki/Backus–Naur_Form)，用于定义形式语言的语法（yacc 使用这种形式）

**编辑：**阅读其他一些答案，人们提出了很好的观点。其中：

- **调用内置语言比调用函数更快。**这是真的，即使只是轻微的，因为 PHP 解释器不需要在解析之前将该函数映射到它的语言内置等价物。但是，在现代机器上，差异可以忽略不计。
- **内置语言绕过错误检查。**这可能是也可能不是，这取决于每个内置函数的 PHP 内部实现。确实，函数通常具有更高级的错误检查和内置函数没有的其他功能。
- **语言结构不能用作函数回调。**这是真的，因为构造**不是函数**。它们是独立的实体。当您编写内置函数时，您并不是在编写带有参数的函数——内置函数的语法由解析器直接处理，并被识别为内置函数，而不是函数。（如果您考虑具有一流函数的语言，这可能更容易理解：实际上，您可以将函数作为对象传递。使用内置函数无法做到这一点。）











语言结构由语言本身提供（如“if”、“while”等指令）；因此他们的名字。

这样做的一个结果是它们比预定义或用户定义的函数更快地被调用*（或者我听过/读过几次）*

我不知道它是如何完成的，但他们可以做的一件事（因为直接集成到语言中）是“绕过”某种错误处理机制。例如，isset() 可以与不存在的变量一起使用，而不会引起任何通知、警告或错误。

```php
function test($param) {}
if (test($a)) {
    // Notice: Undefined variable: a
}

if (isset($b)) {
    // No notice
}
```

*请注意，并非所有语言的结构都如此。

函数和语言结构之间的另一个区别是，其中一些可以不带括号地调用，例如关键字。

例如 ：

```php
echo 'test'; // language construct => OK

function my_function($param) {}
my_function 'test'; // function => Parse error: syntax error, unexpected T_CONSTANT_ENCAPSED_STRING
```

*在这里，并非所有语言结构都如此。*

我想绝对没有办法“禁用”语言结构，因为它是语言本身的一部分。另一方面，许多“内置”PHP 函数并不是真正内置的，因为它们是由扩展提供的，因此它们始终处于活动状态*（但不是全部）*

另一个区别是语言结构不能用作“函数指针”（例如，回调）：

```php
$a = array(10, 20);

function test($param) {echo $param . '<br />';}
array_map('test', $a);  // OK (function)

array_map('echo', $a);  // Warning: array_map() expects parameter 1 to be a valid callback, function 'echo' not found or invalid function name
```

我现在没有任何其他想法出现……而且我对 PHP 的内部原理知之甚少……所以现在就这样吧^^

如果您在这里没有得到太多答案，也许您可以向**邮件列表内部人员**询问这个问题（请参阅http://www.php.net/mailing-lists.php），那里有许多 PHP 核心开发人员；他们是那些可能知道那些东西的人^^

*（我对其他答案很感兴趣，顺便说一句 ^^ ）*

作为参考：[PHP 中的关键字和语言结构列表](http://php.net/manual/en/reserved.keywords.php)









redis  和memcached的区别？


对于 redis 和 memcached 我总结了下面四点。现在公司一般都是用 redis 来实现缓存，而且 redis 自身也越来越强大了！

1. **redis支持更丰富的数据类型（支持更复杂的应用场景）**：Redis不仅仅支持简单的k/v类型的数据，同时还提供list，set，zset，hash等数据结构的存储。memcache支持简单的数据类型，String。
2. **Redis支持数据的持久化，可以将内存中的数据保持在磁盘中，重启的时候可以再次加载进行使用,而Memecache把数据全部存在内存之中。**
3. **集群模式**：memcached没有原生的集群模式，需要依靠客户端来实现往集群中分片写入数据；但是 redis 目前是原生支持 cluster 模式的.
4. **Memcached是多线程，非阻塞IO复用的网络模型；Redis使用单线程的多路 IO 复用模型。**



![img](php7.assets/2eef2930-c995-49d7-8ae7-de6a2e29757b.jpg)

https://www.zhihu.com/question/19829601

作者：阿里云云栖号
链接：https://www.zhihu.com/question/19829601/answer/145409431
来源：知乎
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。



**Redis 和 Memcache 都是基于内存的数据存储系统。Memcached是高性能分布式内存缓存服务；Redis是一个开源的key-value存储系统。与Memcached类似，Redis将大部分数据存储在内存中，支持的数据类型包括：字符串、哈希 表、链表、等数据类型的相关操作。下面我们来进行来看一下redis和memcached的区别。权威比较**

Redis的作者Salvatore Sanfilippo曾经对这两种基于内存的数据存储系统进行过比较：

1. Redis支持服务器端的数据操作：Redis相比Memcached来说，拥有更多的数据结构和并支持更丰富的数据操作，通常在Memcached里，你需要将数据拿到[客户端](https://www.zhihu.com/search?q=客户端&search_source=Entity&hybrid_search_source=Entity&hybrid_search_extra={"sourceType"%3A"answer"%2C"sourceId"%3A145409431})来进行类似的修改再set回去。这大大增加了网络IO的次数和数据体积。在Redis中，这些复杂的操作通常和一般的GET/SET一样高效。所以，如果需要缓存能够支持更复杂的结构和操作，那么Redis会是不错的选择。
2. 内存使用效率对比：使用简单的key-value存储的话，Memcached的内存利用率更高，而如果Redis采用hash结构来做key-value存储，由于其组合式的压缩，其内存利用率会高于Memcached。
3. 性能对比：**由于Redis只使用单核，而Memcached可以使用多核，所以平均每一个核上Redis在存储小数据时比Memcached性能更高。而在100k以上的数据中，Memcached性能要高于Redis，虽然Redis最近也在存储大数据的性能上进行优化，但是比起Memcached，还是稍有逊色。**
