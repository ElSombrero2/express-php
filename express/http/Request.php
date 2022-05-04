<?php

namespace Express\Http;

class Request{
    
    private $path;
    private $remote_port;
    private $server_port;
    private $method;

    public $headers;
    public $body;
    public $query;
    public $params;

    public function __construct(){
        $this->path = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->remote_port = $_SERVER['REMOTE_PORT'];
        $this->server_port = $_SERVER['SERVER_PORT'];
        $this->headers = getallheaders();
    }

    public function GetPath(){ return $this->path; }

    public function GetMethod(){ return $this->method; }

    public function GetRemotePort(){ return $this->remote_port; }

    public function GetServerPort(){ return $this->server_port; }
}
