<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Login test!');
$I->amOnPage('login');
$I->fillField('email','zhaobing024@gmail.com');
$I->fillField('password','123456');
$I->click('Login');
$I->see('欢迎赵兵登录');
$I->canSeeInCurrentUrl('/');
//$I->seeInDatabase('users',['email'=>'zhaobing024@gmail.com']);
