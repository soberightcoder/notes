# yum基础命令操作

#### 基础命令操作

```
yum 命令：用于添加/删除/更新RPM包,自动解决包的依赖问题以及系统更新升级

参数

-e [error level], --errorlevel=[error level] 错误输出级别
-q, --quiet 安静的操作
-t 忽略错误
-R[分钟] 设置等待时间
-y 自动应答yes
--skip-broken 忽略依赖问题
--nogpgcheck 忽略GPG验证
```



| 命令                                                         | 效果                                      |
| ------------------------------------------------------------ | ----------------------------------------- |
| yum install -y                                               | 安装                                      |
| yum makecache                                                | 更新yum缓存                               |
| **yum list installed \| grep xxx**   \  rpm -qa \|grep -i package_name | 查看已经安装软件                          |
| yum list softwarename                                        | #查看软件源中是否有此软件                 |
| yum -y update xxx                                            | 更新软件 配置和系统设置都会被修改         |
| yum -y upgrade  xxx                                          | 更新软件 配置和系统设置都不会被修改       |
| **yum remove xxx xxx xxx**                                   | 卸载                                      |
| yum clean all                                                | 清除所有的yum缓存                         |
| clean packages                                               | 清除临时包文件（/var/cache/yum 下文件） c |
| clean headers                                                | 清除rpm头文件                             |
| yum search xxx                                               | 查找软件                                  |
| yum info xxx                                                 | 查看软件的信息                            |

#### yum源的更新

* 备份

  ~~~
  mv /etc/yum.repos.d/Centos-Base.repo   /etc/yum.repos.d/Centos-Base.repo.bak
  ~~~

* 更新阿里源

  ~~~
  wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
  ~~~

  * -O 重新命名，显示下载信息；
  * -o 不显示下载信息，下载信息保存在第一个参数文件中；

* 更新yum缓存

  ~~~
  yum makecache
  ~~~

  **wget资源下载 有些资源需要加参数 -no-check-certificate**
  
  # 



---

## 清华源

>**靠谱的镜像源！！**

---

### centos 7，8 镜像源

https://mirrors.tuna.tsinghua.edu.cn/help/centos/  

````shell
# 对于 CentOS 7
# 还会生成副本！！ .bak 做好备份！！
sed -e 's|^mirrorlist=|#mirrorlist=|g' \
    -e 's|^#baseurl=http://mirror.centos.org/centos|baseurl=http://mirrors4.tuna.tsinghua.edu.cn/centos|g' \
    -i.bak \
    /etc/yum.repos.d/CentOS-*.repo
````

### debian 11 bulleyes



https://mirrors.tuna.tsinghua.edu.cn/help/ubuntu/

---

