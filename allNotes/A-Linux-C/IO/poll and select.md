# select  and poll



>**from:**
>
>https://blog.csdn.net/gaoyuelon/article/details/124727838?spm=1001.2101.3001.6650.8&utm_medium=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-8-124727838-blog-95162952.235%5Ev36%5Epc_relevant_anti_vip_base&depth_1-utm_source=distribute.pc_relevant.none-task-blog-2%7Edefault%7EBlogCommendFromBaidu%7ERate-8-124727838-blog-95162952.235%5Ev36%5Epc_relevant_anti_vip_base&utm_relevant_index=15

---

## brief

阻塞模型，就是一个请求全部处理完才能处理下一个请求，一个请求没有处理完会阻塞到下一个请求；

`````c
listen_fd = socket ()
bind();
listen();
while(1) 
{
    accept();//创建连接
    recv(); // 接收信息！！！！ 没有消息传输会阻塞到这里，必须完全处理完在这个请求才会处理下一个请求；
}
`````



非阻塞模型；

````c
//调用即返回，不管有哦没有数据可读写！！！
// 但是这个过程需要不断的轮询调用函数，如果还客户端一直没有响应，服务端的轮询就会占用大量的cpu资源！！！

````



io复用！



---



基础的网络编程模型中，套接字通常都是阻塞的，比如服务端listen阻塞等待客户端来连接，建立连接后，recv阻塞等待接收数据。而如果在等待接收数据的过程中，又有新的客户端连接，这时服务端无能为力，因为服务端还在阻塞等待接收上一个客户端的数据。

有一种做法是将套接字设置为非阻塞的，调用即返回，不管套接字是否准备好（是否有数据可读/写），但这就需要不断轮询调用函数（因为服务端也不知道什么时候会来数据）如果客户端一直没有响应，服务端的轮询就会占用大量的CPU资源，效率低下。而另一种方法是采用IO复用：

这样的进程需要一种预先告知内核的能力，使得内核一旦发现进程指定的一个或多个I/O条件就绪
（也就是说输入已准备好被读取，或者描述符已能承接更多的输出），它就通知进程。这个能力称为I/O复用。
-----------
在Linux中IO复用有select、poll和epoll，epoll较前两种区别较大，下一篇总结。
它们都有这样的能力：同时监听多个文件描述符。

**需要指出的是，I/O复用虽然能同时监听多个文件描述符，但它本身是阻塞的。**

**并且当多个文件描述符同时就绪时，如果不采取额外的措施，程序就只能按顺序依次处理其中的每一个文件描述符，这使得服务器程序看起来像是串行工作的。如果要实现并发，只能使用多进程或多线程等编程手段。**

select
先来看一下函数原型：

`````c
#include <sys/select.h>

int select(int nfds, fd_set *readfds, fd_set *writefds,
                  fd_set *exceptfds, struct timeval *timeout);
`````





从后往前：timeout参数用来指定超时时间，和其他函数中设置超时时间的含义一样，select本身是阻塞的，如果设置了超时时间，不管监听的文件描述符是否就绪都会返回。再往前三个fd_set *类型的参数，分别指向可读、可写和异常等事件对应的文件描述符集合，我们在调用select时，通过这三个参数分类传入需要被监听的文件描述符集合。nfds是所有被select监听的文件描述符中的最大值加1，注意不是描述符个数加1，而是描述符最大值加1。
更详细的，timeout是一个结构体，包含秒数和微秒数：

`````c
struct timeval
{
	long tv_sec;//秒数
	long tv_usec;//微秒数
};
`````




有些系统会修改该值，把值修改成剩余的时间。比如，超时设置是5秒，在文件描述符可用之前逝去了3秒，那么在调用返回时，tv_sec的值就变为了2。有一些系统则不改变该值，因此，为了方便移植，我们在每次调用select时最好重新设置该值。更进一步，我们还可以用select的定时，来替代sleep()，只需要将前几个参数都设置为零和空，并设置超时时间：

````c
struct timeval tv;
tv.tv_sec = 0;
tv.tv_usec = 500;

select(0, NULL, NULL, NULL, &tv);
````


例：



```c
   #include <sys/select.h>

#include <stdio.h>

int main() {
        struct timeval tv;
        tv.tv_sec = 5;
        tv.tv_usec = 0;
   select(0, NULL, NULL, NULL, &tv);

    printf("%s", "hello world");

    return 0;
    }
```


