<?php
use Phalcon\Mvc\Router;

$router = new myRouter(false);

$router->bindProvider(FilesInterface::class,Files::class);

$router->removeExtraSlashes(true);
$router->addMiddlewaresForEveryRoute([isLoggedin::class]);

$router->add('/page/{page:[0-9]+}','index::index')->setName('index');
$router->add('/','index::index')->setName('home');

$router->add('/search/{search:[^/]+}','standards::search')->setName('standards.search.index');
$router->add('/search/{search:[^/]+}/page/{page:[0-9]+}','standards::search')->setName('standards.search');
$router->add('/search/{search:[^/]+}/{item:[0-9]+}','standards::showSearchItem')->setName('standards.showSearchItem');

$router->addx('/standards/add','standards::add',[standardRules::class])->setName('standards.add');
$router->add('/standards/addWebData/{type}/{source_id}','standards::getWebData')->setName('standards.getWebData');

$router->add('/standards/archive/{month:[-0-9]+}','standards::archive')->setName('standards.archive');
$router->add('/standards/archive/{month:[-0-9]+}/page/{page:[0-9]+}','standards::archive')->setName('standards.archive.page');

$router->add('/standards/{file:[0-9]+}','standards::show')->setName('standards.show');
$router->addx('/standards/{file:[0-9]+}/edit','standards::edit',[standardRules::class])->setName('standards.edit');
$router->add('/standards/{file:[0-9]+}/delete','standards::delete')->setName('standards.delete');
$router->add('/standards/{file:[0-9]+}/updateFromWeb','standards::updateFromWeb')->setName('standards.updateFromWeb');

$router->add('/standards/{file:[0-9]+}/readinglog','standards::readinglog')->setName('standards.readinglog');

$router->addx('/standards/{file:[0-9]+}/addComment','standards::addComment',[commentRules::class])->setName('standards.addComment');
$router->addx('/standards/{file:[0-9]+}/comments/{comment:[0-9]+}/edit','standards::editComment',[commentRules::class])->setName('standards.editComment');
$router->add('/standards/{file:[0-9]+}/comments/{comment:[0-9]+}/delete','standards::deleteComment')->setName('standards.deleteComment');

$router->add('/standards/{file:[0-9]+}/Attachments','standards::showAttachments')->setName('standards.showAttachments');
$router->add('/standards/{file:[0-9]+}/addAttachment','standards::addAttachment')->setName('standards.addAttachment');
$router->add('/standards/{file:[0-9]+}/Attachments/{attachment:[0-9]+}/edit','standards::editAttachment')->setName('standards.editAttachment');
$router->add('/standards/{file:[0-9]+}/Attachments/{attachment:[0-9]+}/delete','standards::deleteAttachment')->setName('standards.deleteAttachment');
$router->add('/standards/{file:[0-9]+}/Attachments/{attachment:[0-9]+}/download','standards::downloadSingleAttachment')->setName('standards.downloadSingleAttachment');

$router->add('/standards/{file:[0-9]+}/addTag','standards::addTag')->setName('standards.addTag');
$router->add('/standards/{file:[0-9]+}/deleteTag/{taggable:[0-9]+}','standards::deleteTag')->setName('standards.deleteTag');
$router->add('/standards/{file:[0-9]+}/tags','standards::showTags')->setName('standards.showTags');
$router->add('/standards/addTag2List','standards::addTag2List')->setName('standards.list.addTag');

//标准的链接相关的操作
$router->add('/standards/{file:[0-9]+}/addLink','standards::addLink')->setName('standards.addLink');
$router->add('/standards/{file:[0-9]+}/Links','standards::showLinks')->setName('standards.showLinks');
$router->add('/standards/{file:[0-9]+}/deleteLink/{link:[0-9]+}','standards::deleteLink')->setName('standards.deleteLink');

