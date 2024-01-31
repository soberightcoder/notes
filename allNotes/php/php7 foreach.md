# php7 foreach

**一、foreach()循环对数组内部指针不再起作用,**在PHP7之前，当数组通过foreach迭代时，数组指针会移动。现在开始，不再如此，见下面代码。。

```php
$array` `= [0, 1, 2];``foreach` `(``$array` `as` `&``$val``) ``{``var_dump
(current(``$array``));``}
```

PHP5运行的结果会打印int(1) int(2) bool(false)

PHP7运行的结果会打印三次int(0)，也就是说数组的内部指针并没有改变。

之前运行的结果会打印int(1), int(2)和bool(false)

**二、按照值进行循环的时候，foreach是对该数组的拷贝操作**

foreach按照值进行循环的时候(by-value)，foreach是对该数组的一个拷贝进行操作。这样在循环过程中对数组做的修改是不会影响循环行为的。

```php
$array` `= [0, 1, 2];``$ref` `=& ``$array``; ``// Necessary to trigger the old behavior``foreach` `(``$array` `as` `$val``) {``var_dump(``$val``);``unset(``$array``[1]);``}
```

上面的代码虽然在循环中把数组的第二个元素unset掉，但PHP7还是会把三个元素打印出来：(0 1 2)
之前老版本的PHP会把1跳过，只打印(0 2).

**三、按照引用进行循环的时候，对数组的修改会影响循环。**

如果在循环的时候是引用的方式，对数组的修改会影响循环行为。不过PHP7版本优化了很多场景下面位置的维护。比如在循环时往数组中追加元素。

```php
$array` `= [0];
``foreach` `(``$array` `as` `&``$val``) {
``
var_dump(``$val``);
``$array``[1] = 1;``
}
```

上面的代码中追加的元素也会参与循环，这样PHP7会打印"int(0) int(1)"，老版本只会打印"int(0)"。

**四、对简单对象plain (non-Traversable) 的循环。**

对简单对象的循环，不管是按照值循环还是按引用循环，和按照引用对数组循环的行为是一样的。不过对位置的管理会更加精确。

**五、对迭代对象(Traversable objects)对象行为和之前一致。**

编者按：stackoverflow上面的解释：Traversable object is one that implements Iterator or IteratorAggregate interface。如果一个对象实现了iterator或者IteratorAggregate接口，即可称之为迭代对象。