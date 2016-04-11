<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/11/30
 * Time: 8:14
 */
trait FileableInterfaceTrait
{
//    public function getHtml($key)
//    {
//        if(null == $this->$key) return null;
//
//        if($key == 'abstract' OR $key == 'Abstract'){
//            if($this->$key == null) return null;
//            $maxLength = 200;//最大显示长度
//
//            if(mb_strlen($this->$key) > $maxLength){
//                return '<div class="abstract" style="display: block;">'.
//                    '<pre>'.myTools::cut($this->$key,$maxLength).'  <a href="#" id="expand">展开</a></pre>'.'</div><div class="abstract" style="display: none;">'.
//                '<pre>'.$this->$key.'  <a href="#" id="collaps">收起</a></pre></div>';
//            }
//
//            return '<pre>'.myTools::cut($this->$key,$maxLength).'</pre>';
//
//        }
//
//
//        if($key == 'Subject_Categories'){
//            $result = '';
//            foreach(preg_split('/<br>\s*/m', $this->$key) as $category){
//                $result .='<span>'.trim($category).'</span>';
//            }
//            return $result;
//        }
//
//        if($key == 'keywords'){
//            $delimiter = ' ';
//            if(static::class == 'Baiduxueshu') $delimiter = '/';
//            $result =[];
//            $words = explode($delimiter,$this->$key);
//            foreach($words as  $word){
//                $word = trim($word);
//                $result[] = '<span><a class="btn-link" href="http://standard.zhaobing/search/'.$word.'">'.$word.'</a></span>';
//            }
//            return implode(' ',$result);
//        }
//
//        if($key == 'Descriptors'){
//            $result = '';
//            $words = explode(',',$this->$key);
//            foreach($words as $word){
//                $word = preg_replace('|^.+\*|','',$word);
//                $result .='<span><a href="http://standard.zhaobing/search/'.$word.'">'.$word.'</a></span> ';
//            }
//            return $result;
//        }
//
//
//
//        return $this->$key;
//    }

    /**
     * @return Files
     */
    public function getStandard()
    {
        return Files::findFirst($this->file_id);
    }

    public function getDBName()
    {
        return static::getDatabaseName();
    }

    public function getModelType()
    {
        $name = static::class;
        return myParser::getModelType($name);
    }

    public function getClassName()
    {
        return get_class($this);
    }

    public static function findBySourceId($souceId)
    {
        return static::query()
            ->where('source_id = :id:',['id'=>$souceId])
            ->execute()->getFirst();
    }

    public function getStatisticsByMonth()
    {
        return (new Files())->getStaticsByMonth($this->getClassName());
    }

    public function delete()
    {
        EventFacade::trigger(new fileableDeleteEvent($this));
        parent::delete();
    }




}