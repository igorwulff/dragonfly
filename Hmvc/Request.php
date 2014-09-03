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
	protected $method;
	
	/**
	 * Construct the Request
	 * 
	 * @param Router $router
	 */
	public function __contruct(Uri $uri, $method = null, Request $parent = null){
		$this->uri = $uri;
		$this->parent = $parent;
		
		if($this->isHmvc() === false && is_null($method)){
			$this->method = $this->getUri()->getRequestMethod();
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
	public function create(Uri $uri, $method = 'index'){
		$class = get_class($this);
		return new $class($uri, $method, $this);
	}
	
	/**
	 * @return bool Checks whether the request is a front controller 
	 * or a widget controller
	 */ 
	public function isHmvc(){
		return get_class($this->uri) !== '\Dragonfly\Network\Uri';
	}
	
	/**
	 * @return Router Returns the Router
	 */ 
	public function getRouter(){
		// if there is no parent or the request has a router assigned, then return the router else call the parent.
		
		if(is_null($this->router)){
			if(is_null($this->parent)){ // if there is no parent create a router object
				$this->router = new Router();
			} else {
				return $this->getParent()->getRouter();
			}
		}
		
		return $this->router;
	}
	
	public function setRouter(Router $router){
		$this->router = $router;
	}
	
	public function getParent(){
		return $this->parent;
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
		if($this->isHmvc() === true && is_null($params)){
			$params = $this->getUri()->getMethodData();
		}
		
		// Dispatch the router with the current Uri and given params
		$this->getRouter()->dispatch($this, $params);
	}
}
