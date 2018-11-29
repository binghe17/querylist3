<?php
//Login 模拟登陆扩展    https://querylist.cc/docs/guide/v3/Login
require 'vendor/autoload.php'; 
use QL\QueryList;

echo '<pre>';



//-------------------
// $login = QueryList::run('Login',[
//     'target' => '登陆表单提交的目标地址',
//     'method' => 'post',
//     //登陆表单需要提交的数据
//     'params' => ['username'=>'admin','password'=>'admin'],
//     'cookiePath' => 'cookie保存路径'
//     //更多参数查看Request扩展
//     ]);
// //登陆成功后，就可以调用get和post两个方法来抓取登陆后才能抓的页面
// $ql = $login->get('页面地址'[,'处理页面的回调函数','传给回调的参数']);
// $ql = $login->post('页面地址','post提交的数据数组'[,'处理页面的回调函数','传给回调的参数']);

// $data = $ql->setQuery(...)->data;





//--------------------
// 返回值为Login插件对象，这个对象的get和post两个方法的返回值为设置好了html属性的QueryList对象，然后应该调用QueryList的setQuery方法设置采集规则。

// //模拟登陆
// $login = QueryList::run('Login',[
//     'target' => 'http://xxx.com/login',
//     'method' => 'post',
//     'params' => ['username'=>'admin','password'=>'admin'],
//     'cookiePath' => './cookie123.txt'
//     ]);

// $data = $login->post('http://xxx.com/admin',['key'=>'value'],function($content,$args){
// //这里可以对页面做一些格外的处理
// //替换页面的所有的yyy为xxx
// $content = str_replace('yyy',$args,$content);
// return $content;
// },'xxx')->setQuery(['title'=>['h1','text']])->data;


