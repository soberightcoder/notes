# daemon.json 配置

> 

```json
//from-data 可以设置 容器和镜像的的目录  "from-data": 'd:\\docker'
//限制文件的大小；
"log-driver":"json-file",
"log-opts": {"max-size":"500m", "max-file":"3"}
```





`````json
{
    "log-driver":"json-file",
	"log-opts": {"max-size":"500m", "max-file":"3"}	,
    " log-path": "var/log/docker",
}


//目录 ；
`````

