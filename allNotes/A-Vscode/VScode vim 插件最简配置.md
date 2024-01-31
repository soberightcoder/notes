# VScode vim 插件最简配置

* 首先打开快捷键吧，实在是忘了怎么找workspace setting的配置放在那里了

![image-20200720212157007](C:\Users\25438\AppData\Roaming\Typora\typora-user-images\image-20200720212157007.png)

* 搜索 setting.json,并且打开setting.json 我自己乱配置的害怕找不到了 随便配置的快捷键

  ![image-20200720212348757](VScode vim 插件最简配置.assets/image-20200720212348757.png)

* 编写 vim的setting.json

  ~~~v
  {
      "vim.normalModeKeyBindingsNonRecursive": [
      {
        "before": ["i"],
        "after": ["k"]
      },
      {
        "before": ["j"],
        "after": ["h"]
      },
      {
        "before": ["k"],
        "after": ["j"]
      },
      {
        "before": ["h"],
        "after": ["i"]
      },
      {
        "before": ["H"],
        "after": ["I"]
      },
      {
        "before": ["J"],
        "after": ["0"]
      },
      {
        "before": ["L"],
        "after": ["$"]
      },
      {
        "before": ["m"],
        "after": [5"j"]
      },
      {
          "before": ["M"],
          "after": [5"k"]
      },
      {
        "before": ["Q"],
        "commands": [":wq"]
      },v
    ],
  
  }
  
  
    // 标签栏和面包屑的显示和隐藏
    "workbench.editor.showTabs": true,
    "breadcrumbs.enabled": false,
  
  
  // ctrl + j = ===  toggle panel  penel   toggle panel //开关面板  
  // close panel 只有关的意思
  // toggle 有开关的意思；
  ~~~
  
  * 大写 就用shift+字母按 还是很快捷的；
  
  * m M： 就是为了浏览用的，五倍速下滑，或者上滑;
  
  * Q：保存并且退出
  * J L :分别是到行首和行尾
  * ESC：退出编辑模式进入普通模式
  * normalModeKeyBindingsNonRecursive：就是普通模式下的映射，不进行递归(NOnRecursive)
  
  



## vim

>silent : 指示是否禁止显示日志消息的布尔值。



```c
{
  "vim.easymotion": true,
   //??// incsearch
  "vim.incsearch": true,
  "vim.useSystemClipboard": true,
  "vim.useCtrlKeys": true,
  "vim.hlsearch": true,
  "vim.insertModeKeyBindings": [
    {
      "before": ["j", "j"],
      "after": ["<Esc>"]
    }
  ],
  "vim.normalModeKeyBindingsNonRecursive": [
    {
      "before": ["<leader>", "d"],
      "after": ["d", "d"]
    },
    {
      "before": ["<C-n>"],
      "commands": [":nohl"]
    },
    {
      "before": ["K"],
      "commands": ["lineBreakInsert"],
      "silent": true
    }
  ],
  "vim.leader": "<space>",
  "vim.handleKeys": {
    "<C-a>": false,
    "<C-f>": false
  }
}


    "vim.visualModeKeyBindings": [
        {
            "before": [
                "<leader>", "v", "i", "m"
            ],
            "commands": [
                {
                    "command": "git.clone",
                    "args": [ "https://github.com/VSCodeVim/Vim.git" ]
                }
            ]
        }
    ]
```



### vscode  和vim冲突的解决方案

在使用中经常想使用ctrl-c，虽然在vscode中有配置选项可以让vim与ctrl键解绑，但是这样就使用不了vim的VISUAL BLOCK。所以进行了自定义设置。

设置 - Vim Configuration - Handle Keys

```json
"vim.handleKeys": {
    "<C-a>": false,
    "<C-c>": false,
    "<C-x>": false,
    "<C-f>": false,
    "<C-h>": false,
    "<C-s>": false,
    "<C-z>": false,
    "<C-y>": false,
    "<C-j>": false,
},

//最好加上 ctrl + j 和 vim的冲突问题；
```







## settings 

>settings.json 个人配置；

ctrl+N  想要打开的文件  settings.json 就可以打开了；

