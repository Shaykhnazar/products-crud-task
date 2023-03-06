<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Db;

class MainController extends Controller
{
    /**
     * Main page
     */
    public function IndexAction()
    {
        $this->view->render('Main page site');
    }
}