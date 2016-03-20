<?php
use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/8/13
 * Time: 18:59
 *
 */

class isLoggedin extends myValidation{

    public function isValid($data = null)
    {
        if(SessionFacade::has('auth')) return true;
        if(CookieFacade::has('auth')) {
            $user = Users::findByCookieAuth((array)CookieFacade::get('auth'));
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
        $this->redirectUrl = UrlFacade::get(['for'=>'login']);
        $this->excludedRoutes = ['login','standards.getWebData'];
    }
} 