//针对文件列表的操作
$router->add('/standards/combineRevisions','standards::combineRevisions')->setName('standards.combineRevisions');
$router->add('/standards/deleteSelectedFiles','standards::deleteSelectedFiles')->setName('standards.deleteSelectedFiles');
$router->add('/standards/downloadAttachments','standards::downloadAttachment')->setName('standards.downloadAttachment');

$router->add('/standards/{file:[0-9]+}/relationship','standards::relationship')->setName('standards.relationship');
$router->add('/standards/{file:[0-9]+}/getRelation/{relation}','standards::getRelation')->setName('standards.getRelation');
$router->add('/standards/{file:[0-9]+}/relationship/addReferenceTo/{file2:[0-9]+}','standards::addReference')->setName('standards.addReference');

$router->add('/revisions/{rev:[0-9]+}','revisions::show')->setName('revisions.show');
$router->add('/revisions/{rev:[0-9]+}/delete','revisions::delete')->setName('revisions.delete');
$router->add('/standards/{file:[0-9]+}/addRevisionTo/{file2:[0-9]+}','standards::addRevisions')->setName('standards.addRevisionsTo');

$router->add('/journals/{journal}','journals::show')->setName('journals.show');
$router->add('/journals/{journal}/page/{page:[0-9]+}','journals::show')->setName('journals.show.page');

$router->add('/tags','tags::index')->setName('tags.index');
$router->add('/tags/page/{page:[0-9]+}','tags::index')->setName('tags.index.page');
$router->add('/tags/{tag:[0-9]+}','tags::show')->setName('tags.show');
$router->add('/tags/{tag:[0-9]+}/page/{page:[0-9]+}','tags::show')->setName('tags.show.page');
$router->add('/tags/{tag:[0-9]+}/edit','tags::edit')->setName('tags.edit');
$router->add('/tags/{tag:[0-9]+}/delete','tags::delete')->setName('tags.delete');

$router->add('/tags/{tag:[0-9]+}/addAttachment','tags::addAttachment')->setName('tags.addAttachment');
$router->add('/tags/{tag:[0-9]+}/Attachments','tags::showAttachments')->setName('tags.showAttachments');
$router->add('/tags/{tag:[0-9]+}/Attachments/{attachment:[0-9]+}/delete','tags::deleteAttachment')->setName('tags.deleteAttachment');

$router->add('/tags/{tag:[0-9]+}/archives/{month:[-0-9]+}','tags::showArchive')->setName('tags.showArchive');

$router->add('/tags/{tag:[0-9]+}/deleteTaggableItems','tags::deleteTaggableItems')->setName('tags.deleteTaggableItems');

$router->add('/tags/{tag:[0-9]+}/addComment','tags::addComment')->setName('tags.addComment');
$router->add('/tags/{tag:[0-9]+}/comments/{comment:[0-9]+}/edit','tags::editComment')->setName('tags.editComment');
$router->add('/tags/{tag:[0-9]+}/comments/{comment:[0-9]+}/delete','tags::deleteComment')->setName('tags.deleteComment');

$router->add('/tags/{tag:[0-9]+}/item/{file:[0-9]+}','tags::showItem')->setName('tags.showItem');
$router->add('/tags/{tag:[0-9]+}/item/{taggable:[0-9]+}/delete','tags::deleteItem')->setName('tags.deleteItem');
$router->add('/taggables/{taggable:[0-9]+}/addComment','tags::commentItem')->setName('taggables.addComment');

$router->add('/tags/{tag:[0-9]+}/addLink','tags::addLink')->setName('tags.addLink');
$router->add('/tags/{tag:[0-9]+}/links/{link:[0-9]+}/delete','tags::deleteLink')->setName('tags.deleteLink');
$router->add('/tags/{tag:[0-9]+}/links','tags::showLinks')->setName('tags.showLinks');

