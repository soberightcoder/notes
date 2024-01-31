# 通信问题

# 

### 容器之间的通信

通过 docker0  默认的

或者自己创建docker  network create -d bridge  bridge_name



### 容器访问外网

通过路由的转发,NAT网路地址转换；



### 主机访问 容器

通过expose 暴漏端口；  

只要主机不访问 就不需要访问