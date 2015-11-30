<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/30
 * Time: 8:14
 */
trait FileableInterfaceTrait
{
    public function getHtml($key)
    {
        if($key == 'abstract' OR $key == 'Abstract'){
            if($this->$key == null) return null;
            return '<pre>'.$this->$key.'</pre>';
        }


        if($key == 'Subject_Categories'){
            $result = '';
            foreach(preg_split('/<br>\s*/m', $this->$key) as $category){
                $result .='<span>'.trim($category).'</span>';
            }
            return $result;
        }

        if($key == 'keywords'){
            $result ='';
            $words = explode(' ',$this->$key);
            foreach($words as $word){
                $result .='<span><a href="http://standard.zhaobing/search/'.$word.'">'.$word.'</a></span> ';
            }
            return $result;
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

    /**
     * @return Files
     */
    public function getStandard()
    {
        return Files::findFirst($this->file_id);
    }

}