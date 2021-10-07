<?php
require '../autoload.php';

use Express\Core\Express;
use Express\Http\Request;
use Express\Http\Response;

$app = new Express();

$app->use(null, Express::json());
$app->use(null, Express::urlencoded());

$app->get('/', function(Request $req, Response $res){
    $res->json([
        'message' => 'done'
    ]);
});

$app->post('/', function(Request $req, Response $res){
    $res->json([
        'message' => 'done'
    ]);
});

$app->bootstrap();