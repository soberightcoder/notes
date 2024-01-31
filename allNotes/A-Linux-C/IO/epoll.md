# epoll

>epoll

---

## epoll 函数

````c
epoll_create();


NAME
       epoll_create, epoll_create1 - open an epoll file descriptor

SYNOPSIS
       #include <sys/epoll.h>

       int epoll_create(int size);
       int epoll_create1(int flags);




NAME
       epoll_ctl - control interface for an epoll descriptor

SYNOPSIS
       #include <sys/epoll.h>

       int epoll_ctl(int epfd, int op, int fd, struct epoll_event *event);


//op 选项：
       Valid values for the op argument are :

       EPOLL_CTL_ADD
              Register  the  target  file  descriptor  fd  on  the  epoll instance   
              referred to by the file descriptor  epfd  and  associate  the  event   
              event with the internal file linked to fd.

       EPOLL_CTL_MOD
              Change  the  event  event associated with the target file descriptor   
              fd.

       EPOLL_CTL_DEL
              Remove (deregister) the target file descriptor  fd  from  the  epoll   
              instance  referred to by epfd.  The event is ignored and can be NULL   
              (but see BUGS below).
           
           
               typedef union epoll_data {
               void        *ptr;
               int          fd;
               uint32_t     u32;
               uint64_t     u64;
           } epoll_data_t;

           
           //struct epoll_event
                struct epoll_event {
               uint32_t     events;      /* Epoll events */
               epoll_data_t data;        /* User data variable */
           };
           
   //epoll_wait 
    NAME
       epoll_wait, epoll_pwait - wait for an I/O event on an epoll file descriptor

SYNOPSIS
       #include <sys/epoll.h>

       int epoll_wait(int epfd, struct epoll_event *events,
                      int maxevents, int timeout);
````























----

