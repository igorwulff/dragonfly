<?php
namespace Dragonfly\Hmvc;
use Dragonfly\Network\Uri;
use Dragonfly\Network\Httprequest;

/**
 * 
 * 
 * @package    Dragonfly
 * @subpackage Hmvc
 */
class Request {
	
	protected $uri;
	protected $parent;
	protected $controller;
	protected $method;
	
	/**
	 * Construct the Request
	 * 
	 * @param Router $router
	 */
	public function __contruct(Uri $uri, $method = 'index'){
		$this->uri = $uri;
		
		if($this->isHmvc() === false){
			if($this->getUri() instanceof Httprequest){
				$this->method = $this->uri->getRequestMethod();
			}
		} else {
			$this->method = $method;
		}
	}
	
	/**
	 * Create a new request based on the given uri and method
	 * 
	 * @param Uri $uri
	 * @param string $method = 'index'
	 * 
	 * @return Request
	 */
	public static function create(Uri $uri, $method = 'index'){
		$instance = new get_called_class(null);
		$instance->setUri($uri);
		$instance->setMethod($method);
		
		return $instance;
	}
	
	/**
	 * @return Router Returns the Router
	 */ 
	public function getRouter(){
		return $this->router;
	}
	
	/**
	 * @return bool Checks whether the request is a front controller 
	 * or a widget controller
	 */ 
	public function isHmvc(){
		return get_class($this->uri) !== '\Dragonfly\Network\Uri';
	}
	
	/**
	 * Set the Uri
	 * 
	 * @param Uri $uri
	 */ 	
	public function setUri(Uri $uri){
		$this->uri = $uri;
	}
	
	/**
	 * Set the method
	 * 
	 * @param Uri $uri
	 */ 
	public function setMethod($method){
		$this->method = strtolower($method);
	}
	
	/**
	 * Returns the method
	 * 
	 * @return string
	 */
	public function getMethod(){
		return $this->method;
	}

	/**
	 * Returns the used Uri
	 * 
	 * @return Uri
	 */
	public function getUri(){
		return $this->uri;
	}
	
	/**
	 * Send the request. 
	 * 
	 * @param array $params = null
	 */ 
	public function send(array $params = null){
		// Set method data from request when no paramaters are given and the request is not a hmvc
		if($this->isHmvc() === false){
			// Dispatch the router with the current Uri and given params
			$this->getRouter()->dispatch($this->getUri(), $params);
		} else {
			
		}
	}
}
