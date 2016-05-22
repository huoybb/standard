<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/22
 * Time: 6:57
 */
trait commentableTrait
{
    public function hasComments()
    {
        return $this->commentCount > 0;
    }

    /**
     * 获取该模型的所有评论
     * 这个其实也可以变成一个通用的方法落实在myModel中的
     * @return null|Phalcon\Mvc\Model\Resultset\Complex
     */
    public function comments()
    {
        /** @var myModel $this */
        return $this->make('comments',function(){
            return Comments::query()
                ->leftJoin('Users','Users.id = Comments.user_id')
                ->where('Comments.commentable_id = :id:')
                ->andWhere('Comments.commentable_type = :type:')
                ->bind(['id'=>$this->id,'type'=>get_class($this)])
                ->orderBy('Comments.updated_at Desc')
                ->columns(['Comments.*','Users.*'])
                ->execute();
        });

    }

    public function addComment($data)
    {
        /** @var myModel $this */
        $comment = new Comments();
        $comment->content=$data['content'];
        $comment->commentable_id = $this->id;
        $comment->commentable_type = get_class($this);
//        $comment->user_id = $this->getDI()->getShared('session')->get('auth')['id'];//获得当前登录对象的id
        $user = \Phalcon\Di::getDefault()->get('auth');
        $comment->user_id = $user->id;//获得当前登录对象的id
//        dd($comment);
        $comment->save();
        /** @var myModel $this */
        if(method_exists($this,'increaseCount')){
            $this->increaseCount('commentCount');
        }else{
            $this->save();//更新时间
        }

        if(is_a($this,'Tags')){
            $meta = $this->getTagmetaOrNew();
            $meta->save();
        }
        return $comment;
    }

    public function deleteComment(Comments $comment)
    {
        /** @var myModel $this */
        if(method_exists($this,'decreaseCount')) $this->decreaseCount('commentCount');
        return $comment->delete();
    }

    public function getAddCommentFormUrl()
    {
        /** @var myModel $this */
        $modelName = strtolower(get_class($this));
        $modelNameSingleForm = $modelName;
        if(preg_match('|.*s|',$modelName)){
            $modelNameSingleForm = substr_replace($modelName,'',-1);
        }
        //修正file-standard的关系
        if($modelName == 'files') $modelName = 'standards';
//        dd($modelName.' - '.$modelNameSingleForm);
        return UrlFacade::get(['for'=>$modelName.'.addComment',$modelNameSingleForm=>$this->id]);
    }

    public function beforeDeleteForComments()
    {
        $comments = $this->comments();
        if($comments){
            foreach($comments as $c){
                $c->comments->delete();
            }
        }
        return $this;
    }


}