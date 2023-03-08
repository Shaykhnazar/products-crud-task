<?php

namespace app\core;

class View
{
    
    protected string $path;
    protected $route;
    protected string $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    /**
     * This function is important to view necessary layouts
     * @param $title
     * @param array $vars
     */
    public function render($title, array $vars = []): void
    {
        extract($vars);
        $path = 'app/views/'.$this->path.'.php';
        if(file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'app/views/layouts/'.$this->layout.'.php';
        } else {
            echo 'Вид не найден '.$this->path;
        }
    }

    /**
     * redirecting url path
     * @param $url
     */
    public function redirect($url)
    {
        header('location: '.$url);
        exit;
    }

    /**
     * @param $code
     */
    public static function errors($code)
    {
        http_response_code($code);
        $path = 'app/views/errors/'.$code.'.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    /**
     * @param $status
     * @param $message
     */
    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    /**
     * @param $url
     */
    public function location($url)
    {
        exit(json_encode(['url' => $url]));
    }
}