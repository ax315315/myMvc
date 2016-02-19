<?php 
	/**
	* 
	*/
	class Template
	{
		public $template_name =null;
		public $data =array();
		public $output = null;
		public $tmpfile = null;
		private $fileTime = 2;
		private $path = null;
		private $filepath = null;

		public function __construct(){
			$this->path = ROOT_PATH . APP_PATH . '/Runtime' . '/';
		}

		public function init($template_name,$time = ''){
			$this->template_name = $template_name;
			if($time != '' && is_numeric($time)){
				$this->fileTime = $time;
			}
			/*$this->data = $data;*/

			$this->fetch();
		}

		public function fetch(){
			$view_file = VIEW_PATH;
			$tempfile = $this->fileNameDo($this->template_name);
			$filepath = $this->path . $tempfile;
			if(file_exists($view_file)){
				if(file_exists($filepath) && $this->IsdeleteCache($filepath)){
					$this->tmpfile = file_get_contents($filepath) . 'cache';
				}
				if(!file_exists($filepath) && $this->tmpfile!= null){
					$this->CacheFile($tempfile,$this->tmpfile);
				}
				if(!file_exists($filepath) && $this->tmpfile == null){
					$this->tmpfile = file_get_contents($view_file);
				}
				ob_start();
				echo $this->tmpfile;				
				$content = ob_get_contents();
				ob_end_clean();
				$this->output = $content;
			}else{
				trigger_error('加载' . $view_file . '失败');
			}
		}

		public function outPut(){
			echo $this->output;
		}

		public function CacheFile($filename,$data){
			$this->filepath = $this->path . $filename;
			echo $this->IsdeleteCache($this->filepath);
			file_put_contents($this->filepath,$data);
		}

		private function IsdeleteCache($filepath){
			if(file_exists($filepath)){
				$fileinfo = new SplFileInfo($filepath);
			}else{
				return false;
			}
			$fileMtime = $fileinfo->getMTime();
			if(time() - $fileMtime > $this->fileTime){
				$fileinfo = null ;
				@unlink($filepath);
				return false;
			}else{
				return true;
			}
			$fileinfo = null ;
		}

		private function fileNameDo($filename){
			$temStr = str_replace(ROOT_PATH,'',$filename);
			$temArr = explode('/',$temStr);
			$temFile  = '';
			foreach ($temArr as $value) {
				if($value == ''){
					continue;
				}
				$temFile .= $value . '_';
			}
			$str = substr($temFile,0,-1);
			return $str;
		}

		public function astring($viewParams='' , $params=''){
			if($this->tmpfile != null){
				$temp = $this->tmpfile;
				$preg = '/\{'.'\$'.$viewParams.'\}/';
				$html = preg_replace($preg,$params,$temp);
				$this->tmpfile = $html;
			}else{
				$view_file = VIEW_PATH;
				if(file_exists($view_file)){
					$tmpfile = $view_file;
					$temp = file_get_contents($tmpfile);
					$preg = '/\{'.'\$'.$viewParams.'\}/';
					$html = preg_replace($preg,$params,$temp);
					$this->tmpfile = $html;
				}				
			}			
		}

	}
 ?>