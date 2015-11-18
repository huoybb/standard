<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/7/16
 * Time: 13:44
 */
use Carbon\Carbon;
use Phalcon\Mvc\Model;

abstract class myModel extends Model{

    protected $instance = [];

    abstract public function columnMap();//增加一个强制项要求，这个也许不是一个好主意！！
    //files tags 需要改写这个函数，便于编程
    public function getAddCommentFormUrl()
    {
        return '/';
    }

    /*
     * 仿照Laravel对时间的数据进行处理，便于将来的使用
     */
    public $created_at = null;
    public function beforeSave()
    {
        if($this->created_at != null) {
            if(is_a($this->created_at,'\Carbon\Carbon'))
                $this->created_at = $this->created_at->toDateTimeString();
        }else{
            $this->created_at = Carbon::now()->toDateTimeString();
        }

        $this->updated_at = Carbon::now()->toDateTimeString();
    }

    public function afterFetch()
    {
        if(isset($this->created_at)) $this->created_at = Carbon::parse($this->created_at);
        if(isset($this->updated_at)) $this->updated_at = Carbon::parse($this->updated_at);
    }


    /**
     * 获取该模型的所有评论
     * 这个其实也可以变成一个通用的方法落实在myModel中的
     * @return null|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function comments()
    {
        return $this->make('comments',function(){
            return Comments::query()
                ->where('commentable_id = :tag_id:')
                ->andWhere('commentable_type = :type:')
                ->bind(['tag_id'=>$this->id,'type'=>get_class($this)])
                ->orderBy('updated_at Desc')
                ->execute();
        });

    }

    public function addComment($data)
    {
        $comment = new Comments();
        $comment->content=$data['content'];
        $comment->commentable_id = $this->id;
        $comment->commentable_type = get_class($this);
        $comment->user_id = $this->getDI()->getShared('session')->get('auth')['id'];//获得当前登录对象的id
        $comment->save();
        return $this;
    }

    public function getClassName()
    {
        return get_class($this);
    }

    //增加缓存，避免重复查询，例如在files下索取comments、tags、revs等需要增加一个缓存来减少数据库的查询次数
    public function make($object,Closure $closure)
    {
        if(!isset($this->instance[$object])){
            $this->instance[$object] = $closure();
        }
        return $this->instance[$object];
    }

    static public function saveNew($data){
        $instance = new static();
        return $instance->save($data);
    }




} 