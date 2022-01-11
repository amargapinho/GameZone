<?php

namespace GameZone;

use PDO;

class DB extends PDO{

    use Singleton;

    const DEFAULT_DB_PATH = __DIR__ . '/../db/database.db';

    public function __construct($dbPath = self::DEFAULT_DB_PATH){
        parent::__construct("sqlite:$dbPath");
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * @param array $array
     * @return string
     */
    public function prepareArray(array $array): string{
        return implode(', ', array_fill(0, count($array), '?'));
    }

}