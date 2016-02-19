<?php 
	/**
	* 核心控制器
	*/
	class Controller
	{
		
		function __construct()
		{
			# code...
		}

		final protected function model(){
			if(empty($model)){
				trigger_error('不能实例化空模型');
			}
			$model_name = $model . "Model";
			return new $model_name;
		}

		final protected function load($lib ,$auto = TRUE){
			if(empty($lib)){
				trigger_error('加载的类库名不能为空');
			}else if($auto === TRUE){
				return Application::$_lib[$lib];
			}else if($auto === FALSE){
				return Application::newLib();
			}
		}

		final protected function show($data=array()){
			$template = $this->load('template');
			$template -> init(VIEW_PATH,$data);
			$template -> output();
		}

		final protected function assign($viewParams , $params){
			$template = $this->load('template');
			$template ->astring($viewParams,$params);
		}

		final protected function SaveFile($filename , $data){
			$file = $this->load('cache');
			$file->Save($filename , $data);
		}
	}
 ?>