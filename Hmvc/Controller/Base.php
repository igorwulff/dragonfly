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

  public abstract function output();
  
}
