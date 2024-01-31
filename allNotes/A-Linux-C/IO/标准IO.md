# 标准IO

> 标准io的几个参数；
>
> 标准io的几个参数；

---

## 函数fopen 

>fopen

```cc
//return FILE * 要用 一个FILE *fd 来接收！！！
NAME
       fopen, fdopen, freopen - stream open functions

SYNOPSIS
       #include <stdio.h>
//const char *path传过来的数值不能是常量；
       FILE *fopen(const char *path, const char *mode);


//const char *mode
The argument mode points to a string beginning with one of the following  sequences  (possibly  followed  by   
   additional characters, as described below):
//r r+ 要求文件必须存在！！！
   r      Open text file for reading.  The stream is positioned at the beginning of the file.

   r+     Open for reading and writing.  The stream is positioned at the beginning of the file.
       
// w w+ a a+ 是文件不存在创建！！！
   w   （覆盖写）   Truncate file to zero length or create text file for writing.  The stream is positioned at the begin-   
          ning of the file.//有则清空，无则创建！第一个有效字符，是开始处；

   w+     Open for reading and writing.  The file is created if it does not exist, otherwise it  is  truncated.   
          The stream is positioned at the beginning of the file.

   a   （append 追加写）   Open  for  appending (writing at end of file).  The file is created if it does not exist.  The stream   
          is positioned at the end of the file.  //追加写，文件不存在将会被创建！ end of file最后一个有效字节的下一个字节！

   a+     Open for reading and appending (writing at end of file).  The file is created if it does  not  exist.   
          The  initial file position for reading is at the beginning of the file, but output is always appended   
          to the end of the file. //read at beginning of the file ,write at the end of the file;
              
  //       The argument mode points to a string beginning with one  
       of the following sequences (possibly followed by  addi-  
       tional characters, as described below):
 //the 'b' is ignored on all POSIX conform-ing systems, including Linux.       
     // windows下需要加b；
  //eg：linux编译环境！！ 就是传进来的参数字符串并不会修改！
    char *ptr = 'abc';
	ptr[0] = 'x';
	ptr = 'xbc';这个才能进行改变！！
	？ "xbc" ??? 这里会报错！！
     这个是一个常量  ，不能修改常量的内容；
        值永远不会变化的量！！！
        
//RETURN VALUE
       Upon successful completion fopen(), fdopen()  and  fre-  
       open()  return  a  FILE  pointer.   Otherwise,  NULL is  
       returned and errno is set to indicate the error.
//errno 看成一个全局变量！！！ 所有人的都用，必须马上打印，有可能会被覆盖！！！以前是一个全局变量！！
// 私有化之后是一个宏了；私有化数据？？？
// 有一个表可以去参考！！
//position  error-base.h  查看这个头文件！！
// vim /usr/include/asm-generic/errno-base.h
        
 //报错！！！！ 报错---errno的数据！！！
 //perror(); 
  //这个函数还是非常好用的！！！ 只要是记录在errno的都可以用perror来记录错误信息！！
  //perror print errno； 可以自动关联 errno;     
 //include <string.h>
  // strerror(errno);
//printf(strerror,"fpen():%s\n",strerror(error));
        
        c
 //fopen 返回的是一个指针，指向的是那一块内容？
 //1.栈 在栈上，会被销毁，返回一个指针的话，指针指向的数据也会被销毁！所以我们需要fclose；
 //2.堆   所以只能放在堆上； 所以我们需要用 fclose；=== free；
 //3.静态区 如果是全局变量，那么第二次的结果会覆盖掉第一次结果！！所以肯定是不行的！！这一次不会放在静态区！！
 // 静态区会被覆盖！！！
 // 分配的空间是在堆上！！！我猜对了！！！因为是一个指针；
        
        // 只要返回一个指针，一般放在堆上的空间！如果有一个逆操作！！fopen() fclose()
        //当然也可能存在于静态区；
    FILE *fopen(const char *path, const char *mode)
    {
        FILE *tmp = NULL;
        tmp = malloc(sizeof(FILE));
        tmp->... = ...
        tmp->... = ...
        
        return tmp;
    }
// 之后还会有一个fclose 就是相当于free 就是释放内存！！！
  
```



## fread fwrite fgets 

`````c
// 告诉最多可以读多少！！！
//int size 显示读取数据的多少！！不然有可能会存在溢出的风险；读取的内容大于rbuf的大小！！！
//       char *fgets(char *s, int size, FILE *stream);
//size - 1
//'\n'
abcd\n\0    //\0代表的是字符串的结束！！
// 注意 '\0'代表字符的结束！！！
1->a b c d '\0'
2->'\n' '\0'
// 说实话这个优点蒙蔽！！！！！//tod 没看出来 运行了两次！
    
       int fputs(const char *s, FILE *stream);
`````



