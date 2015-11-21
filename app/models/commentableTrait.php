<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 6:57
 */
trait commentableTrait
{
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
    public function getAddCommentFormUrl()
    {
        /** @var myModel $this */
        $modelName = strtolower(get_class($this));
        $modelNameSingleForm = substr_replace($modelName,'',-1);
        //修正file-standard的关系
        if($modelName == 'files') $modelName = 'standards';
//        dd($modelName.' - '.$modelNameSingleForm);
        return $this->getDI()->get('url')->get(['for'=>$modelName.'.addComment',$modelNameSingleForm=>$this->id]);
    }

}