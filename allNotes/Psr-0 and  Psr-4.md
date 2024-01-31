#  Psr-0  and  Psr-4 自动加载规范

>两个自动加载规范； php 
>
>psr-0  and psr-4; 都是自动加载规范，但是psr-0，已经被抛弃，现在使用的是psr-4；
>
>``````php
>## 很重要的部分；
>##自动加载主要是分为三部分组成；
>### 1. vendor name 组织名字，顶级命令空间，或者一个项目的名称；
>// 最重要的部分： namespace 
>// 这里说的类名是包含命名空间的！！
>// 但是路由是 url 和 类名的一个映射关系；
>// 自动加载的是，类名到 类目录的映射关系；require_once;
>### 2. namespace 怎么转换成 文件路径 然后require_once  引入文件就可以了；
>``````
>
>

---

## Psr-o

> 此规范已被弃用 - 本规范已于 2014 年 10 月 21 日被标记为弃用，目前最新的替代规范为 [PSR-4]() 。

本文是为`自动加载器（autoloader）`实现通用自动加载，所需要遵循的编码规范。

## 规范说明 (vendor name  供应商名称，组织者名称，或者顶级命名空间；)

- 一个标准的 命名空间 (namespace) 与 类 (class) 名称的定义必须符合以下结构： `\<Vendor Name>\(<Namespace>\)*<Class Name>`；  //上面的是一个正则，(<namespace>\\)*  就是代表 子命名空间可以（0，无穷）；
- 其中 `Vendor Name` 为每个命名空间都必须要有的一个顶级命名空间名；
- 需要的话，每个命名空间下可以拥有多个子命名空间；
- 当根据完整的命名空间名从文件系统中载入类文件时，每个命名空间之间的分隔符都会被转换成文件夹路径分隔符；
- **<font color=red>类名称中的每个 `_` 字符也会被转换成文件夹路径分隔符，而命名空间中的 `_` 字符则是无特殊含义的。  和psr-4的一个很大的区别</font>** 
- 当从文件系统中载入标准的命名空间或类时，都将添加 `.php` 为目标文件后缀；
- **`组织名称(Vendor Name)`、`命名空间(Namespace)` 以及 `类的名称(Class Name)` 可由任意大小写字母组成。**

## 范例

- `\Doctrine\Common\IsolatedClassLoader` => `/path/to/project/lib/vendor/Doctrine/Common/IsolatedClassLoader.php`
- `\Symfony\Core\Request` => `/path/to/project/lib/vendor/Symfony/Core/Request.php`
- `\Zend\Acl` => `/path/to/project/lib/vendor/Zend/Acl.php`
- `\Zend\Mail\Message` => `/path/to/project/lib/vendor/Zend/Mail/Message.php`

## 命名空间以及类名称中的下划线

- `\namespace\package\Class_Name` => `/path/to/project/lib/vendor/namespace/package/Class/Name.php`
- `\namespace\package_name\Class_Name` => `/path/to/project/lib/vendor/namespace/package_name/Class/Name.php`

以上是使用通用自动加载必须遵循的最低规范标准， 可通过以下的示例函数 SplClassLoader 载入 PHP 5.3 的类文件，来验证你所写的命名空间以及类是否符合以上规范。

## 实例

以下示例函数为本规范的一个简单实现。

```php
<?php

function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        //  这里注意一下截取；
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}
//
spl_autoload_register('autoload');
```

## SplClassLoader 实例

以下的 gist 是 一个 SplClassLoader 类文件的实例，如果你遵循了以上规范，可以把它用来载入你的类文件。 这也是目前 PHP 5.3 建议的类文件载入方式。

