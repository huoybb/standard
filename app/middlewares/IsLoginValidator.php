<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/8/13
 * Time: 18:59
 *
 * 这里都是采用硬编码的方式，需要转换为phalcon的编码形式，包括变量的获取，转移地址设置等
 */

class IsLoginValidator extends myValidation{

    public function isValid($data = null)
    {
        if($this->session->has('auth')) return true;
        if($this->cookies->has('auth')) {
            $auth = $this->cookies->get('auth')->getValue();
            $user = Users::findByCookieAuth($auth);
            $this->flash->success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);
            $this->session->set('auth',['id'=>$user->id,'name'=>$user->name]);
            //登录
//            $token = $this->security->getToken();
//            $this->cookies->set('auth[token]',$token,time() + 15 * 86400);
//            $user->save(['remember_token'=>$token]);
            return true;
        }
        return false;
    }

    public function initialize()
    {
        $this->redirectUrl = 'http://standard.zhaobing/login';
        $this->excludedRoutes = ['login','standards.getWebData'];
    }

} 