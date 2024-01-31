# Vim

> **如何用 vim 和 配置vim**

vim ! ls /usr/local  暂时去这个文档； 可以返回；

**.vimrc**   **vim的run command**  source .vimrc   rc 运行命令

**删除和复制 都是包含本光标所在的行或者元素**

**vim中的ddp 就是移动某一行；**

**dw删除一个单词；    **    **向后删除  也删除当前元素**  包括光标所在的元素；

**db  向前删除**  不包括 光标所在的元素

**d3i    网上删除三行       不包含  本行 向上删除3行；**

**d3k  往下删除3行；** **包括自己这一行 一共四行**

**yny  复制三行**

**d3d 删除三行；**

**yL**  **面向字符字符复制一行；**  **然后p可以在光标之后粘贴**

**ynw**  **面向字符复制多个单词**

**dL**  **面向字符的；复制这行并且删除这行；** 

**dd**  **面向行的；**       **p 只能复制在下一行；**



The last change is held in the mark named `.` so you can jump to the mark with `. (backtick, dot) or '. (apostrophe, dot). See:

```
:help mark-motions
:help '.
```

how-to-paste-in-the-line-where-the-cursor-is

这一切都取决于您要粘贴的寄存器中的数据类型。如果数据是面向行的数据（yy例如，拉动），它将作为整行粘贴在光标上方或下方。如果数据是面向字符的（用 eg 拉出y2w），那么它将被粘贴到当前行中的光标位置或之前。

`:help linewise-register`有关寄存器类型和 put 命令之间交互的更多信息，请参阅



**该命令p粘贴在光标下方并P粘贴在光标上方。粘贴到光标所在行的命令是什么？**

**可以使用yL这个命令； 然后p复制到光标之后；**  yL 就是复制光标到本行结束 ；





删除命令 x【删除光标所在字符】
**nx【删除光标所在处后n个字符】**
**dd【删除光标所在行，ndd删除n行】**
**dG【删除光标所在行到末尾的内容】**
**D【删除从光标所在处到行尾】**
:n1,n2d【删除指定的行】
:10,20d 【删除第十行到第20行的内容】
光标移到第一行，然后dG【删除所有内容】

小贴士，一般在操作在本地编辑好的文档，全部复制，然后将服务器文档 dG全部删除，在粘贴新的文档。

复制剪切命令 yy、Y【复制当前行】
nyy、nY【复制当前行一下n行】
**dd【剪切当前行】**
**ndd【剪切当前行一下n行】**
**p、P【粘贴在当前光标所在行下活行上】**

替换和取消命令 r 【取代光标所在处字符】
R【从光标所在处开始替换字符，按Esc结束】
**u【取消上一步操作】**
Ctrl+r 【恢复上一步被撤销的操作】



### 键盘绑定 :help map-overview
**vim最大的特点在于可以把所有的操作能够用一个命令字符串表达出来，**
**因此这带来了编写脚本的最大的便利。键盘绑定就是一个例子，这个功能允许**
**把一个命令字符串绑定到一个按键/按键组合。**

一般格式：映射命令 按键组合 命令组合
例子：nmap c ^i#<Esc>j
解释：映射normal模式下的按键c为：^i#<Esc>j，就是在该行开头加上#号
，然后下移一行

常用映射命令：
**map :全模式映射**  **noremap 处于这一个级别的；**
**nmap :normal模式映射**
**vmap :visual模式映射**
**imap :insert模式映射**

**nnoremap/nmap仅在Normal模式下工作,但noremap/map将在Normal,Visual,Select和Operator-pending模式下工作.**

**noremap norecusion  不递归；**



### 注释 .vimrc 注释需要双引号；  linux 操作系统中；

`````shell
  1 let mapleader=" "
  2 "   i
  3 "<j   l>
  4 "   k
  5
  6 nnoremap "" mQlbi"<ESC>ea"<ESC>`Ql
  7 noremap i k
  8 noremap j h
  9 noremap k j
 10 noremap l l
 11 " insert
 12 noremap h i
 13 noremap H I
 14 noremap I H
 15 noremap J 0
 16 noremap L $
 17 noremap m 5j
 18 noremap M 5k
 19
 20 noremap <LEADER><CR> :nohlsearch<CR>
 21 syntax on   
 22 set number
 23 set hlsearch
 24 set ignorecase
 
 25 set scrolloff=30
 26 set ts=4
 	set autoindent  ## 自动缩进；
 	set cursorline

 27 map R :source $MYVIMRC<CR>
 28 map Q :wq<CR>
 
 ## 比较常用到的就是这些配置；
 
set encoding=utf-8 #设置编码格式
set ff=unix #将文件格式转为unix格式
set paste    #粘贴赋值的时候用；

##前缀键的扩展；
let mapleader=' '
noremap <LEADER><CR> :nohlsearch<CR>
`````





