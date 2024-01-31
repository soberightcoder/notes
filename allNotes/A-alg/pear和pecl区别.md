============================================
商业转载请联系获得授权，非商业转载请注明出处
**作者：**[苏南大叔](https://newsn.net/) 【京城，非著名互联网从业人员】
**来源：**https://newsn.net/say/pear-pecl.html
**打赏：**https://newsn.net/shang.html
**加群：**https://newsn.net/group.html

欢迎转发/打赏/点赞/留言，感谢您的支持！



目前来说，`pear`和`pecl`都早已没落了。官方的姐妹花，已经变成了落难兄弟。除了`pecl`还是有点用途外，`pear`似乎再无人提起，转而代之的是：`composer`。`pecl`安装扩展，在不同的操作系统上，也有很多的替代品，比如`brew`，`yum`等等。



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - pear-pecl](https://newsn.net/usr/img/water/53/53ae544e5836b85f.png)]()

[PHP高手都在这里，就差你了](https://newsn.net/group.html#php)

如何安装pear和pecl？pear和pecl有何区别？（图16-1）



在本文中，苏南大叔和大家聊聊，`pecl`和`pear`命令的安装，补充一下知识点。本文的测试环境是`mac`，但是在其它操作系统下，操作上的区别也不大。

## `pear`和`pecl`区别

`pear`和`pecl`这对php官方的姐妹花，对于很多人来说，有些傻傻的分不清。苏南大叔，这里通俗的解释一下。

- `pear`，PHP Extension and Application Repository。下载到的代码，是php编写的，是大多数phper能够理解和看懂的，说白了，就是php类库。
- `pecl`，PHP Extension Community Library。`pecl`下载到的，是放在`php.ini`的`extension`里面的dll或者so文件，当然，是经过`pecl`本地编译过的，通常是c语言编写的。对于phper来说，修改源码是有些难度的。

正常情况下，`pear`和`pecl`这两个命令，是可以自动识别的。苏南大叔截图如下：



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 000_pear](https://newsn.net/usr/img/water/c3/c377e4df365755f2.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-2）





[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 000_pecl](https://newsn.net/usr/img/water/bc/bc3235673a5d76f8.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-3）



## `pear`和`pecl`命令安装

如果您的命令行下面不能识别`pear`和`pecl`的话，那么您可能需要安装一下对应脚本。具体的安装步骤，可以参加下面这个链接。



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - pecl-command-not-found](https://newsn.net/usr/img/water/db/db545d46b06037f6.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-4）



- [http://pear.php.net/manual/en/installation.getting.php]()



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 001_000](https://newsn.net/usr/img/water/57/5714e9a0a64fb20b.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-5）





[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 001_001](https://newsn.net/usr/img/water/d1/d1c0faae0371cd3f.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-6）



苏南大叔的测试环境是mac，所以，下面的截图，都基于mac下的测试环境。前提是您的测试机安装了php，可以正常解析php命令。

```bash
curl -O https://pear.php.net/go-pear.phar
php -d detect_unicode=0 go-pear.phar
```

Plain text

Copy



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 001_002](https://newsn.net/usr/img/water/cc/cc13e657fa6b0ab1.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-7）





[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 002](https://newsn.net/usr/img/water/be/be8d9505e12cad9d.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-8）



在接下来的安装中，会提示有12个安装参数。在官方给出的说明中，提示大家需要修改两个参数，分别是`1`和`4`。

- `1`号需要修改为：`/usr/local/pear`。
- `4`号需要修改为：`/usr/local/bin`。

在测试过程中，苏南大叔，并没有修改。而是直接一连串回车。目前似乎也没有什么问题。but，既然官方建议修改了，为了保险起见，大家就修改一下吧。下面是修改的过程截图。修改完成后，回车即可。还会提示，自动识别出来的`php.ini`位置是不是对的。大家直接回车就好了。



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - pecl-options-1](https://newsn.net/usr/img/water/0d/0d9fa532968ea602.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-9）





[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - pecl-options-4](https://newsn.net/usr/img/water/9d/9daf06adcc29b470.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-10）



## 脚本修改`php.ini`

这个过程中，脚本会要求确认修改`php.ini`，会在里面增加`include_path`。其实就是用php的`require`和`include`的时候，能够直接使用到pear下载的脚本，而做的准备。



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 003](https://newsn.net/usr/img/water/c7/c7f336d6598983d7.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-11）





[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 004](https://newsn.net/usr/img/water/0c/0c8335aa3fe00425.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-12）



下面的两张图，显示了`php.ini`变化前后对`include_path`的影响。



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 005](https://newsn.net/usr/img/water/8a/8af062e14d3a8f6f.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-13）





[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - 006](https://newsn.net/usr/img/water/77/779c45ed2157d424.png)]()如何安装pear和pecl？pear和pecl有何区别？（图16-14）



## 额外说明

如果您在`mac`下经常使用`pecl`的话，您可能还需要主动安装`cmake`和`autoconf`。利用`brew`就可以安装他们。

```bash
brew install cmake
brew install autoconf
```

Plain text

Copy



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - brew-cmake](https://newsn.net/usr/img/water/5e/5e1b375d791af543.png)]()

[PHP高手都在这里，就差你了](https://newsn.net/group.html#php)

如何安装pear和pecl？pear和pecl有何区别？（图16-15）



或者您还可能遇到需要`channel-update`的情况，如下图所示：



[![苏南大叔：如何安装pear和pecl？pear和pecl有何区别？ - brew-channel-update](https://newsn.net/usr/img/water/9a/9a536042adb2e238.png)]()

[PHP高手都在这里，就差你了](https://newsn.net/group.html#php)

如何安装pear和pecl？pear和pecl有何区别？（图16-16）



## 小结

在本文中，大家学习了在`mac`系统下，`pear`和`pecl`命令的安装过程。安装号对应的命令后，就可以愉快的使用他们，安装各种公开的库文件了。目前来说，更多的情况，可能会更多的使用`pecl`。