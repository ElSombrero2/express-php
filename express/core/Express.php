<?php

namespace Express\Core;

use Express\Http\Request;
use Express\Http\Response;

class Express{

    private $gets = [];
    private $posts = [];
    private $puts = [];
    private $deletes = [];
    private $patchs = [];
    private $uses = [];
    private $config = [ 'view' => 'views' ];

    public static function json(){
        return (function(Request $req, Response $res){
            $json = file_get_contents('php://input');
            $req->body = json_decode($json, true);
        });
    }

    public static function urlencoded(){
        return (function(Request $req, Response $res){
            $req->body = $_POST;
        });
    }

    public function __construct(){}

    public function use($path , callable ...$middlewares){ array_push($this->uses, new Route($path, $middlewares)); }

    public function get(string $path , callable ...$middlewares){ array_push($this->gets, new Route($path, $middlewares)); }

    public function post(string $path , callable ...$middlewares){ array_push($this->posts, new Route($path, $middlewares)); }

    public function delete(string $path , callable ...$middlewares){ array_push($this->deletes, new Route($path, $middlewares)); }

    public function put(string $path , callable ...$middlewares){ array_push($this->puts, new Route($path, $middlewares)); }

    public function patch(string $path , callable ...$middlewares){ array_push($this->patchs, new Route($path, $middlewares)); }

    public function bootstrap(){
        $req = new Request();
        $res = new Response();
        $res->setViewPath($this->config['view']);
        $req->query = $_GET;
        $is_called = false;
        $this->callMiddlewares($this->uses, $req, $res);
        $method = $req->GetMethod();
        if(strtolower($method) === 'get') $is_called = $this->call($this->gets, 'get', $req, $res);
        if(strtolower($method) === 'post') $is_called = $this->call($this->posts, 'post', $req, $res);
        if(strtolower($method) === 'delete') $is_called = $this->call($this->deletes, 'delete', $req, $res);
        if(strtolower($method) === 'put') $is_called = $this->call($this->puts, 'put', $req, $res);
        if(strtolower($method) === 'patch') $is_called = $this->call($this->patchs, 'patch', $req, $res);
        if(!$is_called) die('cannot '.strtoupper($method).' '.strtolower($req->GetPath()));
    }

    private function call(array $arr, string $method, Request $req, Response $res){
        $is_called = false;
        $path = $req->GetPath();
        if(strtolower($req->GetMethod()) === $method){
            for($i = 0; $i < count($arr); $i++){
                if($arr[$i]->getPath() === $path){
                    $arr[$i]->call($req, $res, 0);
                    $is_called = true;
                }else if($arr[$i]->match($path)){
                    $req->params = $arr[$i]->extract($path);
                    $arr[$i]->call($req, $res, 0);
                    $is_called = true;
                }
            }
        }
        return $is_called;
    }

    private function callMiddlewares($arr, $req, $res){
        $path = $req->GetPath();
        for($i = 0; $i < count($arr); $i++){
            if($arr[$i]->getPath() === $path || $arr[$i]->getPath() === null){
                $arr[$i]->call($req, $res, 0);
            }else if($arr[$i]->match($path)){
                $req->params = $arr[$i]->extract($path);
                $arr[$i]->call($req, $res, 0);
            }
        }
    }

    private function set($key, $value){ $this->config[$key] = $value; }

    private function GetConfig(){ return $this->sets; }
}