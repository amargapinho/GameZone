<?php

namespace GameZone;


use PDOStatement;

class Game extends DatabaseObject{

    private $gameId;
    private $gameName = '';
    /**
     * @var Image[]
     */
    private $images;
    private $description = '';
    /**
     * @var Category[]
     */
    private $categories;
    private $releaseDate;
    private $price;
    private $review;
    private $wishlisted = false;
	private $favored = false;
	private $purchaseDate;

	/**
	 * @return bool
	 */
	public function isFavored():bool {
		return $this->favored;
	}

	/**
	 * @param bool $favored
	 * @return Game
	 */
	public function setFavored(bool $favored):self {
		$this->favored=$favored;
		return $this;
	}

    /**
     * @param array $data
     * @return self
     */
    public function populate(array $data): DatabaseObject{
        return $this
        ->setGameId((int)$data['gameID'])
        ->setGameName($data['gameName'])
        ->setDescription($data['description'])
        ->setReleaseDate((int)$data['releaseDate'])
        ->setPrice((float)$data['price'])
        ->setReview((int)$data['review'])
        ->setWishlisted((bool)$data['wishlisted'])
        ->setPurchaseDate($data['purchaseDate'])
        ->setDeleted((bool)$data['deleted'])
		->setFavored((bool)$data['favored']);
    }

    /**
     * Get the value of gameId
     * 
     * @return int
     */ 
    public function getGameId(): int{
        return $this->gameId;
    }

    /**
     * Set the value of gameId
     *
     * @param int $gameId
     * @return  self
     */
    public function setGameId(int $gameId): self{
        $this->gameId = $gameId;
        return $this;
    }

    /**
     * Get the value of gameName
     * 
     * @return string
     */ 
    public function getGameName(): string{
        return $this->gameName;
    }

    /**
     * Set the value of gameName
     *
     * @param string $gameName
     * @return  self
     */
    public function setGameName(string $gameName): self{
        $this->gameName = $gameName;
        return $this;
    }

    /**
     * Get the value of images
     * 
     * @return Image[]
     */ 
    public function getImages(): array{
        if(!isset($this->images)){
            $this->images = Image::getImagesByGame($this);
        }
        return $this->images;
    }

    /**
     * @param Image $image
     * @return self
     */
    public function addImage(Image $image): self{
        $this->loadImages()->images[] = $image;
        return $this;
    }

    /**
     * Get the value of description
     * 
     * @return string
     */ 
    public function getDescription(): string{
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param string $description
     * @return  self
     */
    public function setDescription(string $description): self{
        $this->description = $description;
        return $this;
    }

    /**
     * @return Category[]
     */ 
    public function getCategories(): array{
        return $this->loadCategories()->categories;
    }

    /**
     * @param Category $category
     * @return self
     */
    public function addCategory(Category $category): self{
        $this->loadCategories()->categories[] = $category;
        return $this;
    }

    /**
     * Get the value of releaseDate
     * 
     * @return string
     */ 
    public function getReleaseDate(): string{
        return $this->releaseDate;
    }

    /**
     * Set the value of releaseDate
     *
     * @param int $releaseDate
     * @return  self
     */
    public function setReleaseDate(int $releaseDate): self{
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * Get the value of price
     * 
     * @return float
     */ 
    public function getPrice(): float{
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param float $price
     * @return  self
     */
    public function setPrice(float $price): self{
        $this->price = $price;
        return $this;
    }

    /**
     * Get the value of review
     * 
     * @return int
     */ 
    public function getReview(): int{
        return $this->review;
    }

    /**
     * Set the value of review
     *
     * @param int $review
     * @return  self
     */
    public function setReview(int $review): self{
        $this->review = $review;
        return $this;
    }

    /**
     * Get the value of wishlisted
     * 
     * @return bool
     */ 
    public function isWishlisted(): bool{
        return $this->wishlisted;
    }

    /**
     * Set the value of wishlisted
     *
     * @param bool $wishlisted
     * @return  self
     */
    public function setWishlisted(bool $wishlisted): self{
        $this->wishlisted = $wishlisted;
        return $this;
    }

    /**
     * Get the value of purchaseDate
     * 
     * @return int
     */ 
    public function getPurchaseDate(): int{
        return $this->purchaseDate;
    }

    /**
     * Set the value of purchaseDate
     *
     * @param int $purchaseDate
     * @return  self
     */
    public function setPurchaseDate(int $purchaseDate): self{
        $this->purchaseDate = $purchaseDate;
        return $this;
    }

    /**
     * @return self[]
     */
    public static function getAll(): array{
        $games = [];

        foreach(DB::getInstance()->query('SELECT * FROM games WHERE deleted = FALSE') as $row){
            $games[] = (new self())->populate($row);
        }

        return $games;
    }

    /**
     * @param int $id
     * @return self
     */
    public static function getGame(int $id): self{
        $game = new self();

        $statement = DB::getInstance()->prepare('SELECT * FROM games WHERE gameID = ? LIMIT 1');
        if($statement->execute([$id]) && $data = $statement->fetch()){
            $game->populate($data);
        }

        return $game;
    }

    /**
     * @param bool $forceReload
     * @return self
     */
    public function loadCategories(bool $forceReload = false): self{
        if(!isset($this->categories) || $forceReload) {
            $this->categories = Category::getCategoriesByGame($this);
        }
        return $this;
    }

    /**
     * @param bool $forceReload
     * @return self
     */
    public function loadImages(bool $forceReload = false): self{
        if(!isset($this->images) || $forceReload){
            $this->images = Image::getImagesByGame($this);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getInsertParams(): array{
        return [
			$this->getReview(),
			$this->getPurchaseDate(),
			$this->getPrice(),
			$this->isFavored(),
            $this->getGameName(),
            $this->getDescription(),
            $this->getReleaseDate(),
            $this->isWishlisted(),
            $this->isDeleted()
        ];
    }

    public function primaryKeyIsset(): bool{
        return isset($this->gameId);
    }

    public function getPrimaryKey(): int{
        return $this->getGameId();
    }

    protected function setPrimaryKey($id): DatabaseObject{
        return $this->setGameId($id);
    }

    protected function prepareUpdate(): PDOStatement{
        return DB::getInstance()->prepare('UPDATE games SET review = ?, purchaseDate = ?, price = ?, favored = ?, gameID = ?, gameName = ?, description = ?, releaseDate = ?, wishlisted = ?, deleted = ? WHERE gameID = ?');
    }

    protected function prepareInsert(): PDOStatement{
        return DB::getInstance()->prepare('INSERT INTO games (review, purchaseDate, price, favored, gameName, description, releaseDate, wishlisted, deleted) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
    }

    public static function importCSV(string $csv): self{
        $game = new Game();

        $csvArray = explode(";", $csv);

        $game
			->setGameName($csvArray[0])
			->setDescription($csvArray[1])
			->setReleaseDate($csvArray[2])
			->setPrice($csvArray[3])
			->setReview($csvArray[4])
			->setWishlisted($csvArray[5])
			->setPurchaseDate($csvArray[6])
			->setDeleted($csvArray[6])
			->save();

        return $game;
    }
}