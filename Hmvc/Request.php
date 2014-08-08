<?php
namespace Dragonfly\Hmvc;
use Dragonfly\Network\Uri;
use Dragonfly\Network\Httprequest;

/**
 * 
 * 
 */
class Request {
	
	protected $router;
	protected $uri;
	protected $method;
	
	/**
	 * 
	 * 
	 * @param Router $router
	 */
	public function __contruct(Router $router = null){
		$this->router = $router;
		
		if($this->isHmvc() === false){
			$this->uri = $this->getRouter()->getRequestUri();
			
			if($this->uri instanceof Httprequest){
				$this->method = $this->getRouter()->getRequestUri()->getRequestMethod();
			}
		}
	}
	
	public static function create(Uri $uri, $method = 'action'){
		$instance = new get_called_class(null);
		$instance->setUri($uri);
		$instance->setMethod($method);
		
		return $instance;
	}
	
	public function getRouter(){
		return $this->router;
	}
	
	public function isHmvc(){
		return is_null($this->router);
	}

	public function setUri(Uri $uri){
		$this->uri = $uri;
	}
	
	public function setMethod($method){
		$method = strtolower($method);
		if(in_array($method, array('action', 'post', 'get', 'delete', 'head', 'put')) !== false){
			$this->method = $method;
		} else {
			throw new \BadMethodCallException("Invalid method given: $method");	
		}	
	}
	
	public function getMethod(){
		return $this->method;
	}

	public function getUri(){
		return $this->uri;
	}
	
	public function send(array $params = null){
		// Set method data from request when no paramaters are given and the request is not a hmvc
		if($this->isHmvc() === false && is_null($params)){
			$this->params = $this->getRouter()->getRequestUri()->getData($this->getMethod());
		}
		
		$this->getRouter()->dispatch($this->getUri());
	}
}
