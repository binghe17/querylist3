<?php
namespace QL\Ext;
/**
 * @Author: Jaeger <hj.q@qq.com>
 * @version                  1.0
 * 模拟登陆扩展
 */
class Login extends Request
{
    private $http;
    public $html;
    public function run(array $args)
    {
        $this->http = $this->hq($args);
        $this->html = $this->http->result;
        return $this;
    }
    public function get($url,$callback = null,$args = null)
    {
        $result = $this->http->get($url);
        return $this->getQL($result,$callback,$args);
    }
    public function post($url,$data=array(),$callback = null,$args = null)
    {
        $result = $this->http->post($url,$data);
        return $this->getQL($result,$callback,$args);
    }
    private function getQL($html,$callback = null,$args = null)
    {
        if(is_callable($callback)){
            $result = call_user_func($callback,$result,$args);
        }
        $ql = $this->getInstance();
        $ql->html = $html;
        return $ql;
    }
}