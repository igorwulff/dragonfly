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
	
	protected $router;
	protected $uri;
	protected $method;
	
	/**
	 * Construct the Request
	 * 
	 * @param Router $router
	 */
	public function __contruct(Router $router = null){
		$this->router = $router;
		
		if($this->isHmvc() === false){
			$this->uri = $this->getRouter()->getRequestUri();
			
			if($this->uri instanceof Httprequest){
				$this->method = $this->uri->getRequestMethod();
			}
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
	 * @return bool Checks whether the request is a a front controller 
	 * or a widget controller
	 */ 
	public function isHmvc(){
		return is_null($this->router);
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
		if($this->isHmvc() === false && is_null($params)){
			$params = $this->getRouter()->getRequestUri()->getData($this->getMethod());
		}
		
		// Dispatch the router with the current Uri and given params
		$this->getRouter()->dispatch($this->getUri(), $params);
	}
}