```v

settings.json，

{
  // 是否要确认是否信任新打开的文件
  "security.workspace.trust.untrustedFiles": "open",
  // redhat 遥测设置
  "redhat.telemetry.enabled": true,
  // xml 设置，这是自动生成的
  "xml.server.binary.trustedHashes": [
    "75545f1685acea66aed67cb886c59e49cbbf0f51c25c89baad76cf0a3ee962a7"
  ],
  // 编辑器设置在保存时自动格式化
  "editor.formatOnSave": true,
  // 图标主题
  "workbench.iconTheme": "material-icon-theme",
  // 不要弹出确认拖放
  "explorer.confirmDragAndDrop": false,
  // 不要弹出确认删除
  "explorer.confirmDelete": false,
  // 设置编辑器的字体
  "editor.fontFamily": "'CaskaydiaCove NF Mono', 'Cascadia Mono', 'Source Han Sans CN', Consolas, 'Courier New', monospace",
  // 开启编辑器的连字符设置
  "editor.fontLigatures": true,
  // 开始的编辑器
  "workbench.startupEditor": "none",
  // 智能提交
  "git.enableSmartCommit": true,
  // git 不要弹窗确认是否同意 sync
  "git.confirmSync": false,
  // python 对 formatter 的设置
  "python.formatting.autopep8Args": [
    "--ignore",
    "E402"
  ],
  // python 对某些语法分析的设置
  "python.analysis.diagnosticSeverityOverrides": {
    "reportUnsupportedDunderAll": "none"
  },
  // 设置 html 的 formatter
  "[html]": {
    "editor.defaultFormatter": "vscode.html-language-features"
  },
  // unicode 高亮设置
  "editor.unicodeHighlight.allowedLocales": {
    "zh-hans": true,
    "zh-hant": true
  },
  // 光标的动画效果
  "editor.cursorBlinking": "smooth",
  "editor.cursorSmoothCaretAnimation": "on",
  // 指定默认的 termimal
  "terminal.integrated.defaultProfile.windows": "PowerShell",
  // 设置 terminal 的字体
  "terminal.integrated.fontFamily": "CaskaydiaCove NF Mono",
  // 设置 markdown 预览的字体
  "markdown.preview.fontFamily": "CaskaydiaCove NF Mono, -apple-system, BlinkMacSystemFont, 'Segoe WPC', 'Segoe UI', system-ui, 'Ubuntu', 'Droid Sans', sans-serif",
  // 关闭编辑器的自动检测缩进设置
  "editor.detectIndentation": false,
  // 设置不同语言的 tab 大小
  "[javascript]": {
    "editor.tabSize": 2,
  },
  "[css]": {
    "editor.tabSize": 2,
  },
  "[jsonc]": {
    "editor.tabSize": 2,
  },
  "[json]": {
    "editor.tabSize": 2,
  },
  "[lua]": {
    "editor.tabSize": 2,
  },
  "[javascriptreact]": {
    "editor.tabSize": 2,
  },
  "[scss]": {
    "editor.tabSize": 2,
  },
  "[java]": {
    "editor.tabSize": 2,
  },
  // 行包裹设置
  "editor.wordWrap": "on",
  // python 设置在文件所在目录进行执行
  "python.terminal.executeInFileDir": true,
  // 终端的限制
  "terminal.integrated.bellDuration": 100000,
  // 不要高亮一些看不见的 unicode 字符
  "editor.unicodeHighlight.invisibleCharacters": false,
  "workbench.colorCustomizations": {
    // 光标的颜色设置
    "editorCursor.foreground": "#16C60C",
    // 当前行的背景颜色设置
    "editor.lineHighlightBackground": "#292e42",
    // 状态栏颜色设置
    "statusBar.background": "#1e1e1e",
    "statusBar.foreground": "#9b9b8f",
    "statusBar.border": "#333a48",
  },
  // 隐藏 minimap
  "editor.minimap.autohide": true,
  "editor.minimap.enabled": false,
  // 在某些情况下隐藏光标
  "editor.hideCursorInOverviewRuler": true,
  // 以下三行是为了隐藏滚动栏
  "editor.scrollbar.horizontal": "hidden",
  "editor.scrollbar.vertical": "hidden",
  "editor.scrollbar.verticalScrollbarSize": 0,
  // 布局控制
  "workbench.layoutControl.enabled": false,
  // 渲染行高的风格
  "editor.renderLineHighlight": "line",
  // 取消 occurrence 和 selection 的高亮
  "editor.occurrencesHighlight": false,
  "editor.selectionHighlight": false,
  // 以下是 vim 的设置
  // vim 使用系统剪贴板
  "vim.useSystemClipboard": true,
  // 开启 vim 的 easymotion
  "vim.easymotion": true,
  // 当输入一个搜索字符时，显示下一个匹配的结果
  "vim.incsearch": true,
  // vim 来接管 ctrl 键 // 使用 vim 来接管 ctrl ；
  "vim.useCtrlKeys": true,
  // 高亮搜索结果
  "vim.hlsearch": true,
  // 设置 vim 的 leader 键为空格键
  "vim.leader": "<space>",
  // 设置 vim 不接管某些快捷键
  "vim.handleKeys": {
    "<C-a>": false,
    "<C-f>": false
  },
  // vim normal 模式下的键位设置
  "vim.normalModeKeyBindings": [
    // 侧边栏的显示和隐藏的快捷键，我映射成了 leader + e
    {
      "before": [
        "leader",
        "e"
      ],
      "commands": [
        {
          "command": "workbench.action.toggleSidebarVisibility"
        }
      ]
    },
    // cmake 快速编译和运行文件，我映射成了 leader + l，这个和直接点击底部状态栏的运行按钮效果是一样的
    {
      "before": [
        "leader",
        "l"
      ],
        //这里是vscode 的命令
      "commands": [
        {
          "command": "workbench.action.terminal.sendSequence",
          "args": {
            "text": "clear \u000D"
          }
        },
        {
          "command": "cmake.launchTarget"
        }
      ]
    },
    // 在左侧的文件管理器中打开当前文件
    {
      "before": [
        "leader",
        "f"
      ],
      "commands": [
        {
          "command": "revealInExplorer"
        }
      ]
    },
    // 取消高亮，比如我们在当前文件中搜索之后可以使用这个快捷键
    {
      "before": [
        "leader",
        "h"
      ],
       // vim的命令模式；
      "commands": [
        ":noh"
      ]
    },
    // 关闭当前的 tab
    {
      "before": [
        "leader",
        "c"
      ],
      "commands": [
        ":q"
      ]
    },
    // 保存当前的文件
    {
      "before": [
        "leader",
        "w"
      ],
      "commands": [
        ":w"
      ]
    },
    // 显示和隐藏左侧的活动栏
    {
      "before": [
        "leader",
        "a"
      ],
      "commands": [
        {
          "command": "workbench.action.toggleActivityBarVisibility"
        }
      ]
    },
    // 显示和隐藏底部的状态栏
    {
      "before": [
        "leader",
        "b"
      ],
      "commands": [
        {
          "command": "workbench.action.toggleStatusbarVisibility"
        }
      ]
    },
    // 快速在底部的 terminal 中运行 python 文件
    {
      "before": [
        "leader",
        "p",
        "y"
      ],
      "commands": [
        "workbench.action.files.saveAll",
        {
          "command": "workbench.action.terminal.sendSequence",
          "args": {
            "text": "clear \u000D"
          }
        },
        "workbench.action.terminal.focus",
        {
          "command": "workbench.action.terminal.sendSequence",
          "args": {
            "text": "python '${file}'\u000D"
          }
        },
        "workbench.action.focusActiveEditorGroup"
      ]
    },
    // 快速在底部的 terminal 中运行 autohotkey
    {
      "before": [
        "leader",
        "k",
        "k"
      ],
      "commands": [
        "workbench.action.files.saveAll",
        {
          "command": "workbench.action.terminal.sendSequence",
          "args": {
            "text": "clear \u000D"
          }
        },
        "workbench.action.terminal.focus",
        {
          "command": "workbench.action.terminal.sendSequence",
          "args": {
            "text": "${file} \u000D"
          }
        },
        "workbench.action.focusActiveEditorGroup"
      ]
    },
    // 这个和 Ctrl + P 效果是等同的，即，快速搜索打开文件
    {
      "before": [
        "leader",
        "g",
        "g"
      ],
      "commands": [
        {
          "command": "workbench.action.quickOpen"
        }
      ]
    },
    // 在当前打开的项目中搜索文本
    {
      "before": [
        "leader",
        "g",
        "f"
      ],
      "commands": [
        {
          "command": "workbench.view.search"
        }
      ]
    },
    // 快速运行 java 代码
    {
      "before": [
        "leader",
        "j",
        "a"
      ],
      "commands": [
        {
          "command": "java.debug.runJavaFile"
        }
      ]
    },
    // 快速执行 VSCode 的 debug 命令
    {
      "before": [
        "leader",
        "r",
      ],
      "commands": [
        {
          "command": "workbench.action.debug.start"
        }
      ]
    },
  ],
  // vim 的 visual 模式下的键位绑定
  "vim.visualModeKeyBindings": [
    // 向右缩进，可以重复使用
    {
      "before": [
        ">"
      ],
      "commands": [
        "editor.action.indentLines"
      ]
    },
    // 向左缩进，可以重复使用
    {
      "before": [
        "<"
      ],
      "commands": [
        "editor.action.outdentLines"
      ]
    },
  ],
  // vim 在 normal 模式下非递归的键位绑定
  "vim.normalModeKeyBindingsNonRecursive": [
    // 将 u 和 VSCode 自身的撤销动作绑定
    {
      "before": [
        "u"
      ],
      "commands": [
        "undo"
      ]
    },
    // 将 Ctrl + r 和 VSCode 自身的重做动作绑定
    {
      "before": [
        "C-r"
      ],
      "commands": [
        "redo"
      ]
    }
  ],
  // vim 的 easymotion 插件的高亮字符的前景色
  "vim.easymotionMarkerForegroundColorOneChar": "#DF5452",
  // 关闭 snippet 的阻止快速建议的行为
  "editor.suggest.snippetsPreventQuickSuggestions": false,
  // 禁止一些括号设置
  "editor.guides.bracketPairs": false,
  "editor.guides.bracketPairsHorizontal": false,
  // 开启 vim-surround
  "vim.surround": true,
  // 扩展忽视建议
  "extensions.ignoreRecommendations": true,
  // cmake 配置
  "cmake.configureOnOpen": true,
  // 编辑器内联的建议
  "editor.inlineSuggest.enabled": true,
  // 关闭 terminal 中的多行粘贴的警告
  "terminal.integrated.enableMultiLinePasteWarning": false,
  // 窗口的缩放程度
  "window.zoomLevel": 1,
  // 关闭不明 unicode 字符的高亮
  "editor.unicodeHighlight.ambiguousCharacters": false,
  // 修改窗口的风格为 windows 原生风格
  "window.titleBarStyle": "native",
  // 标签栏和面包屑的显示和隐藏
  "workbench.editor.showTabs": true,
  "breadcrumbs.enabled": false,
  // 修改窗口标题的显示文字
  "window.title": "💖${folderName}-FanyFull",
  // 我们在文件管理器中使用 vscode 打开文件时，确保其会在新的 vscode 窗口中打开
  "window.openFilesInNewWindow": "on",
  // 将 manifest 文件关联到 xml 文件，这样，manifest 文件就可以使用 xml 的语法高亮了
  "files.associations": {
    "*.manifest": "xml"
  },
  // 大文件的最大可使用内存
  "files.maxMemoryForLargeFilesMB": 8192,
  // 关闭 tab 标签的 X 按钮
  "workbench.editor.tabCloseButton": "off",
  // 隐藏 tab 标签的 X 按钮，当然，如果 CloseButton 被隐藏了，那么这个设置其实是无所谓
  "workbench.editor.tabSizing": "shrink",
  // accessibility
  "editor.accessibilitySupport": "off",
  "git.openRepositoryInParentFolders": "never",
  // 设置 python 在输入的时候进行格式化，也就是说，自动缩进
  "[python]": {
    "editor.formatOnType": true
  },
  // 隐藏菜单栏
  "window.menuBarVisibility": "hidden",
  "workbench.statusBar.visible": false,
  "workbench.activityBar.visible": false,
}

```



