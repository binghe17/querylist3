<?php
namespace QL\Ext;
/**
 * @Author: Jaeger <hj.q@qq.com>
 * @version                  1.0
 * 网络操作扩展
 */
class Request extends AQuery
{
    protected function hq(array $args)
    {
        $args = array(
            'http' => isset($args['http'])?$args['http']:$args,
            'callback' => isset($args['callback'])?$args['callback']:'',
            'args' =>  isset($args['args'])?$args['args']:''
            );
        $http = $this->getInstance('QL\Ext\Lib\Http');
        $http->initialize($args['http']);
        $http->execute();
        if(!empty($args['callback'])){
            $http->result = call_user_func($args['callback'],$http->result,$args['args']);
        }
        return $http;
    }
    public function run(array $args)
    {
        $http = $this->hq($args);
        $ql = $this->getInstance();
        $ql->html = $http->result;
        return $ql;
    }
}