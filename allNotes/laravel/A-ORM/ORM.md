# Eloquent ORM--- 一定要给一个大纲 ，这样还是比较容易去学习的；

>**ORM object relational mapping 对象关系映射；一个对象映射数据库的一个表；**
>
>**一行数据据可以看成是一个对象，整个表就可以看成是这个对象的列表**
>
><font color=red>**把数据库的数据想象成编程语言中的对象，这才是ORM的内容；**</font>
>
>**就是model去操作数据库；**
>
>

---

## moel操作

`````php
php artisan make:model TModel
//
`````





---



## 最基础的操作 剩下的操作 参考查询构造器

````php
在Laravel中，ORM（对象关系映射）是一种常见的数据库操作方式，它允许你使用面向对象的方式来操作数据库表。以下是一些在Laravel中比较常用的ORM操作：

//查询
//查询构造器： 使用模型类的静态方法，你可以执行各种数据库查询操作，如all、find、where等，以便检索、过滤和排序数据。例如：
//这些方法返回单个模型实例，而不是返回模型集合： 
//Eloquent 的 all 方法会返回模型中所有的结果。由于每个 Eloquent 模型都充当一个 查询构造器，所以你也可以添加查询条件，然后使用 get 方法获取查询结果： all get 返回的都是集合，可以直接通过foreach();来使用数据；
$users = User::where('age', '>', 30)->orderBy('name')->get();  
User::all(); //查询所有的数据？

first();//查询一条数据；返回的是一个模型对象
find();//返回的是模型实例； 

// 把数据转换成数组的形式 --- 这个还是很重要的；
你还可以使用getAttributes方法来获取模型的所有属性，或者使用toArray方法将模型转换为数组：
$user = User::first();
$attributes = $user->getAttributes(); // 获取所有属性
$userArray = $user->toArray(); // 将模型转换为数组
通过这些方法，你可以方便地从Laravel模型对象中获取数据，并根据需要将其转换为数组或获取特定的属性。
#####-------------------------------------------------------------------------------------------

//模型的创建和保存： 你可以通过创建模型类来表示数据库中的表，然后使用该模型类的实例来创建新的记录并将其保存到数据库中。例如：

$user = new User;
$user->name = 'John Doe';
$user->email = 'john@example.com';
$user->save();

//更新记录： 你可以使用模型实例的update方法或静态方法where来更新数据库中的记录。例如：
$user = User::find(1);  // 返回一个模型对象； 然后你对模型对象的属性修改，然后去执行save操作；更新操作；
$user->email = 'newemail@example.com'; // 这个是 一条记录就当成一个对象；
$user->save();
// 或者
//  User::where('id', 1)->update(['email' => 'newemail@example.com']);
// 删除记录： 使用模型实例的delete方法或静态方法where来删除数据库中的记录。例如：

$user = User::find(1);
$user->delete();
// 或者
User::where('age', '<', 18)->delete();
这些是在Laravel中比较常用的ORM操作，它们使得与数据库交互变得简单而直观。
    

````









---