## keybindings.json

>keyshort 的快捷键的文本json格式形式；



## 位置



先进入keyboard shortcut  

![image-20230407122638532](VScode vim 插件最简配置.assets/image-20230407122638532.png)







## 配置写法；

>command 不会写，可以去搜keyboard shortcut 去看一下；去搜寻一下；	

`````v
//keybindings.json，
// Place your key bindings in this file to override the defaultsauto[]
[
  // new file in explorer
  {
    "key": "ctrl+n",
    "command": "explorer.newFile",
    "when": "explorerViewletFocus"
  },
  // 以下是 vim 绑定的键位
  // 当光标在编辑器中聚焦时，显示和隐藏底部的 panel
  {
    "key": "ctrl+j",
    "command": "workbench.action.togglePanel",
    "when": "editorTextFocus"
  },
  // 编写代码时的智能提示框的上下选择
  {
    "key": "ctrl+j",
    "command": "selectNextSuggestion",
    "when": "vim.active && suggestWidgetMultipleSuggestions && suggestWidgetVisible && textInputFocus"
  },
  {
    "key": "ctrl+k",
    "command": "selectPrevSuggestion",
    "when": "vim.active && suggestWidgetMultipleSuggestions && suggestWidgetVisible && textInputFocus"
  },
  // 在 quickOpen 的对话框中上下跳转
  {
    "key": "ctrl+j",
    "command": "workbench.action.quickOpenSelectNext",
    "when": "vim.active && inQuickOpen"
  },
  {
    "key": "ctrl+k",
    "command": "workbench.action.quickOpenSelectPrevious",
    "when": "vim.active && inQuickOpen"
  },
  // 当光标聚焦在编辑器中且 vim 处于 normal 模式时，进行 tab 栏目的左右跳转
  {
    "key": "shift+h",
    "command": "workbench.action.previousEditor",
    "when": "editorTextFocus && vim.mode == 'Normal'"
  },
  {
    "key": "shift+l",
    "command": "workbench.action.nextEditor",
    "when": "editorTextFocus && vim.mode == 'Normal'"
  },
  // 在不同的组件之间进行跳转
  {
    "key": "ctrl+h",
    "command": "workbench.action.navigateLeft"
  },
  {
    "key": "ctrl+l",
    "command": "workbench.action.navigateRight"
  },
  {
    "key": "ctrl+k",
    "command": "workbench.action.navigateUp",
    "when": "terminal.active && terminalFocus"
  },
  // 跳转到 terminal 中
  {
    "key": "ctrl+\\",
    "command": "workbench.action.terminal.toggleTerminal"
  },
  // vim 模式下的左侧的文件管理器的操作
  // 在文件管理器中搜索
  {
    "key": "/",
    "command": "list.find",
    "when": "listFocus && listSupportsFind && !inputFocus"
  },
  // 新建一个文件
  {
    "key": "a",
    "command": "explorer.newFile",
    "when": "explorerViewletVisible && filesExplorerFocus && !explorerResourceIsRoot && !explorerResourceReadonly && !inputFocus"
  },
  // 新建一个文件夹
  {
    "key": "shift+a",
    "command": "explorer.newFolder",
    "when": "explorerViewletVisible && filesExplorerFocus && !explorerResourceIsRoot && !explorerResourceReadonly && !inputFocus"
  },
  // 给文件重命名
  {
    "key": "r",
    "command": "renameFile",
    "when": "explorerViewletVisible && filesExplorerFocus && !explorerResourceIsRoot && !explorerResourceReadonly && !inputFocus"
  },
  // 删除文件
  {
    "key": "d",
    "command": "deleteFile",
    "when": "explorerViewletVisible && filesExplorerFocus && !explorerResourceIsRoot && !explorerResourceReadonly && !inputFocus"
  },
  // 在不同的 terminal 之间进行跳转
  {
    "key": "ctrl+shift+alt+j",
    "command": "workbench.action.terminal.focusNext",
    "when": "terminalFocus && terminalHasBeenCreated && !terminalEditorFocus || terminalFocus && terminalProcessSupported && !terminalEditorFocus"
  },
  {
    "key": "ctrl+shift+alt+k",
    "command": "workbench.action.terminal.focusPrevious",
    "when": "terminalFocus && terminalHasBeenCreated && !terminalEditorFocus || terminalFocus && terminalProcessSupported && !terminalEditorFocus"
  },
  // codeAction 上下选择
  {
    "key": "j",
    "command": "selectNextCodeAction",
    "when": "codeActionMenuVisible"
  },
  {
    "key": "k",
    "command": "selectPrevCodeAction",
    "when": "codeActionMenuVisible"
  },
  // terminal 中上下滚动
  {
    "key": "alt+j",
    "command": "workbench.action.terminal.scrollDown",
    "when": "terminalFocus"
  },
  {
    "key": "alt+k",
    "command": "workbench.action.terminal.scrollUp",
    "when": "terminalFocus"
  },
  // 关闭 terminal
  {
    "key": "ctrl+w",
    "command": "workbench.action.terminal.kill",
    "when": "terminalFocus"
  },
  // 调整底部的 panel 的大小
  {
    "key": "ctrl+shift+k",
    "command": "workbench.action.terminal.resizePaneUp",
    "when": "terminalFocus"
  },
  {
    "key": "ctrl+shift+j",
    "command": "workbench.action.terminal.resizePaneDown",
    "when": "terminalFocus"
  },
  // 最大化 terminal
  {
    "key": "ctrl+win+`",
    "command": "workbench.action.toggleMaximizedPanel",
    "when": "terminalFocus"
  },
]
 VSCode
