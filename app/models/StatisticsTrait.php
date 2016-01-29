<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/12/14
 * Time: 6:58
 */
trait StatisticsTrait
{
    public function getStaticsByMonth($repo = null)
    {
        $className = static::class;
        $repoName = $repo==null?'Files':$repo;
        $key = 'standard:archives:'.$repoName;
        if(!RedisFacade::exist($key)){
            $query = $className::query()
                ->columns(['count('.$className.'.id) AS num','DATE_FORMAT('.$className.'.created_at,"%Y-%m") As month'])
                ->groupBy('month')
                ->orderBy('month DESC');
            if($repo) $query = $query->rightJoin($repo,'sub.file_id = '.$className.'.id','sub');
            $results =  $query
                ->execute();
            RedisFacade::set($key,json_encode($results));
        }
        return json_decode(RedisFacade::get($key));

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