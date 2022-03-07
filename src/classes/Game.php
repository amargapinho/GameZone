<?php
namespace GameZone;

use PDOStatement;

class Game extends DatabaseObject {

	private const CSV_NAME=0;
	private const CSV_DESCRIPTION=1;
	private const CSV_RELEASE_DATE=2;
	private const CSV_PRICE=3;
	private const CSV_REVIEW=4;
	private const CSV_WISHLISTED=5;
	private const CSV_MISC=6;
	public $gameID;
	public $gameName='';

	/**
	 * @var Image[]
	 */
	public $images;
	public $description='';

	/**
	 * @var Category[]
	 */
	public $categories;
	public $releaseDate;
	public $price;
	public $review;
	public $wishlisted=false;
	private $deleted=false;

	/**
	 * @return bool
	 */
	public function isDeleted():bool {
		return $this->deleted;
	}

	/**
	 * @param bool $deleted
	 * @return Game
	 */
	public function setDeleted(bool $deleted):self {
		$this->deleted=$deleted;

		return $this;
	}

	/**
	 * @param array $data
	 * @return self
	 */
	public function populate(array $data):DatabaseObject {
		return $this->setGameID((int) $data['gameID'])->setGameName($data['gameName'])->setDescription($data['description'])->setReleaseDate($data['releaseDate'])->setPrice($data['price'])->setReview((int) $data['review'])->setWishlisted((bool) $data['wishlisted'])->setDeleted((bool) $data['deleted']);
	}

	/**
	 * Get the value of gameID
	 *
	 * @return int
	 */
	public function getGameID():int {
		return $this->gameID;
	}

	/**
	 * Set the value of gameID
	 *
	 * @param int $gameID
	 * @return  self
	 */
	public function setGameID(int $gameID):self {
		if ($gameID!==0) {
			$this->gameID=$gameID;
		}

		return $this;
	}

	/**
	 * Get the value of gameName
	 *
	 * @return string
	 */
	public function getGameName():string {
		return $this->gameName;
	}

	/**
	 * Set the value of gameName
	 *
	 * @param string $gameName
	 * @return  self
	 */
	public function setGameName(string $gameName):self {
		$this->gameName=$gameName;

		return $this;
	}

	/**
	 * Get the value of images
	 *
	 * @return Image[]
	 */
	public function getImages():array {
		if (!isset($this->images)) {
			$this->images=Image::getImagesByGame($this);
		}

		return $this->images;
	}

	/**
	 * @param Image $image
	 * @return self
	 */
	public function addImage(Image $image):self {
		$this->loadImages()->images[]=$image;

		return $this;
	}

	/**
	 * Get the value of description
	 *
	 * @return string
	 */
	public function getDescription():string {
		return $this->description;
	}

	/**
	 * Set the value of description
	 *
	 * @param string $description
	 * @return  self
	 */
	public function setDescription(string $description):self {
		$this->description=$description;

		return $this;
	}

	/**
	 * @return Category[]
	 */
	public function getCategories():array {
		return $this->loadCategories()->categories;
	}

	/**
	 * @param Category $category
	 * @return self
	 */
	public function addCategory(Category $category):self {
		DB::getInstance()->prepare('INSERT INTO gameCategories(gameID, categorieID) VALUES (?, ?)')->execute([$this->getGameID(), $category->getCategoryID()]);

		$this->loadCategories(true);

		return $this;
	}

	/**
	 * Get the value of releaseDate
	 *
	 * @return int
	 */
	public function getReleaseDate():int {
		return $this->releaseDate;
	}

	/**
	 * Set the value of releaseDate
	 *
	 * @param int|string $releaseDate
	 * @return  self
	 */
	public function setReleaseDate($releaseDate):self {
		$this->releaseDate=$this->convertDate($releaseDate);

		return $this;
	}

	/**
	 * Get the value of price
	 *
	 * @return float
	 */
	public function getPrice():float {
		return $this->price;
	}

	/**
	 * Set the value of price
	 *
	 * @param float|string $price
	 * @return  self
	 */
	public function setPrice($price):self {
		$this->price=(float) str_replace(',', '.', $price);

		return $this;
	}

	/**
	 * Get the value of review
	 *
	 * @return int
	 */
	public function getReview():int {
		return $this->review;
	}

	/**
	 * Set the value of review
	 *
	 * @param int $review
	 * @return  self
	 */
	public function setReview(int $review):self {
		$this->review=$review;

		return $this;
	}

