<?php

class Searchlog extends myModel
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
    public $keywords;

    /**
     *
     * @var string
     */
    public $extra;

    /**
     *
     * @var integer
     */
    public $user_id;

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
     * @param Users $user
     * @return Searchlog
     */
    public static function getLastSearch(Users $user)
    {
        return static::query()
            ->where('user_id = :user:',['user'=>$user->id])
            ->orderBy('created_at DESC')
            ->execute()->getFirst();
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'searchlog';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Searchlog[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Searchlog
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
            'keywords' => 'keywords',
            'extra' => 'extra',
            'user_id' => 'user_id',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        );
    }

    public static function getLast5Searched()
    {
        return static::query()
            ->orderBy('created_at DESC')
            ->limit(5)
            ->execute();
    }
    public static function getMostSearched(){
        return static::query()
            ->groupBy('keywords')
            ->columns(['keywords','count(*) AS num'])
            ->orderBy('num DESC')
            ->limit(5)
            ->execute();
    }


}
