# != and !==

>!= 和 !==的区别！！！

---

## code

`````php
//!== 是包含数据类型也不等于的！！！
//数据类型也不想等！！！
//设计模式中的订阅发布模式；

    public function deattach(Subscriber $subscriber) {
        //false int
        //0== false的
        // 所以这里必须是全不等！！！ 数据类型也不等于  
        //0!=false  0==false！！！！
        if (($key = array_search($subscriber,$this->subscribers)) !== false) {
            unset($this->subscribers[$key]);
        }
    }
`````



![image-20231125184836680](./!=%20and%20!==.assets/image-20231125184836680.png)