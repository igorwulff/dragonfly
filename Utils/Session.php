<?php
namespace Dragonfly\Utils;

class Session {
  
  private $data;
  
  public function start(){
    session_start();
    $this->data = &$_SESSION;
  }
  
  public function close(){
			session_unset();
  		session_destroy();
  		session_write_close();
  		setcookie(session_name(), '', 0, '/');
  		session_regenerate_id(true);
  }
  
  public function setData(array $data = array()){
    $this->data = array_merge($data, $this->data);
  }
  
  public function unsetData($key){
    unset($this->data[$key]);
  }
  
  public function getData($key){
    return array_key_exists($this->data, $key) ? $this->data[$key] : false;
  }
}
