<?php

namespace GameZone;

use PDOStatement;

class Image extends DatabaseObject {

    const PATH = __DIR__ . '/../images/';

    private $imageName;
    private $gameID;
	private $deleted = false;

	/**
	 * @return bool
	 */
	public function isDeleted():bool {
		return $this->deleted;
	}

	/**
	 * @param bool $deleted
	 * @return Image
	 */
	public function setDeleted(bool $deleted):self {
		$this->deleted = $deleted;
		return $this;
	}

    public function populate(array $data): self{
        return $this
            ->setImageName($data['imageName'])
            ->setGameID((int)$data['gameID'])
			->setDeleted((bool)$data['deleted']);
    }

    /**
     * @return string
     */
    public function getImageName(): string{
        return $this->imageName;
    }

    /**
     * @param string $imageName
     * @return self
     */
    public function setImageName(string $imageName): self{
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return int
     */
    public function getGameID(): int{
        return $this->gameID;
    }

    /**
     * @param int $gameID
     * @return self
     */
    public function setGameID(int $gameID): self{
        $this->gameID = $gameID;
        return $this;
    }

    /**
     * @param Game $game
     * @return Image[]
     */
    public static function getImagesByGame(Game $game): array{
        $images = [];

        $statement = DB::getInstance()->prepare('SELECT * FROM images WHERE gameID = ? AND deleted = FALSE');
        if($statement->execute([$game->getGameId()])){
            foreach ($statement->fetchAll() as $row) {
                $images[] = (new self())->populate($row);
            }
        }

        return $images;
    }

    protected function getInsertParams(): array{
        return [
            $this->getImageName(),
			$this->isDeleted(),
            $this->getGameID()
        ];
    }

    public function delete(){
        parent::delete();
        unlink(self::PATH . $this->getImageName());
    }

    /**
     * @return array
     */
    public static function getAll(): array{
        $images = [];

        foreach (DB::getInstance()->query('SELECT * FROM images') as $row){
            $images[] = (new self())->populate($row);
        }

        return $images;
    }

    /**
     * @return bool
     */
    protected function primaryKeyIsset(): bool{
        return isset($this->imageName);
    }

	/**
	 * @return string
	 */
    protected function getPrimaryKey(): string{
        return $this->getImageName();
    }

    /**
     * @param string $id
     * @return DatabaseObject
     */
    protected function setPrimaryKey($id): DatabaseObject{
        return $this->setImageName($id);
    }

    /**
     * @return PDOStatement
     */
    protected function prepareUpdate(): PDOStatement{
        return DB::getInstance()->prepare('UPDATE images SET deleted = ? WHERE imageName = ?');
    }

	/**
	 * @return array
	 */
	protected function getUpdateParams():array {
		return [
			$this->isDeleted(),
			$this->getImageName()
		];
	}

	/**
     * @return PDOStatement
     */
    protected function prepareInsert(): PDOStatement{
        return DB::getInstance()->prepare('INSERT INTO images (imageName, deleted, gameID) VALUES(?, ?, ?)');
    }

    /**
     * @return PDOStatement
     */
    protected function prepareDelete(): PDOStatement{
        return DB::getInstance()->prepare('DELETE FROM images WHERE imageID = ?');
    }
}