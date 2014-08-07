<?php
namespace Dragonfly\Hmvc;
use Dragonfly\Network\Uri;

class Router {
  
	protected $requestUri;
	protected $routes;
  
	public function __construct(Uri $requestUri, array $routes = array()){
	  $this->requestUri = $requestUri;
		$this->setRoutes($routes);
	}
	
	public function setRoutes(array $routes){
		$this->routes = $routes;
	}
	
	public function getRequestUri(){
		return $this->requestUri;
	}
	
	public function lookup(Uri $uri){
		
		
		
	}
  
}
