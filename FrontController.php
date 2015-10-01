<?php
namespace framework;
use framework\Router\DefautRouter;
class FrontController
{
    private static $instance = null;
    protected $controller;
    protected $action;
    protected $params;
    protected $basePath = "Controllers/";
    private function __construct()
    {
    }
    public function dispatch()
    {
        $router = new DefautRouter();
        $router->parse();
        $controller = $router->getController();
        $method = $router->getMethod();
        if($controller == null){
            $controller = $this->getDefaultController();
        }
        if($method == null){
            $method = $this->getDefaultMethod();
        }
    }

    public function getDefaultController(){
        $controller = \framework\App::getInstance()->getConfig()->app['default_controller'];
        if($controller){
            return $controller;
        }
        return 'index';
    }
    public function getDefaultMethod(){
        $method = \framework\App::getInstance()->getConfig()->app['default_method'];
        if($method){
            return $method;
        }
        return 'index';
    }

    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new FrontController();
        }
        return self::$instance;
    }
    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }
    /**
     * @param mixed $controller
     * @return FrontController
     */
    public function setController($controller)
    {
        $controller = $this->basePath . ucfirst(strtolower($controller)) . "Controller";
        if(!class_exists($controller)){
            throw new \InvalidArgumentException("The controller '$controller' has not been defined.");
        }
        $this->controller = $controller;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * @param mixed $action
     * @return FrontController
     */
    public function setAction($action)
    {
        $reflector = new \ReflectionClass($this->controller);
        if (!$reflector->hasMethod($action)) {
            throw new \InvalidArgumentException("The action '$action' has not been defined.");
        }
        $this->action = $action;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }
    /**
     * @param array $params
     * @return FrontController
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }
}