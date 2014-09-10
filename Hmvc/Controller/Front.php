<?php
namespace Dragonfly\Hmvc\Controller;

abstract class Front extends Base {
  
  public function __construct(Request $request){
    parent::__construct($request);
    $this->prepareLayout();
  }
  
  public function prepareLayout(){
    
  }
}
