<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Db;
use app\models\Product;

class ProductController extends Controller
{
    /**
     * Main page
     */
    public function IndexAction()
    {
        $this->view->render('Manage products', [
            'products' => $this->model->getList()
        ]);
    }


    /**
     * Action to store new product
     * get data from create view form
     */
    public function StoreAction()
    {

    }
}