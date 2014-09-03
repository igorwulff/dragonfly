<?php
namespace Dragonfly\Hmvc;
use Dragonfly\Network\Uri;

/**
 * 
 * 
 * @package    Dragonfly
 * @subpackage Hmvc
 */
class Router implements \SplSubject {
  
	protected $routes;
	protected $observerList;
	protected $currentRequest;
  	
  	public function __construct(){
		$this->observerList = new \SplObjectStorage();
  	}
  	
  	/**
  	 * Attach a observer to the list
  	 */ 
    public function attach(\SplObserver $observer) {
        $this->observerList->attach($observer);
    }
	
	/**
	 * Detach a observer from the list
	 */
    public function detach(\SplObserver $observer) {
        $this->observerList->detach($observer);
    }
	
	/**
	 * Notify all observers from the list
	 */
    public function notify() {
        foreach ($this->observerList as $observer) {
            $observer->update($this);
        }
    }
    
    /*
     * Get the current active request used in use by the router.
     */
    public function getCurrentRequest(){
    	return $this->currentRequest;
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
	 * Get the current route based on the given request.
	 * 
	 */ 
	protected function getRoute(Request $request){
		
	}
	
	/**
	 * Load the controller and calls the required action method
	 * 
	 * @param Request $request
	 * @param array $params = array()
	 */
	public function dispatch(Request $request, array $params = null){
		$this->currentRequest = $request;
		
		$this->notify();
		
		$route = $this->getRoute($request);
	}
  
}
