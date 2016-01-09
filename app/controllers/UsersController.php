<?php

class UsersController extends myController
{

    public function loginAction()
    {
        if($this->request->isPost()){
            $data = $this->request->getPost();
            $user = Users::findByEmail($data['email']);
            if($user AND $this->security->checkHash($data['password'],$user->password)){
                $this->flash->success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);
                $remember = isset($data['remember'])?$data['remember']:'off';
                (new IsLoginValidator())->registerSession($user,$remember);
                $this->redirectByRoute(['for'=>'home']);
            }else{
                $this->flash->error('登录不成功，密码或者邮件地址有误！');
            }
        }

        if($this->session->has('auth')) $this->redirectByRoute(['for'=>'home']);

        $this->view->form = myForm::buildLoginForm();
    }
    public function logoutAction()
    {
        (new IsLoginValidator())->destroySession();
        $this->redirectByRoute(['for'=>'login']);
    }

    public function showTagAction(Users $user,Tags $tag,$page =1)
    {
        $this->view->mytag = $tag;
        $this->view->page = $this->getPaginator($tag->getTaggedFiles($user),25,$page);
        $this->view->form = myForm::buildCommentForm($tag);//这个应该去掉
    }

}

