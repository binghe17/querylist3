<?php
require 'vendor/autoload.php';
// require 'phpQuery.php';
// require 'QueryList.php';

use QL\QueryList;

echo '<pre>';
//---------------------
//상품 검색 링크
// https://search.shopping.naver.com/search/all.nhn?query=%EC%95%84%EC%9D%B4%ED%8F%B0X%EC%BC%80%EC%9D%B4%EC%8A%A4&cat_id=&frm=NVSHATC //검색
// https://search.shopping.naver.com/search/all.nhn?query=14016207273    //직접 상품고유ID로 검색도 됨.
// https://search.shopping.naver.com/search/all.nhn?origQuery=%EC%95%84%EC%9D%B4%ED%8F%B0X%EC%BC%80%EC%9D%B4%EC%8A%A4&pagingIndex=2&pagingSize=80&viewType=list&sort=rel&frm=NVSHPAG&query=%EC%95%84%EC%9D%B4%ED%8F%B0X%EC%BC%80%EC%9D%B4%EC%8A%A4
    
    //분석:
    // query='아이폰X케이스'
    // origQuery='아이폰X케이스'
    // pagingIndex=2
    // pagingSize=80    //20, 40, 60, 80
    // viewType=list  //thumb
    // sort=rel
    // frm=NVSHPAG


//특정상품 클릭시 전환하는 페이지 링크
// https://search.shopping.naver.com/detail/detail.nhn?nv_mid=14541402633
// https://search.shopping.naver.com/detail/detail.nhn?nv_mid=15472472279
// https://search.shopping.naver.com/detail/detail.nhn?nv_mid=12916256024&cat_id=50004594&frm=NVSHATC&query=%EC%95%84%EC%9D%B4%ED%8F%B0+X+%EC%BC%80%EC%9D%B4%EC%8A%A4&NaPm=ct%3Djozdw31s%7Cci%3D5f4d689e453aed600e0179518f47a22e30c9af3f%7Ctr%3Dslsl%7Csn%3D95694%7Chk%3D33ad4999c619e8d9bf9d6e128af0201dd9792484




// 필요한 변수: 1.검색어(페이지), 2.몇페이지의 데이터 가져오기;  3.상품ID, 4.감시상품의 순위계산; )
// 저장할 값: 저장날짜시간. 검색어, 상품ID, 한페이지에서 출력되는 리스트의 모든 상품ID. 카테고리분류ID,  (상품명, 카테고리ID, 상품가격, 총상품수) 
// 어느상품을 어느시간에 몇페이지만큼의 데이터를 가져왔다. (검색어 범위로 긁어온다)





//https://search.shopping.naver.com/search/all.nhn?pagingIndex=1&pagingSize=20&viewType=list&sort=rel&frm=NVSHPAG&query=아이폰X케이스



function makeRangeList($search='', $pageStart=1, $pageEnd=1, $pageSize=20, $viewType='list', $sort='rel', $frm='NVSHPAG'){
    if($pageEnd < $pageStart) $pageEnd = $pageStart;
    for ($i = $pageStart; $i <= $pageEnd ; $i++) { 
        $rs[$i] = 'https://search.shopping.naver.com/search/all.nhn?';
        $rs[$i] .= 'pagingIndex='. $i .'&';
        $rs[$i] .= 'pagingSize='. $pageSize;   //20, 40, 60, 80
        $rs[$i] .= '&viewType='. $viewType;     //list, thumb
        $rs[$i] .= '&sort='. $sort;
        $rs[$i] .= '&frm='. $frm;
        $rs[$i] .= '&query='. $search;
    }
    return $rs;
}
$list = makeRangeList('아이폰X케이스', 1,2);
var_dump($list);




