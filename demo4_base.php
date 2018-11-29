<?php
// QueryList V3 中文文档  https://querylist.cc/docs/guide/v3/overview
require 'vendor/autoload.php'; 
use QL\QueryList;


//---------------采集文章页

$url = 'https://www.cnbeta.com/articles/tech/779841.htm';// 待采集的页面地址
$rules = [// 采集规则
    'title' => ['.title>h1','text'],// 文章标题
    'date' => ['.meta>span:eq(0)','text'],// 发布日期
    'content' => ['#artibody','html'] // 文章内容
];
$data = QueryList::Query($url,$rules)->data;
print_r($data);

        // Array
        // (Array
        // (
        //     [0] => Array
        //         (
        //             [title] => GitHub意外宕机 已确认数据存储系统存在问题
        //             [date] => 2018年10月22日 14:42
        //             [content] => <p style="text-align: center;"><img src="https://static.cnbetacdn.com/article/2018/1022/82e649adfde2e98.png" alt="github-down-due-to-data-storage-system-issue-523345-2.png"></p>
        // <p>发稿前，GitHub 已经排除了部分故障。目前似乎只有某些特定地区受到了影响，但欧洲等部分地区仍未完全恢复。</p>
        // <blockquote>
        // <p>GitHub 团队表示，数据存储系统是导致本次故障的罪魁祸首。为尽快恢复服务，他们正在努力修复。</p>
        // <p>过去的几个小时，所有工作都集中在这方面。在此期间，部分用户可能看到不一致的结果。</p>
        // </blockquote>
        // <p>今年早些时候，<a data-link="1" href="https://afflnk.microsoft.com/c/1251234/439031/7808" target="_blank">微软</a>宣布以 75 亿美元收购 GitHub 。近日，欧盟委员会认定微软接管 GitHub 不违背反竞争原则，并准予放行。</p>
        // <p>[编译自：<a href="https://news.softpedia.com/news/github-down-due-to-data-storage-system-issue-523345.shtml" target="_self">Softpedia</a>]</p>
        //         )

        // )


//--------------采集列表页

$url = 'https://www.cnbeta.com/';// 待采集的页面地址
$rules = [// 采集规则
    'title' => ['a:eq(0)','text'],    // 文章标题
    'link' => ['a:eq(0)','href'],    // 文章链接地址
    'img' => ['img:eq(0)','src'],   // 文章缩略图
    'summary' => ['p:eq(0)','text']    // 文章简介
];
$range = '.items-area>.item';// 切片选择器
$data = QueryList::Query($url,$rules,$range)->data;
print_r($data); 


        // Array
        // (
        //     [0] => Array
        //         (
        //             [title] => 看NASA火箭发射系统如何在1分钟内释放出45万加仑的水
        //             [link] => https://www.cnbeta.com/articles/science/779871.htm
        //             [img] => https://static.cnbetacdn.com/thumb/mini/article/2018/1022/2313d68aa837a59.png
        //             [summary] => 据外媒报道，NASA将这个称为是“点火超压保护和降噪冲水散热系统(Ignition Overpressure Protection and Sound Suppression water deluge system)”，那么它究竟是怎么样的呢？请看下面这段视频：
        //         )

        //     [1] => Array
        //         (
        //             [title] => 日本最具价值科技初创公司创始人：“机器人管家”五年内将能进入市场
        //             [link] => https://www.cnbeta.com/articles/tech/779869.htm
        //             [img] => https://static.cnbetacdn.com/thumb/mini/article/2018/1022/d272d6fd91a56cd.png
        //             [summary] => 据外媒报道，当你想到机器人--那种可能在家里满足你一切需求的机器人--你往往认为那是遥远的未来，你肯定不会想到它能在五年之后出现。日本最具价值的科技初创公司Preferred Networks创始人Toru Nishikawa表示：“我们希望在五年内将这种机器人推向市场并看到它们被使用。十年太长了，不能再等了。”
        //         )

        //     [2] => Array
        //         (
        //             [title] => YY CEO李学凌自曝在身体植入芯片：为了深度了解自己
        //             [link] => https://www.cnbeta.com/articles/tech/779867.htm
        //             [img] => https://static.cnbetacdn.com/thumb/mini/article/2018/1022/92681d656443196.jpg
        //             [summary] => 欢聚时代（YY）联合创始人、董事长兼CEO李学凌在朋友圈晒出身体植入芯片的经历，并表示这样可以“更好地了解自己”。李学凌称，这是里程碑的一天，未来会有更多的人在身体里植入芯片。李学凌还描述了植入芯片的过程：“很高速地弹射出去，啪的一声就打进去了，没有一点的疼感。”
        //         )

        //     // ...

        //  ）






