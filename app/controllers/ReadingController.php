<?php

class ReadingController extends myController
{

    public function wantAction(Files $file)
    {
        if(AuthFacade::wantToRead($file)) return $this->success();
        return $this->failed();
    }
    public function readingAction(Files $file)
    {
        if(AuthFacade::reading($file)) return $this->success();
        return $this->failed();
    }
    public function doneAction(Files $file)
    {
        if(AuthFacade::done($file)) return $this->success();
        return $this->failed();
    }

    public function wantlistAction()
    {
        $this->view->files = AuthFacade::getReadingList('want');
    }





}

