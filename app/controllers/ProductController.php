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
        $this->view->render('Manage products');
    }

    public function getlistAction()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // Parse the query string
        $params = [];
        parse_str($_SERVER['QUERY_STRING'], $params);

        // Retrieve the page number from the query string, default to 1
        $page = isset($params['page']) ? intval($params['page']) : 1;

        // Calculate the starting index and limit for the query
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Retrieve the products for the current page
        $products = $this->model->getList($limit, $offset);

        // Retrieve the total number of products for pagination
        $count = $this->model->getCount()['count'];

        if ($count > 0) {
            // Build the pagination links
            $lastPage = ceil($count / $limit);
            $prevPage = $page > 1 ? $page-1 : null;
            $nextPage = $page < $lastPage ? $page+1 : null;

            // Build the response object
            $response = [
                "data" => $products,
                "links" => [
                    "first" => 1,
                    "prev" => $prevPage,
                    "self" => $page,
                    "last" => $lastPage,
                    "next" => $nextPage,
                ]
            ];

            http_response_code(200);
            $this->responseJson($response);
        } else {
            http_response_code(404);
            $this->responseJsonAsData([], "Tovarlar topilmadi", JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * Action to store new product
     * get data from create view form
     */
    public function StoreAction()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $name = $_POST['name'] ?? null;
        $sku = $_POST['sku'] ?? null;

        if (!$name && !$sku) {
            $this->responseErrorMessage("Tovar nomi va SKU to'ldirilishi shart!");
        } else if ($this->model->checkDuplicate($name, $sku) !== false) {
            $this->responseErrorMessage("Bunday Tovar nomi yoki SKU allaqachon mavjud!");
        }

        // Insert the new product into the database
        $this->model->store($_POST['name'], $_POST['sku']);

        // Retrieve the newly inserted product
        $product = $this->model->getLastInsertedProduct();

        http_response_code(201);
        $this->responseJsonAsData($product, "Tovar qo'shildi!");
    }
}