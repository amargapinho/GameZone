<?php

namespace GameZone;

use PDO;

class DB extends PDO{

    use Singleton;

    const DEFAULT_DB_PATH = __DIR__ . '/../db/database.db';

    public function __construct($dbPath = self::DEFAULT_DB_PATH){
        parent::__construct('sqlite:' . $dbPath);
    }

}