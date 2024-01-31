# vim  基础命令 -- av1



`````php

# 很强的光标移动命令；

# % : 匹配括号移动，包括 (, {, [. （陈皓注：你需要把光标先移到括号上） 找到block 块区域的范围；
                     
# * 和 #:  匹配光标当前所在的单词，移动光标到下一个（或上一个）匹配单词（*是下一个，#是上一个）   可以用 space + enter 去取消高亮； 
# 
# f +  字符  就匹配行 找到那个字符  ; 分号就是下一个字符
# w  向后的单词开头开头    往后找单词的首部； ->
# e  单词的末尾；  //本单词的末尾；
# b  向前的word单词开头；本单词的开头； 往前找单词的首部；<-

# J
# L
# gg 第一行；
# G  最后一行； 
# jkli  noremap  norecursion

# n  代表的的是上一次 查询的内容继续进行查询吗？

# noremap m 5k; 直接向下5行 5行的查找；
# noremap M 5i; 直接向上5行 5行的查找；
##------


# .重复上一次命令；

#分号(;)代表的是下一个，逗号(,)代表的是上一个！
# next 上一个搜索内容！！
`````

![Word moves example](vim 基础命令.assets/word_moves.jpg)

## 

---



## 块操作  --- 就是前面的批量操作；

> <c-v> 就是ctrl + v;    选中--- 然后插入，
>
> 

##### 块操作: `<C-v>`

块操作，典型的操作： `0 <C-v> <C-d> I-- [ESC]`

- `^` → 到行头
- `<C-v>` → 开始块操作
- `<C-d>` → 向下移动 (你也可以使用hjkl来移动光标，或是使用%，或是别的)
- `I-- [ESC]` → I是插入，插入“`--`”，按ESC键来为每一行生效。

![Rectangular blocks](http://yannesposito.com/Scratch/img/blog/Learn-Vim-Progressively/rectangular-blocks.gif)

在Windows下的vim，你需要使用 `<C-q>` 而不是 `<C-v>` ，`<C-v>` 是拷贝剪贴板。

---



##  一些简单的命令 . 代表上一次命令；

1. `.` → (小数点) 可以重复上一次的命令
2. N<command> → 重复某个命令N次





## 回到上一个修改的地方 

ctrl + shift + backspace 

`````shell
The last change is held in the mark named . so you can jump to the mark with `. (backtick, dot) or '. (apostrophe, dot). See:

:help mark-motions
:help '.
`````





## 自动提示  --ide 自带自动提示； 所以不需要这个；

##### 自动提示： `<C-n>` 和 `<C-p>`

在 [Insert](https://so.csdn.net/so/search?q=Insert&spm=1001.2101.3001.7020) 模式下，你可以输入一个词的开头，然后按 `<C-p>或是<C-n>，自动补齐功能就出现了`



---

##  替换：s/old/new/g

输入 :s/old/new/g 可以替换 old 为 new.





---

   **输入 `/` 然后紧随一个字符串是则是在当前所编辑的文档中向后查找该字符串。 输入问号 `?` 然后紧随一个字符串是则是在当前所编辑的文档中向前查找该字 符串。**

**完成一次查找之后按 `n` 键则是重复上一次的命令，可在同一方向上查**
**找下一个字符串所在；或者按 `Shift-N` 向相反方向查找下该字符串所在。**

`````shell
# n 是重复上一次查找命令

## . 是上一次任意的命令；

## `.  mark .会记录 record the last change pos  

## `是代表的是 去的意思 
## .代表的是上一次命令的位置； 
## 所以连起来 `.代表的是去上一次 命令的位置；
`````



## 连贯操作



vim 快捷命令
Vim 有一个模块化的结构，允许你使用各种命令的组合操作。大多数命令有两个、三个或四个部分。三部分结构的一个版本是这样的：

**操作符（operator）- 文本对象（text object）- 动作（motion）。**

vim 操作符
操作符包括删除（delete）、更改（change）、视觉选择（visual select）和替换（replace），每次选一个使用。

vim 文本对象
**文本对象要么在内部（inside）要么在周围（around）。**

vim 动作
动作有很多种，可以把动作看作是命令的一种目标。举个例子，我可以按 dib，意思是在块内删除（delete inside block）。

**其中操作符是 delete，文本对象是 inside，动作是 block。这样就可以删除一个（括号）块内的所有内容。**

可选的组合数量很多：

di'——删除（delete）“单引号”内（inside）的内容。

da"——删除“双引号”周围（around）的内容。是包括括号的

dit——删除 html 标签（tag）内的内容。

ci[——改变（change）[方括号] 内的内容。

diw  就是删除一个单词 或者 ciw 修改一个单词，这是我们使用比较多的；

ciw 是修改一个单词；

可供选择的动作命令有很多，它们的表现也各不相同，具体取决于你是在三部分组合中使用，还是在两部分组合中使用（这时去掉文本对象，让命令从光标位置向后运行）。

下面是你可以在上述三段式组合中使用的一些相关动作的清单。

--------------------------------------------------
| motions                       | key    |
| ----------------------------- | ------ |
| word                          | w      |
| WORD (includes special chars) | W      |
| block (of parentheses)        | b or ( |
| BLOCK (of curly braces)       | B or { |
| brackets                      | [      |
| single quotes                 | '      |
| double quotes                 | "      |
| tag (html or xml <tag></tag>) | t      |
| paragraph                     | p      |
| sentence                      | s      |

这里做一下简单总结

更改匹配标点符号中的文本内容，c 表示 change，i 表示inside。
ci’、ci”、ci(、ci[、ci{、ci< -
1
删除匹配标点符号中的文本内容，d 表示 delete，i表示inside。
di’、di”、di(或dib、di[、di{或diB、di< -
1
复制匹配标点符号中的文本内容
yi’、yi”、yi(、yi[、yi{、yi< -
1
选中匹配标点符号中的文本内容
vi’、vi”、vi(、vi[、vi{、vi< -
————————————————
版权声明：本文为CSDN博主「CodingCos」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。
原文链接：https://blog.csdn.net/sinat_32960911/article/details/131977001
