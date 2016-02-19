<?php
	require dirname(__FILE__). '/system/app.php';
	require dirname(__FILE__). '/config/config.php';
	define('APP_PATH', '/myapp');
	Application::run($CONFIG);
 ?>