`````c
//fread fwrite

SYNOPSIS
       #include <stdio.h>
		//size 每个对象的大小！ nmemb 对象的个数！
       size_t fread(void *ptr, size_t size, size_t nmemb, FILE *stream);

       size_t fwrite(const void *ptr, size_t size, size_t nmemb,FILE *stream);

// 最好用单字节来操作！！！ 下面就是为啥只有size 一般用单字节的原因！！
//RETURN VALUE
       On  success,  fread() and fwrite() return the number of  
       items read or written.  This number equals  the  number  
       of  bytes transferred only when size is 1.  If an error  
       occurs, or the end of the file is reached,  the  return  
       value is a short item count (or zero).
// 只有满足一个对象的长度的时候，才会是1；不满足一个对象长度的时候为0；
       
`````



![image-20230518105534797](./%E6%A0%87%E5%87%86IO.assets/image-20230518105534797.png)

## 文件权限问题

>**umask值越大，权限就越低！！！**
>
>umask 0001  去修改
>
>umask 0002 默认是0002；
>
>umask掩码的意思！

**为啥是644 是因为，0666&~umask**

**umask = 0002 所以是0644，umask就是为了保证权限不能过松！！！**

````c
umask
In computing, umask is a command that determines the settings of a mask that controls how file permissions are set for newly created files. 
    It also may refer to a function that sets the mask, or it may refer to the mask itself, which is formally known as the file mode creation mask. The mask is a grouping of bits, each of which restricts how its corresponding permission is set for newly created files. 
        The bits in the mask may be changed by invoking the umask command.
````



## 文件位置指针函数

>fseek 位置；
>
>FILE 结构体里面肯定会有一个文件位置指针！！

`````c
//repostion

NAME
//       fgetpos,  fseek,  fsetpos, ftell, rewind - reposition a  
//      stream

SYNOPSIS
       #include <stdio.h>
	//whence 偏移的相对位置！！
    //offset 是相对于 whence的位置相对位置！！！
       int fseek(FILE *stream, long offset, int whence);  
 If whence is set  to 
//     SEEK_SET, SEEK_CUR, or SEEK_END,
the offset is relative  to  the  start  of the file, the current position  
       indicator, or end-of-file, respectively. 

       long ftell(FILE *stream);  //tell 告诉现在我们所处的位置！文件指针所在的位置！！！

       void rewind(FILE *stream);  //

//
RETURN VALUE
       The rewind() function returns no value.  Upon  success-  
       ful completion, fgetpos(), fseek(), fsetpos() return 0,  
       and ftell() returns the current offset.  Otherwise,  -1  
       is returned and errno is set to indicate the error. 
           
           
           
 //code 利用这几个命令来查看文件的大小！！
  #include <stdio.h>
#include <stdlib.h>
/**
 * 计算文件的大小
*/

int main(int argc, char **argv)
{
    FILE *fp = NULL;
    fp = fopen("tmp.txt","r");
    if (fp == NULL)
    {
        perror("fopen()");
        exit(1);
    }
    fseek(fp,0,SEEK_END);
    printf("%ld",ftell(fp));
}
// rewind ();  重置指针！！！ 对fseek的封装！！
//  The  rewind() function sets the file position indicator  
       for the stream pointed to by stream to the beginning of  
       the file.
             (void) fseek(stream, 0L, SEEK_SET) //就是
           
           
           
// 空洞文件的产生！！
//下载文件，首先先生成空洞文件！！
//然后利用多线程，去填充空洞文件！！

           

`````

## fflush

`````c
//fflush force flush 强制刷新缓冲区！！
    //If  the  stream  argument is NULL, fflush() flushes all open output streams.

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>



/***
 * fflush
 * 刷新缓冲区！！
 * 缓冲区的作用！！
 * 大多数情况下是好事！！合并系统调用
 * 
 * 行缓冲： 换行刷新，或者缓存满了刷新，强制刷新，stdout
 * 
 * 全缓冲： 满了的时候刷新，强制刷新，（ 文件io，默认，只要不是终端设备）
 * 
 * 无缓冲：如stderr,无缓冲；//
 * 
 * 可以使用stdvbuf来设置缓冲类型！！
 * 
 * shift + k直接跳到 man 手册！
 * 是
 * 行缓存:当输入输出遇到换行符时候就是行缓存了。标准输入和标准输出都是行缓
*/

int main() 
{
    int i;
    //都打印不出来；
    //仅仅输出到缓冲区 
    //stdout 是行缓冲，换行刷新缓冲区或者缓冲区满了的时候刷新缓冲区！
    // printf("Before whiel()");
    // fflush(stdout);
    // while(1);
    // printf("After while()");
    // fflush(NULL);
    bool f = true;
    printf("%lld\n",sizeof(f)); //1 
    // size_t // 无符号的64位 // 返回的是字节数！！
    exit(0);
}
`````



## 空洞文件！

