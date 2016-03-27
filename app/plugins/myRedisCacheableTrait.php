<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/27
 * Time: 23:41
 */
trait myRedisCacheableTrait
{
    public function cache($key,$value,$encodeMethod = 'igbinary')
    {
        $encode = [
            'igbinary'=>[
                'encode'=>'igbinary_serialize',
                'decode'=>'igbinary_unserialize',
            ],
            'json'=>[
                'encode'=>'json_encode',
                'decode'=>'json_decode',
            ],
        ];
        if(RedisFacade::exist($key) == false){
            RedisFacade::set($key,$encode[$encodeMethod]['encode']($value));
        }
        return $encode[$encodeMethod]['decode'](RedisFacade::get($key));
    }
}