<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/14
 * Time: 19:57
 */
trait ReadingTraitForUser
{
    /**
     * @param Files $file
     * @return bool
     */
    public function wantToRead(Files $file)
    {
        /** @var Users $this */

        $lastStatus = $this->getLastReadingStatusOf($file);
        if($lastStatus == 'want') return false;

        $this->makeLastReadingInactive($file);

        Reading::saveNew([
            'file_id'=>$file->id,
            'user_id'=>$this->id,
            'status'=>'want',
            'times'=>$this->getReadingTimesFor($file,'want'),
            'isActive'=>true,
        ]);
        if($lastStatus == 'reading') $this->save([
            'reading_count'=>$this->reading_count-1,
            'done_count'=>$this->done_count+1,
        ]);
        $this->save(['want_count'=>$this->want_count+1]);

        $this->removeCache([$lastStatus,'want']);
        return true;
    }


    /**
     * @param Files $file
     * @return bool
     */
    public function reading(Files $file)
    {
        /** @var Users $this */
        $lastStatus = $this->getLastReadingStatusOf($file);
        if($lastStatus == 'reading') return false;
        $this->makeLastReadingInactive($file);
        Reading::saveNew([
            'file_id'=>$file->id,
            'user_id'=>$this->id,
            'status'=>'reading',
            'times'=>$this->getReadingTimesFor($file,'reading'),
            'isActive'=>true,
        ]);
        if($lastStatus == 'want') $this->save(['want_count'=>$this->want_count-1]);
        $this->save(['reading_count'=>$this->reading_count+1]);
        $this->removeCache([$lastStatus,'reading']);

        return true;
    }

    /**
     * @param Files $file
     * @return bool
     */
    public function done(Files $file)
    {
        /** @var Users $this */
        $lastStatus = $this->getLastReadingStatusOf($file);
        if($lastStatus == 'done') return false;
        $this->makeLastReadingInactive($file);
        Reading::saveNew([
            'file_id'=>$file->id,
            'user_id'=>$this->id,
            'status'=>'done',
            'times'=>$this->getReadingTimesFor($file,'done'),
            'isActive'=>false,
        ]);
        if($lastStatus <> 'null') {
            $property = $lastStatus.'_count';
            $this->save([
                $property=>$this->$property-1,
                'done_count'=>$this->done_count+1
            ]);
        }
        $this->removeCache([$lastStatus,'done']);

        return true;

    }

    public function getReadingStatusFor(Files $file)
    {
        $status = $this->getLastReadingStatusOf($file);
        $result = [
            'null'=>'未读',
            'want'=>'想读',
            'reading'=>'在读',
            'done'=>'读过'
        ];
        return $result[$status];
    }

    /**
     * @param string $status
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getReadingList($status,$isActive = true)
    {
        $key = $this->getReadingKey($status);
        /** @var myModel $this */
        return $this->cache($key,function()use($status,$isActive){
            return ModelsManager::createBuilder()
                ->from(['r'=>'Reading'])
                ->leftJoin('Files','file_id = f.id','f')
                ->where('user_id = :user:',['user'=>AuthFacade::getID()])
                ->andWhere('r.status = :status:',['status'=>$status])
                ->andWhere('r.isActive = :isActive:',['isActive'=>$isActive])
                ->orderBy('r.created_at DESC')
                ->columns(['r.*','f.*'])
                ->getQuery()->execute();
        });
    }


    private function getReadingTimesFor(Files $file,$newStatus)
    {
        $lastStatus = $this->getLastReadingStatusOf($file);//null,want,reading,done
        $statusMatrix = [
            'null'=>[
                'want'=>1,
                'reading'=>1,
                'done'=>1,
            ],
            'want'=>[
                'reading'=>0,
                'done'=>0,
            ],
            'reading'=>[
                'want'=>1,
                'done'=>0,
            ],
            'done'=>[
                'want'=>1,
                'reading'=>1,
            ]
        ];
//        dd($statusMatrix[$lastStatus][$newStatus]);
//        dd($this->getLastReadingTimesOf($file));
        return $statusMatrix[$lastStatus][$newStatus] + $this->getLastReadingTimesOf($file);
    }

    private function getLastReadingStatusOf($file)
    {
        return $this->make('lastStatus',function()use($file){
            $lastRecord = $this->getLastReadingOf($file);
            if($lastRecord) return $lastRecord->status;
            return 'null';
        });

    }

    private function getLastReadingTimesOf($file)
    {
        return $this->make('lastTimes',function()use($file){
            $lastRecord = $this->getLastReadingOf($file);
            if($lastRecord) return $lastRecord->times;
            return 0;
        });

    }

    /**
     * @param $file
     * @return myModel
     */
    private function getLastReadingOf($file){
        return $this->make('lastReading',function()use($file){
            return Reading::query()
                ->where('user_id = :user:',['user'=>$this->id])
                ->andWhere('file_id = :file:',['file'=>$file->id])
                ->orderBy('id DESC')
                ->execute()->getFirst();
        });
    }

    /**
     * @param $file
     */
    private function makeLastReadingInactive($file){
        $lastReading = $this->getLastReadingOf($file);
        if($lastReading) $lastReading->save(['isActive'=>false]);
    }

    /**
     * 清楚缓存的函数
     * @param array $keys
     * @return bool
     */
    private function removeCache(array $keys){
        foreach($keys as $key){
            $cacheKey = $this->getReadingKey($key);
            RedisFacade::delete($cacheKey);
        }
        return true;
    }

    private function getReadingKey($key){
        return 'standard:users:'.AuthFacade::getID().':reading:'.$key;
    }


}