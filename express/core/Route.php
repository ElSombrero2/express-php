<?php

namespace Express\Core;


class Route{

    private $pathname;
    private $match_split;
    private $middlewares;

    function __construct(String $pathname = null,Array $middlewares){
        $this->pathname = $pathname;
        $this->match_split = explode('/', $this->pathname);
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

    public function match($url){
        $url_split = explode('/', $url);
        if(count($url_split) === count($this->match_split)){
            for($i = 0; $i < count($url_split); $i++){
                $str = $this->match_split[$i];
                $path = $url_split[$i];
                if(!(strlen($str) > 0 && $str[0] === '{' && $str[strlen($str) - 1] === '}')){
                    if($path !== $str)
                        return false;
                }
            }
        }else return false;
        return true;
    }

    public function extract($url){
        $url_split = explode('/', $url);
        $params = [];
        if(count($url_split) === count($this->match_split)){
            for($i = 0; $i < count($url_split); $i++){
                $str = $this->match_split[$i];
                $path = $url_split[$i];
                if(strlen($str) > 0 && $str[0] === '{' && $str[strlen($str) - 1] === '}'){
                    $params[str_replace(' ', '', substr($str, 1, strlen($str) - 2))] = $path;
                }
            }
        }
        return $params;
    }
}