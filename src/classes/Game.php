<?php

class Game{

    private $gameId;
    private $gameName;
    private $images;
    private $description;
    private $categorieID;
    private $releaseDate;
    private $price;
    private $review;
    private $wishlisted;
    private $favored;
    private $purchaseDate;
    private $deleted;

    /**
     * Get the value of gameId
     * 
     * @return int
     */ 
    public function getGameId()
    {
        return $this->gameId;
    }

    /**
     * Set the value of gameId
     *
     * @return  self
     */ 
    public function setGameId(int $gameId)
    {
        $this->gameId = $gameId;

        return $this;
    }

    /**
     * Get the value of gameName
     * 
     * @return string
     */ 
    public function getGameName()
    {
        return $this->gameName;
    }

    /**
     * Set the value of gameName
     *
     * @return  self
     */ 
    public function setGameName(string $gameName)
    {
        $this->gameName = $gameName;

        return $this;
    }

    /**
     * Get the value of images
     * 
     * @return array
     */ 
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @return  self
     */ 
    public function setImages(array $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return self
     */
    public function addImage(string $image){
        $this->images[] = $image;

        return $this;
    }

    /**
     * Get the value of description
     * 
     * @return string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of categorieID
     * 
     * @return int
     */ 
    public function getCategorieID()
    {
        return $this->categorieID;
    }

    /**
     * Set the value of categorieID
     *
     * @return  self
     */ 
    public function setCategorieID(int $categorieID)
    {
        $this->categorieID = $categorieID;

        return $this;
    }

    /**
     * Get the value of releaseDate
     * 
     * @return string
     */ 
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set the value of releaseDate
     *
     * @return  self
     */ 
    public function setReleaseDate(string $releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get the value of price
     * 
     * @return int
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice(int $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of review
     * 
     * @return int
     */ 
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set the value of review
     *
     * @return  self
     */ 
    public function setReview(int $review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get the value of wishlisted
     * 
     * @return bool
     */ 
    public function isWishlisted()
    {
        return $this->wishlisted;
    }

    /**
     * Set the value of wishlisted
     *
     * @return  self
     */ 
    public function setWishlisted(bool $wishlisted)
    {
        $this->wishlisted = $wishlisted;

        return $this;
    }

    /**
     * Get the value of favored
     * 
     * @return bool
     */ 
    public function isFavored()
    {
        return $this->favored;
    }

    /**
     * Set the value of favored
     *
     * @return  self
     */ 
    public function setFavored(bool $favored)
    {
        $this->favored = $favored;

        return $this;
    }

    /**
     * Get the value of purchaseDate
     * 
     * @return string
     */ 
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Set the value of purchaseDate
     *
     * @return  self
     */ 
    public function setPurchaseDate(string $purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get the value of deleted
     * 
     * @return bool
     */ 
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set the value of deleted
     *
     * @return  self
     */ 
    public function setDeleted(bool $deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }
}