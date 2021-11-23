<?php

namespace GameZone;

trait Singleton{

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

}