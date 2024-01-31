# tcp keepalive  and http keepalive



 ## 两者是一个东西吗？

**不是，TCP keepalive 和 HTTP keepalive 是两个不同的概念。**

**TCP keepalive 是一种机制，用于在两个端点之间的TCP连接上发送探测包，以检测连接是否仍然有效。这有助于在连接空闲时检测到连接断开或故障。**

**HTTP keepalive 是一种机制，允许在单个TCP连接上发送多个HTTP请求和响应，而不是每个请求都建立新的TCP连接。这有助于减少连接建立和断开的开销，提高性能。**

**因此，虽然它们都涉及到保持连接的活跃状态，但TCP keepalive 和 HTTP keepalive 是不同的概念。**