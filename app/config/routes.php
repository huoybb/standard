<?php

$router = new myRouter(false);

$router->addMiddlewaresForEveryRoute(['IsLoginValidator']);

$router->removeExtraSlashes(true);
$router->add('/page/{page:[0-9]+}','index::index')->setName('index');
$router->add('/','index::index')->setName('home');

$router->add('/search/{search:[^/]+}/page/{page:[0-9]+}','standards::search')->setName('standards.search');
$router->add('/search/{search:[^/]+}','standards::search')->setName('standards.search.index');
$router->add('/search/{search:[^/]+}/{item:[0-9]+}','standards::showSearchItem')->setName('standards.showSearchItem');

$router->addx('/standards/add','standards::add',['standardRules'])->setName('standards.add');
$router->add('/standards/addDoD','standards::addDoD')->setName('standards.addDoD');

$router->add('/standards/addWebData/{type}/{source_id}','standards::getWebData')->setName('standards.getWebData');

$router->add('/standards/addTag2List','standards::addTag2List')->setName('standards.list.addTag');

$router->add('/standards/archive/{month:[-0-9]+}','standards::archive')->setName('standards.archive');
$router->add('/standards/archive/{month:[-0-9]+}/page/{page:[0-9]+}','standards::archive')->setName('standards.archive.page');

$router->add('/standards/{file:[0-9]+}','standards::show')->setName('standards.show');
$router->addx('/standards/{file:[0-9]+}/edit','standards::edit',['standardRules'])->setName('standards.edit');
$router->add('/standards/{file:[0-9]+}/delete','standards::delete')->setName('standards.delete');

$router->addx('/standards/{file:[0-9]+}/addComment','standards::addComment',['commentRules'])->setName('standards.addComment');
$router->addx('/standards/{file:[0-9]+}/comments/{comment:[0-9]+}/edit','standards::editComment',['commentRules'])->setName('standards.editComment');
$router->add('/standards/{file:[0-9]+}/comments/{comment:[0-9]+}/delete','standards::deleteComment')->setName('standards.deleteComment');

$router->add('/standards/{file:[0-9]+}/Attachments','standards::showAttachments')->setName('standards.showAttachments');
$router->add('/standards/{file:[0-9]+}/addAttachment','standards::addAttachment')->setName('standards.addAttachment');
$router->add('/standards/{file:[0-9]+}/Attachments/{attachment:[0-9]+}/edit','standards::editAttachment')->setName('standards.editAttachment');
$router->add('/standards/{file:[0-9]+}/Attachments/{attachment:[0-9]+}/delete','standards::deleteAttachment')->setName('standards.deleteAttachment');

$router->add('/standards/{file:[0-9]+}/addTag','standards::addTag')->setName('standards.addTag');
$router->add('/standards/{file:[0-9]+}/deleteTag/{taggable:[0-9]+}','standards::deleteTag')->setName('standards.deleteTag');
$router->add('/standards/{file:[0-9]+}/tags','standards::showTags')->setName('standards.showTags');

$router->add('/standards/{file:[0-9]+}/addLink','standards::addLink')->setName('standards.addLink');
$router->add('/standards/{file:[0-9]+}/Links','standards::showLinks')->setName('standards.showLinks');
$router->add('/standards/{file:[0-9]+}/deleteLink/{link:[0-9]+}','standards::deleteLink')->setName('standards.deleteLink');

$router->add('/standards/{file:[0-9]+}/addRevisionTo/{file2:[0-9]+}','standards::addRevisions')->setName('standards.addRevisionsTo');
$router->add('/standards/combineRevisions','standards::combineRevisions')->setName('standards.combineRevisions');
$router->add('/standards/deleteSelectedFiles','standards::deleteSelectedFiles')->setName('standards.deleteSelectedFiles');

$router->add('/standards/{file:[0-9]+}/relationship','standards::relationship')->setName('standards.relationship');
$router->add('/standards/{file:[0-9]+}/getRelation/{relation}','standards::getRelation')->setName('standards.getRelation');
$router->add('/standards/{file:[0-9]+}/relationship/addReferenceTo/{file2:[0-9]+}','standards::addReference')->setName('standards.addReference');

$router->add('/revisions/{rev:[0-9]+}','revisions::show')->setName('revisions.show');
$router->add('/revisions/{rev:[0-9]+}/delete','revisions::delete')->setName('revisions.delete');

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

$router->add('/tags/{tag:[0-9]+}/item/{item:[0-9]+}','tags::showItem')->setName('tags.showItem');
$router->add('/tags/{tag:[0-9]+}/item/{taggable:[0-9]+}/delete','tags::deleteItem')->setName('tags.deleteItem');
$router->add('/taggables/{taggable:[0-9]+}/addComment','tags::commentItem')->setName('taggables.addComment');

$router->add('/subRepository/{repository}','subrepository::show')->setName('subRepository');
$router->add('/subRepository/{repository}/page/{page:[0-9]+}','subrepository::show')->setName('subRepository.page');

$router->add('/login','Users::login')->setName('login');
$router->add('/logout','Users::logout')->setName('logout');

return $router;