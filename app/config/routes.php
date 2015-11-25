<?php

$router = new myRouter(false);

//$router->addMiddlewaresForEveryRoute(['IsLoginValidator']);

$router->removeExtraSlashes(true);
$router->add('/page/{page:[0-9]+}','index::index')->setName('index');
$router->add('/','index::index')->setName('home');

$router->add('/search/{search:[^/]+}/page/{page:[0-9]+}','standards::search')->setName('standards.search');
$router->add('/search/{search:[^/]+}','standards::search')->setName('standards.search.index');
$router->add('/search/{search:[^/]+}/{item:[0-9]+}','standards::showSearchItem')->setName('standards.showSearchItem');

$router->addx('/standards/add','standards::add',['standardRules'])->setName('standards.add');
$router->add('/standards/addDoD','standards::addDoD')->setName('standards.addDoD');
$router->add('/standards/addDoD/{accessNumber:[A-Z0-9]+}','standards::addDoDByGet')->setName('standards.addDoDByGet');

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

$router->add('/standards/{file:[0-9]+}/addRevisionTo/{file2:[0-9]+}','standards::addRevisions')->setName('standards.addRevisionsTo');

$router->add('/revisions/{rev:[0-9]+}','revisions::show')->setName('revisions.show');
$router->add('/revisions/{rev:[0-9]+}/delete','revisions::delete')->setName('revisions.delete');

$router->add('/tags','tags::index')->setName('tags.index');
$router->add('/tags/{tag:[0-9]+}','tags::show')->setName('tags.show');
$router->add('/tags/{tag:[0-9]+}/page/{page:[0-9]+}','tags::show')->setName('tags.show.page');
$router->add('/tags/{tag:[0-9]+}/edit','tags::edit')->setName('tags.edit');

$router->add('/tags/{tag:[0-9]+}/addComment','tags::addComment')->setName('tags.addComment');
$router->add('/tags/{tag:[0-9]+}/comments/{comment:[0-9]+}/edit','tags::editComment')->setName('tags.editComment');
$router->add('/tags/{tag:[0-9]+}/comments/{comment:[0-9]+}/delete','tags::deleteComment')->setName('tags.deleteComment');

$router->add('/tags/{tag:[0-9]+}/item/{item:[0-9]+}','tags::showItem')->setName('tags.showItem');
$router->add('/tags/{tag:[0-9]+}/item/{taggable:[0-9]+}/delete','tags::deleteItem')->setName('tags.deleteItem');

return $router;