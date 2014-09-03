<?php
namespace Dragonfly\Datamapper;

final class Service {

  private $datasourceList;
  
  public function __construct(){
    $this->datasourceList = array();
  }
  
  public function getDatasource($name){
    if(array_key_exists($name, $this->datasourceList) === false){
      throw new \OutOfRangeException("Can't retrieve datasource with name $name, because the datasource doesn't exists.");
    }
    
    return $this->datasourceList[$name];
  }
  
  public function addDatasource($name, Datasource $datasource){
    try {
      /*
       * If there is no datasource with this name a \OutOfRangeException is fired, 
       * which means it is allowed to add a new Datasource.
       */
      $datasource = $this->getDatasource();
      
      throw new \OutOfRangeException("Datasource with name $name is already in use.");
    } catch(\OutOfRangeException $e){
       $this->datasourceList[$name] = $datasource;
    }
  }
  
  public function unsetDatasource($name){
    try {
      $datasource = $this->getDatasource();
      $datasource->disconnect();
      
      unset($this->datasourceList[$name]);
    } catch(\OutOfRangeException $e){
       throw new \OutOfRangeException("Can't unset the datasource. The datasource with the name $name does not exists.");
    }
  }
  
}
