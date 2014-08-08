<?php
namespace Dragonfly\Network;

class Uri {
	
	protected $originalUri;
	protected $scheme;
	protected $host;
	protected $port;
	protected $user;
	protected $pass;
	protected $path;
	protected $query;
	protected $fragment;
	
	public function __construct($uri){
		$this->originalUri = $uri;
		$this->parse($uri);
	}
	
	protected function parse($uri){
		if($components = parse_url($uri)){
			foreach($components as $key => $value){
				$this->$key = $value;
			}
			
			if(!is_null($this->path)){
				$this->path = explode('/', trim($this->path, '/'));
			}
			
			if(!is_null($this->query)){
				parse_str($this->query, $this->query);	
			}
		} else {
			throw new Exception('Unable to parse uri: '.$uri);
		}
	}

	public function getOriginalUri(){
		return $this->originalUri;
	}
	
	public function getScheme(){
		return $this->scheme;
	}
	
	public function getHost(){
		return $this->host;
	}
	
	public function getPort(){
		return $this->port;
	}
	
	public function getUser(){
		return $this->user;
	}
	
	public function getPass(){
		return $this->pass;
	}
	
	public function getPath($offset = 0, $length = null){ 
		return implode('/', array_slice($this->path, $offset, $length), true);
	}
	
	public function getQuery($offset = 0, $length = null){
		return is_null($this->query) ? "" : implode('/', array_slice($this->query, $offset, $length), true);
	}
	
	public function getQueryValue($key){
		return !is_null($this->query) && array_key_exists($this->query) ? $this->query[$key] : false;
	}
	
	public function getPathCount(){
		return is_null($this->path) ? 0 : count($this->path);
	}
	
	public function getQueryCount(){
		return is_null($this->query) ? 0 : count($this->query);
	}
	
	public function getFragment(){
		return $this->fragment;	
	}
	
	public function __toString(){
		$string = '';
		
		if(!is_null($this->getScheme()) && !is_null($this->getHost()){
			$string.= $this->getScheme().'://';
			
			if(!is_null($this->getUser())){
				$string.= $this->getUser();
				if(!is_null($this->getPass())){
					$string.= ':'.$this->getPass();
				}
				$string.= '@';
			}
			
			$string.= $this->getHost();
		}
		
		if(!is_null($this->getPath())){
		  $string.= '/'.$this->getPath();
		}
		
		if(!is_null($this->getQuery())){
			$string.= '?'.http_build_query($this->getQuery());
		}
		
		if(!is_null($this->getFragment())){
			$string.= '#'.$this->getFragment();
		}
		
		return $string;
	}
}
