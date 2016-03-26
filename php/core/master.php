<?php

class Master {

    protected $controller = "home";
    protected $method = "index";
    protected $params = [];

    function __construct() {
        $url = $this->parseUrl($_SERVER['REQUEST_URI']);
        if (isset($_SESSION['user']) || isset($_SESSION['admin']) || $url[1] == 'cron' || $url[2] == 'login' || $url[2] == 'motDePasseOublie' || $url[2] == 'changerMdp' || $url[2] == 'connect' || ($url[1] == 'utilisateur' && $url[2] == 'create')) {
            unset($url[0]);

            //controller
            if(file_exists(ROOT."php/controllers/".$url[1].".php"))
                $this->controller = $url[1];
            unset($url[1]);

            //method
            require ROOT."php/controllers/".$this->controller.".php";
            $this->controller = new $this->controller;
            if(isset($url[2]) && method_exists($this->controller, $url[2])) {
                $this->method = $url[2];
                unset($url[2]);
            }

            //params
            if($url)
                $this->params = array_values($url);
        }
        else {
            require ROOT."php/controllers/".$this->controller.".php";
            $this->controller = new $this->controller;
        }
        unset($url);

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl($url) {
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
    }
}