<?php

use Slim\App;

return function (App $app) {
    $app->post('/message', \App\Application\Actions\SendMessageAction::class);
};