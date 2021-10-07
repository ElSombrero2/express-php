<?php

use Express\Core\Express;
use Express\Http\Request;
use Express\Http\Response;

require '../autoload.php';

$app = new Express();

$app->get('/', function(Request $req, Response $res, $next){
    $next();
}, function (Request $req,Response $res, $next){
    $next();
},function (Request $req,Response $res, $next){
    $next();
},function (Request $req,Response $res, $next){
    $next();
},function (Request $req,Response $res){
    echo 'Done<br/>';
});

$app->post('/', function(Request $req, Response $res, $next){
    $next();
}, function (Request $req,Response $res, $next){
    $next();
},function (Request $req,Response $res, $next){
    $next();
},function (Request $req,Response $res, $next){
    $next();
},function (Request $req,Response $res){
    echo 'Done<br/>';
});

$app->bootstrap();