- [gist.github.com/221634](http://gist.github.com/221634)



## Psr-4 自动加载规范；

为了避免歧义，文档大量使用了「能愿动词」，对应的解释如下：

- `必须 (MUST)`：绝对，严格遵循，请照做，无条件遵守；
- `一定不可 (MUST NOT)`：禁令，严令禁止；
- `应该 (SHOULD)` ：强烈建议这样做，但是不强求；
- `不该 (SHOULD NOT)`：强烈不建议这样做，但是不强求；
- `可以 (MAY)` 和 `可选 (OPTIONAL)` ：选择性高一点，在这个文档内，此词语使用较少；

> 参见：[RFC 2119](http://www.ietf.org/rfc/rfc2119.txt)

## 1. 总览

PSR-4 描述了从文件路径中 [自动加载](http://php.net/autoload) 类的规范。 它拥有非常好的兼容性，并且可以在任何自动加载规范中使用，包括 [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)。 PSR-4 规范也描述了放置 autoload 文件（就是我们经常引入的 `vendor/autoload.php`）的位置。

## 2. 规范

1. 术语「class」指的是类（classes）、接口（interfaces）、特征（traits）和其他类似的结构。

2. 全限定类名具有以下形式：

   ```php
    \<NamespaceName>(\<SubNamespaceNames>)*\<ClassName>
   ```

   1. 全限定类名**必须**拥有一个顶级命名空间名称，也称为    <font color=red>供应商命名空间（vendor namespace）。</font>
   2. 全限定类名**可以**有一个或者多个子命名空间名称。
   3. 全限定类名**必须**有一个最终的类名（我想意思应该是你不能这样 `\<NamespaceName>(\<SubNamespaceNames>)*\` 来表示一个完整的类）。
   4. 下划线在全限定类名中没有任何特殊含义（在 [PSR-0](https://learnku.com/docs/psr/psr-0-automatic-loading-specification) 中下划是有含义的）。
   5. 全限定类名**可以**是任意大小写字母的组合。
   6. 所有类名的引用**必须**区分大小写。

3. 全限定类名的加载过程

   1. 在全限定的类名（一个「命名空间前缀」）中，一个或多个前导命名空间和子命名空间组成的连续命名空间，不包括前导命名空间的分隔符，至少对应一个「根目录」。
   2. 「命名空间前缀」后面的相邻子命名空间与根目录下的目录名称相对应（且**必须**区分大小写），其中命名空间的分隔符表示目录分隔符。
   3. 最终的类名与以`.php` 结尾的文件名保持一致，这个文件的名字**必须**和最终的类名相匹配（意思就是如果类名是 `FooController`，那么这个类所在的文件名必须是 `FooController.php`）。

4. 自动加载文件**禁止**抛出异常，**禁止**出现任何级别的错误，也**不建议**有返回值。

## 3.<font color=red> 范例  这个案例下面标头的很重要； </font>

**下表显示了与给定的全限定类名、命名空间前缀和根目录相对应的文件的路径。**

**prefix == vendor name  ；**他在自动加载里面就是前缀呀，然后去除前缀的命名空间就是，就是目录；

**base directory  （基目录）== 来实现映射到不同的web.php  和api.php  laravel 就是这样做的；**

| Fully Qualified Class Name   | Namespace Prefix | Base Directory         | Resulting File Path                       |
| ---------------------------- | ---------------- | ---------------------- | ----------------------------------------- |
| \Acme\Log\Writer\File_Writer | Acme\Log\Writer  | ./acme-log-writer/lib/ | ./acme-log-writer/lib/File_Writer.php     |
| \Aura\Web\Response\Status    | Aura\Web         | /path/to/aura-web/src/ | /path/to/aura-web/src/Response/Status.php |
| \Symfony\Core\Request        | Symfony\Core     | ./vendor/Symfony/Core/ | ./vendor/Symfony/Core/Request.php         |
| \Zend\Acl                    | Zend             | /usr/includes/Zend/    | /usr/includes/Zend/Acl.php                |

想要了解一个符合规范的自动加载器的实现可以查看[示例文件](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md)。示例中的自动加载器**禁止**被视为规范的一部分，它随时都**可能**发生改变。



##常量 仅仅是这个页面的常量，但是可以通过 \$GLOABLS  来访问；超全部变量；来实现跨页面访问；// 

`````php
CONST PI = 3.14;
//一个页面运行结束之后 全局变量会被销毁，所以不要考虑到跨页面的问题；页面就代表一个进程的结束！！
// 注意框架都是引入到index.php 一个目录来运行，
//php不能跨页面运行；
//一个页面结束就是一个进程的结束！！
//因为session是保存到磁盘里的，所以可以跨页面访问；；； 别被误导了！！
`````



//  直接引入  require  和 自动加载引入 都是一个东西 都是用的是require； 引用外部文件；

当你用 require直接引入一个文件的时候 那么他的namespace 就不重要了，随便写就可以了；

如果 你要用自动加载来require引入外部文件，注意命名空间+类名 = 路径+类名.php 的对应关系；

`````php
class Autoload
{
    /**
     * 自动加载
     * @param $className
     */
    public static function main($className)
    {
        
        // 其实这里的Meitu就是前缀，或者说是顶级域名；
        $file = trim($className, '\\');
        $file = explode('\\', $file);
        // 判断顶级命名空间ll
        $path = __DIR__;
        $topNameSpace = array_shift($file);
        if ($topNameSpace != 'MeiTu') {
            $path = $path . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . $topNameSpace;
        }
        // 其实这里可以加一个base directory 基础目录；那么就可以到任意一个目录去了 来区分 不同的api 和 admin；pc端和手机端；
        //DIRECTORY_SEPARATOR;   不同的操作系统的问题；SEPARATOR
        $file = $path . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $file) . '.php';
        if (is_file($file)) {
            require_once($file);
        }
    }
}

`````





## \$GLOBALS  也是没有跨页面的能力的；