**模式：**

* 普通模式 normal

  * 移动

    `````
    w  单词头的移动
    e  单词尾的移动
    shift +l  行末尾
    shift +j  行开头
    m   浏览，5行的浏览
    b w的反操作
    ijkl  上下移动
    f + 字符串 查找  fa：将光标移到右边的第一个字符a上，继续按';'（分号），可以延相同的方向找到下一个a，继续按','（逗号），可以延反方向找到下一个a
    `````

  * 进入插入模式：

    `````
    i   shift +u
    o   shift + o
    a   shift +a
    
    c 	shift +c   修改并插入  cc  删除整行 然后插入 chw ch" 修改
    `````
    
    

* 插入模式 insert

  

* 可视模式  visual

  选中

* 命令模式 command

  :set number

  :set hlsearch 

**批量操作模式**

 可视化模式 

1. ctrl + v可视化选中  然后 切插入模式 插入  然后esc 进行的批量操作；可视化模式 选中  可以用x 来删除
2. 给字符串加“”的操作；nnoremap "" mQlbi"<ESC>ea"<ESC>`Ql

 **映射方式map**

noremap  nore 不进行递归；

map

 **i n c v** 四种模式可以组合

noremap

inoremap  映射

**set number 这个是命令行；**

**set scrolloff=5** 

vsplit  分屏；



缩进和 Tab

tab 设置为四个字符

**tabstop=4;**

**set ts=4**

**自动对齐文件中行的缩进：  自动缩进；**

**set autoindent**





智能缩进使用了代码语法和样式来对齐：

**set smartindent**

提示：vim 具有语言感知功能，并根据文件中所使用的编程语言提供了默认的设置，让工作更高效。有很多默认配置命令，包括 axs cindent、cinoptions、indentexpr 等，这里就不做进一步的介绍。syn 是一个有用的命令，用于显示或设置文件语法。

设置 Tab 的空格数量：

**set tabstop=4**  ts=4 

**set sm  括号匹配高亮**



set mouse=a

**启用鼠标后，按住Shift键仍可使用鼠标按钮。这包括使用鼠标按钮复制粘贴。** 



set showmatch  :set noshowmatch ⾼亮显⽰(set noshowmatch不显⽰){, }, (, ), [, 或者 ] 的匹配情况
--------------------------------------------------------



### 格式的配置



**:set encoding=utf-8 #设置编码格式**
**:set ff=unix #将文件格式转为unix格式**
**:set paste**



#### 目前的个人配置  后面会将继续更新 .vimrc 

`````shell
 let mapleader=" "
  2 "   i
  3 "<j   l>
  4 "   k
  5
  6 nnoremap "" mQlbi"<ESC>ea"<ESC>`Ql
  7 noremap i k
  8 noremap j h
  9 noremap k j
 10 noremap l l
 11 " insert
 12 noremap h i
 13 noremap H I
 14 noremap I H
 15 noremap J 0
 16 noremap L $
 17 noremap m 5j
 18 noremap M 5k
 19
 20 noremap <LEADER><CR> :nohlsearch<CR>
 21
 22 syntax on
 23 set number
 24 set hlsearch
 25 set ignorecase
 26 set scrolloff=30
 27
 28 "tab
 29 set ts=4
 30 set autoindent
 31 set sm
 32
 33 set ff=unix
 34 set encoding=utf-8
 36
 37 map R :source $MYVIMRC<CR>
 38 map Q :wq<CR>
`````