//-------------------内容过滤

$html =<<<STR
    <div id="demo">
        xxx
        <span class="tt">yyy</span>
        <span>zzz</span>
        <p>nnn</p>
    </div>
STR;

//只想获取内容:xxx
$data = QueryList::Query($html,array(
        'txt' => array('#demo','text','-span -p') 
    ))->data;
print_r($data);

        //  结果:
        //  Array
        // (
        //     [0] => Array
        //         (
        //             [txt] => xxx
        //         )
        // )





//去掉p标签，但保留p标签的内容
$data = QueryList::Query($html,array(
        'txt' => array('#demo','html','p') 
    ))->data;
print_r($data);

        //  结果:
        //  Array
        // (
        //     [0] => Array
        //         (
        //             [txt] => xxx
        //         <span class="tt">yyy</span>
        //         <span>zzz</span>
        //         nnn
        //         )
        // )





//获取纯文本，但保留p标签
$data = QueryList::Query($html,array(
        'txt' => array('#demo','text','p') 
    ))->data;
print_r($data);

        //  结果:
        //  Array
        // (
        //     [0] => Array
        //         (
        //             [txt] => xxx
        //         yyy
        //         zzz
        //         <p>nnn</p>
        //         )
        // )





//去掉class名为tt的元素和p标签，但保留p标签的内容
$data = QueryList::Query($html,array(
        'txt' => array('#demo','html','-.tt p') 
    ))->data;
print_r($data);

        //  结果:
        //  Array
        // (
        //     [0] => Array
        //         (
        //             [txt] => xxx
        //         <span>zzz</span>
        //         nnn
        //         )
        // )






//--------------向回调函数中传参数       注意:只有高版本PHP才支持此语法，如果报错就说明你装的PHP版本太低。

$html =<<<STR
    <div id="demo">
        xxx
        <a href="/yyy">链接一</a>
        <a href="/zzz">链接二</a>
    </div>
STR;

$baseUrl = 'http://xxx.com';

//获取id为demo的元素下的最后一个a链接的链接和文本
//并补全相对链接

//方法一
$data = QueryList::Query($html,array(
        'link' => array('#demo a:last','href','',function($content) use($baseUrl){
            return $baseUrl.$content;
        }),
        'name' => array('#demo a:last','text') 
    ))->data;
print_r($data);

//方法二
$data = QueryList::Query($html,array(
        'link' => array('#demo a:last','href'),
        'name' => array('#demo a:last','text') 
    ))->getData(function($item) use($baseUrl){
    $item['link'] = $baseUrl.$item['link'];
    return $item;
});
print_r($data);

        //  结果
        //  Array
        // (
        //     [0] => Array
        //         (
        //             [link] => http://xxx.com/zzz
        //             [name] => 链接二
        //         )

        // )





//---------------------------递归多级采集

//获取每个li里面的h3标签内容，和class为item的元素内容
$html =<<<STR
    <div id="demo">
        <ul>

            <li>
              <h3>xxx</h3>
              <div class="list">
                <div class="item">item1</div>
                <div class="item">item2</div>
              </div>
            </li>

             <li>
              <h3>xxx2</h3>
              <div class="list">
                <div class="item">item12</div>
                <div class="item">item22</div>
              </div>
            </li>

        </ul>
    </div>
STR;

$data = QueryList::Query($html,array(
        'title' => array('h3','text'),
        'list' => array('.list','html')
    ),'#demo li')->getData(function($item){

    $item['list'] = QueryList::Query($item['list'],array(
             'item' => array('.item','text')
        ))->data;
    return $item;

});
print_r($data);


        //  结果:
        // Array
        // (
        //     [0] => Array
        //         (
        //             [title] => xxx
        //             [list] => Array
        //                 (
        //                     [0] => Array
        //                         (
        //                             [item] => item1
        //                         )
        //                     [1] => Array
        //                         (
        //                             [item] => item2
        //                         )
        //                 )
        //         )
        //     [1] => Array
        //         (
        //             [title] => xxx2
        //             [list] => Array
        //                 (
        //                     [0] => Array
        //                         (
        //                             [item] => item12
        //                         )
        //                     [1] => Array
        //                         (
        //                             [item] => item22
        //                         )
        //                 )
        //         )
        // )







