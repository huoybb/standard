<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/5/21
 * Time: 20:30
 * @property  \Phalcon\Mvc\Model\Query\Builder
 */
class FileFilter extends myModelFilter
{
    public function journal($name)
    {

        return $this->builder->innerJoin(Fileable::class,'fileable.file_id = Files.id','fileable')
            ->innerJoin(Wanfang::class,'Wanfang.id = fileable.fileable_id AND fileable.fileable_type = "Wanfang"')
            ->andWhere('Wanfang.Journal = :journal:',['journal'=>$name]);
    }
    public function orderBy($column)
    {
        $order = $this->request->get('order')?:'DESC';
        return $this->builder->orderBy($column.' '.$order);
    }


}