$router->add('/tags/{tag:[0-9]+}/relationship/addReferenceTo/{tag2:[0-9]+}','tags::addReference')->setName('tags.addReference');
$router->add('/tags/{tag:[0-9]+}/getRelation/{relation}','tags::getRelation')->setName('tags.getRelation');
$router->add('/tags/{tag:[0-9]+}/references','tags::references')->setName('tags.references');
$router->add('/tags/{tag:[0-9]+}/deleteReference/{reference:[0-9]+}','tags::deleteReference')->setName('tags.deleteReference');


$router->add('/subRepository/{repository}','subrepository::show')->setName('subRepository');
$router->add('/subRepository/{repository}/page/{page:[0-9]+}','subrepository::show')->setName('subRepository.page');

$router->add('/subRepository/{repository}/search/{search:[^/]+}','subrepository::search')->setName('subRepository.search');
$router->add('/subRepository/{repository}/search/{search:[^/]+}/page/{page:[0-9]+}','subrepository::search')->setName('subRepository.search.page');

$router->add('/subRepository/{repository}/archive/{month:[-0-9]+}','subrepository::showArchive')->setName('subRepository.showArchive');
$router->add('/subRepository/{repository}/archive/{month:[-0-9]+}/page/{page:[0-9]+}','subrepository::showArchive')->setName('subRepository.showArchive.page');

$router->addx('/subRepository/{repository}/showNoAttachment','subrepository::showNoAttachment',[isAdministrator::class])->setName('subRepository.showNoAttachment');
$router->addx('/subRepository/{repository}/showNoAttachment/page/{page:[0-9]+}','subrepository::showNoAttachment',[isAdministrator::class])->setName('subRepository.showNoAttachment.page');

$router->add('/login','Users::login')->setName('login');
$router->add('/logout','Users::logout')->setName('logout');

$router->add('/user/{user:[0-9]+}/tag/{tag:[0-9]+}','users::showTag')->setName('users.showTag');
$router->add('/user/{user:[0-9]+}/tag/{tag:[0-9]+}/page/{page:[0-9]+}','users::showTag')->setName('users.showTag.page');

$router->addx('/user/manageUsers','users::manageUsers',[isAdministrator::class])->setName('users.manageUsers');
$router->addx('/user/createNewUser','users::createNewUser',[isAdministrator::class])->setName('users.createNewUser');
$router->addx('/user/{user:[0-9]+}/delete','users::deleteUser',[isAdministrator::class])->setName('users.deleteUser');

$router->addx('/user/{user:[0-9]+}/sendPassWordResetEmail','users::sendPasswordResetEmail',[isAdministrator::class])->setName('users.sendPasswordResetEmail');
$router->add('/user/resetPassword/{token:.+}','users::resetPassword')->setName('users.resetPassword');
$router->add('/user/userRequestResetPassword','users::userRequestResetPassword')->setName('users.userRequestResetPassword');

//订阅和通知
$router->add('/tags/{tag:[0-9]+}/subscribe','tags::subscribe')->setName('tags.subscribe');
$router->add('/tags/{tag:[0-9]+}/unsubscribe','tags::unsubscribe')->setName('tags.unsubscribe');
$router->add('/notification','Users::readNotification')->setName('users.readNotification');
$router->add('/notification/done/{notification:[0-9]+}','Users::doneNotification')->setName('users.readNotification.done');

$router->add('/standards/{file:[0-9]+}/subscribe','standards::subscribe')->setName('standards.subscribe');
$router->add('/standards/{file:[0-9]+}/unsubscribe','standards::unsubscribe')->setName('standards.unsubscribe');

$router->add('/reading/file/{file:[0-9]+}/want','reading::want')->setName('reading.want');
$router->add('/reading/file/{file:[0-9]+}/reading','reading::reading')->setName('reading.reading');
$router->add('/reading/file/{file:[0-9]+}/done','reading::done')->setName('reading.done');

$router->add('/want','reading::wantlist')->setName('reading.wantlist');
$router->add('/reading','reading::readinglist')->setName('reading.readinglist');
$router->add('/done','reading::donelist')->setName('reading.donelist');

return $router;