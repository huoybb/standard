<?php
use Phalcon\Ext\Mailer\Manager;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/28
 * Time: 15:31
 */
class myMailer
{
    private $mailer = null;
    /**
     * myMailer constructor.
     */
    public function __construct()
    {
        $config = ConfigFacade::getService()->mailConfig->toArray();
        $this->mailer = new Manager($config);
    }

    public function sendMail(Users $user, Activity $activity)
    {
        $message = $this->mailer->createMessage()
            ->to($user->email,$user->name)
            ->subject("你关注的主题:{$activity->object_type}-{$activity->object_id},有更新")
            ->content($activity->doing);

//        $message->cc('zhaobing024@gmail.com','赵兵');
//        $message->bcc('example_bcc@gmail.com');
        $message->send();
    }
    public function sendResetPasswordMail(Users $user)
    {
        $token = SecurityFacade::getToken();
        $user->save([
            'remember_token'=>$token,
            'accountStatus'=>'密码修订中'
        ]);

        $urlToken = myTools::getUrlEncodedToken($token,$user);
        $url = 'http://standard.zhaobing'.UrlFacade::get(['for'=>'users.resetPassword','token'=>$urlToken]);
        $message = $this->mailer->createMessage()
            ->to($user->email,$user->name)
            ->subject('密码重置')
            ->content($url)
            ->send();
    }

}