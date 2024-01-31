# 信号

>信号的概念；
>
>signal()函数;
>
>信号的不可靠；
>
>可重入函数；
>
>信号的响应过程；
>
>信号常用函数；kill raise alarm pause abort() system() sleep()的问题，等待一个信号；
>
>信号集合；
>
>信号屏蔽处字/pending集处理；
>
>扩展 sigsuspend() sigaction setitimer();
>
>实时信号

----

## 信号概念；

 >信号是软件中断；
 >
 >信号的是应用层中断；
 >
 >信号的响应依赖于中断！！！
 >
 >SIGRTMIN 实时信号 real time  1-32 是标准信号！！！