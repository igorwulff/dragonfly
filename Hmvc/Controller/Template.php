<?php
namespace Dragonfly\Hmvc\Controller;

abstract class Template extends Base {
  
  protected $controllerStorage;
  
  public function __construct(Request $request){
    parent::__construct($request);
    $this->controllerStorage = new \SplObjectStorage();
  }

  protected function attachController(Template $controller){
    $this->controllerStorage->attach($controller);
  }
  
  protected function detachController(Template $controller){
    $this->controllerStorage->detach($controller);
  }
  
  protected function getControllerStorage(){
    return $this->controllerStorage;
  }
  
  public function output(){
    foreach($this->getControllerStorage() as $controller){
      $controller->output();
    }
  }
}
