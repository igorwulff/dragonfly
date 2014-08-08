<?php
namespace Dragonfly;

/**
 * The default autoloader used for loading files in the Dragonfly package or other libraries
 * 
 * @package     Dragonfly
 * @subpackage  Framework
 */
class Autoloader {
  
	private $namespace;
	private $pathList = array();
	private $seperator;
	private $extensionList = array();
	
	public function __construct($namespace, $seperator = "\\", array $extensionList = array('php', 'phtml')){
	  $this->namespace = $namespace;
	  $this->seperator = $seperator;
	  
    foreach($extensionList as $value){
      $this->addExtension($value);
    }
	}
	
	public function addPath($path, $append = true){
		return (bool)$append === true ? array_push($this->pathList, $path) : array_unshift($this->pathList, $path);
	}
	
	public function addExtension($extension){
		return array_push($this->extensionList, $extension);
	}
	
	public function register(){
		spl_autoload_register(array($this, 'load'));
	}
	
	private function load($name){
		$filename = '';
		foreach($this->pathList as $path){
			$filename = $path.$name.$this->extension;
			if(file_exists($filename)){
				require_once $filename;
				return true;
			}
		}

		if(!file_exists($filename)){
			throw new \Exception('File '.$filename.' not found');
		} else if(!class_exists($name, false)){
			// Make sure we throw an Exception so we have a stacktrace
			throw new \Exception('Class "'.$name.'" not found');
		}

		return;
	}
  
}
