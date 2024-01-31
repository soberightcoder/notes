# break  and continue  and return 

>break : 一层for 或者while的循环；
>
>continue; 跳出本次循环，进行下一次循环；
>
>return : 结束这个函数；无论循环多少次函数的结束;  函数默认结束 } 右括号默认结束；return null；



`````php
/**
 * break  结束一次循环；
 * continue 结束本次循环，进行下一次循环；
 * return 结束这个函数 无论多少次循环都要结束；
 */

function beak() {
//    for ($i = 0; $i <=5; $i++) {
//        if ($i == 3) {
//            break;
//        }
//        echo $i."--";// 0-1-2
//    }
    for ($i = 0; $i <=5; $i++) {
        if ($i == 3) {
            continue;
        }
        echo $i . "--";// 0-1-2-4-5;
    }
}
beak();
`````

