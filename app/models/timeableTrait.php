<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/17
 * Time: 13:30
 */
use Carbon\Carbon;
trait timeableTrait
{
    public function getResultsBetween(Carbon $startTime, Carbon $endTime)
    {
        $className = get_class($this);
        /** @var myModel $this */
        return $this->getModelsManager()->createBuilder()
            ->from($className)
            ->where('created_at > :start:',['start'=>$startTime->toDateTimeString()])
            ->andWhere('created_at < :end:',['end'=>$endTime->toDateTimeString()])
            ->orderBy('created_at DESC');
    }
}