版权声明： 本博客所有文章除特别声明外，均采用 CC BY-SA 4.0 协议 ，转载请注明出处！

p8597 和 p8615
tzoj6101 简单做过

Hexo  Fluid
`````



## vscode 调试

c/c++ debug 调试需要扩展；

C/C++ Extension Pack   扩展包； c/c++的扩展包；应该是要做xdebug



### launch.json

>用于调试的配置文件；debug的配置文件；

###那些方面做配置：

* 指定语言环境，
* 指定调试类型； launch attach
* 是否打开浏览器；
* 远程调试；远程服务的ip和端口号是什么？



### 配置参数

>基础的三个参数；

![image-20230407232929220](VScode vim 插件最简配置.assets/image-20230407232929220.png)



## request  :调试类型：launch attack（连接 附上）

> **launch ： vscode启动程序的时候并且分配一个调试器；**
>
>**attack ： 程序本身在运行，然后附加一个调试器；进而进行调试；服务本身不停止；进行调试；**

![image-20230407234226294](VScode vim 插件最简配置.assets/image-20230407234226294.png)



### 启动程序的方式

>手动启动，launch；

launch启动，vscode 会添加调试器，可以进行打断点；比较适合调试；

* 根据配置 launch.json  都是launch启动；

手动启动，gcc test.c 不可以打断点；



![image-20230408001906277](VScode vim 插件最简配置.assets/image-20230408001906277.png)



## run without debuging  VS start debuging

>区别：
>
>* without debuging 就是不可以打断点，也就是不能进行打断点的debug；类似于手动启动，但是是读取的launch的启动；
>* start debuging ，就是可以调试；
>
>共性：都是使用launch来进行配置启动；

![image-20230408002509063](VScode vim 插件最简配置.assets/image-20230408002509063.png)

![image-20230408002620870](VScode vim 插件最简配置.assets/image-20230408002620870.png)



# 快捷键

## hide side bar



![image-20230408003228755](VScode vim 插件最简配置.assets/image-20230408003228755.png)



## rencently oepn file









## setting.json

>左下角，的配置setting，里面有配置主要分为三部分：
>
>三种配置：
>
>* user settings.json
>* workspace.json
>* folder settings.json 

 ![在这里插入图片描述](VScode vim 插件最简配置.assets/watermark,type_ZmFuZ3poZW5naGVpdGk,shadow_10,text_aHR0cHM6Ly9ibG9nLmNzZG4ubmV0L25hbWVzcGFjZV9QdA==,size_16,color_FFFFFF,t_70.png)



![image-20230408010734913](VScode vim 插件最简配置.assets/image-20230408010734913.png)



## GCC的命令格式；

>gcc 参数，g ，o，c

`````c
// -c   gcc hello.c =====> hello.o // 只执行到编译部分； 预处理 编译 汇编 链接 执行文件；

