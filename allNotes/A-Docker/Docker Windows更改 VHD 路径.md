# Docker Windows更改 VHD 路径

>c盘爆满，用第三方工具spacesniffer；看到是这个虚拟硬盘的原因；
>
>所以把虚拟硬盘移到D盘；来缓解c盘爆满的原因！！！

打开 %APPDATA%\Docker\settings.json

默认路径

"MobyVhdPathOverride":"C:\Users\Public\Documents\Hyper-V\New folder\MobyLinuxVM.vhdx"

将其修改为
 "MobyVhdPathOverride":"D:\Virtual hard disks\MobyLinuxVM.vhdx"

然后打开Docker

那么Docker 自动创建的 VHD 就在 D盘了

然后可以打开 Hyper-V 管理器

![img](./Docker%20Windows%E6%9B%B4%E6%94%B9%20VHD%20%E8%B7%AF%E5%BE%84.assets/webp.webp)