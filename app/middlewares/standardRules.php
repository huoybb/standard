<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/9/8
 * Time: 19:03
 */

class standardRules extends myValidationRules
{
    public $rules = [
        'title'=>['validator'=>'PresenceOf','message'=>'评论内容不能为空！']
    ];

}