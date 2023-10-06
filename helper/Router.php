<?php
//La función de esta clase es dirigir las solicitudes a controladores 
//y métodos específicos en una aplicación web según el módulo y el método proporcionados. 
class Router
{

    private $configuration;
    private $defaultController;
    private $defaultMethod;

    public function __construct($configuration, $defaultController, $defaultMethod)
    {
        $this->configuration = $configuration;
        $this->defaultController = $defaultController;
        $this->defaultMethod = $defaultMethod;
    }

    public function route($module, $method)
    {
        $controller = $this->getControllerFrom($module);
        $this->executeMethodFromController($controller, $method);
    }

    private function getControllerFrom($module)
    {
        $controllerName = 'get' . ucfirst($module) . 'Controller';
        $validController = method_exists($this->configuration, $controllerName) ? $controllerName : $this->defaultController;
        return call_user_func(array($this->configuration, $validController));
    }

    private function executeMethodFromController($controller, $method)
    {
        $validMethod = method_exists($controller, $method) ? $method : $this->defaultMethod;
        call_user_func(array($controller, $validMethod));
    }

    //$controller es una instancia de un objeto que representa un controlador en la aplicación web.
    //$validMethod es el nombre del método que se quiere llamar en ese controlador.
}
