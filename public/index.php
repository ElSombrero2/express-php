<?php

use Express\Core\Express;
use Express\Http\Request;
use Express\Http\Response;

require '../autoload.php';

$app = new Express();

$app->get('/', function(Request $req, Response $res){
    $res->status(400)->json([
        'name' => 'Done'
    ]);
});

$app->bootstrap();