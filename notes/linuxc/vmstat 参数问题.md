#  vmstat 参数问题



##前言

````shell
NAME
#       vmstat - Report virtual memory statistics
````


vmstat 报告有关processes，memory， paging，block IO，traps，disks 和 cpu activity的信息。这些报告旨在帮助识别系统瓶颈，Linux vmstat并不将自己视为正在运行的进程。
vmstat用来观测系统整体的性能情况，并不能观测单个进程，单个进程观测可以用pidstat。

###一、vmstat简介
虚拟内存统计命令vmstat提供系统内存运行状况的高级视图，包括当前可用内存和分页统计信息。

delay：更新时间间隔，以秒为单位。如果没有指定延迟，则只打印一个报告，其中包含自引导以来的平均值。
count：更新次数。在没有指定count的情况下，当定义了delay时，count默认值则为无限大。

vmstat每两秒显示一次，显示五次：

`````shell
[root@localhost ~]# vmstat -w 2 5
procs -----------------------memory---------------------- ---swap-- -----io---- -system-- --------cpu--------
 r  b         swpd         free         buff        cache   si   so    bi    bo   in   cs  us  sy  id  wa  st
 0  0            0      1100516        17264      5916084    0    0     1     1    4    2   2   1  97   0   0
 0  0            0      1100292        17264      5916084    0    0     0     0  729 3516   5   2  93   0   0
 1  0            0      1100268        17264      5916084    0    0     0     4  825 3379   5   2  93   0   0
 1  0            0      1100020        17264      5916084    0    0     0     0  831 3464   6   2  92   0   0
 0  0            0      1099872        17264      5916084    0    0     0     2  908 3519   5   2  93   0   0
`````


我们可以看到第一行数据的与其他行的数据差异较大（比如 in 和 cs 这两个数据），查看man手册说明：

`````shell
The  first report produced gives averages since the last reboot.  Additional reports give information on a sampling period of length delay.  The process and memory reports are instantaneous in either case.
`````


第一行数据是系统启动以来的平均值，其他行才是你在运行 vmstat 命令时，设置的间隔时间的平均值。另外，进程和内存的报告内容都是即时数值。

### 1.1 processes

`````shell
Procs
    r: The number of runnable processes (running or waiting for run time).
    b: The number of processes in uninterruptible sleep.
`````

**r 表示 处于运行态的进程，正在执行或者正在运行队列中等待运行。**
**通过ps或top显示为 R 状态（Running 或 Runnable）的进程。**

**b 表示 不可中断的处于睡眠态的进程，进程正在睡眠（阻塞），等待某些条件的达成。但是与 interruptible sleep 的进程不一样的是，该进程在等待条件的过程中，不会对信号做出任何响应。**
**通过ps或top显示为D状态的进程就是处于uninterruptible sleep的进程，该类型进程通常是等待硬件设备的 I/O 响应等重要的操作，或者持有一个信号量。**
**比如，当一个进程向磁盘读写数据时，为了保证数据的一致性，在得到磁盘回复前，它是不能被其他进程或者中断打断的，这个时候的进程就处于不可中断状态。如果此时的进程被打断了，就容易出现磁盘数据与进程数据不一致的问题。**
**不可中断状态是系统对进程和硬件设备的一种保护机制。**

###1.2 memory
````shell
 swpd: the amount of of swapped-out memory.
 free: the amount of idle memory (Free available memory).
 buff: the amount of memory used as buffers (buffer cache).
 cache: the amount of memory used as cache (page cache).
````


buff/cache：系统中的空闲内存（free memory）在系统启动后，如果空闲内存（free memory）较多，会有一部分用来当作缓存，以提高系统性能。这部分缓存可以在需要的时候（free memory不够的时候）释放出来供应用程序使用。

缓存（buff/cache）占用实际的物理内存，通常缓存的是磁盘上的数据，用来减少对磁盘I/O的操作，把对磁盘的访问变成对物理内存的访问，应该缓存经常访问的数据（热数据），而不是不常访问的数据（冷数据）。

### Swap

````shell
si: Amount of memory swapped in from disk (/s).
so: Amount of memory swapped to disk (/s).
````

如果 the si and so 持续非零，则系统处于内存不足的状态，内存的一些数据（最近没有访问的数据，非活跃的数据）正在交换到 swap device（Swap分区，匿名页被交换到Swap分区） 或者 file（file-backed pages会被直接写入到文件中）中。

anonymous pages和file-backed pages：

Linux一个进程使用的内存分为2种：
file-backed pages（有文件背景的页面，比如代码段、比如read/write方法读写的文件、比如mmap读写的文件；他们有对应的硬盘文件，因此如果要交换，可以直接和硬盘对应的文件进行交换），此部分页面进page cache。
anonymous pages（匿名页，如stack，heap，CoW后的数据段等；他们没有对应的硬盘文件，因此如果要交换，只能交换到虚拟内存-swapfile或者Linux的swap硬盘分区），此部分页面，如果系统内存不充分，可以被swap到swapfile或者硬盘的swap分区。
具体可参考：swappiness=0究竟意味着什么？

如果系统开启了Swap分区，在物理内存不够用时，操作系统会从物理内存中把部分暂时不被使用的数据转移到交换分区，从而为当前运行的程序留出足够的物理内存空间。通常生产环境不会开启Swap分区，会影响性能。

查看交换分区：

`````shell
[root@localhost ~]# free -h human
              total        used        free      shared  buff/cache   available
Mem:           7705         837        1502         138        5365        6275
Swap:          7935           0        7935
# type -t 命令的类型；
[root@810c31373153 proc]# type -t free
file
`````

### 1.3 block IO
`````shell
 bi: Blocks received from a block device (blocks/s).
 bo: Blocks sent to a block device (blocks/s).
所有 linux blocks 目前都是1024字节。#不应该是 4k字节码？

`````

### 1.4 System

``````shell
System
    in: The number of interrupts per second, including the clock.(时钟中断；) ##时钟信号是不是就是时间的分片？？
    cs: The number of context switches per second.  context switch cs 上下文切换；
``````


其中 in 代表系统每秒发生中断的次数，包括时钟中断（是否包括了系统软中断）。

其中 cs 代表系统每秒上下文切换的次数，显示了系统总体的上下文切换情况。
上下文切换包括：进程上下文切换、线程上下文切换以及中断上下文切换（是否包括了系统调用上下文切换）。

man 手册中指出：没有统计系统调用的数目，cs应该没有包括系统调用上下文切换的次数。

````shell

Does not tabulate the block io per device or count the number of system calls.
````

###1.5 cpu activity

`````shell
CPU
    These are percentages of total CPU time.
    us: Time spent running non-kernel code.  (user time, including nice time)
    sy: Time spent running kernel code.  (system time)  系统时间；
    id: Time spent idle. cpu空间时间；Mt #idle
    wa: Time spent waiting for IO.
    st: Time stolen from a virtual machine. #stolen 偷窃虚拟机的cpu 时间；
`````
