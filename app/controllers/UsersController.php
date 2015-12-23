<?php

class UsersController extends myController
{

    public function indexAction()
    {

    }

    public function loginAction()
    {
        if($this->request->isPost()){
            $data = $this->request->getPost();
            $user = Users::findByEmail($data['email']);

            if($this->security->checkHash($data['password'],$user->password)){
                $this->flash->success('欢迎'.$user->name.'登录！你上次登录的时间是：'.$user->updated_at);

                $remember = 'off';
                if(isset($data['remember'])) $remember = $data['remember'];

                $this->registerSession($user,$remember);

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
        $this->distroySession();
        $this->redirectByRoute(['for'=>'login']);
    }

    public function registerAction()
    {

    }

    private function registerSession(Users $user,$remember)
    {
        $this->session->set('auth',['id'=>$user->id,'name'=>$user->name]);
        if($remember == 'on'){
            $token = $this->security->getToken();
            $user->save(['remember_token'=>$token]);
            $this->cookies->set('auth[email]',$user->email,time() + 15 * 86400);
            $this->cookies->set('auth[token]',$token,time() + 15 * 86400);
        }
    }

    private function distroySession()
    {
        $this->auth->save(['remember_token'=>$this->security->getToken()]);
        $this->session->remove('auth');
        $this->cookies->get('auth[email]')->delete();
        $this->cookies->get('auth[token]')->delete();
    }
}

