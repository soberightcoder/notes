# ORM

>Object Relational Mapping    对象关系映射；
>
>简单来说，对象来映射数据库中的数据；
>
>一个类对应着一整张表；

​		

````php
php artisan make:model ModelTest
    
    <?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

  /**
     * 与模型关联的数据表
     *  定义了表名；
     * @var string
     */
    protected $table = 'my_flights';
    
}

/**
 *  相同的属性和方法  子类会重写父类的；
 */

class A
{
    protected $name = 10;

    public function ceshi() {
        echo "A---ceshi";
    }
}

class B extends A
{
    protected $name = 1000;

    public function ceshi() {
        echo $this->name;  // 1000
        echo "\n";
        echo "B---ceshi";
    }
}
$b = new B;
$b->ceshi();  


// 查询规则；
$flights = App\Flight::where('active', 1)                            //select 查询
               ->orderBy('name', 'desc')
               ->take(10)
               ->get();

// 通过主键取回一个模型...
$flight = App\Flight::find(1);

// 取回符合查询限制的第一个模型 ...
$flight = App\Flight::where('active', 1)->first();     // 一条；                

$flights = App\Flight::find([1, 2, 3]);// find 就是主键查询；

$count = App\Flight::where('active', 1)->count();

$max = App\Flight::where('active', 1)->max('price');


App\Flight::where('active', 1)  //  多个where 
          ->where('destination', 'San Diego')
          ->update(['delayed' => 1]);                                  // 更新；

$deletedRows = App\Flight::where('active', 0)->delete();            // delete

// save 的一些用法 既可以当更新也可以当添加

//当编辑数据使用save()，如果select 没有包含主键的话，发现 save()没有执行编辑的操作
//update
$UserModel= new User();
$where['id'] = 1;//array('id'=>1);  或者
$User= $UserModel
            ->select(['id','image'])  // 数组的概念；select； 应该都可以把
            ->where($where)
            ->first();
$User['image'] = $post['image'];
$User->save();

//insert 
 public function getIndex()
    {
        $temp = App\Temp::where('status' , 0)->orderBy('id' , 'desc')->first();
        $temp->status = 1;
        $temp->save();
     
        $post = new App\Post;  //
    	// 下面的全部是字段名字？？？
        $post->title = $temp->title;
        $post->link = $temp->link;
        $post->desc = $temp->desc;
        $post->cat_id = $temp->cat_id;
        $post->url_id = $temp->url_id;
        $post->body = $this->render($post);
     
        $post->save();
        echo "+";
    }


//要在数据库中创建一条新记录，只需创建一个新模型实例，并在模型上设置属性和调用 save 方法即可：

<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlightController extends Controller
{
    /**
     * 创建一个新的航班实例。
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // 验证请求...

        $flight = new Flight;
		// name 就是字段的意思；
        $flight->name = $request->name;//$request->input('name');

        $flight->save();
    }
}

//在这个例子中，我们把来自 HTTP 请求中的 name 参数简单地指定给 App\Flight 模型实例的 name 属性。当我们调用 save 方法，就会添加一条记录到数据库中。当 save 方法被调用时，created_at 以及 updated_at 时间戳将会被自动设置，因此我们不需要去手动设置它们。


////基本更新
//save 方法也可以用于更新数据库中已经存在的模型。要更新模型，则须先取回模型，再设置任何你希望更新的属性，接着调用 save 方法。同样的，updated_at 时间戳将会被自动更新，所以我们不需要手动设置它的值：

$flight = App\Flight::find(1);

$flight->name = 'New Flight Name';

$flight->save();


````



