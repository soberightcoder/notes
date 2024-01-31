# exec 函数族

 >**few** 
 >
 >**fork + exec +wait 搭建出来了整个unix的框架！**

---

## exec

````c
bash
    ./primer2
    	./primer2
    	./primer2
    	......
    	201 
// 1个父进程 201 个子进程；
//每一个子进程执行的任务都是一样对 ，那么还有什么意义？
````

exec 函数族：

>功能是统一的：**执行一个文件**；
>
>函数族的功能：
>
>The  exec()  family of functions replaces the current process  image with a new process image.
>
>replace the current process image with a new process image.  关键词 replace 替换；
>
>extern char \**environ;  环境变量就是程序员和管理员的一种约定！！
>
>**我还是我，但是我已经不是我了！！！ 这就是exec()族；**

* execl()

  `````c
  //int execl(const char *path, const char *arg, ...);
  The  exec()  family of functions replaces the current process  image with a new process image.
  //pid 是不变的
  RETURN VALUE
         The exec() functions return only if an  error  has  occurred.  
         The  return  value  is  -1,  and errno is set to indicate the  
         error.
  `````

  

* execlp()

  ````c
  //*file 只需要文件名 就行了
  int execlp(const char *file, const char *arg, ...);
  // 只需要知道filename 文件名就可以了！！！  可以通过 环境变量去查询；PATH  环境变量就是管理员的一种约定！！！
  ````

  

* execv()

* execvp()

## code

`````c
G:\cwebsite\linuxc\process\exec.c
 #include <stdio.h>
#include <stdlib.h>
//unix 标准库 的头文件
#include <unistd.h>
/**
 * exec族；
*/
int main()
{
    puts("Begin!");
    // int res;
    // execl("/usr/bin/date","date","+%s",NULL);
    //replace current process iamge with a new process image;//所以当前进程就会回来了；
    //但是运行出错，肯定不回去新的process ，所以肯定会报错；
    //exec 和fork 之前需要用execl();
    fflush(NULL); // 输出内容； 不然不会输出 因为在还在缓冲区；
    execl("/usr/bin/date", "date", "+%s", NULL);
    // execl("/usr/bin/sleep", "sleep", "100", NULL);
    //
    // if (res < 0) {
    //     perror("exel() error");
    //     exit(1);
    // }
    //直接写 就行；
    perror("exel() error");
    exit(1);
    puts("End!");
    exit(0);
}

#if 0 
    res：
Begin!
1683618705
#endif
// 注意要加 fflush 来刷新缓冲区； 刷新所有的缓冲区；
//.exec 输出到stdout 是行缓存；
        
//.exec > /tmp/out 是全缓存；所以 Begin还在缓冲区；所以我们需要刷新缓冲区；
//res
[root@fce7a0a3deef process]# ./exec > /tmp/out 
[root@fce7a0a3deef process]# !cat
cat /tmp/out
Begin!
1683619306
`````



## few

>为什么命令行，总是在最后输出，是因为父进程要wait 进行收尸；
>
>duplicate ，父进程和子进程具有相同的0，1，2文件描述符也分别指向相同的0，1，2，所以子进程的输出父进程也是可以看到的！！！

`````c
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/wait.h>

/**
 * few == fork exec wait
 * shell 运行一个命令的原理
 * 先fork 一个子进程 父进程wait；wait 阻塞在这里！！！
 * 
*/

int main() {
    pid_t pid;

    puts("Begin!");
    fflush(NULL);
    pid = fork();
    if (pid < 0) {
        perror("fork()");
        exit(1);
    }
    if (pid == 0) {
        //子进程
        execl("/usr/bin/date","date","+%s",NULL);
        perror("execl()");
        exit(2);
    }
    //收尸；//如果不进行收尸，那么先会输入命令行，代表父进程已经结束了，然后子进程，进行输出；
    wait(NULL);
    puts("End!");
    exit(0);
}
`````

``````c
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/wait.h>

/**
 * few == fork exec wait
 * shell 运行一个命令的原理
 * 先fork 一个子进程 父进程wait；wait 阻塞在这里！！！
 * 
*/

int main() {
    pid_t pid;

    puts("Begin!");
    fflush(NULL);
    pid = fork();
    if (pid < 0) {
        perror("fork()");
        exit(1);
    }
    if (pid == 0) {
        //子进程
        // execl("/usr/bin/date","date","+%s",NULL);
        execl("/usr/bin/sleep", "sleep", "100", NULL);
        //可以伪造名字；
        //木马的低级长生办法；
        //为造成了 httpd 100
        // execl("/usr/bin/sleep", "httpd", "100", NULL);
        perror("execl()");
        exit(2);
    }
    //收尸；//如果不进行收尸，那么先会输入命令行，代表父进程已经结束了，然后子进程，进行输出；
    wait(NULL);
    puts("End!");
    exit(0);
}

//ps -axf
//bash 产生了一个子进程去运行./few，然后few 去fork了一个进程去运行sellp；
  15 pts/1    Ss     0:00 bash
  295 pts/1    S+     0:00  \_ ./few
  296 pts/1    S+     0:00      \_ sleep 100
``````

# 辅助知识

> vscode  shift + alt +f就是格式化；format；

## vim

>i  == inside;
>
>a == append；追加附加；

您可以按以下顺序删除包括引号在内的所有内容：

```
da" 
```

请记住，这只适用于单行，并将删除最后一个引号后面的任何尾随空格。
您也可以使用 *delete inside* 序列删除引号内的字符，而不删除引号：

```
di"
```

您也可以使用 *change inside* 序列来移除字符并切换至插入模式，让您轻松取代引号内的文字：

```
ci" 
```

修改一个单词.删除当前单词，并且进入到编辑模式；

`````c
ciw 修改一个单词；内部的一单词
`````







- `**di**` 这里的i a不再是 insert 和append，而是作为d y c操作的一部分，对 block 或者段落进行定位的定位符。在这种情况下，i代表 inner ，a代表an object `di(` 指删除(内的所有内容但不包括括号本身
- `**da**` 指令`da(`则会删除包括括号在内的括号括起来的所有内容。常见的 object 有括号（包括() [] {} <>），引号（包括单双引号），word，WORD，sentence， paragraph 等
