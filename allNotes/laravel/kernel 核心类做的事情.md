# kernel 核心类做的事情；





##HTTP / Console 内核

接下来， 根据进入应用程序的请求类型来将传入的请求发送到 HTTP 内核或控制台内核。而这两个内核是用来作为所有请求都要通过的中心位置。 现在，我们先看看位于 app/Http/Kernel.php 中的 HTTP 内核。



HTTP 内核继承了 Illuminate\Foundation\Http\Kernel 类，该类定义了一个 bootstrappers 数组。 这个数组中的类在请求被执行前运行，这些 bootstrappers 配置了错误处理，日志，检测应用环境，以及其它在请求被处理前需要执行的任务。

````php
//环境变量的配置都保存在，config/app.php 文件内，可以自己去设置；
// 有很多都是使用的env函数，也就是.env配置的优先级会比较高；
env('APP_NAME', 'Laravel'); // 就是.env里面有配置，使用env的，没有就用laravel；
 'env' => env('APP_ENV', 'production');//检测环境的问题；
````



![image-20231226211915207](./kernel%20%E6%A0%B8%E5%BF%83%E7%B1%BB%E5%81%9A%E7%9A%84%E4%BA%8B%E6%83%85.assets/image-20231226211915207.png)

HTTP 内核还定义了所有请求被应用程序处理之前必须经过的 HTTP 中间件。这些中间件处理 HTTP 会话 读写 HTTP session、判断应用是否处于维护模式、验证 CSRF 令牌 等等。

`````php
//todo 
//怎么查看 这个请求经历过的中间件，待更新；
`````



下面两张图片； 就是他需要加载的中间件；

````php
//app\Http\Kernel.php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        // 启动web的时候使用的中间件；
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}


//public/index.php

$app = require_once __DIR__.'/../bootstrap/app.php';
// 获取容器IOC（app）里面的kernel对象；
$kernel = $app->make(Kernel::class);//这边必须要make make 才是真正的运行对象；bind 有可能仅仅是做一个容器的绑定，有可能是函数的延迟绑定；


//bootstrap/app.php

// 这里是容器的绑定；
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

````



**HTTP 内核的 handle 方法签名相当简单：获取一个 Request，返回一个 Response。可以把该内核想象作一个代表整个应用的大黑盒子，输入 HTTP 请求，返回 HTTP 响应。**

````php
// 获取的是响应对象；send 就已经输出响应对象了；
$response = tap($kernel->handle(
    //先获取到http的请求对象Request；
    $request = Request::capture()
))->send();// 已经输出对象了；
//kernel->handle();会输入一个request 然后给一个reponse 响应；
````



