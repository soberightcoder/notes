# docker volumes



**Docker 挂载主机目录的默认权限是 读写 ，用户也可以通过增加 readonly 指定为 只读 。**

`````php
$ docker run -d -P \
--name web \
# -v /src/webapp:/opt/webapp:ro \
--mount type=bind,source=/src/webapp,target=/opt/webapp,readonly \
training/webapp \
python app.py
`````

