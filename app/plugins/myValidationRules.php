<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/9/10
 * Time: 20:30
 */
abstract class myValidationRules
{
    public $rules = [];
    public function getRules()
    {
        return $this->rules;
    }

}