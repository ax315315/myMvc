<?php 
	define('SYSTEM_PATH', dirname(__FILE__));
	define('ROOT_PATH',  substr(SYSTEM_PATH, 0,-7));
	define('SYS_LIB_PATH',SYSTEM_PATH.'/lib');
	define('APP_LIB_PATH', ROOT_PATH.'/lib');
	define('SYS_CORE_PATH', SYSTEM_PATH.'/core');
/*	define('CONTROLLER_PATH', SYSTEM_PATH.'/controller');
	define('MODEL_PATH', SYSTEM_PATH.'/model');
	define('VIEW_PATH', SYSTEM_PATH.'/view');*/
	define('LOG_PATH', SYSTEM_PATH.'/error');
 	final class Application{
 		public static $_lib = null;
 		public static $_config = null;

 		public static function init(){
 			self::setAutoLibs();
 			require SYS_CORE_PATH . '/model.php';
 			require SYS_CORE_PATH . '/controller.php';
 		}

 		public static function run($config){
 			self::$_config = $config['system'];
 			self::init();
 			self::autoload();
 			self::$_lib['route']->setUrlType(self::$_config['route']['url_type']);
 			$url_array = self::$_lib['route']->getUrlArray();
			self::path($url_array,'template');
 			self::routeToCm($url_array);
 		}

 		public static function autoload(){
 			foreach (self::$_lib as $key => $value) {
 				require(self::$_lib[$key]);
 				$lib = ucfirst($key);
 				self::$_lib[$key] = new $lib;
 				var_dump(self::$_lib);
 			}
 		}

 		public static function path($url_array,$pathname){
 			if($pathname == 'template'){
 				if(isset($url_array['app'])){
 					$app = $url_array['app'];
 				}else{
 					$app = self::$_config['route']['default_appName'];
 				}
 				$controller = isset($url_array['controller'])?$url_array['controller']:'index';
 				$action = isset($url_array['action'])?$url_array['action']:'index';
 				$temp = ROOT_PATH.'/'.$app.'/'.self::$_config['route']['default_module'].'/'.'view/';
 				$temp = $temp . $controller . '/' . $action .'.html';
 				define('VIEW_PATH',$temp);
 			}
 		}

 		public function setAutoLibs(){
 			self::$_lib = array(
 					'route' => SYS_LIB_PATH . '/lib_route.php',
 					/*'mysql' => SYS_LIB_PATH . '/lib_mysql.php',*/
 					'template' => SYS_CORE_PATH . '/template.php',
 				);
 		}

 		public static function routeToCm($url_array = array()){
 			$app = '';
 			$controller = '';
 			$action = '';
 			$model = '';
 			$params = '';
			if(isset($url_array['app'])){
 				$app = $url_array['app'];
 			}
 			if(isset($url_array['controller'])){
 				$controller = $model = $url_array['controller'];
 				if($app){
 					$controller_file = ROOT_PATH.'/'.$app.'/'.self::$_config['route']['default_module'].'/'.'controller/'.$controller.'Controller.php';
 					$model_file = ROOT_PATH.'/'.$app.'/'.self::$_config['route']['default_module'].'/'.'model/'.'Model.php';
 				}else{
					$controller_file = ROOT_PATH.'/'.$controller.'Controller.php';
 					$model_file = ROOT_PATH.'/'.$model.'Model.php';
 				}
 			}else{
 				$controller = $model = self::$_config['route']['default_controller'];
 				if($app){
 					$model_file = ROOT_PATH.'/'.$app.'/'.self::$_config['route']['default_controller'].'Model.php';
					$controller_file = ROOT_PATH.'/'.$app.'/'.self::$_config['route']['default_module'].'/'.'controller/'.self::$_config['route']['default_controller'].'Controller.php';
 				}else{
 					$controller_file = ROOT_PATH.'/'.self::$_config['route']['default_controller'].'Controller.php';
 					$model_file = ROOT_PATH.'/'.self::$_config['route']['default_controller'].'Model.php';
 				}
 			}

/* 			echo $controller_file ."<br />";
 			echo $model_file ."<br />";*/
 			if(isset($url_array['action'])){
 				$action = $url_array['action'];
 			}else{
 				$action = self::$_config['route']['default_action'];
 			}

 			if(isset($url_array['params'])){
 				$params = $url_array['params'];
 			}
 			if(file_exists($controller_file)){
 				if(file_exists($model_file)){
 					require $model_file;
 				}
 				require $controller_file;
	 			$controller = $controller.'Controller';
	 			$controller = new $controller;
	 			if($action){
	 				if(method_exists($controller, $action)){
	 					isset($params) ? $controller->$action($params):$controller->action();
	 				}else{
	 					die('控制器方法不存在');
	 				}
	 			}else{
	 				die('控制器方法不存在');
	 			} 				
 			}else{
 				die('控制器不存在');
 			}
 		}
 	}
	
 ?>