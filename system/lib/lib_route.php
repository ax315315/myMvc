<?php 
	/**
	* 
	*/
	class Route
	{
		public $url_query;
		public $url_type;
		public $route_url = array();

		public function __construct(){
			$this->url_query = parse_url($_SERVER['REQUEST_URI']);
		}
		
		public function setUrlType($url_type = 2){
			if($url_type > 0 && $url_type < 3){
				$this->url_type	= $url_type	;
			}else{
				trigger_error("指定的URL模式不存在");
			}
		}

		public function getUrlArray(){
			$this->makeUrl();
			return $this->route_url;
		}

		public function makeUrl(){
			switch ($this->url_type) {
				case 1:
					$this->querytToArray();
					break;
				
				case 2:
					$this->pathinfoToArray();
					break;
			}
		}

		public function	querytToArray(){
			if(!empty($this->url_query['query'])){
				$arr = explode('&',$this->url_query['query']);
			}else{
				$arr = array();
			}

			$array = $temp = array();
			if(count($arr)){
				foreach ($arr as $item) {
					$temp = explode('=',$item);
					$array[$temp[0]] = $temp[1];
				}
				if(isset($array['app'])){
					$this->route_url['app'] = $array['app'];
				}
				if(isset($array['controller'])){
					$this->route_url['controller'] = $array['controller'];
				}
				if(isset($array['action'])){
					$this->route_url['action'] = $array['action'];
				}
				if(count($array) > 0){
					$this->route_url['params'] = $array;
				}
			}else{
				$this->route_url = array();
			}
		}
	}
 ?>