# GDB 调试

>

---

gcc -g main.c -o main

// gdb attach pid_name   调试运行的程序；

gdb main

r  run 运行代码；

b breakpoint main  //打断点

d 1;删除beakpoint num = 1

info b  查看断点和 wait吧

watch i  // 监视i这个变量；

c continue 继续； 运行到下一个断点开始；

q quit 退出调试

enter 回车 继续上一个命令；

n next step  不进入函数的运行；

p i ;打印变量i；print

s 是进入到函数内运行； 进入函数运行；

kill 杀死正在运行的代码，或者说进程；

bt 栈的调式，backchoice   返回选项！！1

info r  查看寄存器；

info   f 查看帧的信息！！ 堆栈信息！！！



gdb 如何查看堆栈信息和寄存器信息？
在使用GDB调试程序时，可以通过以下命令查看堆栈信息和寄存器信息：

查看堆栈信息 bt：查看当前函数调用栈，即当前函数调用的上一层函数以及它们的调用栈信息。 up/down n：在堆栈中向上/向下移动n层。
frame n：切换到第n层堆栈。 info frame：查看当前堆栈帧的信息，包括函数名、参数、返回地址等。 info
args：查看当前函数的参数信息。 info locals：查看当前函数的局部变量信息。 查看寄存器信息 info
registers：查看所有寄存器的值。 info registers reg：查看指定寄存器reg的值，如info registers
rax。 print /x $reg：以16进制格式查看指定寄存器reg的值，如print /x $rax。 set $reg =
value：设置指定寄存器reg的值为value，如set $rax = 0x1234。
以上是常用的GDB命令，可以通过这些命令查看堆栈信息和寄存器信息，方便调试程序。





- list：展开调试的源代码，缩写 l；
- break：设置断点，缩写为 b；
- info break：查看断点信息，缩写为 i b
- delete：删除断点
- print：打印变量的值，缩写为 p；
- run：程序开始运行，缩写 r，在 r 后可以加入程序启动启动参数，程序运行到断点处暂停；  // 可以的！！！！ 也可以重新开始！！
- step：单步调试，可以进入子函数，缩写为 s；//可以进入到函数！！！
- next：单步调试，不进入子函数，缩写为 n；
- continue：程序继续运行，，到下一断点处暂停，缩写为 c；
- set args：设置运行参数    set args a b c d
- show args：查看运行参数
- **gdb attatch pid：加载运行中的进程进行调式**
- dir dirname ... ：指定源目录
- x/28hx ---：以十六进程输出内存块数据
- kill：停止调试
- 段错误调试：
  - 通过 ulimit 命令查看一下系统是否配置支持了 dump core 的功能。通过 ulimit -c 或 ulimit -a，可以查看 core file 大小的配置的情况，如果为 0，则表示系统关闭了 dump core；可以通过 ulimit -c unlimited 来打开。若发生了段错误，但没有 core dump，是由于系统禁止 core 文件的生成。
  - gdb [exec file] [core file] | gdb -c corefile execfile
  - backtrace：查看堆栈信息，缩写为 bt，注意 run 到出错的地方后，运行此命令，可以查看到错误的地方
  - frame 堆栈错误编号：切换到编号处堆栈
  - 之后用 gdb 的通用调试命令查看参数等  gdb info；

l 100 list  100行之后的代码 方便 打断点；

b 10 给第10行加断点 breakpoint

p i;打印某一个变量；



核心文档（core file），也称核心转储（core dump），在汉语中有时戏称为吐核，是[操作系统](https://www.frdic.com/dicts/wiki/操作系统.html)在[进程](https://www.frdic.com/dicts/wiki/进程.html)收到某些[信号](https://www.frdic.com/dicts/wiki/信号_(计算机科学).html)而终止运行时，将此时进程地址空间的内容以及有关进程状态的其他信息写出的一个磁盘文档。这种信息往往用于[调试](https://www.frdic.com/dicts/wiki/调试.html)。