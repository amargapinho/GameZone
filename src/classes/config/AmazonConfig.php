<?php

namespace GameZone\config;

class AmazonConfig{

    private $keyID = 'YOUR-AWS-KEY';
    private $secretKey = 'YOUR-AWS-SECRET-KEY';
    private $associateID = 'YOUR-AMAZON-ASSOCIATE-ID';


    /**
     * Get the value of associateID
     * 
     * @return string
     */ 
    public function getAssociateID(): string
    {
        return $this->associateID;
    }

    /**
     * Get the value of secretKey
     * 
     * @return string
     */ 
    public function getSecretKey(): string{
        return $this->secretKey;
    }

    /**
     * Get the value of keyID
     * 
     * @return string
     */ 
    public function getKeyID(): string
    {
        return $this->keyID;
    }
}