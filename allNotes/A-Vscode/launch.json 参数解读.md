# launch.json 参数解读





version
"version":"0.2.0"

表示版本号，一般不用修改。（ps:据说这个参数没有具体作用。和VScode的版本等等都无关。）

configurations
"configurations":[

]

其中包含每一项调试任务的具体配置信息。（我理解，就是给所有配置信息取个名字。）

name
"name":"test0",

调试任务的名称，在运行和调试下拉框可以展示出来。也就是下图位置。

 type
"type": "cppdbg"

指示编译器类型，如果用的MinGW64，那填的就是cppdgb

request
"request": "launch"
 请求配置类型。

有两种类型，分别是 launch 和 attach，前者的意思就是 VSCode 会打开这个程序然后进入调试，后者的意思是你已经打开了程序，然后接通 Node.js 的内部调试协议进行调试。

program

````c 
 "program": "${workspaceFolder}/build/${fileBasename}",
在 VSCode 调试过程中，通常需要配置一个 .vscode/launch.json 文件。这个配置文件中包括了很多参数，其中一些参数需要填写变量，这些变量通常用于在不同情况下动态生成参数值。这些变量被称为“替换变量”，是一种非常方便的技术。

替换变量的语法是 ${variableName}，其中 variableName 根据场景而不同，具体解释如下：

${workspaceFolder}：表示当前打开文件所在的工作区目录的绝对路径；
${file}：表示当前打开文件的绝对路径；
${fileBasename}：表示当前打开文件的文件名，不包括扩展名；
${fileDirname}：表示当前打开文件所在的目录的路径。
${relativefile}:工作目录到打开文件的目录；绝对目录；会包含整个文件名；
以上是最常见的替换变量，其他还有一些可用的变量，需要根据具体使用情况使用。

// *** //注意：拿到别人的代码在自己本地调试的时候，出了问题先来查一查路径设置对了没。
````





args
args": [],

**传递给程序的命令行参数。比如可以是debug的输入文档，建议使用绝对路径。**


 stopAtEntry 
"stopAtEntry": false,

可选参数。如果为true，则调试程序应在目标的入口点处停止。如果床底了processId，则不起任何作用

cwd
 "cwd": "${workspaceFolder}"，

cd到工程的顶层目录。一般是指，所要调试的程序所在目录。

environment
 "environment": [],

要添加到程序中的环境变量{"name":"config","value":"Debug"}。

无需求可不设置。

 externalConsole
"externalConsole": false,

true:启动控制台;false:在vscode的集成的控制台显示

MIMode
"MIMode": "gdb",

调试方式，指定调试器是gdb，又或者lldb等等。

setupCommands
        "setupCommands": [
        {
          "description": "为 gdb 启用整齐打印", //
          "text": "-enable-pretty-printing", //
          "ignoreFailures": true //
        }
      ],

这个参数一般不需要修改。

miDebuggerPath
"miDebuggerPath":"/usr/bin/gdb"，

设置调试器路径






## 2. 例子

为了更好地理解上述替换变量的含义，这里提供两个例子。

### 2.1. 使用`${workspaceFolder}`

在项目中，可能需要调试运行一些脚本，脚本的目录可能会在项目的不同位置（例如在项目的根目录，或者在某个子目录下）。这时候我们可以在 launch.json 文件中配置如下的代码：

```json
{
  "name": "Debug My Script",
  "type": "python",
  "request": "launch",
  "program": "${workspaceFolder}/path/to/my/script.py"
}
```

`${workspaceFolder}` 在这里就变成了一个变量，表示当前打开文件所在工作区的绝对路径，`${workspaceFolder}/path/to/my/script.py` 就表示拼接路径，生成了要执行的脚本文件的路径。

### 2.2. 使用 `${file}`

在编写项目代码时，有时候需要 Debug 单个文件。这时候我们也可以使用替换变量。

```json
{
  "name": "My Test",
  "type": "python",
  "request": "launch",
  "program": "${workspaceFolder}/path/to/my/test.py",
  "args": ["${file}"]
}
```

这里，`${file}` 表示当前打开文件的绝对路径，加入 args 选项中，用于传递测试用例的位置。





