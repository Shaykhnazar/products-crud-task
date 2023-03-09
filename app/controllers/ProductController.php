<?php

namespace app\controllers;

use app\core\Controller;

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
     *
     */
    public function getoneAction()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // Parse the query string
        $params = [];
        parse_str($_SERVER['QUERY_STRING'], $params);

        // Retrieve the product id from the query string, default to null
        $id = isset($params['id']) ? intval($params['id']) : null;

        if ($id) {
            // Retrieve the product
            $product = $this->model->getById($id);

            http_response_code(200);
            $this->responseJsonAsData($product);
        } else {
            http_response_code(404);
            $this->responseJsonAsData([], "Tovar topilmadi", JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * Action to store new product
     * get data from create form
     */
    public function StoreAction()
    {
        header("Access-Control-Allow-Methods: POST");
        $this->extractedUpdateInsert($name, $sku);

        if (!$name && !$sku) {
            $this->responseErrorMessage("Tovar nomi va SKU to'ldirilishi shart!");
        } else if ($this->model->checkDuplicate($name, $sku) !== false) {
            $this->responseErrorMessage("Bunday Tovar nomi yoki SKU allaqachon mavjud!");
        }
//        if ($this->model->checkSkuExists($sku) === false) {
//            $this->responseErrorMessage("Bunday SKU bazada mavjud emas!");
//        }

        // Insert the new product into the database
        $this->model->store($name, $sku);

        // Retrieve the newly inserted product
        $product = $this->model->getLastInsertedProduct();

        http_response_code(201);
        $this->responseJsonAsData($product, "Tovar qo'shildi!");
    }

    /**
     * Action to update product
     * get data from edit form
     */
    public function UpdateAction()
    {
        header("Access-Control-Allow-Methods: POST");
        $this->extractedUpdateInsert($name, $sku);

        $id = $_POST['id'] ?? null;
        if (!$name && !$sku && !$id) {
            $this->responseErrorMessage("Tovar nomi va SKU to'ldirilishi shart!");
        } else if ($this->model->checkDuplicate($name, $sku, $id) !== false) {
            $this->responseErrorMessage("Bunday Tovar nomi yoki SKU allaqachon mavjud!");
        }

        // Update
        $this->model->update($name, $sku, $id);

        // Retrieve the new updated product
        $product = $this->model->getById($id);

        http_response_code(200);
        $this->responseJsonAsData($product, "Tovar yangilandi!");
    }


    /**
     * Action to delete product
     */
    public function deleteAction()
    {
        header("Access-Control-Allow-Methods: POST");

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->responseErrorMessage("Tovar id`sida xatolik!");
        }

        if ($this->model->delete($id)) {
            http_response_code(200);
            $this->responseJsonAsData(true, "Tovar o'chirildi!");
        }

        http_response_code(503);
        $this->responseErrorMessage("Tovar o'chirishda xatolik!");
    }

    /**
     * @param $name
     * @param $sku
     * @return void
     */
    protected function extractedUpdateInsert(&$name, &$sku): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $name = $_POST['name'] ?? null;
        $sku = $_POST['sku'] ?? null;
    }
}