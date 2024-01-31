# gcc

>GNU complier collection   new complier collection ; 编译器的集合 可以编译很多语言；collection



看编译器的支持多少位？？？

##1

您可以检查`gcc -v`的输出，或者使用更直接的选项`-dumpmachine`。第一个选项允许您发现GCC是否支持multilib（以便它可以编译32位和64位二进制文件），第二个选项将只返回默认目标（如果我没有弄错的话）。

`````shell
$ gcc -dumpmachine
mingw32
`````

## 2

编写如下C代码：

```c
#include<stdio.h>
#include<stdlib.h>
void main(){   
    int*pointer;   
    printf("%d", sizeof(pointer));  
}
```

然后编译并运行
如果输出显示8，则编译器版本为64位，否则如果输出显示4，则编译器版本为32位，c指针的大小等于编译器版本
8表示8字节= 64位
4表示4个字节= 32位



## command and run



## GCC的命令格式；![img](gcc.assets/v2-f45de959011fda57a26d5dadbe46a20a_720w.webp)

>gcc 参数，g ，o，c

`````c
// -c   gcc hello.c =====> hello.o // 只执行到编译部分； 预处理 编译 汇编 链接 执行文件；compile

// -o 可以修改 目标文件的名字,输出重定向而已；gcc hello.c -o app ====> app
// -g  gdb调试器； gcc -g hello.c -o hello.o  // 并没有报错；
// gcc hello.c ====> a.out 
//  直接执行 gcc hello.c 就行 生成可执行文件 默认是a.exe  windows系统中，是这样的；
// 
5. gcc -g source_file.c
 // dgb  就是程序调试器；
//  debugger，简称「GDB 调试器」，是Linux 平台下最常用的一款程序调试器。
　　 -g，生成供调试用的可执行文件，可以在gdb中运行。由于文件中包含了调试信息因此运行效率很低，且文件也大不少。这里可以用strip命令重新将文件中debug信息删除。这是会发现生成的文件甚至比正常编译的输出更小了，这是因为strip把原先正常编译中的一些额外信息（如函数名之类）也删除了。用法为 strip a.out
    // 输出目标文件；  
    3. gcc -c source_file.c

　　//-c，只执行到编译，输出目标文件。
    
    
    1. gcc -E source_file.c

　　//-E，只执行到预编译。直接输出预编译结果。预处理，预处理结果；

    //输出的是汇编；
2. gcc -S source_file.c

　　 -S，只执行到源代码到汇编代码的转换，输出汇编代码。

//
3. gcc -c source_file.c

　　-c，只执行到编译，输出目标文件。

 // 输出  几个过程；// 预处理->编译->汇编->链接->执行；
4. gcc (-E/S/c/) source_file.c -o output_filename

　　-o, 指定输出文件名，可以配合以上三种标签使用。-o 参数可以被省略。这种情况下编译器将使用以下默认名称输出：

　　-E：预编译结果将被输出到标准输出端口（通常是显示器）

　　-S：生成名为source_file.s的汇编代码

　　-c：生成名为source_file.o的目标文件。 不要去链接！！！
    
    gcc：无标签情况：生成名为a.out（a.exe）的可执行文件。
    // 注意 目标文件和可执行文件的区别；
    //目标文件链接之后才会生成可执行！！！
    //不指定 -o 那么就是默认的a.* 上述都是这样的！！
    // gcc -E hello.c -o hello  他会自动给你后缀 .i  并不会自己加后缀，你需要重定向 保存到一个文件里面，就是这样！！
    // -o 就是重定向的意思！！
 // gcc test.c 直接生成可执行文件；
    
    [root@810c31373153 linuxc]# gcc --help
  -v                       Display the programs invoked by the compiler
  -###                     Like -v but options quoted and commands not executed
  -E                       Preprocess only; do not compile, assemble or link
  -S                       Compile only; do not assemble or link
  -c                       Compile and assemble, but do not link
  -o <file>                Place the output into <file>
  -pie                     Create a position independent executable
`````





## 详解四个过程



接下我们看看编译过程不同阶段都在做什么。

**1.预处理**
编译过程的第一步预就是预处理，与处理结束后会产生一个后缀为(.i)的临时文件，这一步由预处理器完成。预处理器主要完成以下任务。

- 删除所有的注释
- 宏扩展
- 文件包含

预处理器会在编译过程中删除所有注释，因为注释不属于程序代码，它们对程序的运行没有特别作用。

宏是使用 **#define** 指令定义的一些常量值或表达式。宏调用会导致宏扩展。预处理器创建一个中间文件，其中一些预先编写的汇编级指令替换定义的表达式或常量（基本上是匹配的标记）。为了区分原始指令和宏扩展产生的程序集指令，在每个宏展开语句中添加了一个“+”号。

文件包含
C语言中的文件包含是在预处理期间*将另一*个包含一些预写代码的文件添加到我们的C程序中。它是使用**#include**指令完成的。在预处理期间包含文件会导致在源代码中添加**文件名**的全部内容，从而替换**#include<文件名>**指令，从而创建新的中间文件。

