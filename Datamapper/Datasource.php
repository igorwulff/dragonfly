<?php
namespace Dragonfly\Datamapper;

abstract class Datasource {
  
  protected $handle;
  
  abstract public function connect(array $data);
  
  public function disconnect(){
    $this->handle = null;
  }
  
  public function isConnected(){
    return !is_null($this->getHandle());
  }
  
  public function getHandle(){
    return $this->handle;
  }
}