// -o 可以修改 目标文件的名字；gcc hello.c -o app ====> app
// -g  gdb调试器； gcc -g hello.c -o hello.o  // 并没有报错；
// gcc hello.c ====> a.out 
//  直接执行 gcc hello.c 就行 生成可执行文件 默认是a.exe  windows系统中，是这样的；
// 
5. gcc -g source_file.c
 // dgb  就是程序调试器；
//  debugger，简称「GDB 调试器」，是Linux 平台下最常用的一款程序调试器。
　　 -g，生成供调试用的可执行文件，可以在gdb中运行。由于文件中包含了调试信息因此运行效率很低，且文件也大不少。这里可以用strip命令重新将文件中debug信息删除。这是会发现生成的文件甚至比正常编译的输出更小了，这是因为strip把原先正常编译中的一些额外信息（如函数名之类）也删除了。用法为 strip a.out
    // 输出目标文件；  
    3. gcc -c source_file.c

　　-c，只执行到编译，输出目标文件。
    
    
    1. gcc -E source_file.c

　　-E，只执行到预编译。直接输出预编译结果。

    //输出的是汇编；
2. gcc -S source_file.c

　　 -S，只执行到源代码到汇编代码的转换，输出汇编代码。

//
3. gcc -c source_file.c

　　-c，只执行到编译，输出目标文件。

 // 输出
