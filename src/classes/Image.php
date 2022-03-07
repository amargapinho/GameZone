<?php

namespace GameZone;

use PDOStatement;

class Image {

	const PATH=__DIR__.'/../img/';

	const WEB_PATH='/src/img/';

	public $imageName;

	public $gameID;

	/**
	 * @param array $data
	 * @return Image
	 */
	public function populate(array $data):self {
		return $this->setImageName($data['imageName'])->setGameID((int) $data['gameID']);
	}

	/**
	 * @return string
	 */
	public function getImageName():string {
		return $this->imageName;
	}

	/**
	 * @param string $imageName
	 * @return self
	 */
	public function setImageName(string $imageName):self {
		$this->imageName=$imageName;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getGameID():int {
		return $this->gameID;
	}

	/**
	 * @param int $gameID
	 * @return self
	 */
	public function setGameID(int $gameID):self {
		$this->gameID=$gameID;

		return $this;
	}

	/**
	 * @param Game $game
	 * @return Image[]
	 */
	public static function getImagesByGame(Game $game):array {
		$images=[];

		$statement=DB::getInstance()->prepare('SELECT * FROM images WHERE gameID = ?');
		if ($statement->execute([$game->getGameID()])) {
			foreach ($statement->fetchAll() as $row) {
				$images[]=(new self())->populate($row);
			}
		}

		return $images;
	}

	/**
	 * @return array
	 */
	protected function getInsertParams():array {
		return [$this->getImageName(), $this->getGameID()];
	}

	/**
	 * @return PDOStatement
	 */
	protected function prepareInsert():PDOStatement {
		return DB::getInstance()->prepare('INSERT INTO images (imageName, gameID) VALUES(?, ?)');
	}

	/**
	 * @param string $extension
	 * @return string
	 */
	public static function generateImageName(string $extension='.jpg'):string {
		do {
			$name=uniqid().$extension;
		} while (file_exists(Image::PATH.$name));

		return $name;
	}

	/**
	 * @param string $imageName
	 * @return string
	 */
	public static function getExtension(string $imageName):string {
		return substr($imageName, strrpos($imageName, '.'));
	}

	public function save() {
		$this->prepareInsert()->execute($this->getInsertParams());
	}

	public function delete() {
		DB::getInstance()->prepare('DELETE FROM images WHERE imageName = ?')->execute([$this->getImageName()]);
		unlink(Image::PATH.$this->getImageName());
	}

	/**
	 * @param int $gameID
	 * @param string $extension
	 * @param string $base64
	 * @return Image
	 */
	public static function import(int $gameID, string $extension, string $base64):Image {
		$imageName=Image::generateImageName($extension);
		file_put_contents(Image::PATH.$imageName, base64_decode($base64));

		$image=new Image();
		$image->setImageName($imageName)->setGameID($gameID)->save();

		return $image;
	}

}