<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/20
 * Time: 9:55
 */
trait ReadingTraitForFile
{
    public function getReadingLog(Users $user = null)
    {
        if(null == $user) $user = AuthFacade::getService();
        /** @var Files $this */
        $logs = $this->getModelsManager()->createBuilder()
            ->from(['r'=>'Reading'])
            ->where('r.file_id = :file:',['file'=>$this->id])
            ->andWhere('r.user_id =:user:',['user'=>$user->id])
            ->orderBy('r.created_at ASC')
            ->getQuery()->execute();
        $records = [];
        $times = 1;
        foreach($logs as $log){
            if($times != $log->times) $times = $log->times;
            $records[$times][$log->status] = $log;
        }
        return $records;
    }
}