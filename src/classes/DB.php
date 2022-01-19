<?php

namespace GameZone;

use PDO;

class DB extends PDO{

    use Singleton;

	const DB_FOLDER = __DIR__ . '/../db/';
	const SQL_PATH = self::DB_FOLDER . 'database.sql';
    const DEFAULT_DB_PATH = self::DB_FOLDER . 'database.db';

    public function __construct($dbPath = self::DEFAULT_DB_PATH){
		if(file_exists($dbPath)){
			parent::__construct("sqlite:$dbPath");
		}else {
			file_put_contents($dbPath, '');
			parent::__construct("sqlite:$dbPath");
			$this->exec(file_get_contents(self::SQL_PATH));
		}
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