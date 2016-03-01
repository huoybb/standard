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
                FlashFacade::success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);
                EventFacade::fire('auth:login',$user,$data);
                return $this->redirectByRoute(['for'=>'home']);
            }else{
                $this->flash->error('登录不成功，密码或者邮件地址有误！');
            }
        }

        $this->view->form = myForm::buildLoginForm();
    }
    public function logoutAction()
    {
        EventFacade::fire('auth:logout',$this);
        $this->redirectByRoute(['for'=>'login']);
    }

    public function createNewUserAction()
    {
        if($this->request->isPost()){
            $data = $this->request->getPost();
            if(!(Users::findByEmail($data['email']))){
                Users::createNewUser($data);
                return $this->redirectByRoute(['for'=>'home']);
            }
        }
        $this->view->form = myForm::buildCreateNewUserForm();
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
        $this->view->notifications =AuthFacade::getNotifications();
    }
    public function doneNotificationAction(Notification $notification)
    {
        $notification->save(['status'=>true]);
        return $this->redirectByRoute(['for'=>'tags.show','tag'=>$notification->getTagID()]);
    }
}

