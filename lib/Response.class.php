<?php 
	/**
	* 通讯接口
	*/
	class Response
	{
		const JSON = 'json';
		public function show($code,$message = '',$data = array(),$type=self::JSON){
			$res = array(
				'code' => $code,
				'message' => $message,
				'data' => $data,
				);
			$type = isset($_GET['format'])?$_GET['format']:self::JSON;
			if($type == 'json'){
				$this->json($code,$message,$data);
				exit;
			}elseif($type == 'array'){
				var_dump($res);
			}elseif($type == 'xml'){
				$this->xmlEncode($code,$message,$data);
			}
		}

		public function json($code,$message = '',$data = array()){
			if(!is_numeric($code)){
				return '';
			}
			$res = array(
				'code' => $code,
				'message' => $message,
				'data' => $data,
				);
			echo json_encode($res);
		}

		public function xmlEncode($code,$message = '',$data = array()){
			if(!is_numeric($code)){
				return '';
			}
			$res = array(
				'code' => $code,
				'message' => $message,
				'data' => $data,
				);
			header("Content-Type:text/xml");
			$xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
			$xml .="<root>\n";
			$xml .= $this->xmlFomat($res);
			$xml .="</root>\n";
			echo $xml;			
		}

		private function xmlFomat($data){
			$xml = '';	
			foreach ($data as $key => $value) {
				$attr = '';		
				if(is_numeric($key)){
					$attr = " id='{$key}'";
					$key = "item";
				}
				$xml .= "<{$key}{$attr}>";
				$xml .= is_array($value)?$this->xmlFomat($value):$value;
				$xml .= "</{$key}>";
			}
			return $xml;
		}
	}
 ?>