2.**编译**
C 中的编译阶段使用内置*编译器软件*将 （.i） 临时文件转换为具有汇编级指令（低级代码）的汇编**文件** （.s）。为了提高程序的性能，编译器将中间文件转换为程序集文件。
汇编代码是一种简单的英文语言，用于编写低级指令（在微控制器程序中，我们使用汇编语言）。整个程序代码由编译器软件一次性解析（语法分析），并通过终端窗口告诉我们源代码中存在的任何**语法错误**或**警告**。
下图显示了编译阶段如何工作的示例。

**3.组装**
使用汇编*程序*将程序集级代码（.s 文件）转换为机器可理解的代码（二进制/十六进制形式）。汇编程序是一个预先编写的程序，它将汇编代码转换为机器代码。它从程序集代码文件中获取基本指令，并将其转换为特定于计算机类型（称为目标代码）的二进制/十六进制代码。
生成的文件与程序集文件同名，在 DOS 中称为扩展名为 **.obj** **的对象文件**，在 UNIX 操作系统中扩展名为 **.o**。
下图显示了组装阶段如何工作的示例。程序集文件 hello.s 将转换为具有相同名称但扩展名不同的对象文件 hello.o。

**4. 链接**
链接是将库文件包含在我们的程序中的过程。*库文件*是一些预定义的文件，其中包含机器语言中的函数定义，这些文件的扩展名为.lib。一些未知语句写入我们的操作系统无法理解的对象 （.o/.obj） 文件中。你可以把它理解为一本书，里面有一些你不知道的单词，你会用字典来找到这些单词的含义。同样，我们使用*库文件*来为对象文件中的一些未知语句赋予意义。链接过程会生成一个**可执行文件**，其扩展名为 **.exe** 在 DOS 中为 .out，在 UNIX 操作系统中为 **.out**。
下图显示了链接阶段如何工作的示例，我们有一个具有机器级代码的对象文件，它通过链接器传递，链接器将库文件与对象文件链接以生成可执行文件。

### 举例

接下来，我们通过一个例子详细看看C编译过程中涉及的所有步骤。第一步先写一个简单的C程序并保存为hello.c

```c
// Simple Hello World program in C
#include<stdio.h>
int main()
{
    // printf() is a output function which prints
    // the passed string in the output console
    printf("Hello World!");
    
    return 0;
}
```

接着我们执行编译命令对hello.c进行编译：

```shell
gcc -save-temps hello.c -o compilation
```

*-save-temps* 选项会保留所有编译过程中产生的中间文件，总共会生成四个文件。

- hello.i 预处理器产生的文件
- hello.s 编译器编译后产生的文件
- hello.o 汇编程序翻译后的目标文件
- hello.exe 可执行文件(Linux系统会产生hello.out文件)





----

## 简述过程

> 当我们写好了C语言的代码之后，下一步就是gcc编译运行，这里对gcc代码的部分参数加以解释。
> 一个程序最终是为了生成一个可执行文件。
> 完整的流程：源程序，预处理，编译生成汇编，汇编生成目标文件   可执行文件
> ——————---.c———.i—————.s——-------------—.o —--------------.exe(.out)（自动执行，可执行文件）

示例：

一、不使用参数，直接gcc
通过gcc 不加参数可以一步直接编译生成可执行文件.

````shell
gcc main.c

````

_这里自动生成的是可执行文件默认为a.out，当然可以通过-o选项更改生成文件的名字，比如将生成的可执行文件命名为HelloWord；HelloWord.exe；HelloWord.o；…(无所谓的后缀）

_为了以防混淆，还是建议根据源程序，预处理，编译生成汇编，可执行文件步骤写出相应的后缀，比如默认生成的是aaaa.o文件，修改为test.o即可，保持后缀一样，至于怎么判断后缀，了解本文开始的引言部分就明白了。

二、只使用 -o output  更改输出的文件名；

> 用法：在 -o 后面输入自定义的文件名

````shell
gcc  HelloWord.c -o  HelloWord
# 这个HelloWord.c是目标文件，不是可执行文件，执行文件是自动生成的a.out 
# 想修改a.out的名字为HelloWord，HelloWord是可执行文件
````

三、只使用 -c

> ！注意：第一步这里不生成一个可执行文件

````shell
gcc -c HelloWord.c 

# _这个HelloWord.c是目标文件，不是可执行文件，因为这里用到了-c，
# 告诉gcc到汇编为止，不要进行链接。

# _链接就是将目标文件、启动代码、库文件链接成可执行文件的过程，
# 这个文件可被加载或拷贝到存储器执行。

# _会生成一个HelloWord.o的文件
````

````shell
gcc HelloWord.o
# 到第二步才会生成一个默认名为a.out的可执行文件。
````

* 如果想要修改默认的可执行文件名字，第二步这里替换

```shell
gcc HelloWord.o -o HelloWord
# 生成一个名字为HelloWord的可执行文件
```

四、实例代码解释（混合使用）

`````shell
gcc -c test.c -o AA.o
#因为含有-c，所有自动生成同名的.o文件(test.o),修改名字为AA.o
`````

