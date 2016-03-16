<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Make sure Login page works, when not login!');
$I->amOnPage('/');
$I->see('登录页面');
