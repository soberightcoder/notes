# vscode vim 输入法切换问题

>
>
>Switch your input method in shell. This project is a basic support for VSCodeVim. It provides the command line program for VSCodeVim's autoSwitchIM function.
>
>im-select.exe im 就是input method 输入法的意思！！！！

# [vscode使用vim插件在切换normal mode和insert mode 时反复切换输入法的解决办法](https://www.cnblogs.com/hhr346/p/16631028.html)

vscodevim的配置切换输入法

今天在用`vscode`写（水）一个暑研论文的时候，用的是还没用多久的vim输入方式，vim的最大优点就是移动光标的多种方式可以最大程度减少对方向键或者是鼠标的依赖。但是对于我目前的中文写论文的方式来说存在一个很大的问题，就是在esc进入insert mode之后总是因为输入法的问题要切换到英文输入法，这就让本来流利的vim变得磕磕绊绊，之前没有想过这个问题有没有什么好的解决方法，今天上网一看，果然也有很多人有同样的困扰。 然后经过一番搜索整合之后，在知乎找到了针对windows操作系统下的vim解决方法。 对于mac似乎是已经有比较好的方法，参见[这个](https://github.com/ybian/smartim)。

然后解决办法主要参考了[这个知乎问答方法](https://www.zhihu.com/question/303850876)

主要步骤和注意事项整合如下：

1、为系统添加一个英文输入法，注意**不是输入法软件**，这个我之前就已经搞好了，因为大家都知道大部分游戏都需要把“讨厌”的中文输入法关掉；

2、下载`im-select.exe`，在这里的[GitHub链接](https://github.com/daipeihust/im-select#installation)处下载即可；

3、**在下载的路径处**右击并选择open terminal，输入`im-select`即可查看到当前输入法的编号。

*注意因为Windows可能会不信任这个exe文件，所以如果出现无法识别命令，可以在terminal输入`.\im-select`即可运行*

一般来说微软的中文输入法编号为2052，而美式键盘的编号则为1033，这里关系到下一步添加配置文件的时候选择的输入法的编号。

输入`im-select 编号`即可切换到编号对应的输入法

4、然后打开`vscode`的`settings.json`的配置文件，并且添加

```json
"vim.autoSwitchInputMethod.enable": true,
"vim.autoSwitchInputMethod.defaultIM": "1033",
"vim.autoSwitchInputMethod.obtainIMCmd": "E:\\imselect\\im-select.exe", 
"vim.autoSwitchInputMethod.switchIMCmd": "E:\\imselect\\im-select.exe {im}",
```

注意json的行尾要添加逗号（末尾除外）

再注意更改路径到你自己的安装路径处

再再注意\ \才是路径间隔符

至此，已经完成配置，总的来说就是通过`vscode`的配置，让你在切换到normal mode之后切换到英文输入法，切换到insert mode 之后再自动切换输入法。

如果哪一天不需要中文输入了，把上面配置文件第一行里的true改成false即可。

(总结：能用英文尽量用英文-，-)