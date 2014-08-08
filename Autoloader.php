<?php
namespace Dragonfly;

/**
 * The default autoloader used for loading files in the Dragonfly package or other libraries
 * 
 * @package     Dragonfly
 * @subpackage  Framework
 */
class Autoloader {

	private $pathList = array();
	private $seperator;
	private $extensionList = array();
	
	public function __construct(array $pathList = array(), $seperator = "\\", array $extensionList = array('php', 'phtml')){
		foreach($pathList as $value){
			$this->addPath($value);
		}
		
		$this->seperator = $seperator;
		
		foreach($extensionList as $value){
			$this->addExtension($value);
		}
	}
	
	public function addPath($path, $append = true){
		return (bool)$append === true ? array_push($this->pathList, $path) : array_unshift($this->pathList, $path);
	}
	
	public function removePath($path){
		array_key_exists($this->pathList, $path) ? unset($this->pathlist[$path]) : throw new \BadMethodException("Path $path does not exist.");
	}
	
	public function getPathList(){
		return $this->pathlist;
	}
	
	public function addExtension($extension, $append = true){
		return (bool)$append === true ? array_push($this->extensionList, $extension) : array_unshift($this->extensionList, $extension);
	}
	
	public function removeExtension($extension){
		array_key_exists($this->extensionList, $extension) ? unset($this->extensionList[$extension]) : throw new \BadMethodException("Extension $extension does not exist.");
	}
	
	public function getExtensionList(){
		return $this->extensionList;
	}
	
	public function register(){
		spl_autoload_register(array($this, 'load'));
	}
	
	private function load($name){
		$filename = '';
		
		foreach($this->pathList as $path){
			foreach($this->extensionList as $extension){
				$filename = $path.$name.'.'.extension;
				
				if(file_exists($filename)){
					require_once $filename;
					if(class_exists(str_replace("/", $this->seperator, $name, false)){
						return true;
					}
				}
			}
		}

		if(!file_exists($filename)){
			throw new \BadMethodException("File $name not found");
		} else if(!class_exists($name, false)){
			// Make sure we throw an Exception so we have a stacktrace
			throw new \BadMethodException("Class $name not found");
		}

		return;
	}
}
