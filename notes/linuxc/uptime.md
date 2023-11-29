# uptime

>**平均负载是指单位时间内，系统处于可运行状态(R)和不可中断状态(D)的平均进程数，也就是平均活跃进程数**。

---

**uptime**

- **`load average: 0.50, 0.75, 1.00`：最近1分钟、5分钟和15分钟的平均负载。**

  

**查看核心数:**

cat /proc/cpuinfo | grep -i "model name" | wc -l

----

