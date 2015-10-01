<?php
namespace framework;
require 'Autoloader.php';
class App
{
    private static $instance = null;
    private $config = null;
    private $frontController = null;

    private function __construct()
    {
        \framework\Autoloader::registerNamespace('framework', dirname(__FILE__ . DIRECTORY_SEPARATOR));
        \framework\Autoloader::init();
        $this->config = Config::getInstance();
    }
    public function run()
    {
        if($this->getConfigFolder() == null){
            $this->setConfigFolder('../config');
        }
        $this->frontController = FrontController::getInstance();
        $this->frontController->dispatch();
    }
    /**
     * @return \framework\Config
     */
    public function getConfig()
    {
        return $this->config;
    }
    public function getConfigFolder()
    {
        return $this->config->getConfigFolder();
    }
    public function setConfigFolder($path)
    {
        $this->config->setConfigFolder($path);
    }
    /**
     * @return \framework\App
     */
    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new App();
        }
        return self::$instance;
    }
}