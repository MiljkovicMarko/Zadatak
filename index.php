<?php
	ob_start();
	require_once 'Configuration.php';

	function autoloadAll($className) {
		$className=str_replace("App",'./',str_replace("\\","/",$className));

		$class=$className.'.php';
		require_once($class);
	}
	
	spl_autoload_register('autoloadAll');

	$databaseConfiguration = new App\Core\DatabaseConfiguration(
		Configuration::DATABASE_HOST,
		Configuration::DATABASE_USER,
		Configuration::DATABASE_PASS,
		Configuration::DATABASE_NAME
	);

	$databaseConnection = new App\Core\DatabaseConnection($databaseConfiguration);

	$url = strval(filter_input(INPUT_GET, 'URL'));
	$httpMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

	$router = new App\Core\Router();
	$routes = require_once 'Routes.php';
	foreach ($routes as $route) {
		$router->add($route);
	}

	$route = $router->find($httpMethod, $url);
	$arguments = $route->extractArguments($url);

	$fullControllerName = '\\App\\Controllers\\' . $route->getControllerName() . 'Controller';
	$controller = new $fullControllerName($databaseConnection);

	$controller->__pre();
	call_user_func_array([$controller, $route->getMethodName()], $arguments);