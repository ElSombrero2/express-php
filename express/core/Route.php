<?php

namespace Express\Core;

use Express\Http\Request;
use Express\Http\Response;

class Route{

    private $pathname;
    private $middlewares;
    private $response;
    private $request;

    function __construct(String $pathname,Array $middlewares){
        $this->pathname = $pathname;
        $this->middlewares = $middlewares;
        $this->response = new Response();
        $this->request = new Request();
    }

    public function call($index = 0){
        $GLOBALS['index'] = $index;
        if(count($this->middlewares) > 0){
            $this->middlewares[$index]($this->request, $this->response, function(){
                global $index;
                $this->call($index + 1);
            });
        }
    }

    public function getPath(){ return $this->pathname; }

    public function getMiddlewares(){ return $this->middlewares; }
}