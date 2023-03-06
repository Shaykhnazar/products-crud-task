<?php

namespace app\core;
use app\lib\Db;

abstract class Model {
    
    public Db $db;

    public function __construct()
    {
        $this->db = new Db;
    }
}
