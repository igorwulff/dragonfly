<?php
namespace Dragonfly\Hmvc;
use Dragonfly\Network\Uri;

/**
 * 
 * 
 * @package    Dragonfly
 * @subpackage Hmvc
 */
class Router {
  
	protected $requestUri;
	protected $routes;
  	
  	/**
  	 * Construct the Router
  	 * 
  	 * @param Uri $requestUri
  	 */ 
	public function __construct(Uri $requestUri){
		$this->requestUri = $requestUri;
	}
	
	/**
	 * Adds an array of routes to the routes array
	 * 
	 * @param array $routes
	 * @param bool $append Whether to append or prepend the routes
	 * 
	 * @return int Returns the number of routes
	 */
	public function addRoutes(array $routes, $append = true){
		return (bool)$append ? array_push($this->routes, $routes) : array_unshift($this->routes, $routes);
	}
	
	/**
	 * @return Uri Returns the request Uri
	 */ 
	public function getRequestUri(){
		return $this->requestUri;
	}
	
	/**
	 * Load the controller and calls the required action method
	 * 
	 * @param Uri $uri
	 * @param array $params = array()
	 */
	public function dispatch(Uri $uri, array $params = array()){
		
	
	}
  
}
