# 终端terminal中文乱码问题

# 问题及原因

![在这里插入图片描述](./terminal%E7%BB%88%E7%AB%AF%E4%B8%AD%E6%96%87%E4%B9%B1%E7%A0%81%E9%97%AE%E9%A2%98.assets/5afd8e20771d4925932700b4c17158ef.png)
**问题原因：代码文件的字符编码格式为`UTF-8`，但是`terminal`的字符编码格式为`GBK`。**
解决思路：统一代码文件和`terminal`的字符编码格式。



## 解决方案

## chcp 这种仅仅只是暂时修改字符集！！！

这个方法是临时修改`terminal`的字符编码格式。
修改格式如下：
![在这里插入图片描述](./terminal%E7%BB%88%E7%AB%AF%E4%B8%AD%E6%96%87%E4%B9%B1%E7%A0%81%E9%97%AE%E9%A2%98.assets/082a32f83a89479ea7de7c7f3397e7ab.png)
其中：`65001`代表`UTF-8`，`936`代表`GBK`。



## gcc 修改编译的过程；



```c
//run coder
"c": "cd $dir && gcc -fexec-charset=GBK $fileName -o $fileNameWithoutExt && $dir$fileNameWithoutExt",
```



## 启动 vscode cmder终端 的时候自动执行chcp 65001

````c
chchp 65001
//下面加上这一段就行！！！
````

![image-20231029153130349](./terminal%E7%BB%88%E7%AB%AF%E4%B8%AD%E6%96%87%E4%B9%B1%E7%A0%81%E9%97%AE%E9%A2%98.assets/image-20231029153130349.png)