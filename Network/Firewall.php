<?php
namespace Dragonfly\Network;
use \Dragonfly\Hmvc\Router;

class Firewall implements \SplObserver {
	private $datasource;
	
	public function __construct(Collection $datasource){
		$this->datasource = $datasource;
	}
	
	public function getRemoteAddress(){
		return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	}
	
	public function lookup($address = null){
		$address = is_null($address) ? inet_pton(self::getServerRemoteAddress()) : inet_pton($address);
		
		foreach($this->datasource->getData() as $value){
			$from = inet_pton($value['from']);
			$to = inet_pton($value['to']);
			
			if((strlen($address) === strlen($from)) && ($address >= $from && $address <= $to)){
			    if((bool)$value['allowed'] === false){
			    	return true;
			    }
			}
		}
		
		return false;
	}
	
	public function update(\SplSubject $subject){
		if($subject instanceof Router){
			if($this->lookup() === true){
				$subject->getCurrentRequest()->setMethod('accessDeniedFirewall');
			}
		}
	}
}
