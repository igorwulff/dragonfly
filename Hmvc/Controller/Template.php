<?php
namespace Dragonfly\Hmvc\Controller;

abstract class Template extends Base {
  
  protected $controllerStorage;
  protected $skin;
  protected $view;
  protected $presenter;
  
  public function __construct(Request $request){
    parent::__construct($request);
    $this->controllerStorage = new \SplObjectStorage();
  }
  
  protected function setView($view, Presenter $presenter = null){
    $this->view = $view;
    $this->presenter = $presenter;
  }
  
  protected function getView(){
    return $this->view;
  }
  
  protected function getPresenter(){
    return $this->presenter;
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
    
  }
}
