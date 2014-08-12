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
	private $seperator = "\\";
	private $extensionList = array();
	
	/**
	 * Adds a path to the path list
	 * 
	 * @param string $path
	 * @param bool $append Whether to append or prepend the path
	 * 
	 * @return int Returns the number of paths
	 */
	public function addPath($path, $seperator, $append = true){
		return (bool)$append === true ? array_push($this->pathList, array($path => $seperator)) : array_unshift($this->pathList, array($path => $seperator));
	}
	
	/**
	 * Removes a path from the path list
	 * 
	 * @param string $path
	 */
	public function removePath($path){
		$index = array_search($this->pathList, $path);
		
		if($index === false){
			throw new \BadMethodException("Path $path does not exist.");	
		} else {
			unset($this->pathlist[$index];
		}
	}
	
	/**
	 * Retrieve an array of paths
	 * 
	 * @return array Returns a list of paths
	 */
	public function getPathList(){
		return $this->pathlist;
	}
	
	/**
	 * Adds a extension to the extension list
	 * 
	 * @param string $extension
	 * @param bool $append Whether to append or prepend the extension
	 * 
	 * @return int Returns the number of extensions
	 */
	public function addExtension($extension, $append = true){
		return (bool)$append === true ? array_push($this->extensionList, $extension) : array_unshift($this->extensionList, $extension);
	}
	
	/**
	 * Removes a extension from the extension list
	 * 
	 * @param string $extension
	 */
	public function removeExtension($extension){
		$index = array_search($this->extensionList, $extension);
		
		if($index === false){
			throw new \BadMethodException("Extension $extension does not exist.");	
		} else {
			unset($this->extensionList[$index];
		}
	}
	
	/**
	 * Retrieve an array of extensions
	 * 
	 * @return array Returns a list of extensions
	 */
	public function getExtensionList(){
		return $this->extensionList;
	}
	
	/**
	 * Register the autoloader
	 * 
	 * The register method binds the load method to the spl_autoload_register 
	 * function in order to let files be autoloaded.
	 */
	public function register(){
		spl_autoload_register(array($this, 'load'));
	}
	
	/**
	 * Load the requested file
	 * 
	 * @return bool Returns whether a file has been found.
	 */
	private function load($name){
		$filename = '';
		
		// Iterate through the paths
		foreach($this->pathList as $path){
			// Iterate through the extensions
			foreach($this->extensionList as $extension){
				/**
				 * Generate the filename based on the path, the 
				 * requested filename and the extension
				 */
				$filename = $path.$name.'.'.extension;
				
				/**
				 * Load the file if it exists. Return true if the 
				 * class exists.
				 */
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