`````c
//fseek.c
// 实现一个空洞文件

#include <stdio.h>
#include <stdlib.h>

#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
/**
 * fopen 和  fseek实现一个空洞文件！！
*/

int main(int argc, char** argv)
{
#if 0
    // 标准IO版本
    FILE* fp;
    if (argc < 2)
    {
        fprintf(stderr, "argc 参数太少！");
        exit(1);
    }
    fp = fopen(argv[1], "w");
    if (fp == NULL)
    {
        perror("fopen()");
        exit(1);
    }
    // 一定要每一个都要给数据类型，
    //数据类型要对应上！！
    //数据类型真的要对应上！！
    //空洞文件；
    fseek(fp, 1L * 1024L * 1024L * 1024L - 1L, SEEK_SET);
    //写入一个尾0；\0 写一个尾0
    fwrite("", 1, 1, fp);

    fclose(fp);
#endif

    //系统调用版本
    int fd;
    fd = open(argv[1], O_WRONLY | O_CREAT | O_TRUNC, 0600);
    if (fd < 0) 
    {
        perror("open()");
        exit(1);
    }
    //在运算的过程中就会溢出了，丢失了！！
    lseek(fd,1L*1024L*1024L*1024L - 1L,SEEK_SET);
    write(fd,"",1);
    close(fd);
    exit(0);
}
`````



## EOF

    这里需要解决如何区分文件中有效数据与输入结束符的问题。C语言采取的解决方法是：在没有输入时，getchar函数将返回一个特殊值，这个特殊值与任何实际字符都不同。这个值称为EOF（end of file，文件结束）。我们在声明变量c的时候，必须让它大到足以存放getchar函数返回的任何值。这里之所以不把c声明称char类型，是因为它必须足够大，除了能存储任何可能的字符外还要能存储文件结束符EOF。因此，我们将c声明成int类型。
    
        EOF定义在头文件<stdio.h>中，是个整型数，其具体是什么并不重要，只要它与任何char类型的值都不相同即可。这里使用符号常亮，可以确保程序不需要依赖于其对应的任何特定的值。
    
       以上解释得很清楚了，如果将c定义成char，则不能获取到char的取值范围之外的值，使用 “char c; c = getchar();”可能会发生意料之外的数据转换（类似int a = -1; unsigned int b = a;）。
    
        EOF不与任何实际字符相同，所有的字符都能在ascii表里128个字符里找到，acsii码表对应的十进制数从0-128，而十进制数0对应的字符就是空字符'\0'(null)，EOF不存在这128个字符里，即不属于字符，而上述代码需要判断的是获取到的不是字符时结束while，空字符'\0'虽然无法从键盘输入，但也属于字符，所以此处用“c != EOF”而不是“c != '\0'”。如果需要判断是否空字符或者判断字符串是否结束则用“c != '\0'”。

EOF的值

       那EOF等于多少呢，通过代码测试printf("EOF = %d\n", EOF);可以得知EOF的值为-1。



----



## fseek

函数的原型，即使用方法：
int fseek(FILE *stream, long offset, int fromwhere);
功 能: 重定位流上的文件指针
描 述: 函数设置文件指针stream的位置。如果执行成功，stream将指向以fromwhere为基准，偏移offset个字 节的位置。如果执行失败(比如offset超过文件自身大小)，则不改变stream指向的位置。
返回值: 成功，返回0，否则返回其他值。

注意：
第一个参数stream为文件指针
第二个参数offset为偏移量，整数表示正向偏移，负数表示负向偏移
第三个参数origin设定从文件的哪里开始偏移,可能取值为：SEEK_CUR、 SEEK_END 或 SEEK_SET
SEEK_SET： 文件开头
SEEK_CUR： 当前位置
SEEK_END： 文件结尾
其中SEEK_SET,SEEK_CUR和SEEK_END和依次为0，1和2.

简言之：
fseek(fp,100L,0);把fp指针移动到离文件开头100字节处；
fseek(fp,100L,1);把fp指针移动到离文件当前位置100字节处；
ffseek(fp,-100L,2)；把fp指针退回到离文件结尾100字节处。

函数实验实例



```c
void ModifyFile()
{
	system("cls");
	Menu1();
	book stu;
	FILE *fp;
	char x[8];
printf("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
printf("请输入图书id:");
scanf("%s", x);

fp = fopen("book1.dat", "rb+");

if (fp == NULL)
{
	printf("文件打开失败");
	exit(1);
}

fseek(fp, 0, SEEK_SET);
while (fread(&stu, LEN, 1, fp))
{

	if (strcmp(x, stu.id) == 0)
	{
		printf("请重新输入图书id:   ");
		scanf("%s", stu.id);

		printf("请重新输入书名:    ");
		scanf("%s", stu.name);

		printf("请重新输入书籍作者  : ");
		scanf("%s", &stu.author);

		printf("请重新输入图书出版社  : ");
		scanf("%s", &stu.publish);

		printf("请重新输入图书价格 :   ");
		scanf("%lf", &stu.price);
		printf("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
		fflush(stdin);
		fseek(fp, 0-LEN, SEEK_CUR);
		fwrite(&stu, LEN, 1, fp);
		fclose(fp);
	}

	if (feof(fp))
	{
		printf("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
		printf("没有图书信息");
		printf("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n");
	}

}

system("pause");
system("cls");c
return;
```
}
————————————————
版权声明：本文为CSDN博主「归止于飞」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。
原文链接：https://blog.csdn.net/weixin_51871724/article/details/117884241
