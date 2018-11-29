<?php 

require 'vendor/autoload.php'; 

use QL\QueryList;



// // 用法一
// $ql = QueryList::run('Request',[
//     'http' => [
//         'target' => '采集的目标页面',
//         'referrer' => '来源地址',
//         'method' => '请求方式，GET、POST等',
//         'params' => ['提交的参数'=>'参数值','key'=>'value'],
//         //等等其它http相关参数，具体可查看Http类源码
//     ],
//     'callback' => function($html,$args){
//         //处理html的回调方法
//         return $html;
//     },
//     'args' => '传给回调函数的参数'
// ]);

// $data = $ql->setQuery(...)->data;





// // 用法二
// $ql = QueryList::run('Request',[
//     'target' => '采集的目标页面',
//     'referrer' => '来源地址',
//     'method' => '请求方式，GET、POST等',
//     'params' => ['提交的参数'=>'参数值','key'=>'value'],
//     //等等其它http相关参数，具体可查看Http类源码
// ]);
// $data = $ql->setQuery(...)->data;

//返回值为设置好了html属性的QueryList对象，然后应该调用QueryList的setQuery方法设置采集规则。

// //HTTP操作扩展
// $urls = QueryList::run('Request',[
//     'target' => 'http://cms.querylist.cc/news/list_2.html',
//     'referrer'=>'http://cms.querylist.cc',
//     'method' => 'GET',
//     'params' => ['var1' => 'testvalue', 'var2' => 'somevalue'],
//     'user_agent'=>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0',
//     'cookiePath' => './cookie.txt',
//     'timeout' =>'30'
// ])->setQuery(['link' => [
//         'h2>a','href','',function($content){
//             $baseUrl = 'http://cms.querylist.cc'; //利用回调函数补全相对链接
//             return $baseUrl.$content;
//         }
//     ]
// ], '.cate_list li')->getData(function($item){
//     return $item['link'];
// });



