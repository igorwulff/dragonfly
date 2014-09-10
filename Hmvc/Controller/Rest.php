<?php
namespace Dragonfly\Hmvc\Controller;

abstract class Rest extends Base {

  protected $outputFormat = 'json';

  public function postAction(){
    
  }

  public function getAction(){
    
  }
  
  public function deleteAction(){
    
  }
  
  public function putAction(){
    
  }
  
  public function patchAction(){
    
  }
  
  public function setOutputFormat($outputFormat){
    if(in_array($outputFormat, array('json', 'xml', 'plain')) === false){
      throw new \BadMethodException("Invalid output format given: $outputFormat");
    }
    
    $this->outputFormat = $outputFormat;
  }
  
  public function getOutputFormat(){
    return $this->outputFormat;
  }
  
  public function output(){
    
  }
}
