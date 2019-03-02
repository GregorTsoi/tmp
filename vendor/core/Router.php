<?php
/**
 * Created by PhpStorm.
 * User: Gregor
 * Date: 20.02.2019
 * Time: 13:06
 */

namespace vendor\core;


class Router {
    /*
     * текущий маршрут
     * @var array
     * */
    protected static $route = [];

    /*
     * таблица маршрутов
     * @var array
     * */
    protected static $routes = [];

    /*
     * возвращает текущий маршрут
     * @return array
     * */
    public static function getRoute(){
        return self::$route;
    }

    /*
     * возвращает таблицу маршрутов
     * @return array
     * */
    public static function getRoutes(){
        return self::$routes;
    }

    /*
     * добавление маршрута в таблицу маршрутов
     * @param string $regexp регулярное выражение маршрута
     * @param array $route маршрут ([controller, action, params])
     * */
    public static function add($regexp, $route = []){
        self::$routes[$regexp] = $route;
    }

    /*
     * ищет URL в таблице маршрутов
     * @param string $url входящий URL
     * @return boolean
     * */
    public static function matchRoute($url){
        foreach (self::$routes as $pattern=>$route){
            if(preg_match("#$pattern#", $url, $matches)){
                foreach ($matches as $k => $v){
                    if(is_string($k)){
                        $route[$k] = $v;
                    }
                }
                //debug($route);
                if(!isset($route['action'])){
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }


    /*
     * перенаправляет URL по корректному маршруту
     * @param string $url входящий URL
     * @return void
     * */

    public static function dispatch($url){
        if(self::matchRoute($url)){
            $controller = 'app\controllers\\' . self::$route['controller'];
            if(class_exists($controller)){
                $cObj = new $controller;
                $action = self::$route['action'] . 'Action';
                if(method_exists($cObj, $action)){
                    $cObj->$action();
                }else{
                    echo 'Method ' . $controller . '::' . $action . ' not found.';
                }
            }else{
                echo 'Class ' . $controller . ' not found.';
            }
        }else{
            http_response_code(404);
            include '404.html';
        }
    }

    protected static function upperCamelCase($name){
        return $name = str_replace(' ', '',ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase($name){
    }

    protected static function removeQueryString($url){

    }
}