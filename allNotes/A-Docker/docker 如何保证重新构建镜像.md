# docker 重新构建镜像

---

因为 Docker Compose 的 `--force-recreate` 选项只会强制重新创建容器，而不会重新构建镜像。

因此，如果你修改了Dockerfile，需要确保重新构建新的镜像。

 

你可以尝试以下步骤来解决这个问题：

````shell
#1. 使用 `docker-compose down` 命令停止并移除之前的容器和网络。
#2. 使用 `docker-compose build` 命令重新构建镜像，确保新的Dockerfile被正确地应用。
#3. 运行 `docker-compose up` 命令启动容器。//启动容器 存在就不会根据dockerfile 来重新创建！！
````

这样做将会重新构建镜像并创建新的容器，以确保新的Dockerfile的更改生效。

 

上面合成一步就是，

````shell
# 重新创建镜像！！
#build  重建镜像  --force-recreate 重建 容器；
docker-compose up [service] -d --build --force-recreate

````