	/**
	 * Get the value of wishlisted
	 *
	 * @return bool
	 */
	public function isWishlisted():bool {
		return $this->wishlisted;
	}

	/**
	 * Set the value of wishlisted
	 *
	 * @param bool $wishlisted
	 * @return  self
	 */
	public function setWishlisted(bool $wishlisted):self {
		$this->wishlisted=$wishlisted;

		return $this;
	}

	/**
	 * @return self[]
	 */
	public static function getAll():array {
		$games=[];

		foreach (DB::getInstance()->query('SELECT * FROM games WHERE deleted = 0') as $row) {
			$games[]=(new self())->populate($row);
		}

		return $games;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	public static function getGame(int $id):self {
		$game=new self();

		$statement=DB::getInstance()->prepare('SELECT * FROM games WHERE gameID = ? LIMIT 1');
		if ($statement->execute([$id])&&$data=$statement->fetch()) {
			$game->populate($data);
		}

		return $game;
	}

	/**
	 * @param bool $forceReload
	 * @return self
	 */
	public function loadCategories(bool $forceReload=false):self {
		if (!isset($this->categories)||$forceReload) {
			$this->categories=Category::getCategoriesByGame($this);
		}

		return $this;
	}

	/**
	 * @param bool $forceReload
	 * @return self
	 */
	public function loadImages(bool $forceReload=false):self {
		if (!isset($this->images)||$forceReload) {
			$this->images=Image::getImagesByGame($this);
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function getInsertParams():array {
		return [$this->getReview(), $this->getPrice(), $this->getGameName(), $this->getDescription(), $this->getReleaseDate(), (int) $this->isWishlisted(), (int) $this->isDeleted()];
	}

	public function primaryKeyIsset():bool {
		return isset($this->gameID);
	}

	public function getPrimaryKey():int {
		return $this->getGameID();
	}

	protected function setPrimaryKey($id):DatabaseObject {
		return $this->setGameID($id);
	}

	protected function prepareUpdate():PDOStatement {
		return DB::getInstance()->prepare('UPDATE games SET review = ?, price = ?, gameName = ?, description = ?, releaseDate = ?, wishlisted = ?, deleted = ? WHERE gameID = ?');
	}

	protected function prepareInsert():PDOStatement {
		return DB::getInstance()->prepare('INSERT INTO games (review, price, gameName, description, releaseDate, wishlisted, deleted) VALUES(?, ?, ?, ?, ?, ?, ?)');
	}

	/**
	 * @param array $csvArray
	 * @return self
	 */
	public static function importCSV(array $csvArray):self {

		$game=new self();

		$game->setGameName($csvArray[self::CSV_NAME])->setDescription(str_replace('<br>', PHP_EOL, $csvArray[self::CSV_DESCRIPTION]))->setReleaseDate($csvArray[self::CSV_RELEASE_DATE])->setPrice((float) $csvArray[self::CSV_PRICE])->setReview((int) $csvArray[self::CSV_REVIEW])->setWishlisted((bool) $csvArray[self::CSV_WISHLISTED])->save();

		$csvSize=count($csvArray);

		for ($i=self::CSV_MISC; $i<$csvSize; $i++) {

			// 0 => type, 1 => categoryName/extension, 2 => base64 image
			$data=explode(':', $csvArray[$i]);
			switch ($data[0]) {
				case 'category':
					$game->addCategory(Category::import($data[1]));
					break;

				case 'image':
					Image::import($game->getGameID(), $data[1], $data[2]);
					break;
			}
		}

		return $game;
	}

	/**
	 * @return string
	 */
	public function getTwitchImage():string {
		$coverURL=TwitchSearch::getInstance()->search($this->getGameName());
		if (!empty($coverURL)) {

			$imageName=Image::generateImageName();
			file_put_contents(Image::PATH.$imageName, file_get_contents($coverURL));

			$image=new Image();
			$image->setImageName($imageName)->setGameID($this->getGameID())->save();

			$this->loadImages(true);

			$imageName=Image::WEB_PATH.$imageName;
		}

		return $imageName??$coverURL;
	}

	/**
	 * @return string
	 */
	public function getCategoriesAsString():string {
		$names=[];

		foreach ($this->getCategories() as $category) {
			$names[]=$category->getCategoryName();
		}

		return implode(', ', $names);
	}

	/**
	 * @return string
	 */
	public function getPriceFormatted():string {
		return number_format($this->getPrice(), 2, ',', '');
	}

	/**
	 * @param string|int $date
	 * @return int
	 */
	public function convertDate($date):int {
		$time=strtotime($date);

		return $time!==false?$time:$date;
	}

	public function exportCSV($file) {
		$csv=[];

		$csv[self::CSV_NAME]=$this->getGameName();
		$csv[self::CSV_DESCRIPTION]=str_replace(["\r", "\n", "\r\n"], '<br>', $this->getDescription());
		$csv[self::CSV_RELEASE_DATE]=$this->getReleaseDate();
		$csv[self::CSV_PRICE]=$this->getPrice();
		$csv[self::CSV_REVIEW]=$this->getReview();
		$csv[self::CSV_WISHLISTED]=$this->isWishlisted();

		foreach ($this->getCategories() as $category) {
			$csv[]='category:'.$category->getCategoryName();
		}

		foreach ($this->getImages() as $image) {
			$csv[]='image:'.Image::getExtension($image->getImageName()).':'.base64_encode(file_get_contents(Image::PATH.$image->getImageName()));
		}

		fputcsv($file, $csv, ';');
	}

	/**
	 * @param array $files
	 */
	public function uploadImages(array $files) {
		if (is_array($files['name'])) {
			foreach (array_keys($files['name']) as $key) {
				$this->uploadImage($files['name'][$key], $files['tmp_name'][$key]);
			}
		} else {
			$this->uploadImage($files['name'], $files['tmp_name']);
		}

		$this->loadImages(true);
	}

	private function uploadImage($name, $tmp) {

		$name=Image::generateImageName(Image::getExtension($name));

		if (move_uploaded_file($tmp, Image::PATH.$name)) {
			(new Image())->setImageName($name)->setGameID($this->getGameID())->save();
		}
	}

	public function deleteImages() {
		foreach ($this->getImages() as $image) {
			$image->delete();
		}
	}

	public static function getGameByName(string $name):Game {
		$game=new self();

		$statement=DB::getInstance()->prepare('SELECT * FROM games WHERE gameName = ? LIMIT 1');
		if ($statement->execute([$name])) {
			$game->populate($statement->fetch());
		}

		return $game;
	}

	public function delete() {
		$this->setDeleted(true)->save();
	}

	public function recover() {
		$this->setDeleted(false)->save();
	}

	/**
	 * @return Game[]
	 */
	public function getSimilarGames():array {
		$games=[];

		if (!empty($this->getCategories())) {

			$params=$this->getCategoryIDs();
			$db=DB::getInstance();
			$prepare=$db->prepareArray($params);
			$params[]=$this->getGameID();
			$sql="SELECT DISTINCT games.* FROM games INNER JOIN gameCategories ON games.gameID = gameCategories.gameID INNER JOIN categoryRarity ON gameCategories.categorieID = categoryRarity.categorieID WHERE gameCategories.categorieID IN($prepare) AND games.deleted = 0 AND NOT games.gameID = ? ORDER BY categoryRarity.categoryCount";

			$statement=$db->prepare($sql);
			if ($statement->execute($params)) {
				foreach ($statement->fetchAll() as $row) {
					$games[]=(new self())->populate($row);
				}
			}

		}

		return $games;
	}

	/**
	 * @return int[]
	 */
	private function getCategoryIDs():array {
		$ids=[];

		foreach ($this->getCategories() as $category) {
			$ids[]=$category->getCategoryID();
		}

		return $ids;
	}

	public function removeCategories() {
		DB::getInstance()->prepare('DELETE FROM gameCategories WHERE gameID = ?')->execute([$this->getGameID()]);
	}

	/**
	 * @return Game[]
	 */
	public static function getWishlist():array {
		$games=[];

		$sql='SELECT * FROM games WHERE wishlisted = 1 AND deleted = 0';
		foreach (DB::getInstance()->query($sql) as $row) {
			$games[]=(new self())->populate($row);
		}

		return $games;
	}

	/**
	 * @return Game[]
	 */
	public static function getDeletedGames():array {
		$games=[];

		$sql='SELECT * FROM games WHERE deleted = 1';
		foreach (DB::getInstance()->query($sql) as $row) {
			$games[]=(new self())->populate($row);
		}

		return $games;
	}

}
?>