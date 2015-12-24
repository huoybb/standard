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
            $auth = $this->getCookie();
            $user = Users::findByCookieAuth($auth);
            if(!$user) return false;
            $this->flash->success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);
            $this->session->set('auth',['id'=>$user->id,'name'=>$user->name]);
            //登录
            $this->setCookie($user);
            return true;
        }
        return false;
    }

    public function initialize()
    {
        $this->redirectUrl = 'http://standard.zhaobing/login';
        $this->excludedRoutes = ['login','standards.getWebData'];
    }

    private function getCookie()
    {
        $auth = $this->cookies->get('auth')->getValue();
        foreach($auth as $key=>$value){
            $auth[$key]=$this->crypt->decrypt($value);
        }
        return $auth;
    }
//这部分与usercontroller中的东西有重复
    private function setCookie(Users $user)
    {
        $token = $this->security->getToken();
        $user->save(['remember_token'=>$token]);
        $this->cookies->set('auth[email]',$this->crypt->encrypt($user->email),time() + 15 * 86400);
        $this->cookies->set('auth[token]',$this->crypt->encrypt($token),time() + 15 * 86400);

    }


} 