<?php

use Slim\App;

return function (App $app) {
    $app->get('/hello/{name}', \App\Application\Actions\InitChatAction::class)->setName('Home');
};