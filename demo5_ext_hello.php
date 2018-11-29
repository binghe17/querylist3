<?php
require 'vendor/autoload.php'; 
use QL\QueryList;

require 'Ext/Hello.php'; 
use QL\Ext\Hello;


$ql = QueryList::run('Hello',[
    'url' => 'http://www.baidu.com'
    ]);

$data = $ql->setQuery([
    'title'=>['title','text']
    ])->data;

print_r($data);

        // Array
        // (
        //     [0] => Array
        //         (
        //             [title] => 百度一下，你就知道
        //         )
        // )




