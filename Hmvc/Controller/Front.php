<?php
namespace Dragonfly\Hmvc\Controller;

abstract class Front extends Base {
  
  protected $controllerStorage;
  
  public function __construct(Request $request){
    parent::__construct($request);
    $this->controllerStorage = new \SplObjectStorage();
    $this->prepareLayout();
  }
  
  protected abstract function prepareLayout();
    
  protected function attachController(Controller $controller){
    $this->controllerStorage->attach($controller);
  }
  
  protected function detachController(Controller $controller){
    $this->controllerStorage->detach($controller);
  }
  
  protected function getControllerStorage(){
    return $this->controllerStorage;
  }
  
  public function output(){

  }
}
