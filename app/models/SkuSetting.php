<?php

namespace app\models;
use app\core\Model;

class SkuSetting extends Model
{

    /**
     * Update or Insert(If sku already exists with similar prefix and suffix)
     *
     * @param $prefix
     * @param $index
     * @param $suffix
     * @param bool $freshTableBeforeUpdate
     * @return bool|\PDOStatement
     */
    public function updateOrInsert($prefix, $index, $suffix, bool $freshTableBeforeUpdate = false): bool|\PDOStatement
    {
        if ($freshTableBeforeUpdate)
            $this->freshTableData();

        return $this->db->query("INSERT INTO sku_settings (prefix, `index`, suffix)
            VALUES (:prefix, :index, :suffix)
            ON DUPLICATE KEY UPDATE
                prefix = :prefix,
                `index` = :index,
                suffix = :suffix;"
            ,[
                'prefix' => $prefix,
                'index' => $index,
                'suffix' => $suffix,
            ]
        );
    }

    /**
     * Agarda bizda bir necha xil SKU ko'rinishlari bo'lishi kerak bo'lmasa,
     * u holda bazada 1 ta sku yaratish uchun har qo'shganimizda eskisini ochirishimiz kerak.<br>
     *
     * Agarda bizda <i>primary key</i> bo'lganida hammasini bir so'rovda <b>REPLACE INTO ...</b>
     * usulidan foydalanib amalga oshirgan bo'lardik.
     *
     * @return bool|\PDOStatement
     */
    protected function freshTableData(): bool|\PDOStatement
    {
        return $this->db->query("DELETE FROM `sku_settings`");
    }

    /**
     * Generate new sku for product
     *
     * @return string
     */
    public function generate(): string
    {
        // Find the max index on the products table with the condition if exists these prefix and suffix on the sku_settings table
        // and increments index value with statement `MAX(REGEXP_SUBSTR(p.sku, '[0-9]+')) + 1`
        $maxIndexSku = $this->db->fetch("SELECT
            CASE WHEN EXISTS (SELECT * FROM products) THEN REGEXP_SUBSTR(p.sku, '^[a-zA-Z]+') ELSE (SELECT `prefix` FROM sku_settings LIMIT 1) END AS prefix,
            CASE WHEN EXISTS (SELECT * FROM products) THEN MAX(REGEXP_SUBSTR(p.sku, '[0-9]+'))+1 ELSE (SELECT `index` FROM sku_settings LIMIT 1) END AS max_index,
            CASE WHEN EXISTS (SELECT * FROM products) THEN REGEXP_SUBSTR(p.sku, '-?[a-zA-Z]+$') ELSE (SELECT `suffix` FROM sku_settings LIMIT 1) END AS suffix
            FROM products p
                 CROSS JOIN sku_settings s
                        ON p.sku LIKE CONCAT(s.prefix, '%', s.suffix)
            GROUP BY prefix, suffix, p.sku
            ORDER BY max_index DESC
            LIMIT 1
        ");
        if (!$maxIndexSku) {
            $maxIndexSku = $this->db->fetch("SELECT `prefix`, `index` AS `max_index`, `suffix` FROM sku_settings LIMIT 1");
        }

        return $maxIndexSku['prefix'].$maxIndexSku['max_index'].$maxIndexSku['suffix'];
    }

    /**
     * Get count of sku_settings
     *
     * @return array
     */
    public function getCount(): array
    {
        return $this->db->fetch("SELECT COUNT(*) as count FROM `sku_settings`;");
    }
}
