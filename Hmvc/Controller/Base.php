<?php
namespace Dragonfly\Hmvc\Controller;
use \Dragonfly\Hmvc\Request;
use \Dragonfly\Hmvc\Presenter\Base as Presenter;

abstract class Base {

  protected $request;

  public function __construct(Request $request){
    $this->request = $request;
  }
  
  protected function displayView($view, $presenter = null){
    if(is_null($presenter)){
      $presenter = new Presenter($this, $view);
    } else {
      $presenter = new $presenter($this, $view);
      if(!$presenter instanceof Presenter){
        throw new \BadMethodException("Invalid presenter given: ".get_class($presenter));
      }
    }
    
    
  }
  
  public function getRequest(){
    return $this->request;
  }
  
  public abstract function actionNotFound();
  
  public abstract function actionAccessDenied();

  public abstract function output();
  
}
