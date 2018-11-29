<?php
// Multi扩展，可以实现多线程采集。 https://querylist.cc/docs/guide/v3/Multi

require 'vendor/autoload.php'; 
/**
 * 下面实现多线程采集文章信息
 */
use QL\QueryList;

echo '<pre>';
//-------------------
//https://search.shopping.naver.com/search/all.nhn?pagingIndex=2&pagingSize=40&viewType=list&sort=rel&frm=NVSHPAG&query=%EC%95%84%EC%9D%B4%ED%8C%A8%EB%93%9C6%EC%84%B8%EB%8C%80%EC%BC%80%EC%9D%B4%EC%8A%A4



//------------------

//多线程扩展
$cm = QueryList::run('Multi',[
    //待采集链接集合
    'list' => [
        'http://cms.querylist.cc/news/it/547.html',
        'http://cms.querylist.cc/news/it/545.html',
        'http://cms.querylist.cc/news/it/543.html'
        //更多的采集链接....
    ],
    'curl' => [
        'opt' => array(
                    //这里根据自身需求设置curl参数
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true,
                    //........
                ),
        'maxThread' => 100,//设置线程数
        'maxTry' => 3 //设置最大尝试数
    ],
    'success' => function($a){ //采集规则
        $reg = array(
            'title' => array('h1','text'), //采集文章标题
            'content' => array('.post_content','html','a -.content_copyright -script' ) //采集文章正文内容,利用过滤功能去掉文章中的超链接，但保留超链接的文字，并去掉版权、JS代码等无用信息
            );
        $rang = '.content';
        $ql = QueryList::Query($a['content'],$reg,$rang);
        $data = $ql->getData();
        print_r($data);  //打印结果，实际操作中这里应该做入数据库操作
    }

    // ,
    // 'start' => false, //不自动开始线程，默认自动开始
    // 'error' => function(){ //出错处理
        
    // }

]);


// //再额外添加一些采集链接
// $cm->add([
//         'http://cms.querylist.cc/news/it/532.html',
//         'http://cms.querylist.cc/news/it/528.html',
//         'http://cms.querylist.cc/news/other/530.html'
//     ],function($html,$info){
//         //sucess
//         //可选的，不同的采集操作....
//         $reg = array(
//             'title' => array('h1','text'), //采集文章标题
//             );
//         $rang = '.content';
//         $ql = QueryList::Query($html['content'],$reg,$rang);
//         $data = $ql->getData();
//         print_r($data);  //打印结果，实际操作中这里应该做入数据库操作
//     },
//     function(){
//         //error
//         //可选的，不同的出错处理
//     });

// //开始采集
// $cm->start();





//----------------
/*
$url = 'http://www.phpddt.com/category/php/1/';

$curl = QueryList::getInstance('QL\Ext\Lib\CurlMulti');
//100个线程
$curl->maxThread = 100;

$data = QueryList::run('Request',array(
    'http' =>array(
        'target' => $url,
        'referrer'=>$url,
        'user_agent'=>'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.11 (KHTML, like Gecko) Ubuntu/11.10 Chromium/27.0.1453.93 Chrome/27.0.1453.93 Safari/537.36',
        'cookiePath' => './cookie.txt'
    ),
    'callback' => function($html){
        return preg_replace('/<head.+?>.+<\/head>/is','<head></head>',$html);
    }
))->setQuery(array('title'=>['h2 a','text'],'link'=>['h2 a','href']))->getData(function($item) use($curl){
    //判断数据库中是否存在数据
    if(!StudyModel::exist($item['title'])){
        $curl->add(['url' => $item['link']],function($a){
            $html = preg_replace('/<head.+?>.+<\/head>/is','<head></head>',$a['content']);
            $data = QueryList::Query($html,array('title'=>['.entry_title','text'],'content'=>['.post','html','-#headline -script -h3.post_tags -.copyright -.wumii-hook a']))->getData();
            //插入数据库
            StudyModel::insert($data[0]['title'],$data[0]['content'],$a['info']['url']);
        });
    }
});

$curl->start();
*/

