<?php
namespace Dragonfly\Hmvc\Controller;
use \Dragonfly\Hmvc\Request;

abstract class Base {

  protected $request;

  public function __construct(Request $request){
    $this->request = $request;
  }
  
  public function getRequest(){
    return $this->request;
  }

  public abstract function output();
  
}
