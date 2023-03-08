<?php
namespace app\lib;
use PDO;
use PDOStatement;

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
     * @param array $paramTypes
     * @return bool|PDOStatement
     */
    public function query($sql, array $params = [], array $paramTypes = []): bool|PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        if(!empty($params)){
            if (!empty($paramTypes)) {
                foreach ($params as $key => $val) {
                    $stmt->bindValue(':'.$key, $val, $paramTypes[$key]);
                }
            } else {
                foreach ($params as $key => $val) {
                    $stmt->bindValue(':'.$key, $val);
                }
            }
        }
        $stmt->execute();

        return $stmt;
    }

    /**
     * @param $sql
     * @param array $params
     * @param array $paramTypes
     * @return array
     */
    public function row($sql, array $params = [], array $paramTypes = []): array
    {
        $result = $this->query($sql, $params, $paramTypes);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     * @param array $params
     * @param array $paramTypes
     * @return mixed
     */
    public function column($sql, array $params = [], array $paramTypes = []): mixed
    {
        $result = $this->query($sql, $params, $paramTypes);
        return $result->fetchColumn();
    }

    /**
     * @param $sql
     * @param array $params
     * @param array $paramTypes
     * @return bool|array
     */
    public function fetch($sql, array $params = [], array $paramTypes = []): bool|array
    {
        $result = $this->query($sql, $params, $paramTypes);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
