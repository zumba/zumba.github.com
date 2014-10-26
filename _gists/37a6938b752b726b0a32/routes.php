<?php
 
App::uses('ZumbaRoute', 'Routing/Route');
 
Router::defaultRouteClass('ZumbaRoute');
 
$routesFile = __DIR__ . '/routes.connect.php';
$routesHash = sha1_file($routesFile);
 
$cacheFile = TMP . '/routes-' . $routesHash . '.php';
if (file_exists($cacheFile)) {
	include $cacheFile;
} else {
	include $routesFile;
 
	// Prepare for cache
	foreach (Router::$routes as $i => $route) {
		$route->compile();
	}
 
	$tmpCacheFile = TMP . '/routes-' . uniqid('tmp-', true) . '.php';
	file_put_contents($tmpCacheFile, '<?php
		Router::$initialized = true;
		Router::$routes = ' . var_export(Router::$routes, true) . ';
	');
	rename($tmpCacheFile, $cacheFile);
}
 
Router::connectNamed(true);
