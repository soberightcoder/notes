#xml和json

> 数据的传输和存储；
>
> 网络中最常用的两种数据表示格式；



网络中的数据的传输是二进制的形式； 所i一些复杂的数据结构，比如对象和数组；无法进行传输；所以就需要做序列化把；

字符串和int类型是二进制的形式；



xml  extensible markup language 可扩展标记语言；

特点是功能全面，但标签繁琐，格式复杂；tag 标签太繁琐了，太重了把；



json  javascript object notation <font color=red>轻量级的数据交换格式；</font>数据的交换和传输；名值对的形式；

````php
{
    "id": 1,
    "name": "Java核心技术",
    "author": {
        "firstName": "Abc",
        "lastName": "Xyz"
    },
    "isbn": "1234567",
    "tags": ["Java", "Network"]
}
````



JSON作为数据传输的格式，有几个显著的优点：

- JSON只允许使用UTF-8编码，不存在编码问题；" "
- JSON只允许使用双引号作为key，特殊字符用`\`转义，格式简单；
- 浏览器内置JSON支持，如果把数据用JSON发送给浏览器，可以用JavaScript直接处理。

因此，JSON适合表示层次结构，因为它格式简单，仅支持以下几种数据类型：

- 键值对：`{"key": value}`  对象；
- 数组：`[1, 2, 3]`
- 字符串：`"abc"`
- 数值（整数和浮点数）：`12.34`
- 布尔值：`true`或`false`
- 空值：`null`





https://www.cnblogs.com/kakawei/p/5990212.html



可读性会好一些 贴合人类的语言，json更加贴合机器阅读；json更像一个数据块读取是比较麻烦的；

但是 json 体积小 解析速度快，占用带宽小，传输速度快的特点；



JSON构建于两种结构：key/value，键值对的集合;值的有序集合，可理解为数组

