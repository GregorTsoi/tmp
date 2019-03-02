<?php
use vendor\core\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('LIBS', dirname(__DIR__). '/vendor/libs') ;

require_once LIBS . '/functions.php';

spl_autoload_register(function($class){
   $file = ROOT . '/'. str_replace('\\', '/', $class) . '.php';
   if(file_exists($file)){
       require_once $file;
   }
});

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);


debug(Router::getRoute());