$cm = QueryList::run('Multi',[
    'list' => $list,
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
    'success' => function($html,$info){
        $reg = array(
            'id' => array('','data-nv-mid'),
            'class' => array('','class'),
            'mallPid' => array('','data-mall-pid'), //shopId
            // 'shopCno' => array('.mall_txt>.btn_detail','data-cno'),
            'shopSeq' => array('.mall_txt>.btn_detail','data-mall-seq'),
            'mallSeq' => array('','data-mall-seq'),
            'isAD' => array('','data-is-ad'),

            'title' => array('.tit','text' ),
            'price' => array('.price>em>.num','text' ),
            'imgPath' => array('.img>img','data-original' ),
            'linkPath' => array('.img','href' ),
            'cateName' => array('.depth a:last()','title'),
            'cateId' => array('.depth a:last()','href'),
            'reviewCount' => array('.etc>.graph>em','text'),
            'date' => array('.etc>.date','text'),

            'isShop' => array('','data-is-shop-n'),
            'brandName' => array('.mall_txt>.mall_img>img','alt'),
            'brandName_tmp' => array('.mall_txt>.mall_img','text'),//공백일때 보충
            'brandImg' => array('.mall_txt>.mall_img>img','src'),
            'lowestPriceBrand' => array('.mall_list>li:eq(0) .mall_name','text'),
            'lowestPricePrice' => array('.mall_list>li:eq(0) .price','text','-.low'),
            // 'jjim' => array('.etc>.jjim>em','text') //동적데이터임
            'rankNum' => array('','data-expose-rank'),
            'etc' => array('.etc','text','-a -.bar'), //구매건수 획득하기위해 임시저장
            );
        $rang = '#_search_list ._itemSection';
        $ql = QueryList::Query($html['content'],$reg,$rang);
        $data = $ql->getData();
        $i = 1;
        foreach ($data as $k => $v) {
            if( $v['isAD'] == 'true' ){
                unset($data[$k]);
                continue;
            }
            unset($data[$k]['isAd']);
            if(empty($v['isShop'])) $data[$k]['isShop'] = 'false';
            if(empty($v['brandName'])) $data[$k]['brandName'] = $v['brandName_tmp'];
            unset($data[$k]['brandName_tmp']);
            $data[$k]['cateId'] = str_replace('/category/category.nhn?cat_id=','', $v['cateId'] ); //cate link to Id

            $data[$k]['class'] = trim(str_replace('_itemSection','' , $v['class']));
            $data[$k]['dataNum'] = $i;

            $data[$k]['etc'] =   trim(preg_replace('/( ){1,}/i',' ', str_replace("\n",'',str_replace(",",'',$v['etc']))));
            if(strpos($v['etc'],'구매건수')> -1){
                preg_match_all("|구매건수(\d*)|", $data[$k]['etc'], $etcTemp);
                $data[$k]['sellCount'] = $etcTemp[1] != null ?  $etcTemp[1][0] : '';
            }
            unset($data[$k]['etc'] );
           // $data[$k]['etc'] =   iconv("UTF-8","EUC-KR",$data[$k]['etc']);
            $i++;
        }

        //어느페이지에서 데이터 추출했는지 기록
        parse_str(parse_url($html['info']['url'], PHP_URL_QUERY), $pageInfo);
        $pageInfo['length'] = count($data);
        $pageInfo['datas'] = $data;
        $GLOBALS['data'][$pageInfo['pagingIndex']] = $pageInfo; 
       
    }

    // ,'start' => false //不自动开始线程，默认自动开始
    ,'error' => function($err){ 
        echo '<h1>error</h1>';
        print_r($err);
    }

]);



echo '--------';
print_r($data);







// preg_match_all("|구매건수(\d*)|", "리뷰107 구매건수371 등록일 2018.10.", $out);
// print_r($out);




















// //------------test
// $hj = QueryList::Query('https://www.csdn.net/nav/mobile',array(
//     "text"=>array('#feedlist_id .title h2','text')
// ));
// $data = $hj->getData(function($x){
//     return trim($x['text']);
// });
// print_r($data);



