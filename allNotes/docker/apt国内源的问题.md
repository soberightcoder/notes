#解决方案

>阿里云的各种镜像源的镜像地址  **开发者社区**
>
>https://developer.aliyun.com/mirror/



###apt-get install gnupg2    需要安装这个gpg才能解决这个问题；



###来源：

https://chrisjean.com/fix-apt-get-update-the-following-signatures-couldnt-be-verified-because-the-public-key-is-not-available/



###问题：

````shell
Fix apt-get update “the following signatures couldn’t be verified because the public key is not available”

 GPG error: http://mirrors.aliyun.com/ubuntu bionic-security InRelease: The following signatures couldn't be verified because the public key is not available: NO_PUBKEY 3B4FE6ACC0B21F32
````

###解决：

```
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 40976EAF437D05B5
```