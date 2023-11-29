# iostat



![image-20231125231606160](./iostat.assets/image-20231125231606160.png)



所以 指标最重要的就是

````shell
#await average wait time 平均等待时间；

# **avgqu-sz: 平均I/O队列长度。**  IO队列的长度；等待io操作的队列长度！！！
#**await: 平均每次设备I/O操作的等待时间 (毫秒)。** 系统延迟 这个单位是毫秒！！！ 不能太长！！！ 太长的话，肯定会有io瓶颈问题！！！
#**%util: 一秒中有百分之多少的时间用于 I/O 操作，即被io消耗的cpu百分比**
````

