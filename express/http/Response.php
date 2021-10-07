<?php

    namespace Express\Http; 

    class Response{

        private $code = 200;

        private $view_path;

        public function __construct(){
            $this->set('X-Powered-By', 'Express');
        }

        public function setViewPath($view_path){ $this->view_path = $view_path; }

        public function getStatus(){ return $this->code; }

        public function status(int $code){
            $this->code = $code;
            return $this;
        }

        public function send(string $obj){
            $this->set('Content-Type', 'text/html; charset=utf-8')
            ->set('Content-Length', strlen($obj));
            http_response_code($this->code);
            die($obj);
        }

        public function json(array $obj){
            $response = json_encode($obj);
            $this->set('Content-Type', 'application/json; charset=utf-8')
            ->set('Content-Length', strlen($response));
            http_response_code($this->code);
            die($response);
        }

        public function set(string $key, string $value){
            header($key.': '.$value);
            return $this;
        }

        public function render(string $view, array $args = null){
            if($args != null)extract($args);
            require '..\\'.$this->view_path.'\\'.$view.'.php';
        }
    }