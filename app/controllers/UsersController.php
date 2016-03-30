<?php

class UsersController extends myController
{

    public function loginAction()
    {
        if(SessionFacade::has('auth')) {
            FlashFacade::error('您已经登录过了，如果想要重新登录，请先退出登录状态！logout！');
            return $this->redirectByRoute(['for'=>'home']);
        }

        if($this->request->isPost()){
            $data = $this->request->getPost();
            $user = Users::findByEmail($data['email']);
            if($user AND SecurityFacade::checkHash($data['password'],$user->password)){
                if($user->accountStatus != '正常'){
                    FlashFacade::error('你的帐户目前不正常，不能正常登录，请联系系统管理员');
                    return $this->redirectByRoute(['for'=>'login']);
                }
                FlashFacade::success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);
                EventFacade::trigger(new loginEvent($user,$data));
                return $this->redirectByRoute(['for'=>'home']);
            }else{
                $this->flash->error('登录不成功，密码或者邮件地址有误！');
            }
        }

        $this->view->form = myForm::buildLoginForm();
    }
    public function logoutAction()
    {
        EventFacade::trigger(new logoutEvent(AuthFacade::getService()));
        $this->redirectByRoute(['for'=>'login']);
    }




    public function showTagAction(Users $user,Tags $tag,$page =1)
    {
        $this->view->mytag = $tag;
        $this->view->page = $this->getPaginator($tag->getTaggedFiles($user),25,$page);
        $this->view->form = myForm::buildCommentForm($tag);//这个应该去掉
        $this->view->user = $user;
    }

    public function readNotificationAction()
    {
        $this->view->notifications = AuthFacade::getNotifications();
    }
    public function doneNotificationAction(Notification $notification)
    {
        AuthFacade::readNotification($notification);
        $ObjectType = AuthFacade::getNotificationObjectType($notification);

        if($ObjectType == 'Tags'){
            return $this->redirectByRoute(['for'=>'tags.show','tag'=>$notification->getTagID()]);
        }
        if($ObjectType == 'Files'){
            return $this->redirectByRoute(['for'=>'standards.show','file'=>$notification->getTagID()]);
        }
    }

    public function createNewUserAction()
    {
        if($this->request->isPost()){
            $data = $this->request->getPost();
            if(!(Users::findByEmail($data['email']))){
                Users::createNewUser($data);
                return $this->redirectByRoute(['for'=>'users.manageUsers']);
            }
            FlashFacade::warning('邮件地址有重复，请重新填写');
        }
        $this->view->form = myForm::buildCreateNewUserForm();
    }
    public function manageUsersAction()
    {
        $this->view->users = Users::find();
    }
    public function deleteUserAction(Users $user)
    {
        if($user->role == '用户') {
            $user->delete();
            //@todo 决策：是否需要将这个用户的信息都删除，比如评论、上传的附件等？还是仅仅将账户信息锁死就可以啦？
        }
        return $this->redirectByRoute(['for'=>'users.manageUsers']);
    }
    public function sendPasswordResetEmailAction(Users $user)
    {
        if($user->role == '用户'){
            (new myMailer())->sendResetPasswordMail($user);
        }
        return $this->redirectByRoute(['for'=>'users.manageUsers']);
    }

    public function resetPasswordAction($token)
    {
        $user = Users::getUserFromResetPasswordToken($token);

        if($user->updated_at < \Carbon\Carbon::now()->addDay(-1)){
            FlashFacade::error('token已经过期，请重新申请密码重置');
            return $this->redirectByRoute(['for'=>'login']);
        }

        if($this->request->isPost()){
            $data = $this->request->getPost();
            if(!$this->security->checkToken()){
                FlashFacade::error('非法侵入');
                return $this->redirectByRoute(['for'=>'login']);
            }
            if($data['password1'] == $data['password2']){
                $user->savePasswordAndCleanToken($data['password1']);
                FlashFacade::success('密码设置成功，请登录！');
                return $this->redirectByRoute(['for'=>'login']);
            }
            FlashFacade::error('两次密码输入不一致');
        }
        $this->view->form = myForm::buildResetPasswordForm();
    }
    public function userRequestResetPasswordAction()
    {
        if($this->request->isPost()){
            $data = $this->request->getPost();
            //@todo 确保邮件地址是正确的 ，并且数据库中存在这个邮件；
            $user = Users::findFirst(['email = :email:','bind'=>['email'=>$data['email']]]);
            if(!$user) {
                dd("邮件地址:{$data['email']},不存在");
            }
            (new myMailer())->sendResetPasswordMail($user);
            FlashFacade::success('邮件发送成功，请查收邮件并点击链接！');
            $this->redirectByRoute(['for'=>'login']);
        }
        $this->view->form = myForm::buildUserRequestResetPasswordForm();
    }
}

