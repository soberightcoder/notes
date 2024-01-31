# enum 枚举类型

 >构造类型：枚举类型；
 >
 >有限状态；

---

## enum 定义；

````c
//定义！！

enum  标识符
{
    成员1,
    车成员2,
    ......
};



#include <stdio.h>
#include <stdlib.h>
/**
 * enum枚举；
*/
/**
 * 一连串的宏来使用！！
 * 不用每一个宏都要去定义！！
*/

/**
 * enum  和 宏的区别！！！
 * 宏会在预处理替换；
*/
// #define STAGE_RUNNGIN 1
enum
{
    STAGE_RUNING = 1,
    STAGE_CANCELED,
    STAGE_OVER,
};

enum day
{	
    //默认是从0开始！！！
    //会依次往下排序；
    // 从1开始依次进行排序；
    MON = 1,
    TUS,
    THR,
    WES,
    //重排；
    FRI = 1,
    SAT,
    SUN
};
struct job_st
{
    int id;
    int state;
    time_t start, end;
};

int main() {

    enum day a = SAT;
    a = SUN; //3
    printf("%d\n", a);

    //任务
    struct job_st job1;
    // 获取任务状态；
    job1.state = STAGE_OVER;

    switch (job1.state)
    {
    case STAGE_OVER:
            printf("over\n");
        break;
    case STAGE_CANCELED:
            printf("cancel\n");
        break;
    case STAGE_RUNING:
            printf("running\n");
        break;
    default:
        abort();
    }

    return 0;
}
````







