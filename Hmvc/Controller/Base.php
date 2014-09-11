<?php
namespace Dragonfly\Hmvc\Controller;
use \Dragonfly\Hmvc\Request;
use \Dragonfly\Hmvc\Presenter\Base as Presenter;

abstract class Base {

  protected $request;

  public function __construct(Request $request){
    $this->request = $request;
  }
  
  public function getRequest(){
    return $this->request;
  }
  
  public abstract function actionNotFound();
  
  public abstract function actionForbidden();

  public abstract function output();
  
}