// ----------------------------------------区域选择器例子

//采集#main下面的li里面的内容
$html =<<<STR
<div id="main">
    <ul>
        <li>
          <h1>这是标题1</h1>
          <span>这是文字1<span>
        </li>
        <li>
          <h1>这是标题2</h1>
          <span>这是文字2<span>
        </li> 
    </ul>
</div>
STR;



//方法一，不推荐
$data = QueryList::Query($html,array(
    'title' => array('#main>ul>li>h1','text'),
    'content' => array('#main>ul>li>span','text')
    ))->data;
print_r($data);

//方法二，设置范围选择器
$data = QueryList::Query($html,array(
    'list' => array('h1','text'),
    'content' => array('span','text')
    ),'#main>ul>li')->data;
print_r($data);


        //  两种方式的输出结果都相同:
        // Array
        // (
        //     [0] => Array
        //         (
        //             [title] => 这是标题1
        //             [content] => 这是文字1
        //         )
        //     [1] => Array
        //         (
        //             [title] => 这是标题2
        //             [content] => 这是文字2
        //         )
        // )





//但方法一有严重的缺陷，例如html变成这样，其它代码不变
$html =<<<STR
<div id="main">
    <ul>
        <li>
          <h1>这是标题1</h1>
        </li>
        <li>
          <h1>这是标题2</h1>
          <span>这是文字2<span>
        </li> 
    </ul>
</div>
STR;


        //  方法一输出结果,结果已经错位了:
        // Array
        // (
        //     [0] => Array
        //         (
        //             [title] => 这是标题1
        //             [content] => 这是文字2
        //         )
        //     [1] => Array
        //         (
        //             [title] => 这是标题2
        //         )
        // )
        // 方法二输出结果，依旧正确：
        // Array
        // (
        //     [0] => Array
        //         (
        //             [list] => 这是标题1
        //             [content] => 
        //         )
        //     [1] => Array
        //         (
        //             [list] => 这是标题2
        //             [content] => 这是文字2
        //         )
        // )




//-----------------------------内置的乱码解决方案
 
// $html =<<<STR
// <div>
//     <p>这是内容</p>
// </div>
// STR;
// $rule = array(
//     'content' => array('div>p:last','text')
// );
// // QueryList::Query(采集的目标页面,采集规则[,区域选择器][，输出编码][，输入编码][，是否移除头部])
// $data = QueryList::Query($html,$rule,'','UTF-8','GB2312')->data;
// $data = QueryList::Query($html,$rule,'','UTF-8','GB2312',true)->data;//最后一个参数为true(移除头部)

//----------------------------自己手动转码页面，然后再把页面传给QueryList

// $url = 'http://top.etao.com/level3.php?spm=0.0.0.0.Ql86zl&cat=16&show=focus&up=true&ad_id=&am_id=&cm_id=&pm_id=';
// $html = iconv('GBK','UTF-8',file_get_contents($url));//手动转码
// $hj = QueryList::Query($html,array("text"=>array(".title a","text")));
// print_r($hj->data);




//======================对于更复杂的http网络操作
// QueryList本身内置的网络操作非常简单，QueryList关注于DOM选择;对于更复杂的网络操作可以选择使用Request扩展，它可以简单的实现：携带cookie、伪造来路、伪造浏览器等功能，但如果觉的它依旧不能满足你的需求，下面有几个可以参考的方案:

// 1.自己用curl封装一个http请求
function getHtml($url)
{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
}
$rules = array(
//采集规则
);
//获取页面源码
$html = getHtml('http://xxx.com');
//采集
$data = QueryList::Query($html,$rules)->data;



//---------------
// 2.使用第三方http包
// QueryList可以无缝与任意第三放http包配合使用,下面以guzzlehttp/guzzle包为例,Guzzle是一个PHP的HTTP客户端，用来轻而易举地发送请求，并集成到我们的WEB服务上。




