<?php
//QueryList 3.2.1 크롤링도구(php5.6에서 사용가능)   https://querylist.cc/docs/guide/v3/callback

require 'vendor/autoload.php'; 
// require 'phpQuery.php';
// require 'QueryList.php';

use QL\QueryList;


if(!isset($_GET['nv_mid'])) exit('GET방식을 nv_mid값을 넣으세요(<a href="?nv_mid=14016207273">14016207273</a>)');
$nv_mid = isset($_GET['nv_mid']) ? $_GET['nv_mid'] : '14016207274'; //12562325794
// echo $nv_mid;

echo '<pre>';
//------------------

// 상품ID로 최저가 가져오기 (네이버쇼핑)
function naverLowestPrice($nv_mid){
    $url = 'https://search.shopping.naver.com/detail/detail.nhn?nv_mid='. $nv_mid; //최저가 링크
    $rules = [ //推荐方式， 设置范围选择器
        'title' => ['strong','text'],   //['.mini_info strong','text'],
        'price' => ['em','text']        //['.mini_info em','text']
    ];
    $rang = '.mini_info';
    $data = QueryList::Query($url,$rules,$rang)->data;
    $data[0]['id'] = $nv_mid;
    $data[0]['time'] = date("Y-m-d H:i:s");
    return $data[0];
}




$isMidIndexOf = strpos($_GET['nv_mid'], ',') > -1;//indexOf
var_dump($isMidIndexOf);
if($isMidIndexOf){
    $arr = explode(',',$_GET['nv_mid']);
    $arr = array_values(array_filter(array_map('trim',$arr))); //공백제거
    foreach ($arr as $k => $v) {
        print_r(naverLowestPrice($v));
    }
    // print_r($arr);
} else{
    print_r(naverLowestPrice($nv_mid));
}



//TEST   http://localhost/curl/querylist3/demo2.php?nv_mid=14016207273,13963579031
//TEST   http://localhost/curl/querylist3/demo2.php?nv_mid=14016207273


