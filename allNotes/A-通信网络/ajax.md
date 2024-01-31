#ajax  页面无刷新更新数据；



### [*页面无刷新更新*数据(ajax异步加载) ](http://www.baidu.com/link?url=drRdVcvNdkHEIuj8wTStP7y6PMx3curShMzW4iImPiNO5NUGayftebPDJTt_07xhz_9-Z3CF9i9Z-8WN1a-Vcq)



`````js
#Ajax被认为是(Asynchronous(异步) JavaScript And Xml的缩写）
$.ajax({
  url:'/comm/test1.php',
  type:'POST', //GET
  async:true,  //或false,是否异步
  data:{
    name:'yang',age:25
  },
  timeout:5000,  //超时时间
  dataType:'json',  //返回的数据格式：json/xml/html/script/jsonp/text
  beforeSend:function(xhr){
    console.log(xhr)
    console.log('发送前')
  },
  success:function(data,textStatus,jqXHR){
    console.log(data)
    console.log(textStatus)
    console.log(jqXHR)
  },
  error:function(xhr,textStatus){
    console.log('错误')
    console.log(xhr)
    console.log(textStatus)
  },
  complete:function(){
    console.log('结束')
  }
})

`````





