#  origin http header





## What is Origin HTTP Header?

The Origin HTTP Header Request header specifies<font color=red> **the origin of the request**</font> (scheme, hostname, and port). 



**For example, if a user agent needs to request resources contained within a page or retrieved by scripts that it executes, the origin of the page may be included in the request.**



### What is the Syntax of the Origin HTTP Header?

The Origin HTTP Header uses multiple values in its syntax. The syntax for using the Origin HTTP Header is written below. 

```
Origin: null
Origin: <scheme>://<hostname>
Origin: <scheme>://<hostname>:<port>
```







The Origin request header indicates the origin (scheme, hostname, and port) that caused the request. 

For example, if a user agent needs to request resources included in a page, or fetched by scripts that it executes, then the origin of the page may be included in the request.



The Origin header is similar to the Referer header, but does not disclose the path, and may be null. It is used to provide the "security context" for the origin request, except in cases where the origin information would be sensitive or unnecessary.









<font color=red>**Origin请求头表示  引起请求的来源（方案、主机名和端口）。**</font>



例如，如果一个用户代理需要请求包含在一个页面中的资源，或由其执行的脚本获取的资源，**那么页面的来源可能会被包含在请求中。**



**Origin头与Referer头相似，但不透露路径，而且可以是空的。它被用来为原点请求提供 "安全环境"，除非原点信息是敏感的或不必要的情况。**

