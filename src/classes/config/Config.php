<?php

namespace GameZone\config;

use GameZone\Singleton;

class Config{

    use Singleton;

    private $amazon;

    private function __construct(){
        $this->amazon = new AmazonConfig();
    }

    /**
     * @return AmazonConfig
     */
    public function getAmazonConfig(): AmazonConfig{
        return $this->amazon;
    }

}