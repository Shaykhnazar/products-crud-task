<?php

namespace app\core;
use app\core\View;

class Router
{
    protected array $routes = [];

    protected array $params = [];

    public function __construct()
    {
        $arr = require 'app/config/routes.php';
        foreach ($arr as $key=> $val) {
            $this->add($key, $val);
        }
    }

    /**
     * Add routes
     *
     * @param $route
     * @param $params
     */
    public function add($route, $params): void
    {
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    /**
     * Check route exists in routes
     *
     * @return bool
     */
    public function match(): bool
    {
        $url = trim($_SERVER['REQUEST_URI'],'/');
        if (str_starts_with($url, 'api')) {
            // Url without QueryString params
            $url = explode('?', $url, 2)[0];
        }
        foreach ($this->routes as $route => $params) {
            if(preg_match($route, $url,$matches)) {
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * When object has taken this function run
     *
     * @return void
     */
    public function run(): void
    {
        if($this->match()) {
            $controllerClass = 'app\controllers\\'.snakeToCamelWords($this->params['controller']).'Controller';
            if(class_exists($controllerClass)) {
                $action = $this->params['action'].'Action';
                if (method_exists($controllerClass, $action)) {
                    $controller = new $controllerClass($this->params);
                    $controller->$action();
                } else {
                    View::errors(404);
                }
            } else {
                View::errors(404);
            }
        } else {
            View::errors(403);
        }
    }

}