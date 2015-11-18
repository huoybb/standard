<?php
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/9/6
 * Time: 11:01
 */
class myForm
{
    static public function buildCommentForm(myModel $entity = null,Comments $comment = null){
        if ($comment == null) {
            $form = new Form();
            $form->add(new Submit('Add Comment'));
            if (null != $entity) {
                $form->Url = $entity->getAddCommentFormUrl();
            }
        }else{
            $form = new Form($comment);
            $form->add(new Submit('修改'));
        }

        $content = new TextArea('content');
        $content->addValidator(new PresenceOf(['message'=>'评论内容不能为空']));//这里也是一个增加验证的地方
        $form->add($content);
        return $form;
    }

    static public function buildFormFromModel(myModel $model)
    {
        if($model->id){
            $form = new Form($model);
        }else{
            $form = new Form();
        }

        $fields =[];
        foreach($model->columnMap() as $column){
            $metaDataTypes = $model->getModelsMetaData()->getDataTypes($model);
            if(!in_array($column,['created_at','updated_at','id','password','remember_token'])){
                if($metaDataTypes[$column] <> 6){
                    $form->add(new Text($column));
                }else{
                    $form->add(new TextArea($column));
                }

                $fields[]=$column;
            };
        }
        $form->fields =$fields;
        if($model->id){
            $form->add(new Submit('修改'));
        }else{
            $form->add(new Submit('增加'));
        }
        return $form;
    }
}