# base64编码

>total:防止header受干扰；
>
>数据的传输都要转换成二进制进行传输；注意数据传输的编码格式；

**base64** 

用64个字符来表示任意的二进制数据的方式；

所以需要对header头里的字段做编码

编码规则：

假如是3个字节 24位 ；

00000000 00000000 00000000

base64 6位一个字符；

000000 000000 000000 000000 

然后 base64指的是只有64个字符 分别是  ： **A-Z a-z  0-9 + /**  结束符可以使用等号**=**；一共65位；每一个=就代表补了多少位，每一个等号代表两位； 两个等号就是两位，三个等号就是四位；<font color=red>decode解码的时候要去掉等号；</font>

<font color=red>缺点 ：Base64编码会把3字节（utf-8）的二进制数据编码为4字节的文本数据，长度增加33%，好处是编码后的文本数据可以在邮件正文、网页等直接显示。</font>

实例：cookie url 在这两部分比较常用；



<font color =red>？？这里由一个比较好的问题，为什么不编译成二进制或者16进制</font>  

<font color=red>注意： 当你在网络中 传递一个 0 或者 1 并不是这个数据占一个位，而是占一个字节的ASCII；先转换成 ASCII然后进行传输，然后转译；</font>

<font color =red>因为转换成2进制相当于有原先的3个字节 膨胀到了 24个字节；太消耗流量了</font>



= 会在cookie中造成歧义 



**urlencode**

>**url 传递数据 使用的是ascii码**

total： 主要是为了解决url引起歧义的一个问题；

**= & ？ 等的一些歧义  还有汉字的问题；**

urlencode();

http_build_query();

setcookie(); 会对 cookie的值做一个base64加密；

<font color=red>**编码格式 其他的编码格式就是转换为16进制 然后前面加% ，但是带宽扩大了3倍；  如果是ascii 直接用ascii就行**</font>



**编码字符集**  **charset**

unicode   **utf-8  常用的汉字 三个字节一个   可变长的编码格式；英文和一些特殊符号 还是ASCII** 

汉字比较出名的编码格式

gbk 不仅仅中国的，而且还有外国的亚洲的把；

**gb123 简体  2个字节；**	

big5 繁体；





```php
public static function generateTradeId($generateMode = 1)
{
    list($sec, $msec) = explode('.', microtime(true));

    if (Request::checkMode(Request::MODE_PRE)) {
        //最多只支持10个子订单
        return $sec .
            str_pad(substr($msec, 0, 3), 3, '0', STR_PAD_LEFT) .
            '0' .
            str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
    } else {
        //最多只支持10个子订单
        if ($generateMode == 2) { //前两位数字加20;作为订单开头;
            $prefix = (date('y', $sec) + 20) . date('mdHis', $sec);
        } else {
            $prefix = date('ymdHis', $sec);
        }

        return $prefix . str_pad(substr($msec, 0, 3), 3, '0', STR_PAD_LEFT) .
            '0' .
            str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);

    }
}
```