# redo log crash -safe得能力



为什么 redo log 具有 crash-safe 的能力，而 binlog 没有？
redo log 是什么？

一个固定大小，“循环写”的日志文件，记录的是物理日志——“在某个数据页上做了某个修改”。

binlog 是什么？

一个无限大小，“追加写”的日志文件，记录的是逻辑日志——“给 ID=2 这一行的 c 字段加1”。

redo log 和 binlog 有一个很大的区别就是，一个是循环写，一个是追加写。也就是说 redo log 只会记录未刷盘的日志，已经刷入磁盘的数据都会从 redo log 这个有限大小的日志文件里删除。binlog 是追加日志，保存的是全量的日志。

**当数据库 crash 后，想要恢复未刷盘但已经写入 redo log 和 binlog 的数据到内存时，binlog 是无法恢复的。虽然 binlog 拥有全量的日志，但没有一个标志让 innoDB 判断哪些数据已经刷盘，哪些数据还没有。**

举个栗子，binlog 记录了两条日志：

给 ID=2 这一行的 c 字段加1
给 ID=2 这一行的 c 字段加1

**在记录1刷盘后，记录2未刷盘时，数据库 crash。重启后，只通过 binlog 数据库无法判断这两条记录哪条已经写入磁盘，哪条没有写入磁盘，不管是两条都恢复至内存，还是都不恢复，对 ID=2 这行数据来说，都不对。**



但 redo log 不一样，只要刷入磁盘的数据，都会从 redo log 中抹掉，数据库重启后，直接把 redo log 中的数据都恢复至内存就可以了。这就是为什么 redo log 具有 crash-safe 的能力，而 binlog 不具备。

当数据库 crash 后，如何恢复未刷盘的数据到内存中？

根据 redo log 和 binlog 的两阶段提交，未持久化的数据分为几种情况：

change buffer 写入，redo log 虽然做了 fsync 但未 commit，binlog 未 fsync 到磁盘，这部分数据丢失。
change buffer 写入，redo log fsync 未 commit，binlog 已经 fsync 到磁盘，先从 binlog 恢复 redo log，再从 redo log 恢复 change buffer。
change buffer 写入，redo log 和 binlog 都已经 fsync，直接从 redo log 里恢复。
(全文完)



## 刷脏页得策略；

