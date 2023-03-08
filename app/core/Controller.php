<?php

namespace app\core;
use app\core\View;

abstract class Controller
{
    protected $route;
    protected \app\core\View $view;
    protected $acl;
    protected mixed $model;

    public function __construct($route)
    {
        $this->route=$route;
        if(!$this->checkAcl()){
            View::errors(403);
        }
        $this->view= new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    /**
     * @param $name
     * @return Model
     */
    public function loadModel($name): Model
    {
        $path = 'app\models\\'.snakeToCamelWords($name);
        if (class_exists($path)) {
            return new $path;
        }
    }


    /**
     * Necessary to check in Access Control List
     * @return bool
     */
    public function checkAcl(): bool
    {
        $this->acl = require 'app/acl/'.$this->route['controller'].'.php';
        if($this->isAcl('all')){
            return true;
        }
        elseif(isset($_SESSION['authorize']['id']) && $this->isAcl('authorize')){
            return true;
        }
        elseif(!isset($_SESSION['authorize']['id']) && $this->isAcl('guest')){
            return true;
        }
        elseif(isset($_SESSION['admin']) && $this->isAcl('admin')){
            return true;
        }
        return false;    
    }

    /**
     * @param $key
     * @return bool
     */
    public function isAcl($key): bool
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }

    /**
     * @param array $errors
     * @return void
     */
    public function responseError(array $errors=[]): void
    {
        if ($errors) {
            $this->view->message(false, implode(",", $errors));
        }
    }

    /**
     * @param $message
     * @return void
     */
    public function responseSuccess($message): void
    {
        $this->view->message(true, $message);
    }

    /**
     * @param $message
     * @return void
     */
    public function responseErrorMessage($message): void
    {
        $this->view->message(false, $message);
    }

    /**
     * @param $data
     * @param int $flags
     */
    public function responseJson($data, int $flags = 0)
    {
        exit(json_encode($data, $flags));
    }

    /**
     * @param $data
     * @param int $flags
     * @param string $message
     */
    public function responseJsonAsData($data, string $message = '', int $flags = 0): void
    {
        $this->responseJson([
            'data' => $data,
            'message' => $message
        ], $flags);
    }
}