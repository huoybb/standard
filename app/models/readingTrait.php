<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/14
 * Time: 19:57
 */
trait readingTrait
{
    /**
     * @param Files $file
     * @return bool
     */
    public function wantToRead(Files $file)
    {
        $lastStatus = $this->getLastReadingStatusOf($file);
        if($lastStatus == 'want') return false;
        Reading::saveNew([
            'file_id'=>$file->id,
            'user_id'=>$this->id,
            'status'=>'want',
            'times'=>$this->getReadingTimesFor($file,'want'),
        ]);
        if($lastStatus == 'reading') $this->save([
            'reading_count'=>$this->reading_count-1,
            'done_count'=>$this->done_count+1,
        ]);
        $this->save(['want_count'=>$this->want_count+1]);
        return true;
    }

    /**
     * @param Files $file
     * @return bool
     */
    public function reading(Files $file)
    {
        $lastStatus = $this->getLastReadingStatusOf($file);
        if($lastStatus == 'reading') return false;
        Reading::saveNew([
            'file_id'=>$file->id,
            'user_id'=>$this->id,
            'status'=>'reading',
            'times'=>$this->getReadingTimesFor($file,'reading'),
        ]);
        if($lastStatus == 'want') $this->save(['want_count'=>$this->want_count-1]);
        $this->save(['reading_count'=>$this->reading_count+1]);

        return true;
    }

    /**
     * @param Files $file
     * @return bool
     */
    public function done(Files $file)
    {
        $lastStatus = $this->getLastReadingStatusOf($file);
        if($lastStatus == 'done') return false;
        Reading::saveNew([
            'file_id'=>$file->id,
            'user_id'=>$this->id,
            'status'=>'done',
            'times'=>$this->getReadingTimesFor($file,'done'),
        ]);
        if($lastStatus <> null) {
            $property = $lastStatus.'_count';
            $this->save([
                $property=>$this->$property-1,
                'done_count'=>$this->done_count+1
            ]);
        }
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
            $lastRecord = Reading::query()
                ->where('user_id = :user:',['user'=>$this->id])
                ->andWhere('file_id = :file:',['file'=>$file->id])
                ->orderBy('id DESC')
                ->execute()->getFirst();
            if($lastRecord) return $lastRecord->status;
            return 'null';
        });

    }

    private function getLastReadingTimesOf($file)
    {
        return $this->make('lastTimes',function()use($file){
            $lastRecord = Reading::query()
                ->where('user_id = :user:',['user'=>$this->id])
                ->andWhere('file_id = :file:',['file'=>$file->id])
                ->orderBy('id DESC')
                ->execute()->getFirst();
            if($lastRecord) return $lastRecord->times;
            return 0;
        });

    }

}