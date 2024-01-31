#  基础



https://git-scm.com/book/zh/v2/Git-%E5%9F%BA%E7%A1%80-%E8%AE%B0%E5%BD%95%E6%AF%8F%E6%AC%A1%E6%9B%B4%E6%96%B0%E5%88%B0%E4%BB%93%E5%BA%93

# 2.2 Git基础 - 每次记录更新到仓库

## 每次更新到仓库

现在，我们修改了一个真实的**真实**的Git仓库，并从一个真实的Git仓库中检查了所有文件的**工作副本**。将记录下它的时候，就将它提交到仓库。

**请，你的工作目录下的一个文件现在**不在每一个**文件**上的文件，在之后的状态是未修改，已在工作或已暂存之区。

工作中除跟踪外的未跟踪的，它们既不存在于所有记录中的所有目录中，也没有记录在任何目录中的暂存文件。的所有文件都属于跟踪文件，并没有修改状态，因为 Git 刚刚已经检测到它们，而你还没有编辑过它们。

在工作时，您可以自行编辑区为您修改过的文件后，您可以自行将这些过帐文件保存下来。然后提交所有已暂存的修改，如此重复。



 <font color=red>$ git rm --cached README</font>

![Git 下文件生命周期图。](git.assets/lifecycle.png)

图 8. 文件的状态变化周期

### 查看当前文件状态

用`git status`命令查看此文件后可以立即看到什么状态。

```shell
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
nothing to commit, working directory clean
```

