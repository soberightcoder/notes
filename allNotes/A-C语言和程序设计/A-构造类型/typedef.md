# typedef 关键字

>**为已有的数据类型改名！！**
>
>**替代法，替代相同的名字；**

---

## 定义

```c
//code
//定义
//typedef 已有的数据类型 新名字

//code
//code 

#include <stdio.h>

/**
 * 关键字typedef
 * 数据类型有问题，溢出了，所以我们就可以扩容！！
*/
/***
 * define 
*/
#define INT int

// typedef int INT;

int main() {
    INT i;
    i = 11000;
    printf("%d\n", i);
}
```





## define 宏和 typedef的定义和区别？？

>**#define 很纯粹的替换，用宏体来替换宏名；**
>
>**typedef 为已有的数据类型改名字！！！**

`````c
// 也可以实现上述的内容！！
#define INT int; // 所有的INT 都替换成int；很纯粹的替换！！！宏体 替换宏名！！！
typedef int INT; //  改一个名字而已！！！ 
INT i  = 100; //






//todo 下面的改名都是用的是替换！！！！
/****
#define IP int *
typedef int *IP; --> int* IP;
IP p,q; ---> int *p,q;
IP p,q; ---->int *p,*q;
*******

/*******
typedef int ARR[6]   ---> int[6]  ---->ARR  把int[6] 改名为ARR
 
ARR a; === > int a[6]

// typedef


*************

//数组的本质

int[4] a;

`````



## struct and typedef

```c
//

struct node_st
{
	int id;
    char ch;
}

typedef struct node_st NODE;
NODE a; ==> struct node_st a;
//用指针一般要这么用  有* 会比较明显！
//警惕自己这是一个指针变量！
NODE *p ---> struct node_st *p;

typedef struct node_st *NODEP;
NODEP p; ===> struct node_st *p

//另外一种写法
//下面struct是一种新的数据类型
//typedef 数据类型 new数据类型名；
struct 
{
    
};
typedef struct
{
	int i;
    float f;
} NODE,*NODEP;

typedef int FUNC(int); => int(int)  FUNC;   
FUNC f; ---> int f(int)
    
    
typedef int *FUNCP(int); ----> int * (int) 
FUNCP p; ---> int *p(int);//指针函数；

typedef int *(*FUNCP)(int); -----> int*(*)(int)  FUNCP
FUNCP p;----> int *(*p)(int);
```

