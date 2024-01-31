# GCC



**root@b28137ec3b07:~# gcc ceshi**
**root@b28137ec3b07:~# ls**
**a.out  ceshi  ceshi.c  ceshi.sh  config  config.sh  test  test.cpp**
**root@b28137ec3b07:~# ./a.out**
**hello word!**





**直接使用   gcc ceshi.c -o exec_name**
**自定义 可执行文件的文件名；**



`````c
root@b28137ec3b07:~# cat test.c
#include <stdio.h>
int Number(int n)
{
        int count = 0;
        while(n)
        {
                ++count;
                n = (n-1)&n;

        }
        return count;
}

int main(){

        printf("%d",Number(-1));
}

32 位 
在php中有问题；
    
    
`````

gcc test.c -o test.out





root@b28137ec3b07:~# ./a.out
32root@b28137ec3b07:~#
