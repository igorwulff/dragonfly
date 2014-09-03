<?php
namespace Dragonfly\Datamapper;

final static class Service {

  private static $datasourceList = array();
  
  public static function getDatasource($name){
    if(array_key_exists($name, $this->datasourceList) === false){
      throw new \OutOfRangeException("Can't retrieve datasource with name $name, because the datasource doesn't exists.");
    }
    
    return $this->datasourceList[$name];
  }
  
  public static function addDatasource($name, Datasource $datasource){
    try {
      /*
       * If there is no datasource with this name a \OutOfRangeException is fired, 
       * which means it is allowed to add a new Datasource.
       */
      $datasource = self::getDatasource();
      
      throw new \OutOfRangeException("Datasource with name $name is already in use.");
    } catch(\OutOfRangeException $e){
       self::$datasourceList[$name] = $datasource;
    }
  }
  
  public static function unsetDatasource($name){
    try {
      $datasource = self::getDatasource();
      $datasource->disconnect();
      
      unset(self::datasourceList[$name]);
    } catch(\OutOfRangeException $e){
       throw new \OutOfRangeException("Can't unset the datasource. The datasource with the name $name does not exists.");
    }
  }
  
}
