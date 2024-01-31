# select IO





---

## IO多路转接

>监视文件描述符的形式！
>
>当文件描述符有了动作，我们才去；
>
>我们需要布置我们的监控现场！！
>
>三种方式： **监视文件描述符的行为！**
>
>* select ();
>* poll()；
>* epoll():
>
>select 兼容性比较好！！
>
>poll  兼容和移植性会比较好！
>
>epoll 不能移植，专属于linux；



文件描述符有动作，我们才会去，获取 文件描述符的变化！！！

去掉忙等！！

## select

````c
//

NAME
       select,  pselect,  FD_CLR,  FD_ISSET, FD_SET, FD_ZERO -  
       synchronous I/O multiplexing

SYNOPSIS
       /* According to POSIX.1-2001 */
       #include <sys/select.h>

       /* According to earlier standards */
       #include <sys/time.h>
       #include <sys/types.h>
       #include <unistd.h>
	//nfds 你监视的最大文件描述符+1；
    // readfds,writefds,exceptfds
    //timeout 超时！！ 要设置，不设置会忙等！！
    //readfds会发生变化，writefds 是 会发生变化的！！
       int select(int nfds, fd_set *readfds, fd_set *writefds,  
                  fd_set *exceptfds, struct timeval *timeout);



       void FD_CLR(int fd, fd_set *set);  // 删除；删除fd_set 集合中的文件描述符；
       int  FD_ISSET(int fd, fd_set *set); // 是否存在于某一个集合当中！！
       void FD_SET(int fd, fd_set *set); // 设置，放在集合中去；
       void FD_ZERO(fd_set *set);  // 清空！！！ ZERO 清空！！！

//return  value
//发生了你感兴趣的行为的个数！！





//code
//select 监视  不会去忙等，直到发生了变化！
//布置监视任务

//监视

//查看监视结果！

//根据监视结果做相应的操作！




//注意 accept 和 recv 这两个函数 都是阻塞的，因为你并不知道什么客户端什么时候来建立连接，或者发送信息！！！
//send并不是阻塞模型；
````

## relay.c

>我们去不断的尝试！！ 去recv去看一下文件描述符是否发生变化！！