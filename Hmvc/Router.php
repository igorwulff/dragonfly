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
  
	protected $routeQueue;
	protected $observerStorage;
	protected $currentRequest;
  	
	public function __construct(){
		$this->routeQueue = new \SplPriorityQueue();
		$this->observerStorage = new \SplObjectStorage();
		$this->observerStorage->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
	}
	
  	/**
  	 * Attach a observer to the list
  	 */ 
    public function attach(\SplObserver $observer) {
        $this->observerStorage->attach($observer);
    }
	
	/**
	 * Detach a observer from the list
	 */
    public function detach(\SplObserver $observer) {
        $this->observerStorage->detach($observer);
    }
	
	/**
	 * Notify all observers from the list
	 */
    public function notify() {
        foreach ($this->observerStorage as $observer) {
            $observer->update($this);
        }
    }
    
    public function getObserverStorage(){
    	return $this->observerStorage;
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
	public function insertRoute($regex, $uri, $priority){
		$this->routeQueue->insert(array('regex' => $regex, 'uri' => $uri), $priority);
	}
	
	/**
	 * Get the current route based on the given request.
	 * 
	 * Examples:
	 * (news)\/[0-9]*
	 * (news)\/[a-zA-Z\-\_0-9]*
	 */ 
	protected function getRoute(Request $request){
		foreach($this->routeQueue as $route){
			if(preg_match($route['regex'], $this->request->getUri()) === true){
				$this->routeQueue->top();
				return $route['uri'];
			}
		}
		
		$this->routeQueue->top();
		return false;
	}
	
	public function getRouteQueue(){
		return $this->routeQueue;
	}
	
	/**
	 * Load the controller and calls the required action method
	 * 
	 * @param Request $request
	 * @param array $params = array()
	 */
	public function dispatch(Request $request, array $params = null){
		// Set the current request
		$this->currentRequest = $request;
		
		// notify all observers
		$this->notify();
		
		// get the route based on the request
		$route = $this->getRoute($request);
		
		if($route === false){
			throw new \BadMethodException("Unable to dispatch request. No route found.");
		} else {
			// Create the controller
			$controller = new $route($this);
			
			// Generate the method to be called
			$method = "action".$request->getMethod();
			
			// Check if the method exists and if it is callable else set method to notFound
			if(method_exists($controller, $method) === false || is_callable($controller, $method) === false){
				$request->setMethod('notFound');
				$method = "action".$request->getMethod();
			}
			
			// Call the method in the controller with the given params
			if(is_null($params)){
				call_user_func(array($controller, $method));
			} else {
				call_user_func_array(array($controller, $method), $params);
			}	
		} 
	}
  
}
