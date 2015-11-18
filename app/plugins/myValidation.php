<?php
use Phalcon\Validation;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/7/18
 * Time: 21:32
 */

class myValidation extends Validation{
    public $redirectUrl = NULL;//能够自定义返回的url，或者默认为上一个url
    public $excludedRoutes = [];//对于每个路由都是用的如auth等，设置的一个排除路由的设置
    protected $validatorMap = [
        'Email'=>'Phalcon\Validation\Validator\Email',
        'Exclusionin'=>'Phalcon\Validation\Validator\Exclusionin',
        'Inclusionin'=>'Phalcon\Validation\Validator\Inclusionin',
        'Numericality'=>'Phalcon\Validation\Validator\Numericality',
        'PresenceOf'=>'Phalcon\Validation\Validator\PresenceOf',
        'Regex'=>'Phalcon\Validation\Validator\Regex',
        'StringLength'=>'Phalcon\Validation\Validator\StringLength',
        'Uniqueness'=>'Phalcon\Validation\Validator\Uniqueness',
        'Url'=>'Phalcon\Validation\Validator\Url',
        'compare'=>'compare',
        'default'=>'defaultValue'
    ];

    /**接受验证规则
     * @param $rules
     */
    public function take(myValidationRules $rules)
    {
        foreach($rules->getRules() as $field => $rule ){
            $className = $this->validatorMap[$rule['validator']];
            $message = $rule['message'];
            $this->add($field,new $className(['message'=>$message]));
        }
        return $this;
    }

    public function isValid($data)
    {
        $messages = $this->validate($data);
        if(count($messages)){
            foreach($messages as $message){
                $this->flash->error($message->getMessage());
            }
            return false;
        }else{
            return true;
        }
    }

    /**如果有设置，则返回设置地址，否则返回上一个页面
     * @return mixed
     */
    public function getRedirectedUrl()
    {
        return  $this->redirectUrl ?: $_SERVER['HTTP_REFERER'];
    }

} 