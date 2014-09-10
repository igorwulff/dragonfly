<?php
namespace Dragonfly\Hmvc\Controller;
use \Dragonfly\Hmvc\Request;

abstract class Base {

  protected $request;
  protected $model;
  protected $view;

  public function __construct(Request $request){
    $this->request = $request;
  }
  
  protected function setModel(Model $model){
    
  }
  
  protected function setView($view){
    
  }
  
  public function getRequest(){
    return $this->request;
  }

  public abstract function output();
  
}