### vimrc设置空格键

**Vim预置有很多快捷键，再加上各类插件的快捷键，大量快捷键出现在单层空间中难免引起冲突。为缓解该问题，而引入了前缀键<leader>。藉由前缀键， 则可以衍生出更多的快捷键命名空间（namespace)。例如将r键配置为<leader>r、<leader><leader>r等多个快捷键。**

**使用`:help <leader>`命令，可以查看关于前缀键的更多信息。**

## **定义前缀键**

前缀键默认为“\”。使用以下命令，可以将前缀键定义为逗号：

```vim
let mapleader=","
```

使用以下命令，利用转义符“\”将前缀键设置为空格键也是不错的主意：

```vim
let mapleader = "\<space>"
```

## **配置实例**

定义以下快捷键，用于删除当前文件中所有的行尾多余空格：

```vim
nnoremap <leader>W :%s/\s\+$//<cr>:let @/=''<CR>
```

定义以下快捷键，用于快速编辑和重载[vimrc配置文件](https://link.zhihu.com/?target=http%3A//yyq123.github.io/learn-vim/learn-vi-59-vimrc.html)：

```vim
nnoremap <leader>ev :vsp $MYVIMRC<CR>
nnoremap <leader>sv :source $MYVIMRC<CR>
```

定义以下快捷键，使用前缀键和数字键快速切换[缓冲区](https://link.zhihu.com/?target=http%3A//yyq123.github.io/learn-vim/learn-vi-13-MultiBuffers.html)：

```vim
nnoremap <leader>1 :1b<CR>
nnoremap <leader>2 :2b<CR>
nnoremap <leader>3 :3b<CR> 
```

https://blog.csdn.net/cbaln0/article/details/87979056



vim有着强大的替换和查找功能,若能进行熟练的运用,可以让工作效率得到一个很大程度的提高.

替换

语法:[addr]s/源字符串/目的字符串/[option]

[addr]表示检索范围,如:

**"1,n":表示从第1行到n行**
**"%":表示整个文件,同"1,$a$":表示从当前行到文件尾**

[addr]省略时表示当前行

**s:表示替换操作,其为substitute的缩写**

[option] : 表示操作类型,如:

**g:globe,表示全局替换**

**c:confirm,表示进行确认**

**p:表示替代结果逐行显示(Ctrl + L恢复屏幕)**

**i:ignore,不区分大小写**

[option]省略时仅对每行第一个匹配串进行替换

如果在源字符串和目的字符串中出现特殊字符,如'/','<','>',','等需要前面加反斜杠\进行转义

 

常用命令示例:

#将当前行第一个a替换为b

:s/a/b/

 

#将当前行的所有a替换为b

**:s/a/b/g**

 

#将每行第一个a替换为b

:%s/a/b

 

#将整个文件的所有a替换为b

**:%s/a/b/g**

 

#将1至3行的第一个a替换为b 

:1,3s/a/b/

 

#将1至3行的所有a替换为b

:1,3s/a/b/g

 

上面是一些常用的替换,但是我们日常碰到的问题不止这么简单,这就要涉及到一些较为高级的替换操作,会涉及到转义,正则表达式相关的知识,下面是一些例子:

#使用#作为分隔符,此时中间出现的/不会作为分隔符,如:将当前行的字符串"a/"替换为"b/"

:s#a/#b/#

 

#找到包含字母a的行并删除

:g/a/d

 

#删除所有空行
:g/^$/d

 

 #多个空格替换为一个空格

:s/ \+/ /g

 

#在正则表达式中使用和和符号括起正则表达式,即可在后面使用\1,\2等变量来访问和和中的内容,如下
将data1 data2修改为data2 data1
:s/\w\+\w\+\s\+\w\+\w\+/\2\t\1

