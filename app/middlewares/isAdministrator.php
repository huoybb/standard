<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/2/27
 * Time: 7:10
 */
class isAdministrator extends myValidation{

    public function isValid($data = null)
    {
        if(SessionFacade::has('auth') AND  AuthFacade::getService()->role == '管理员') return true;
        FlashFacade::error('您的权限不能访问的链接:'.RequestFacade::getURI());
        return false;
    }

    public function initialize()
    {
        $this->redirectUrl = UrlFacade::get(['for'=>'home']);
    }

}