<?php
/**
 * QueryList的Hello扩展演示
 */
namespace QL\Ext;
class Hello extends AQuery
{
    /**
     * 必须要实现run()方法
     */
    public function run(array $args)
    {
        //getInstance()方法用于获取任意类的实例，默认获取QueryList实例
        $ql = $this->getInstance();
        //设置QueryList对象的html属性
        $ql->html = $this->getHtml($args['url']);
        //返回QueryList对象
        return $ql;
    }

    /**
     * 自定义一个抓取网页源码的方法
     */
    public function getHtml($url)
    {
      return file_get_contents($url);
    }
}