<?php

namespace App\Core\Routing;

use App\Core\Request;
use App\Core\Routing\Route;
use Exception;

class Router
{
    private $request;
    private $routes;
    private $current_route;

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = Route::routes();
        $this->current_route = $this->findRoute($this->request) ?? null;

        # run middlewares if there is any
        $this->runRouteMiddleware();
    }

    private function runRouteMiddleware()
    {
        $middlewares = $this->current_route['middleware'];
        foreach ($middlewares as $middleware) {
            $object = new $middleware;
            $object->handle();
        }
        
    }

    public function findRoute(Request $request)
    {
        // echo $request->method() . " " . $request->uri();

        foreach ($this->routes as $route) {
            if ( !in_array($request->method(),$route['methods']) ) {
               return false;
            }
            if($this->regex_route_matched($route)){
                return $route;
            }
        }

        return null;
    }

    public function regex_route_matched($route)
    {
        $pattern = "/^". str_replace(['/','{','}'],['\/','(?<','>[-%\w]+)'],$route['uri']) ."$/";
        $result = preg_match($pattern,$this->request->uri(),$matched);
        if(!$result){
            return false;
        }
        foreach ($matched as $key => $value) {
            if(!is_int($key)){
                global $request;
                $request->add_route_params($key,$value);
            }
        }
        return true;
    }

    public function run()
    {
        #405 : invalid request method
        #if($this->invalidRequest()){
        #    $this->dispatch405();
        #}
        #

        #404 : uri not exist
        if(is_null($this->current_route)){
            $this->dispatch404();
        }

        $this->dispatch($this->current_route);
    }

    private function dispatch($route)
    {
        $action = $route['action'];
        # action : null
        if(is_null($action) || empty($action)){
            return;
        }

        # action : clousuer
        if(is_callable($action)){
            // $action();
            call_user_func($action);
        }

        #action : 'Controlller@method'
        if(is_string($action)){
            $action = explode('@',$action);
        }

        # action : ['Controller','method']
        if(is_array($action)){
            $className = '\App\Controllers\\' . $action[0];
            $method = $action[1];

            if(!class_exists($className)){
                throw new Exception("Class $className is not exist");
            }

            $controller = new $className(); 

            if(!method_exists($controller,$method)){
                throw new Exception("The method $method is not exist in class $controller");
            }
            
            $controller->{$method}();
        }
    }

    public function dispatch404()
    {
        header("HTTP/1.1 404 Not Found");
        view('errors.404');
        die();
    }
}