<?php

namespace app\models;
use app\core\Model;
use PDOStatement;

class Product extends Model
{

    /**
     * Get list of products with pagination
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getList(int $limit, int $offset): array
    {
        return $this->db->row("SELECT * FROM `products` LIMIT :limit OFFSET :offset;", [
            'limit' => $limit,
            'offset' => $offset,
        ], [
            'limit' => \PDO::PARAM_INT,
            'offset' => \PDO::PARAM_INT,
        ]);
    }

    /**
     * Get count of products
     *
     * @return array
     */
    public function getCount(): array
    {
        return $this->db->fetch("SELECT COUNT(*) as count FROM `products`;");
    }

    /**
     * Store new product
     *
     * @param $name
     * @param $sku
     * @return bool|PDOStatement
     */
    public function store($name, $sku): bool|PDOStatement
    {
        return $this->db->fetch("INSERT INTO `products` (`name`, `sku`) VALUES (:name, :sku); SELECT LAST_INSERT_ID();", [
            'name' => $name,
            'sku' => $sku,
        ]);
    }

    /**
     * Get product by ID
     *
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return $this->db->fetch("SELECT * FROM products WHERE id = :id", ['id' => $id]);
    }

    /**
     * Get last inserted product
     *
     * @return array
     */
    public function getLastInsertedProduct(): array
    {
        return $this->db->fetch("SELECT * FROM products ORDER BY id DESC LIMIT 1");
    }

    /**
     * Check duplicate for columns name, sku
     *
     * @param $name
     * @param $sku
     * @return array|bool
     */
    public function checkDuplicate($name, $sku): array|bool
    {
        return $this->db->fetch("SELECT * FROM products WHERE name = :name OR sku = :sku;", [
            'name' => $name,
            'sku' => $sku,
        ]);
    }


}
