<?php

namespace app\models;
use app\core\Model;

class Product extends Model
{

    /**
     * Get list
     * @return array
     */
    public function getList(): array
    {
        return $this->db->row('SELECT `id`, `name`, `sku` from `products`');
    }

}