4. gcc (-E/S/c/) source_file.c -o output_filename

　　-o, 指定输出文件名，可以配合以上三种标签使用。-o 参数可以被省略。这种情况下编译器将使用以下默认名称输出：

　　-E：预编译结果将被输出到标准输出端口（通常是显示器）

　　-S：生成名为source_file.s的汇编代码

　　-c：生成名为source_file.o的目标文件。无标签情况：生成名为a.out的可执行文件。
`````







{  
    "version": "0.2.0",  
    "configurations": [  
        
```c
    {  
        "name": "(gdb) Launch", // 配置名称，将会在启动配置的下拉菜单中显示  
        "type": "cppdbg",       // 配置类型，这里只能为cppdbg  
        "request": "launch",    // 请求配置类型，可以为launch（启动）或attach（附加）  
        "program": "${workspaceFolder}/${fileBasenameNoExtension}.exe",// 将要进行调试的程序的路径  
        "args": [],             // 程序调试时传递给程序的命令行参数，一般设为空即可  
        "stopAtEntry": false,   // 设为true时程序将暂停在程序入口处，一般设置为false  
        "cwd": "${workspaceFolder}", // 调试程序时的工作目录，一般为${workspaceFolder}即代码所在目录  
        "environment": [],  
        "externalConsole": true, // 调试时是否显示控制台窗口，一般设置为true显示控制台  
        "MIMode": "gdb",  
        "miDebuggerPath": "C:\\apps\\MinGW\\bin\\gdb.exe", // miDebugger的路径，注意这里要与MinGw的路径对应  
        "preLaunchTask": "g++", // 调试会话开始前执行的任务，一般为编译程序，c++为g++, c为gcc  
        "setupCommands": [  
        	{   
  		"description": "Enable pretty-printing for gdb",  
                "text": "-enable-pretty-printing",  
                "ignoreFailures": true  
        	}  
        ]  
    }  
]  
```


``````c
{
    "version": "2.0.0",
    "command": "g++",
    "args": ["-g","${file}","-o","${fileBasenameNoExtension}.exe"],    // 编译命令参数
    "problemMatcher": {
        "owner": "cpp",
        "fileLocation": ["relative", "\\"],
        "pattern": {
            "regexp": "^(.*):(\\d+):(\\d+):\\s+(warning|error):\\s+(.*)$",
            "file": 1,
            "line": 2,
            "column": 3,
            "severity": 4,
            "message": 5
        }
    }
}
``````





```c
{
	//vscode的默认终端,此处设置为cmd
    	"terminal.integrated.shell.windows": "C:\\WINDOWS\\System32\\cmd.exe",
    	//拖拽移动文件时不要确认提示
    	"explorer.confirmDragAndDrop": false,
    	//手动升级vscode
    	"update.mode": "manual",
    	//自动保存,此处设置为永远自动保存
    	"files.autoSave": "afterDelay",
    	//task的下拉列表中显示历史常用的个数 
    	"task.quickOpen.history": 0,
}
```