14
通过一系列宏来往select中添加感兴趣的文件描述符：



`````c
#include <sys/select.h>

void FD_CLR(int fd, fd_set *set); //清除fdset的位fd
int  FD_ISSET(int fd, fd_set *set);//测试fdset的位fd是否被设置
void FD_SET(int fd, fd_set *set);//设置fdset的位fd
void FD_ZERO(fd_set *set);//清除fdset的所有位
`````


fdset是一个包含整形数组的结构体，该数组的每个元素的每一位(bit)标记一个文件描述符。数组是long int类型，占8字节，数组大小是16，一个字节是8位，因此，select所能支持的最大fd数量便是8 x 8 x 16 = 1024个。这也是select系统调用的缺点之一。
值得注意的是，select函数返回时，内核会修改readfds、writefds、exceptfds中的值（就绪的位被置为1，其余全置为0），便于FD_ISSET来测试哪些描述符就绪。但那些我们加入的还没有就绪的文件描述符也被清0了，所以，每次重新调用select函数时，都得再次把所有描述符集内所关心的位均置为1，这也是另一个select系统调用的缺点。

宏的使用：打开描述符1、4、5的对应位：

`````c
fd_set rset;

FD_ZERO(&ret);
FD_SET(1, &ret);
FD_SET(4, &ret);
FD_SET(5, &ret);
`````


关于select的使用：（以下例子来自man手册，实际上最权威的文档便是你所使用系统的man手册）



```c
#include <stdio.h>

#include <stdlib.h>

#include <sys/time.h>

#include <sys/types.h>

#include <unistd.h>

int
main(void)
{
    fd_set rfds;
    struct timeval tv;
    int retval;
/* Watch stdin (fd 0) to see when it has input. */
FD_ZERO(&rfds);
FD_SET(0, &rfds);

/* Wait up to five seconds. */
tv.tv_sec = 5;
tv.tv_usec = 0;

retval = select(1, &rfds, NULL, NULL, &tv);
/* Don't rely on the value of tv now! */

if (retval == -1)
     perror("select()");
else if (retval)
     printf("Data is available now.\n");
 /* FD_ISSET(0, &rfds) will be true. */
 else
     printf("No data within five seconds.\n");

 exit(EXIT_SUCCESS);
 }
```

用select来监听标准输入文件描述符可读，设置超时时间为5秒。

select在网络编程中的使用：



```c
#include <stdio.h>

#include <unistd.h>

#include <sys/types.h>

#include <sys/socket.h>

#include <netinet/in.h>

#include <string.h>

#include <vector>

using namespace std;

int main(void)
{
    //初始化套接字
    int listenfd = socket(AF_INET, SOCK_STREAM, 0);
    if (listenfd < 0)
    {
        perror("socket");
        return -1;
    }
struct sockaddr_in address;
bzero(&address, sizeof(address));
address.sin_family = AF_INET;
address.sin_addr.s_addr = htonl(INADDR_ANY);
address.sin_port = htons(8080);

int ret = bind(listenfd, (struct sockaddr *)&address, sizeof(address));
if (ret < 0)
{
    perror("bind");
    return -1;
}

ret = listen(listenfd, 5);
if (ret < 0)
{
    perror("listen");
    return -1;
}

fd_set rfds;
struct timeval tv;
int maxfd;

vector<int> clientfd;

while (1)
{
    FD_ZERO(&rfds);

    //将listenfd加入select中，每次都要加入
    FD_SET(listenfd, &rfds);
    maxfd = listenfd;

    //遍历clientfd
    for (int i = 0; i < clientfd.size(); i++)
    {
        //监听每个client的可读事件
        FD_SET(clientfd[i], &rfds);

        //更新值最大的文件描述符
        if (maxfd < clientfd[i])
        {
            maxfd = clientfd[i];
        }
    }

    //设置超时时间
    tv.tv_sec = 5;
    tv.tv_usec = 0;

    ret = select(maxfd + 1, &rfds, NULL, NULL, &tv);
    if (ret == 0)
        continue;
    else
    {
        if (FD_ISSET(listenfd, &rfds))
        {
            struct sockaddr_in client_address;
            socklen_t client_addrlength = sizeof(client_address);
            int connfd = accept(listenfd, (struct sockaddr *)&client_address, &client_addrlength);
            if (connfd < 0)
            {
                perror("accept");
            }
            printf("The connection is successful : %d\n", connfd);
            clientfd.push_back(connfd);
        }
        else
        {
            for (int i = 0; i < clientfd.size(); i++)
            {
                if (FD_ISSET(clientfd[i], &rfds))
                {
                    //如果有客户端的读事件
                    char buf[1024];
                    ret = recv(clientfd[i], buf, sizeof(buf) - 1, 0);
                    if (ret <= 0)
                    {
                        perror("recv");
                    }
                    printf("client: %d recv: %s\n", clientfd[i], buf);
                }
            }
        }
    }
}

for (int i = 0; i < clientfd.size(); i++)
{
    close(clientfd[i]);
}

close(listenfd);
return 0;
}
```



