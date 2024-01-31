#laravel

 >这个可以去仔细看一下； 服务提供者；

####服务提供者 

1. 假设我们要建一个交易类，app/Trade/Sale.php

   ```php
   <?php
   namespace App\Trade;
   class Sale
   {
   public function exchange()
   {
       dd('交易成功啦!');
   }
   }
   ```

2. 在Providers目录下创建一个服务提供者 TradeServiceProvider

   ```php
   php artisan make:provider TradeServiceProvider
   ```

3. 然后在 TradeServiceProvider.php 的register方法中将我们的类进行绑定

   ```php
   /**
    * Register the application services.
    *
    * @return void
    */
   public function register()
   {
       //
       $this->app->bind('trade',function(){
           return new Sale();
       });
   }
   
   
   ```

4. 接下来要去 config/app.php 下的providers数组中增加一行，

   ```php
   // 添加到config/app.php 启动的时候 加载到容器里面；
   App\Providers\TradeServiceProvider::class,
   ```

5. 然后在我们的路由中写一个测试

   ```php
   Route::get('/',function (){
   $trade = app('trade');
   dd($trade->exchange());
   }
   输出结果：交易成功啦!
   ```

6. 至此我们就将我们自己的类添加到IoC 容器中了







####**容器**	





php artisan make:controller  Test\Test

php artisan make:providers CeshiProvider 添加一个服务提供者





添加 容器







### 辅助函数

```php
#其实也是一个对象 ceshiceshi(); 其实返回的就是一个对象；

if(!function_exists('ceshiceshi')){
    function ceshiceshi(){
        return app()->make('ceshiceshi');
    }
}

#参数的形式

if (! function_exists('action')) {
    /**
     * Generate the URL to a controller action.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @return string
     */
    function action($name, $parameters = [], $absolute = true)
    {
        return app('url')->action($name, $parameters, $absolute);
    }
}

注意 laravel 的配置问题
    
 config app 文件 alias 也要设置；
    alias 要添加到门面里面 代表的就是 类的别名；
    
    
    
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    
    
    | 这个类别名数组将在此应用程序时注册
     | 已启动。 但是，请随意注册
     | 别名是“惰性”加载的，因此它们不会影响性能。
    
    provider 服务提供者  需要把服务添加到app容器里面才能用服务里面的对象；
    
    
    | 自动加载的服务提供者
     |------------------------------------------------- -------------------------
     |
     | 此处列出的服务提供商将自动加载到
     | 请求您的应用程序。 随意添加您自己的服务到
     | 此数组为您的应用程序授予扩展功能。
    
     
       | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    
```



## 实现一个中间件

`````php
//去看中间件部分；
`````

