<?php

class IndexController extends myController
{

    public function indexAction($page = 1)
    {

//        $user = $this->auth;
//        $tags = Taggables::query()
//            ->leftJoin('Tags','tag.id = Taggables.tag_id','tag')
//            ->where('user_id = :user:',['user'=>$user->id])
//            ->columns(['tag.*','Count(tag.id) AS count'])
//            ->groupBy('tag.id')
//            ->execute();
////        dd($tags);
//        foreach($tags as $t){
//            $meta = $t->tag->getTagmetaOrNew();
//            $meta->save(['taggableCount'=>$t->count]);
//        }

        $builder = $this->modelsManager->createBuilder()
            ->from('Files')
            ->orderBy('id DESC');
        $this->view->page = $this->getPaginatorByQueryBuilder($builder,25,$page);
        $this->view->page->statistics = myParser::getStatistics();
    }
}

