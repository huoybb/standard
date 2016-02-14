<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/17
 * Time: 13:30
 */
use Carbon\Carbon;
trait dateRangeTrait
{
    public function getResultsBetween(Carbon $startTime, Carbon $endTime)
    {
        $className = get_class($this);
        /** @var myModel $this */
        return $this->getModelsManager()->createBuilder()
            ->from($className)
            ->where('created_at BETWEEN :start: AND :end:',['start'=>$startTime->toDateTimeString(),'end'=>$endTime->toDateTimeString()])
            ->orderBy('created_at DESC');
    }
}