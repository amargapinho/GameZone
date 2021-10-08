<?php


class DB extends PDO{

    const DEFAULT_DB_PATH = __DIR__ . '/../db/database.db';

    private static $instance;

    /**
     * @return self
     */
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function __construct($dbPath = self::DEFAULT_DB_PATH){
        parent::__construct('sqlite:' . $dbPath);
    }



}