poll
poll系统调用和select类似，也是在指定时间内轮询一定数量的文件描述符，以测试其中是否有就绪者。但它解决了一些select的不足。
select使用了基于文件描述符的三位掩码的解决方案，效率不高，poll可以使用由nfds个pollfd结构体构成的数组，fds指针指向该数组。并且poll能处理的事件类型也比select更加丰富。
函数原型:

`````c
#include <poll.h>

int poll(struct pollfd *fds, nfds_t nfds, int timeout);

struct pollfd {
    int   fd;         /* file descriptor */
    short events;     /* requested events */
    short revents;    /* returned events */
};
`````


每个pollfd结构体指定一个被监视的文件描述符。可以给poll传递多个pollfd结构体，使它能够监视多个文件描述符。每个结构体的events变量是要监视的文件描述符的事件的位掩码。用户可以设置该变量。revents变量是该文件描述符的结果事件的位掩码。内核在返回时会设置revents变量。events变量中请求的所有事件都可能在revents变量中返回。
比如：要监视某个文件描述符是否可读写，需要把events设置成POLLIN | POLLOUT。返回时，会检查revents中是否有相应的标志位。如果设置了POLLIN，文件描述符可非阻塞读；如果设置了POLLOUT，文件描述符可非阻塞写。
举例：



```c

#include <stdio.h>

#include <unistd.h>

#include <poll.h>

#define TIMEOUT 5

int main(void)
{
    struct pollfd fds[2];
    int ret;//标准输入
fds[0].fd = STDIN_FILENO;
fds[0].events = POLLIN;

//标准输出
fds[1].fd = STDOUT_FILENO;
fds[1].events = POLLOUT;

ret = poll(fds, 2, TIMEOUT * 1000);
if (ret == -1) {
    perror("poll");
    return 1;
}

if (!ret) {
    printf("%d seconds elapse.\n", TIMEOUT);
    return 0;
}

if (fds[0].revents & POLLIN)
    printf("stdin is readable\n");

if (fds[1].revents & POLLOUT)
    printf("stdout is writable\n");

return 0;
}
```


运行，输出

./a.out
stdout is writable

当把一个文件重定向到标准输入后，输出

./a.out < test.c
stdin is readable
stdout is writable

**同时，使用poll无需重新重置pollfd类型的事件集参数，因为内核每次修改的是pollfd结构体的revents成员，而events成员保持不变。**

、、

## 区别

>**from:**
>
>https://zhuanlan.zhihu.com/p/593467376?utm_id=0

select 

1. 内核/用户数据拷贝频繁，操作复杂。

2.3 epoll

epoll是在 Linux内核2.6版本中提出的，epoll可以看作是 select 和 poll 的增强版。

select、poll监听文件描述符的方式是轮询，epoll是通过回调函数，采用回调的方式，只有活跃可用的fd才会调用callback函数，也就是说 epoll 只管你“活跃”的连接，而跟连接总数无关，因此在实际的网络环境中，epoll的效率就会远远高于select和poll。通俗形容如下：

![img](./poll%20and%20select.assets/v2-cc5bc6ef58686cdd3c56641d1b50b9b6_720w.webp)

### epoll 与 select/poll 的流程对比

**select在每次被调用之前，都要把要监控的文件描述符fd加到监控的集合(也可以叫做等待队列)，然后再调用select阻塞，直到有fd返回。这是select低效的原因之一------将“维护等待队列”和“阻塞进程”两个步骤合二为一。**

而epoll 则把这两个步骤分开，先用epoll_ctl维护等待队列，再调用epoll_wait阻塞进程（解耦）。显而易见的，效率就能得到提升。如下图。

![img](./poll%20and%20select.assets/v2-80037d4328e877b76c3bec9825e89efe_720w.webp)