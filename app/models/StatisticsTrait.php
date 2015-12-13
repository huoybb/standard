<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/14
 * Time: 6:58
 */
trait StatisticsTrait
{
    public function getStaticsByMonth()
    {
        return self::query()
            ->columns(['count(id) AS num',"DATE_FORMAT(created_at,'%Y-%m') As month"])
            ->groupBy('month')
            ->orderBy('month DESC')
            ->execute();
    }
    public function getStaticsByDay()
    {
        return self::query()
            ->columns(['count(id) AS num',"DATE_FORMAT(created_at,'%Y-%m-%d') As day"])
            ->groupBy('day')
            ->orderBy('day DESC')
            ->execute();
    }
}