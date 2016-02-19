<?php 
	/**
	* 
	*/
	class Common
	{
		private $html;
		private $path;
		function __construct()
		{
			# code...
		}

		public function show(){
			/*$path = $_SERVER['SCRIPT_NAME'];*/
			$path = $_SERVER['DOCUMENT_ROOT'];
			$html = file_get_contents($path . APP_PATH ."/home/view/index.html");
			echo $html;
		}

		public function assign($viewName,$ctName){
			$html = file_get_contents($path . "/home/view/index.html");

		}
	}
 ?>