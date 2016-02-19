<?php 
	/**
	* 
	*/
	class Cache
	{
		
		function __construct()
		{
			# code...
		}

		function public Save($filename , $data){
			$path = SYSTEM_PATH . APP_PATH . '/Runtime' . '/';
			$file = $path . $filename;
			if(!file_exists($file)){
				file_put_contents($file,$data);
			}else{
				
			}
		}
	}
 ?>