<?php

namespace Express\Core;

use Express\Http\Request;
use Express\Http\Response;

class Route{

    private $pathname;
    private $middlewares;
    private $index = 0;

    function __construct(String $pathname,Array $middlewares){
        $this->pathname = $pathname;
        $this->middlewares = $middlewares;
    }

    public function call(){
        if(count($this->middlewares) > 0)
            $this->middlewares[$this->index](new Request(), new Response(), $this->middlewares[++$this->index] ?? null);
    }

    public function getPath(){ return $this->pathname; }
}