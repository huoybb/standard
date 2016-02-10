<?php
use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/1/11
 * Time: 17:13
 */
class authEventsHandler
{
    public function login($event,Users $user,$data)
    {
        $remember = isset($data['remember'])?$data['remember']:'off';
        SessionFacade::set('auth',['id'=>$user->id,'name'=>$user->name]);
        if($remember == 'on'){
            $token = SecurityFacade::getToken();
            $user->save(['remember_token'=>$token]);
            CookieFacade::set('auth',['email'=>$user->email,'token'=>$token],Carbon::now()->addDay(15)->timestamp);
        }
    }

    public function logout($event)
    {
        AuthFacade::save(['remember_token'=>SecurityFacade::getToken()]);//避免cookie的盗用
        SessionFacade::remove('auth');
        CookieFacade::remove('auth');
    }

}