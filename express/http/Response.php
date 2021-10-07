<?php

    namespace Express\Http; 

    class Response{

        private $code = 200;

        public function __construct(){}

        public function getStatus(){ return $this->code; }

        public function status(int $code){
            $this->code = $code;
            return $this;
        }

        public function send(string $obj){
            $this->set('X-Powered-By', 'Express')
            ->set('Content-Type', 'text/html; charset=utf-8')
            ->set('Content-Length', strlen($obj));
            http_response_code($this->code);
            echo $obj;
        }

        public function json(object $obj){
            $response = json_encode($obj);
            $this->set('X-Powered-By', 'Express')
            ->set('Content-Type', 'application/json; charset=utf-8')
            ->set('Content-Length', strlen($response));
            http_response_code($this->code);
            echo $response;
        }

        public function set(string $key, string $value){
            header($key.': '.$value);
            return $this;
        }
    }