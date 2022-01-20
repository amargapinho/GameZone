<?php

namespace GameZone;

use PDO;

class DB extends PDO{

    use Singleton;

	const DB_FOLDER = __DIR__ . '/../db/';
	const SQL_PATH = self::DB_FOLDER . 'database.sql';
    const DEFAULT_DB_PATH = self::DB_FOLDER . 'database.db';

	/**
	 * @param string $dbPath
	 */
    public function __construct(string $dbPath = self::DEFAULT_DB_PATH){

		$dsn = "sqlite:$dbPath";

		if(file_exists($dbPath)){
			parent::__construct($dsn);
		}else {
			file_put_contents($dbPath, '');
			parent::__construct($dsn);
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