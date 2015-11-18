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
        'content'=>['validator'=>'PresenceOf','message'=>'标准标题不能为空！']
    ];
}