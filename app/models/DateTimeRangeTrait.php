<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/17
 * Time: 13:30
 */
use Carbon\Carbon;
trait DateTimeRangeTrait
{
    public function getResultsQueryBetween(Carbon $startTime, Carbon $endTime)
    {
        $className = get_class($this);
        return ModelsManager::createBuilder()
            ->from($className)
            ->where('created_at BETWEEN :start: AND :end:',['start'=>$startTime->toDateTimeString(),'end'=>$endTime->toDateTimeString()])
            ->orderBy('created_at DESC');
    }
    public function getResultsQueryBefore(Carbon $time)
    {
        $className = get_class($this);
        return ModelsManager::createBuilder()
            ->from($className)
            ->where('created_at < :time:',['time'=>$time->toDateTimeString()]);
    }
    public function getResultsQueryAfter(Carbon $time)
    {
        $className = get_class($this);
        return ModelsManager::createBuilder()
            ->from($className)
            ->where('created_at > :time:',['time'=>$time->toDateTimeString()]);
    }
}