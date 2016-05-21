<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/5/21
 * Time: 20:36
 */
abstract class myModelFilter
{

    /**
     * @var \Phalcon\Mvc\Model\Query\Builder
     */
    protected $builder;

    /**
     * myModelFilter constructor.
     */

    public function __construct(\Phalcon\Http\Request $request)
    {
        $this->request = $request;
    }
    public function apply(\Phalcon\Mvc\Model\Query\BuilderInterface $builder)
    {
        $this->builder = $builder;
        foreach($this->getFilters() as $key=>$value){
            if(method_exists($this,$key)){
                call_user_func_array([$this,$key],array_filter([$value])); //如何防止注入呢？这里需要将来考虑
            }
        }
        return $this->builder;
    }
    public function getFilters()
    {
        $request = $this->request->get();
        unset($request['_url']);
        return $request;
    }



}