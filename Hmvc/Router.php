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
  
	protected $routes;
  	
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
	
	protected function getRoute(Request $request){
		
	}
	
	/**
	 * Load the controller and calls the required action method
	 * 
	 * @param Request $request
	 * @param array $params = array()
	 */
	public function dispatch(Request $request, array $params = null){
		$route = $this->getRoute($request);
	}
  
}
