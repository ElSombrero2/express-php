<?php

namespace Express\Core;


class Route{

    private $pathname;
    private $middlewares;

    function __construct(String $pathname = null,Array $middlewares){
        $this->pathname = $pathname;
        $this->middlewares = $middlewares;
    }

    public function call($req, $res, $index = 0){
        $GLOBALS['index'] = $index;
        $GLOBALS['req'] = $req;
        $GLOBALS['res'] = $res;
        if(count($this->middlewares) > 0){
            $this->middlewares[$index]($req, $res, function(){
                global $index;
                global $req;
                global $res;
                $this->call($req, $res, $index + 1);
            });
        }
    }

    public function getPath(){ return $this->pathname; }

    public function getMiddlewares(){ return $this->middlewares; }
}