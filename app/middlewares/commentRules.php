<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/9/10
 * Time: 20:25
 */
class commentRules extends myValidationRules
{
    public $rules = [
        'content'=>['validator'=>'PresenceOf','message'=>'请填写评论的内容！']
    ];
}