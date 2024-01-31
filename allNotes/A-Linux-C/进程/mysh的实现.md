# mysh的实现

>自己写一个shell;

----

## 实现命令code

```c
//G:\cwebsite\linuxc\process\mysh.c
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/wait.h>
#include <string.h>
#include <glob.h>
/**
 * mysh.c
 * my shell
*/
#define DELIMS " \t\n"
/**
 * 可持续发展的角度来解决整个问题！！
*/
struct cmd_st
{
    glob_t globres;
};
/**
 * 提示符模块
*/
static void prompt() {
    printf("mysh-0.1$ ");
}
/**
 * 1.判断是外部命令或者是内部命令
 * 2. 解析参数，解析成execl可以处理的方式；
 * // 需要用到字符串的截取；
 * 参数类型是二级指针(**p)，那么我们就需要传递，一级指针的地址；
 * 传过去的一级地址，保存在二级指针里面；
 * 我们可以通过 p来改变指向的一级指针； p= 改变的是二级指针的指向；
 * *p  =  改变一级指针的指向；
 * **p 改变 一级指针指向的变量值；
*/


static void parse(char *line, struct cmd_st *res) {
    char *tok;
    int i = 0;
    while(1) {
        //返回的是一个指针；
        // char *strsep(char **stringp, const char *delim);
        tok = strsep(&line,DELIMS);
        if (tok == NULL) 
            break;
            //解决有多个空格的问题；有多个分隔符
            //空串；
            //*tok == tok[0];//一样的；
        if (*tok == '\0')
            continue;
            //追加 //tok是随机内容第一次不能追加；
            //妙呀第一次不追求 其他的次数都要追加
            //追求的内容加在 res 整个指针内；
        glob(tok,GLOB_NOCHECK|GLOB_APPEND*i,NULL,&res->globres);
        i++;
    }
}

int main()
{
    pid_t pid;
    // 初始化为NULL？？？
    //为什么来？？？
    //防止是随机值然后*p修改了内存，赋值为NULL 别人就不能修改内存地址的值；
    //p = &i;//success
    char *linebuf = NULL;//回填变量；
    size_t linebuf_size = 0;

    struct cmd_st cmd;
    while (1) {
        //提示符
        prompt();
        //拿到输入的数据
        //第一个参数是二级指针，其实就是一级指针的地址
        if (getline(&linebuf,&linebuf_size,stdin) < 0)
            break;
        //解析参数
        parse(linebuf,&cmd);
        // 
        if (0) {
            //内部命令
            //do sth
        }
        else {
            //外部命令
            pid = fork();
            if (pid < 0) {
                perror("fork()");
                exit(1);
            }
            if (pid == 0) {
                // 选择后面两个
                //execv
                //execvp 只需要知道文件名就行了
                execvp(cmd.globres.gl_pathv[0], cmd.globres.gl_pathv); 
                perror("execvp()");
                exit(2);
            }
            else {
                //父进程
                wait(NULL);
            }
        }
    }
    /**
     * 外部命令和内部命令；
    */
    exit(0);
}
```





## 使用

`````shell
# 移动到这里
# cp mysh /usr/bin/mysh
[root@fce7a0a3deef bin]# ls -al |grep mysh 
-rwxr-xr-x 1 root root   11888 May  9 11:00 mysh
[root@fce7a0a3deef bin]# cat /etc/passwd
root:x:0:0:root:/root:/usr/bin/mysh
# 就会通过 ,用户就可以通过你的mysh 来进行mysh了；
`````

