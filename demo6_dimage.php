<?php 
//DImage图片下载扩展    https://querylist.cc/docs/guide/v3/DImage
require 'vendor/autoload.php'; 
use QL\QueryList;

echo '<pre>';



//-------------------
// // 用法一
// $html = QueryList::run('DImage',[
//         'content' => file_get_contents('http://xxx.com/1.html'),//html内容
//         'image_path' => '/xx/x/',//图片保存路径（相对于网站跟目录），可选，默认:/images
//         'www_root' => dirname(__FILE__), //网站根目录全路径，如:/var/www/html
//         'base_url' => 'http://uploads.rayli.com.cn',  //补全HTML中的图片路径,可选，默认为空
//         'attr' => array('data-src','src'),        //图片链接所在的img属性，可选，默认src //多个值的时候用数组表示，越靠前的属性优先级越高
//         'callback' => function($imgObj){        //单个值时可直接用字符串  //'attr' => 'data-src',  //回调函数，用于对图片的额外处理，可选，参数为img的phpQuery对象
//                 $imgObj->attr('alt','xxx');
//                 $imgObj->removeAttr('class');
//                 //......
//             }
//         ]
//     );
// print_r($html);




//--------------------
// // 用法二
// $url = 'http://cms.querylist.cc/news/it/547.html';
// $reg = [
//   'title' => array('h1','text'),
//  'content' => array('.post_content','html')
// ];
// $data = QueryList::Query($url,$reg,'.content')->getData(function($item){
//     //图片本地化
//     $item['content'] = QueryList::run('DImage',[
//             'content' => $item['content'],
//             'image_path' => '/img/'.date('Y-m-d'),
//             'www_root' => dirname(__FILE__)
//         ]);
//     return $item;
// });
// print_r($data);




//--------------------
// // 用法三
// $con =<<<STR
// <img src="/App/Tpl/Home/images/loading.gif"  data-original="/images/896891/c21alNoWfSAJ6xqN44SRAdW+0M3gZ7H3msPj8/SpdYZXnUZprQ1Xg5IxQcARLus6wz9xz5O7xve82KY2dpmEGjuLP49w.jpg" alt="鲑鱼龙虾鱼子酱" class="img-responsive img-thumbnail lazy">
// <br/>
// <img src="/App/Tpl/Home/images/loading.gif">
// STR;

// $html = QueryList::run('DImage',[
//         'content' => $con,
//         'www_root' => dirname(__FILE__),
//         'base_url' => 'http://x.44i.cc',
//         'attr' => array('data-original','src'),
//         'image_path' => '/xx',
//         'callback' => function($o){
//             $o->attr('alt','111');
//             $o->removeAttr('class');
//         }
//     ]);
// echo $html;

// // 输出:
// // <img src="/App/Tpl/Home/images/loading.gif" data-original="/xx/fd0c11eef490f3b215a050ac0b9a1318.jpg" alt="111"><br><img src="/xx/a2b617f74ce48ef9d88bfeb96443010b.gif" alt="111">





