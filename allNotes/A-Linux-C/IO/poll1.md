# poll

----



`````c
// 文件描述符绑定事件！
NAME
       poll, ppoll - wait for some event on a file descriptor   

SYNOPSIS
       #include <poll.h>

       int poll(struct pollfd *fds, nfds_t nfds, int timeout); 

//
struct pollfd {
               int   fd;         /* file descriptor */
               short events;     /* requested events */
               short revents;    /* returned events */
           };

//timeout  毫秒  1000ms = 1s
不设置还是阻塞的！！
 >0  超时设置！
 0，非阻塞，看一下有事件发生就记录返回，没有事件发生我也回来！
 -1 阻塞；
    
 //return vlaue
    RETURN VALUE
       On success, a positive number is returned; this is  the  
       number  of structures which have nonzero revents fields  
       (in other  words,  those  descriptors  with  events  or  
       errors reported).  A value of 0 indicates that the call  
       timed out and  no  file  descriptors  were  ready.   On  
       error, -1 is returned, and errno is set appropriately.   

ERRORS
       EFAULT The array given as argument was not contained in  
              the calling program's address space.

       EINTR  A signal occurred before  any  requested  event;  
              see signal(7).
`````







