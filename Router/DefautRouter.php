<?php

namespace framework\Router;


class DefautRouter
{
    private $controller = null;
    private $method = null;
    private $params = array();

    public function parse(){
        $url = substr($_SERVER['PHP_SELF'],strlen($_SERVER['SCRIPT_NAME'])+1);
        $_params = explode('/',$url);
        if($_params[0]) {
            $this->controller = ucfirst($_params[0]);

            if ($_params[1]) {
                $this->method = $_params[1];
                unset($_params[0], $_params[1]);
                $this->params = array_values($_params);
            }
        }

    }
    public function getController(){
        return $this->controller;
    }

    public function  getMethod(){
        return $this->method;
    }

    public function  getParams(){
        return $this->params;
    }
}