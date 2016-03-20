<?php


class Users extends myModel
{

    use ReadingTraitForUser;
    use SubsribeTraitForUser;
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
    public $role;
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

    public static function createNewUser(array $data)
    {
        return static::saveNew([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>SecurityFacade::hash($data['password']),
            'role'=>$data['role']
        ]);
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
            'role' => 'role',
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
//        $key = 'standard:users:'.AuthFacade::getService()->id.':tags';
//        return $this->cache($key,function(){
//            return $this->getMyTagsFromDatabase();
//        });

        if(!TagsCacheFacade::isTagsExist()){
            TagsCacheFacade::setTags($this->getMyTagsFromDatabase());
        }
        return TagsCacheFacade::getTags();
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







}
