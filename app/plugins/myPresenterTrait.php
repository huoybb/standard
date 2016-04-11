<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:12
 */
trait myPresenterTrait
{
    private  $_presenter = null;
    public function present()
    {
        $className = $this->getPresenterName();
        if(!class_exists($className)) throw new Exception('Presenter类不存在，请先定义！');
        if($this->_presenter == null) $this->_presenter = new $className($this);
        return $this->_presenter;
    }
    private function getPresenterName ()
    {
        return get_class($this).'Presenter';
    }
}