<?php

namespace app\controllers;

use app\core\Controller;

class SkuSettingController extends Controller
{
    /**
     * Generate new sku for product
     */
    public function GenerateAction()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // If sku_settings is empty, message to user about it
        $count = $this->model->getCount()['count'];
        if ($count == 0) $this->responseErrorMessage('Oldin sozlamani sozlang! Keyin mahsulot qo\'sha olasiz');

        $generatedSku = $this->model->generate();
        if (!is_null($generatedSku))
            $this->responseJsonAsData($generatedSku);
        else {
            $this->responseErrorMessage('Generatsiya qilishda xatolik yuz berdi.');
        }
    }


    /**
     * Update sku settings
     */
    public function updateAction()
    {
        $errors = [];
        // Initial values
        $prefix = '';
        $index = 0;
        $suffix = $_POST['suffix'] ?? null;

        // Validation
        if ($prefixResult = $this->validateFieldByName('prefix')) {
            $prefix = $prefixResult;
            if ($indexResult = $this->validateFieldByName('index')) {
                $index = $indexResult;
                if ($suffix && !$this->validateFieldByName('suffix')) {
                    $errors[] = "Suffiks maydoni faqat raqamlardan iborat bo'lsin!";
                }
            } else {
                $errors[] = "Index maydoni faqat raqamlardan iborat bo'lsin!";
            }
        } else {
            $errors[] = "Prefix faqat lotin harflaridan iborat bo'lsin!";
        }

        if ($errors) {
            $this->responseError($errors);
        }

        // Update statement
        if ($this->model->updateOrInsert($prefix, $index, $suffix, true)) {
            $this->responseSuccess('Settings updated!');
        }
    }

    private function validateFieldByName($fieldName): bool|string|int
    {
        $fieldValue = $_POST[$fieldName] ?? null;
        return match ($fieldName) {
            'prefix', 'suffix' => validateLatin($fieldValue) ? $fieldValue : false,
            'index' => is_numeric($fieldValue) ? $fieldValue : false,
            'default' => false
        };
    }
}