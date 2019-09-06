<?php

class Router{
	
	function __construct() {
		$routes = require 'routes.php';
		$route = substr($_SERVER['REQUEST_URI'], 1);
		if (array_key_exists($route, $routes)) {
			$path = $routes["$route"];
			include "$path";
		} else {
			include 'view/404.php';
		}
	}
}