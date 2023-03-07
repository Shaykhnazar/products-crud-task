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
            $this->deleteTableData();

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
    protected function deleteTableData(): bool|\PDOStatement
    {
        return $this->db->query("DELETE FROM `sku_settings`");
    }
}
