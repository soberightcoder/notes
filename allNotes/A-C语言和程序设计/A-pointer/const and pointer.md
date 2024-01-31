# 指针和const

>const and pointer
>
>常量指针 const int \*p 限制间接修改；
>
>指针常量 int \* const p 限制指向别的变量；
>
>
>
>尤其重要！！！const 频繁的看到它！！
>
>改变一个变量的值的方法有两种：
>
>1. 直接修改；
>
>2. 间接修改；
>
>3. 改变指针的指向；是改变\*p的值；改变指针指向的值；
>
>   记住这一节是指针与常量； const and pointer；

---

## const

> **const  把一些变量常量化！！**   优点是检查语法；
>
> 符号常量！！！#define PI 3.14 ; 宏最大的缺点，不检查错误！！一改全改；速度快，替换发生在编译阶段，所有运行速度会快！！ **宏名和 宏体的替换！！**！
>
> 

````c
//eg：man memcpy fopen;

//需要了解下面的几种写法！！
//toscore 指针常量和常量指针主要是看两者 const 常量 * 指针两者的前后关系；
/**
 * const and pointer
 * const int a;
 * int const a;
 常量指针
 * const int *p  
 * int const *p
 指针常量；
 * int *const p;
 * const int *const p;
*/
#define PI 3.14;
// 变量会被修改！！！ 所以 变量常量化 需要加 const  
float pi = 3.14;
const float pi = 3.14;



#include <stdio.h>

/**
 * const and pointer
 *  const int a;
 * int const a;
 * const int *p
 * int const *p
 * int *const p;
 * const int *const p;
*/
#define  PI 3.14

int main() {
    //常量只能在定义的时候赋值！！！
    //如果在定义的时候不赋值，那么一直都是哪一个随机值；不会被概念！！
    const float pi = 3.14;
    //2*pi*r

    // pi = 3.14159;
    float *p = &pi; // pi 不希望它修改的；但是间接的修改了，在一些情况就是错误！！！
    *p = 3.141596;

    printf("%f\n", pi);
    /**
     * * 是指针的标志位；
     * const 代表常量；
     * 常量指针
     * const int *p;
     * *p代表的是 指向的变量不会变； 
     * 指针常量
     * int *const p;
     * const p; p代表的指向不会变；
    */
   //常量指针
    int i = 1;
    int j = 2;
    const int *p = &i;
    printf("%d\n", *p);
    i = 10;//success //因为i 没有 const 所以可以修改
    *p = 11;//false; //const 修饰的是 *p;指针指向的变量；
    p = &j;

    //指针常量
    int* const q = &i;
    printf("%d \n",*p);//1
    *q = 10;//true
    // q = &j;//false

    //const int* const p1;
    /**
     * 不能指向野不能间接修改值；
     * const int* const p1 = &i;
    */
    const int* const p1 = &i;
    // *p1 = 11;//F
    // p1 = &j; // F
    return 0 ;
}
````



`````c
// 就是看 const 和 指针标志位*的位置，来判断是指针常量或者常量指针！！！
//指针常量 
//不能修改指向 p = 
int a = 1;
int b = 2;
int * const p =  &a;
//p = &b;//false

//-------------------------------------------------------
//常量指针
const int * q = &a;
//*q = 4444//false

//--------------------------------------------------------
// const int * const q = &a; // 指针常量，
const int * const q  = &a;
`````





## fopen 

>**man fopen** 
>
>**放心传参，我不会给你传递到数据做任何的修改！！**

`````c
//       #include <stdio.h>
// FILE *fopen(const char *path, const char *mode);

// 返回一个文件指针！！！
//为什么使用常量指针！！！ const char* path;
// 放心传参，我对你传递的参数，绝对不会做改变；



//#include <string.h>
//char *strcpy(char *dest, const char *src);
//char *strncpy(char *dest, const char *src, size_t n);

// 不会做任何的修改；
const char* src;
//放心传参，我不会通过，src这个指令，对你传过来的内容做任何的修改！！！



//memcpy  也是；man memcpy;



//做接口也是这样，给别人提供接口，用户提供一些，不能被擅自修改的数据，可以加一个const char *p;来接收；
//接收路径  可以使用  const char *path;
`````