目前，所有跟踪显示的文件都没有显示。在此之后，所有的信息都没有显示。 ，否则 Git 会在这里归为正常。该命令还显示当前位于分支，并且你这个分支同服务器上的分支没有现在，分支名是“master”，这是“分支名”，这是分支名称我们在[Git](https://git-scm.com/book/zh/v2/ch00/ch03-git-branching)和分支中会详细讨论分支引用。

现在，让我们在下创建一个新的文件`README`。`git status`

```shell
$ echo 'My Project' > README
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Untracked files:
  (use "git add <file>..." to include in what will be committed)

    README

nothing added to commit but untracked files present (use "git add" to track)
```

在报告中显示新的状态`README`文件`Untracked files`。 “我需要这个文件”。这样处理你就不必担心将要生成的跟踪文件或不想被跟踪的文件包含在其中`README`。

### 关注新文件

使用命令`git add`开始跟踪一个文件。所以，要跟踪`README`文件，运行：

```console
$ git add README
```

此时再运行`git status`命令，会查看`README`文件已被跟踪，并查询暂存状态：

```shell
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git restore --staged <file>..." to unstage)

    new file:   README
```

这下面`Changes to be committed`的，就说明是已经存在`git add`状态`git init`。`git add <files>`命令 `git add`使用文件或目录的路径作为该参数，该命令的将跟踪当前目录下的所有参数。

### 暂存已修改的文件

现在来修改一个已被跟踪的`CONTRIBUTING.md`文件`git status`。

```console
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    new file:   README

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

    modified:   CONTRIBUTING.md
```

文件`CONTRIBUTING.md`出现`Changes not staged for commit`这行但下面，跟踪文件的发生变化，还开始跟踪文件的暂存区。要暂存已经更新的区域，需要`git add`命令。这是个命令：可以用它在新文件内容，或者把已经跟踪的文件放在暂存的位置，用于合并时把有结果的标记作为解决状态等。 “将一个文件添加到中”要到合适的地方。现在让我们运行`git add`将“CONTRIBUTING.md”放置在暂存区，然后查看暂存区`git status`的输出：

```console
$ git add CONTRIBUTING.md
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    new file:   README
    modified:   CONTRIBUTING.md
```

现在文件都已经存了，下个提交的时候会运行一次并到仓库。暂且此时，你想在`CONTRIBUTING.md`里编辑条注释。重新开始盘后，准备好提交`git status`。看：

```console
$ vim CONTRIBUTING.md
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    new file:   README
    modified:   CONTRIBUTING.md

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

    modified:   CONTRIBUTING.md
```

<font color=red>怎么自己？现在`CONTRIBUTING.md`文件同时出现在暂存区和非暂存区。这怎么可能呢？好吧，实际上 Git 现在暂存区运行的是你`git add`命令时的版本。如果你提交，`CONTRIBUTING.md`的版本是你命令时的版本。一次运行命令时的那个最后`git add`，而不是你运行的最新`git commit`时，在工作中的当前版本。 所以，运行了`git add`之后又作了修订的目录的版本，重新运行`git add`把版本重新暂存起来：</font>

```console
$ git add CONTRIBUTING.md
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    new file:   README
    modified:   CONTRIBUTING.md
```

### 简览

`git status`Git 有一个附带选项可以帮助或显示状态的输出，可以以相应的方式更改命令的输出方式，如果您使用这种`git status -s`命令`git status --short`命令，将更加方便地使用它。的输出。

```console
$ git status -s
 M README
MM Rakefile
A  lib/git.rb
M  lib/simplegit.rb
?? LICENSE.txt
```

新添加的未跟踪文件前面有`??`标记，新添加到存储中的前面有`A`标记，修改过的文件前面有`M`标记区。 输出文件有两栏，左栏暂存的状态，右栏突出例如，上面的报告状态修改显示修改： `README`文件在工作区已但尚未暂存，而`lib/simplegit.rb`文件已且已暂存。 `Rakefile`文件已，暂存后又作了修改，因此该文件的修改中已存在暂存的部分，还有未暂存的修改的部分。

### 放电文件

一般总会有一些文件不包含 Git 的管理，也不希望我们总出现在未跟踪的文件列表中。通常都是一些自动生成的文件，比如日志文件，或者编译过程中创建的临时文件等。在这种情况下在这种情况下，可以创建一个名为`.gitignore`的例子，我们要加载文件的模式`.gitignore`。

```console
$ cat .gitignore
*.[oa]
*~
```

`.o`第一行告诉Git 播放所有以所有`.a`类型的对象文件和文档文件。软件（比如 Emacs）都用这样的文件名保存副本。另外，你可能还需要自动加载日志，tmp 或 pid 目录，以及生成的文档等。要植物一开始就为你的新仓库设置好。 gitignore 的文件的惯用法，今日提交无用的文件。

文件`.gitignore`的格式规范如下：

- 所有的空行或者以`#`视觉的行为都被 Git 启动。
- 可以使用标准模式匹配，在整个工作区应用它会地的全局。
- 以（大）对抗模式可以`/`匹配。
- 匹配模式可以以（`/`）结尾指定目录。
- 要指定模式以外的文件或目录，可以在模式前加上叹号（`!`）取反。

（`*`相反匹配或任意一个；`[abc]`指匹配任何一个列）在方零中则的字符（这个例子匹配的任何一个列）一个 b，或匹配一个）；问（或匹配一个）`?`；如果只在方括号中使用短划线显示两个字符，则表示所有在这范围内的`[0-9]`所有都可以匹配（例如表示匹配） 0 到 9 中间的数字）。 使用两个星号（`**`）表示匹配任意目录，比如`a/**/z`可以匹配`a/z`、`a/b/z`或`a/b/c/z`等。

我们再看一个`.gitignore`文件的例子：

```php
# 忽略所有的 .a 文件
*.a

# 但跟踪所有的 lib.a，即便你在前面忽略了 .a 文件
!lib.a

# 只忽略当前目录下的 TODO 文件，而不忽略 subdir/TODO
/TODO

# 忽略任何目录下名为 build 的文件夹
build/

# 忽略 doc/notes.txt，但不忽略 doc/server/arch.txt
doc/*.txt

# 忽略 doc/ 目录及其所有子目录下的 .pdf 文件
doc/**/*.pdf
```

| 小费 | GitHub 上有一个非常详细的主题项目和语言的`.gitignore`文件列表，你可以在https://github.com/github/gitignore找到它。 |
| ---- | ------------------------------------------------------------ |
|      |                                                              |

| 笔记 | 在最常见的情况目录下，一个仓库有一个`.gitignore`文件，它可能只是简单地在地下有可能只是应用到仓库中。，子目录下也有额外的文件`.gitignore`。`.gitignore`它在它的目录中。（Linux内核的源码库拥有206个`.gitignore`文件。）多个`.gitignore`文件的具体内容超出了本书的范围，更多详情见`man gitignore`。 |
| ---- | ------------------------------------------------------------ |
|      |                                                              |

### 查看已暂存和未暂存的修改

如果你的命令的输出可以用今天`git status`简单的方式来表达，而你想知道具体问题的地方，可以用：有哪些 更新暂存并准备好下次提交？。`git diff``git diff``git status``git diff`

再次修改 README 文件后存，然后编辑`CONTRIBUTING.md`文件后先不存， 运行`status`命令暂存：

```console
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    modified:   README

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

    modified:   CONTRIBUTING.md
```

要查看尚未暂存的文件直接更新了哪些部分，不加参数输入`git diff`：

```console
$ git diff
diff --git a/CONTRIBUTING.md b/CONTRIBUTING.md
index 8ebb991..643e24f 100644
--- a/CONTRIBUTING.md
+++ b/CONTRIBUTING.md
@@ -65,7 +65,8 @@ branch directly, things can get messy.
 Please include a nice description of your changes when you submit your PR;
 if we have to read the whole diff to figure out why you're contributing
 in the first place, you're less likely to get feedback and have your change
-merged in.
+merged in. Also, split your changes into comprehensive chunks if your patch is
+longer than a dozen lines.

 If you are starting to work on a particular area, feel free to submit a PR
 that highlights your work in progress (and note in the PR title that it's
```

这个命令比较的工作是中当前文件和暂存区域还修改目录之间的变化。也是之后没有暂存起来的变化。

查看已经存有的文件最后将要添加到暂存的内容，可以用`git diff --staged`命令将与已存文件提交的文件区别：

```console
$ git diff --staged
diff --git a/README b/README
new file mode 100644
index 0000000..03902a1
--- /dev/null
+++ b/README
@@ -0,0 +1 @@
+My Project
```

请注意，gitdiff本身只是显示还没有存有的记录，而不是自有的暂时`git diff`也没有提交所有的记录。所以今天运行后你更新一下，只显示过存有的所有文件。这个原因。

之前说的，暂存`CONTRIBUTING.md`暂缓，可以使用`git status`查看被修改的或者已经保存的环境。

```console
$ git add CONTRIBUTING.md
$ echo '# test line' >> CONTRIBUTING.md
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    modified:   CONTRIBUTING.md

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

    modified:   CONTRIBUTING.md
```

现在运行`git diff`看暂存前后的变化：

```console
$ git diff
diff --git a/CONTRIBUTING.md b/CONTRIBUTING.md
index 643e24f..87f08c8 100644
--- a/CONTRIBUTING.md
+++ b/CONTRIBUTING.md
@@ -119,3 +119,4 @@ at the
 ## Starter Projects

 See our [projects list](https://github.com/libgit2/libgit2/blob/development/PROJECTS.md).
+# test line
```

然后用`git diff --cached`查看已经暂存起来的变化（`--staged`和`--cached`是同义词）：

```console
$ git diff --cached
diff --git a/CONTRIBUTING.md b/CONTRIBUTING.md
index 8ebb991..643e24f 100644
--- a/CONTRIBUTING.md
+++ b/CONTRIBUTING.md
@@ -65,7 +65,8 @@ branch directly, things can get messy.
 Please include a nice description of your changes when you submit your PR;
 if we have to read the whole diff to figure out why you're contributing
 in the first place, you're less likely to get feedback and have your change
-merged in.
+merged in. Also, split your changes into comprehensive chunks if your patch is
+longer than a dozen lines.

 If you are starting to work on a particular area, feel free to submit a PR
 that highlights your work in progress (and note in the PR title that it's
```

| 笔记 | Git Diff 的插件版本在中，我们使用`git diff`来分析文件差异。不过你也可以使用图形化的工具或外部diff工具来比较。可以使用`git difftool`命令来调用emerge或vimdiff等软件（包括商业软件）输出diff的分析结果。使用`git difftool --tool-help`命令来看你的系统支持哪些 Git Diff 插件。 |
| ---- | ------------------------------------------------------------ |
|      |                                                              |

### 提交更新

在此之前的记录并没有准备好，可以提交的`git add`，暂存的时候已经有记录了。但未存的文件用暂存的文件保留在本地暂存了。 所以，需要准备提交前，`git status`先看下，所的不是，然后你都再运行提交的命令`git commit`：

```console
$ git commit
```

这样会开始你选择的文本编辑器来输入提交说明。

| 笔记 | 启动的编辑器是通过Shell的环境变量指定的，一般为[vim](https://git-scm.com/book/zh/v2/ch00/ch01-getting-started)`EDITOR`或者emacs。当然也可以按照介绍的方式，设置你喜欢的编辑器。 `git config --global core.editor` |
| ---- | ------------------------------------------------------------ |
|      |                                                              |

编辑器会类似下面的文本信息（本示例显示连接 Vim 的屏幕显示方式展示）：

```
# Please enter the commit message for your changes. Lines starting
# with '#' will be ignored, and an empty message aborts the commit.
# On branch master
# Your branch is up-to-date with 'origin/master'.
#
# Changes to be committed:
#	new file:   README
#	modified:   CONTRIBUTING.md
#
~
~
~
".git/COMMIT_EDITMSG" 9L, 283C
```

可以看到，默认的提交消息包含一次运行`git status`的输出，提出注释行里，另外的关系空行，供你提交输入说明。内容能帮你回推广推广的有哪些。

| 笔记 | 详细的内容，可以`-v`查看编辑器修改提示，更改您使用的选项。为了让您知道本次提交的内容的不同之处在于 |
| ---- | ------------------------------------------------------------ |
|      |                                                              |

退出器，Git 会删除评论时执行，用你输入的提交说明生成一次提交。

另外，你也可以在`commit`命令后添加`-m`选项，将提交信息与命令相同的行为，如下所示：

```console
$ git commit -m "Story 182: Fix benchmarks for speed"
[master 463dc4f] Story 182: Fix benchmarks for speed
 2 files changed, 2 insertions(+)
 create mode 100644 README
```

好，你已经创建了一个提交！可以，提交后告诉你，目前是在哪个分支（`master`）提交的，本次提交的 SHA-1 它以及它现在的完整和是什么（`463dc4f`）在本次提交中，有多少文件修改过，多少行添加和删改过。

请记住，提交记录是检测到暂存区域的状态。任何时候都暂存对保留的剩余已修改状态，可以在下一次提交的时候显示文件版本管理每一次提交运行操作作回到这一阶段，以后可以状态，或者进行比较。

### 跳过使用暂存区域

<font color=red>**暂时使用区域的方式，可以表示要提交的细节，但暂时准备暂时显示`git commit`繁体`-a`。会自动把所有已经关注过的文件暂存起来并提交，然后跳过`git add`步骤：**</font>

```console
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

    modified:   CONTRIBUTING.md

no changes added to commit (use "git add" and/or "git commit -a")
$ git commit -a -m 'added new benchmarks'
[master 83e38c7] added new benchmarks
 1 file changed, 5 insertions(+), 0 deletions(-)
```

看到提交了吗？在不再提交之前的`git add`文件“CONTRIBUTING.md”。这是`-a`选项使本次提交包含所有过时的文件。添加到提交中。



##  好好搞定一下  删除和移动 重为名；

### 删除文件

`git rm`要从中删除作业清单，就要从命令 中保存清单中取出工作（说明，是从那里取出），然后可以用从暂存好的文件提交给 Git 文件。目录中删除指定的文件，这样以后就不会出现在未跟踪的文件清单中了。

如果只是简单地从工作中手动删除文件，运行`git status`时也应该在“Changes not stage for commit”部分就是*未暂存目录清单*）看到：

```console
$ rm PROJECTS.md
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes not staged for commit:
  (use "git add/rm <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

        deleted:    PROJECTS.md

no changes added to commit (use "git add" and/or "git commit -a")
```

然后再运行`git rm`记录移除文件的操作：

```console
$ git rm PROJECTS.md
rm 'PROJECTS.md'
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    deleted:    PROJECTS.md
```

下一次提交的时候，该文件就不再版本管理修改了。如果要删除之前或已经存在暂存区的文件，则必须使用强制删除选项`-f`（译注：强制删除首选项）。某种安全特性，用于阻止错误，但不能添加到 Git 的数据的这种数据。

一种情况是想把文件放在Git仓库中，但暂存区域中并删除文件。`.gitignore`不想让Git继续跟踪`.a`。`--cached`：

```console
$ git rm --cached README
```

`git rm`后台文件也可以使用目录的名称，也可以使用命令`glob`模式。

```console
$ git rm log/\*.log
```

注意到星号`*`之前的反斜杠`\`，因为Git有它自己的文件模式扩展匹配方式，所以我们不用shell来`log/`帮忙`.log`。

```console
$ git rm \*~
```

该命令会删除所有名字以`~`结束的文件。



### 移动文件

看其他的 VCS 系统，Git 如果在 Git 中跟踪移动文件的某个时候，在 Git 中编造了这个文件一次，仓库中的元数据并不会显示出一个非常聪明的操作重命名操作。它会推断出发生的原因，至于具体是如何做到的，我们随后再谈。

如此，当你看到 Git 的`mv`命令时，一定会困惑不解。要在 Git 中对文件改名，就可以这样：

```console
$ git mv file_from file_to
```

它会运行正常的工作信息。同时，关于此时的状态，也将明白无误地说明：

```console
$ git mv README.md README
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

    renamed:    README.md -> README
```

确实，运行`git mv`就相当于运行了下面三条命令：

```console
$ mv README.md README
$ git rm README.md
$ git add README
```

单独使用两种方式，所以不管是这样一种方式，直接使用的结果都一样。重命名文件时，记得在提交前删除旧文件名，重新 添加新文件名。`git mv``git mv``git rm``git add`













**git rm**

[git rm命令官方解释](https://git-scm.com/docs/git-rm)

**删除的本质**

在git中删除一个文件，本质上是从tracked files中移除对这些文件的跟踪。更具体地说，就是将这些文件从staging area移除。然后commit。

**作用**

git rm的作用就是将文件从暂存区删除

git rm的作用就是将文件从工作目录 和 暂存区 删除。

git rm并不能仅仅删除工作目录中的文件，而暂存区保持不变。目前git也没有提供任何参数支持这一功能。要想实现这一目标，只能使用Linux自带的/bin/rm命令

**使用场景**

**彻底删除文件**

所谓彻底删除文件，就是在工作目录和暂存区删除文件。

由于gir rm不能直接删除工作目录中的文件，于是使用/bin/rm手动删除。此时执行git status 时就会在 “Changes not staged for commit”部分看到，表示没有被更改没有被暂存

![img](git.assets/ExpandedBlockStart.gif)

[![复制代码](git.assets/copycode.gif)](javascript:void(0);)

```
$ rm PROJECTS.md
$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Changes not staged for commit:
    (use "git add/rm <file>..." to update what will be committed)
    (use "git checkout -- <file>..." to discard changes in workingdirectory)
        deleted: PROJECTS.md
no changes added to commit (use "git add" and/or "git commit -a")
```

[![复制代码](git.assets/copycode.gif)](javascript:void(0);)

**然后再运行 git rm 将文件从暂存区移除**

![img](git.assets/ExpandedBlockStart.gif)

[![复制代码](git.assets/copycode.gif)](javascript:void(0);)

```
$ git rm PROJECTS.md
rm 'PROJECTS.md'
$ git status
On branch master
Changes to be committed:
    (use "git reset HEAD <file>..." to unstage)
        deleted: PROJECTS.md
```

[![复制代码](git.assets/copycode.gif)](javascript:void(0);)

下一次提交时，该文件就不再纳入版本管理了。 

现在假设这样一组场景，有文件file1.c，file2.c，file3.c。我把file1.c做了修改，并且git add到暂存区。这时候如果向上面那样手动/bin/rm删除file1.c，然后再git rm file1.c，这样没有任何问题。但是如果你跳过/bin/rm file1.c这一步，直接git rm file1.c是不被允许的，报错

![img](git.assets/ExpandedBlockStart.gif)

```
$ git rm file1.c 
error: the following file has changes staged in the index:
    file1.c 
(use --cached to keep the file, or -f to force removal)
```

必须要用强制删除选项 -f（即 force 的首字母）。 这是一种安全特性，用于防止误删还没有添加到快照的数据，这样的数据不能被 Git 恢复。

**只删除暂存区的文件**

如果你想保留工作目录中的文件，但是删除对应暂存区中的文件。换句话说，你想让这些保存在磁盘上的文件不再被git跟踪。请使用--cached 选项。为啥会有这种奇怪的需求呢？假设这样一种场景，你忘记了添加.gitignore文件，不小心把很多本应忽略的文件加到了暂存区，这时候就需要这里介绍的做法了。

<font color=red>$ git rm --cached README</font>

git rm 命令后面可以列出文件或者目录的名字，也可以使用 glob 模式。 比方说：

$ git rm log/*.log

注意到星号 * 之前的反斜杠 ， 因为 Git 有它自己的文件模式扩展匹配方式，所以我们不用 shell 来帮忙展开。

此命令删除 log/ 目录下扩展名为 .log 的所有文件。 类似的比如：

$ git rm *~

该命令为删除以 ~ 结尾的所有文件。

**git mv**

不像其它的 VCS 系统，Git 并不显式跟踪文件移动操作。 如果在 Git 中重命名了某个文件，仓库中存储的元数据并不会体现出这是一次改名操作。 不过 Git 非常聪明，它会推断出究竟发生了什么。

你依然可以使用$ git mv file_from file_to 对文件改名。它会恰如预期般正常工作。 实际上，即便此时查看状态信息，也会明白无误地看到关于重命名操作的说明：

![img](git.assets/ExpandedBlockStart.gif)

```
$ git mv README.md README
$ git status
On branch master
Changes to be committed:
    (use "git reset HEAD <file>..." to unstage)
        renamed: README.md -> README        
```

事实上，运行 git mv 就相当于运行了下面三条命令：

![img](git.assets/ExpandedBlockStart.gif)

```
$ mv README.md README
$ git rm README.md
$ git add README
```

如此分开操作，Git 也会意识到这是一次改名，所以不管何种方式结果都一样。 两者唯一的区别是，mv 是一条命令而另一种方式需要三条命令，直接用 git mv 轻便得多。 不过有时候用其他工具批处理改名的话，要记得在提交前删除老的文件名，再添加新的文件名。

 