<?php

class ReadingController extends \Phalcon\Mvc\Controller
{

    public function wantAction(Files $file)
    {
        dd(AuthFacade::wantToRead($file));
    }
    public function readingAction(Files $file)
    {
        dd(AuthFacade::reading($file));
    }
    public function doneAction(Files $file)
    {
        dd(AuthFacade::done($file));
    }




}

