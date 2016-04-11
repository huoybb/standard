<?php

/**
 * 通过这个接口更好的规范诸如：万方、DOD等未来的大的来源类型的格式
 * 未来万方的论文等也需要通过这个接口来实现，以便能够方便在显示页面显示出来
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/27
 * Time: 11:58
 */
interface FileableInterface
{
    public function getStandard();
    public function format();//视图中调用，返回需要显示的字段，以及字段的中文名称
//    public function getHtml($key);
    public function getType();//返回文档类型
    public static function findBySourceId($souceId);
    public static function getDatabaseName();//返回当前数据库的名称
    public function getDBName();//返回当前数据库的名称
    public function getModelType();//返回当前数据库的类型
    public function getDBDescription();//描述当前数据库
    public function getDBHomePageLink();//当前数据库的网页首页链接
}