<?php


class Users extends myModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $remember_token;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;
    /**
     *
     * @var int
     */
    public $want_count;
    /**
     *
     * @var int
     */
    public $reading_count;
    /**
     *
     * @var int
     */
    public $done_count;

    /**
     * @param $email
     * @return Users
     */
    public static function findByEmail($email)
    {
        return static ::query()
            ->where('email = :email:',['email'=>$email])
            ->execute()->getFirst();
    }

    public static function isLoginByCookie(array $cookie)
    {
        $rows = static::query()
            ->where('email = :email:',['email'=>$cookie['email']])
            ->andWhere('remember_token = :token:',['token'=>$cookie['token']])
            ->execute();
        return $rows->count() > 0 ;
    }

    /**
     * @param array $cookie
     * @return Users
     */
    public static function findByCookieAuth(array $cookie)
    {
        return static::query()
            ->where('email = :email:',['email'=>$cookie['email']])
            ->andWhere('remember_token = :token:',['token'=>$cookie['token']])
            ->execute()->getFirst();
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',
            'remember_token' => 'remember_token',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'want_count' => 'want_count',
            'reading_count' => 'reading_count',
            'done_count' => 'done_count',
        );
    }

    /**这个函数的执行时间会比较长，这个需要缓冲一下来加速
     * 将数据库获取的时间用缓存的这种空间换时间的方式来
     * @return mixed
     */
    public function getMyTags()
    {
        if(!RedisFacade::isTagsExist()){
            RedisFacade::setTags($this->getMyTagsFromDatabase());
        }
        return RedisFacade::getTags();
    }
    
    public function has($object)
    {
        return $object->user_id == $this->id;
    }

    private function getMyTagsFromDatabase()
    {
        return Tagmetas::query()
            ->leftJoin('Tags','Tags.id = Tagmetas.tag_id')
            ->where('Tagmetas.user_id = :user:',['user'=>$this->id])
            ->orderBy('Tagmetas.updated_at DESC')
            ->columns(['Tags.*','Tagmetas.*'])
            ->execute();
    }

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
