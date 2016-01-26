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
            'updated_at' => 'updated_at'
        );
    }

    /**这个函数的执行时间会比较长，这个需要缓冲一下来加速
     * @return mixed
     */
    public function getMyTags()
    {
        if(!redisFacade::isTagsExist()){
            $data = Tagmetas::query()
                ->leftJoin('Tags','Tags.id = Tagmetas.tag_id')
                ->where('Tagmetas.user_id = :user:',['user'=>$this->id])
                ->orderBy('Tagmetas.updated_at DESC')
                ->columns(['Tags.*','Tagmetas.*'])
                ->execute();
            redisFacade::setTags($data);
        }
        return redisFacade::getTags();
    }
    
    public function has($object)
    {
        return $object->user_id == $this->id;
    }
    

}
