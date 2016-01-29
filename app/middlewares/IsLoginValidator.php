<?php
use Carbon\Carbon;

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
            $user = Users::findByCookieAuth($this->getCookie());
            if(!$user) return false;
            $this->flash->success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);

            //利用cookie实现登录
            EventFacade::fire('auth:login',$user,['remember'=>'on']);
            return true;
        }
        return false;
    }

    public function initialize()
    {
        $this->redirectUrl = 'http://standard.zhaobing/login';
        $this->excludedRoutes = ['login','standards.getWebData'];
    }


    public function registerSession(Users $user,$remember)
    {
        $this->session->set('auth',['id'=>$user->id,'name'=>$user->name]);
        if($remember == 'on'){
            $this->setCookie($user);
        }
    }

    public function destroySession()
    {
        $this->auth->save(['remember_token'=>$this->security->getToken()]);
        $this->session->remove('auth');
        CookieFacade::get('auth[email]')->delete();
        CookieFacade::get('auth[token]')->delete();
    }

    private function getCookie()
    {
        $auth = CookieFacade::get('auth')->getValue();
        foreach($auth as $key=>$value){
            $auth[$key]=$this->crypt->decrypt($value);
        }
        return $auth;
    }
    private function setCookie(Users $user)
    {
        $token = $this->security->getToken();
        $user->save(['remember_token'=>$token]);
        setcookie('auth[email]',$this->crypt->encrypt($user->email), Carbon::now()->addDay(15)->timestamp);
        setcookie('auth[token]',$this->crypt->encrypt($token),Carbon::now()->addDay(15)->timestamp);
    }

} 