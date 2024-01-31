# vim批量操作



[**vim批量操作**](https://blog.csdn.net/yh13572438258/article/details/121522688)*千次阅读*

2021-11-24 19:15:08

**目录**

[一、列操作](https://www.csdn.net/tags/Mtjacg3sNTE1MTQtYmxvZwO0O0OO0O0O.html#一、列操作)

[二、批量复制与删除](https://www.csdn.net/tags/Mtjacg3sNTE1MTQtYmxvZwO0O0OO0O0O.html#二、批量复制与删除)

[三、批量替换](https://www.csdn.net/tags/Mtjacg3sNTE1MTQtYmxvZwO0O0OO0O0O.html#三、批量替换)

[四、批量注释](https://www.csdn.net/tags/Mtjacg3sNTE1MTQtYmxvZwO0O0OO0O0O.html#四、批量注释)

------

# 一、列操作

**删除列**

在正常模式下（一般按Esc键就是）——光标定位——CTRL+v 进入“VISUAL BLOCK”可视块模式，选取这一列操作多少行——按键盘d 删除。





<font color=red>注意：这里是正确的； 注意要用esc + esc 才可以批量的修改；</font>

注意 在idevim 中 ctrl  + v 是进入到可视化模式；   vim  是用v来进入可视化模式

**插入列**

**例如我们在每一行前都插入注释"// "：**

**在正常模式下（一般按Esc键就是）——光标定位到要操作的地方——CTRL+v 进入“VISUAL BLOCK”模式，选取这一列操作多少行——SHIFT+i(I) 输入要插入的内容如"//"——ESC 按两次，会在每行的选定的区域出现插入的内容。**



# 二、批量复制与删除

在正常模式下（一般按Esc键就是），CTRL+v,进入列块模式，选中需要复制的内容
键盘“y” 复制内容，4line yanked 说明复制了四行
然后移动光标到行首，“p”在光标的后面一列输入内容，按“P”在光标前面一列输入内容；大小p的区别是黏贴内容的区域是所选择光标的前面还是后面一列；

dd          删除游标所在的那一整行
ndd         n 为数字。删除光标所在的行向下n行，例如 10dd 则是删除 10行

gg          移动到行首

12G         跳转到文件的第12行

h, j, k, l       左下上右

CTRL-B，CTRL-F    翻页，等同于PageUp和PageDown。加上数字，表示向上或向下翻多少页

yy         复制游标所在那一行
y1G       复制光标所在列到第一列所有数据
yG        复制光标所在列到最后一列癿所有数据
y0         复制光标所在那个字符到该行行首所有数据
y$         复制光标所在那个字符到该行行尾所有数据
u          复原前一个动作

# 三、批量替换

命令模式下：%s/old/new/g，用old替换new,替换文件的整个匹配

​         ：10,20s/^/ /g，10行到20行前面加空格，用于缩进

​         ：/text，查找text,n查找下一个，N查找前一个

​         ：？text，反向查找text,n查找下一个，N查找前一个

​         ：split file或者new file用新窗口打开文件，

​          ：vsplit纵向打开窗口，Ctrl+ww移动到下一个 窗口

# 四、批量注释

makefile,perl等中注释用#，.v等注释用//类似。

：3,5s/^/#/g  注释3~5行

：3,5s/^#//g  解除注释3~5行

：%s/^/#/g  注释整个文档