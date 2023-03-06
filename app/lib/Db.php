<?php
namespace app\lib;
use PDO;

class Db 
{
    protected PDO $db;

    public function __construct()
    {
        $config = require 'app/config/db.php';
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
    }

    /**
     * @param $sql
     * @param array $params
     * @return false|\PDOStatement
     */
    public function query($sql, array $params = []): bool|\PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        if(!empty($params)){
            foreach ($params as $key => $val) {
                 $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();

        return $stmt;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function row($sql, array $params = []): array
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public function column($sql, array $params = []): mixed
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}
