<?php
namespace Dragonfly\Hmvc\Controller;
use \Dragonfly\Hmvc\Request;

abstract class Base {

  protected $request;
  protected $controllerStorage;

  public function __construct(Request $request){
    $this->request = $request;
    $this->controllerStorage = new \SplObjectStorage();
  }
  
  public function getRequest(){
    return $this->request;
  }
  
  protected function attachChild(Controller $controller){
    $this->controllerStorage->attach($controller);
  }
  
  protected function detachChild(Controller $controller){
    $this->controllerStorage->detach($controller);
  }
  
  protected function getControllerStorage(){
    return $this->controllerStorage;
  }

  public abstract function output();
  
}
