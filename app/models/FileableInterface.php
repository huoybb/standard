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
    public function format();
    public function getHtml($key);
    public function getType();//返回文档类型
    public static function findBySourceId($souceId);
    public static function getDatabaseName();//返回当前数据库的名称
}