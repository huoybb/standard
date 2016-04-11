<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:10
 */
abstract class myPresenter
{
    protected $entity;

    /**
     * BaiduxueshuPresenter constructor.
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }
    public function __get($property)
    {
        if(method_exists($this,$property)){
            return $this->{$property}();
        }

        if(property_exists($this->entity,$property)) {
            if($this->entity->$property)  return $this->entity->$property;
            return null;
        }

        if(method_exists($this->entity,'getFileable') && $this->entity->getFileable()){
            return $this->entity->getFileable()->present()->$property;
        }
    }
    public function get($key)
    {
        if($key == 'abstract' OR $key == 'Abstract'){
            if($this->$key == null) return null;
            $maxLength = 200;//最大显示长度

            if(mb_strlen($this->$key) > $maxLength){
                return '<div class="abstract" style="display: block;">'.
                '<pre>'.myTools::cut($this->$key,$maxLength).'  <a href="#" id="expand">展开</a></pre>'.'</div><div class="abstract" style="display: none;">'.
                '<pre>'.$this->$key.'  <a href="#" id="collaps">收起</a></pre></div>';
            }

            return '<pre>'.myTools::cut($this->$key,$maxLength).'</pre>';

        }


        if($key == 'Subject_Categories'){
            $result = '';
            foreach(preg_split('/<br>\s*/m', $this->$key) as $category){
                $result .='<span>'.trim($category).'</span>';
            }
            return $result;
        }

        if($key == 'keywords'){
            $delimiter = ' ';
            if(static::class == 'Baiduxueshu') $delimiter = '/';
            $result =[];
            $words = explode($delimiter,$this->$key);
            foreach($words as  $word){
                $word = trim($word);
                $result[] = '<span><a class="btn-link" href="http://standard.zhaobing/search/'.$word.'">'.$word.'</a></span>';
            }
            return implode(' ',$result);
        }

        if($key == 'Descriptors'){
            $result = '';
            $words = explode(',',$this->$key);
            foreach($words as $word){
                $word = preg_replace('|^.+\*|','',$word);
                $result .='<span><a href="http://standard.zhaobing/search/'.$word.'">'.$word.'</a></span> ';
            }
            return $result;
        }

        return $this->$key;
    }

}