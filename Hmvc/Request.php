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
		
		/* 
		 * If the request is a front controller request and no method is given, 
		 * then give $method the requestmethod from the HttpRequest.
		 * This can be get, post, put, delete, etc...
		 */
		if($this->isWidgetRequest() === false && is_null($method)){
			$method = $this->getUri()->getRequestMethod();
		}
		
		$this->setMethod($method);
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
	 * @return bool Checks whether the request is made by a widget controller or the bootstrap
	 */ 
	public function isWidgetRequest(){
		return get_class($this->uri) === '\Dragonfly\Network\Uri';
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
	
	/*
	 * Assign the router to the request
	 *
	 * @param Router $router
	 */
	public function setRouter(Router $router){
		$this->router = $router;
	}
	
	/**
	 * @return Request Returns the parent Request
	 */
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
	 * Set the method
	 * 
	 * @param string $method
	 */
	public function setMethod($method){
		$this->method = $method;
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
		// Set method data from request when no paramaters are given and the request is not a widget request
		if($this->isWidgetRequest() === false && is_null($params)){
			$params = $this->getUri()->getMethodData();
		}
		
		// Dispatch the router with the current Uri and given params
		$controller = $this->getRouter()->dispatch($this, $params);
	}
}
