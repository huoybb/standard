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
        if(SessionFacade::has('auth')) return true;
        if(CookieFacade::has('auth')) {
            $user = Users::findByCookieAuth($this->getCookie());
            if(!$user) return false;
            FlashFacade::success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);

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
        SessionFacade::set('auth',['id'=>$user->id,'name'=>$user->name]);
        if($remember == 'on'){
            $this->setCookie($user);
        }
    }

    public function destroySession()
    {
        AuthFacade::save(['remember_token'=>$this->security->getToken()]);
        SessionFacade::remove('auth');
        CookieFacade::remove('auth');
    }

    private function getCookie()
    {
        return (array)CookieFacade::getCookie('auth');
    }
    private function setCookie(Users $user)
    {
        $token = SecurityFacade::getToken();
        $user->save(['remember_token'=>$token]);
        CookieFacade::setCookie('auth',['email'=>$user->email,'token'=>$token],Carbon::now()->addDay(15)->timestamp);
    }

} 