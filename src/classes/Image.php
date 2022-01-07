<?php

namespace GameZone;

use PDOStatement;

class Image extends DatabaseObject {

    const PATH = __DIR__ . '/../images/';

    private $imageID;
    private $imageName;
    private $gameID;

    public function populate(array $data): self{
        return $this
            ->setImageID($data['imageID'])
            ->setImageName($data['imageName'])
            ->setGameID($data['gameID']);
    }

    /**
     * @return int
     */
    public function getImageID(): int{
        return $this->imageID;
    }

    /**
     * @param int $imageID
     * @return self
     */
    public function setImageID(int $imageID): self{
        $this->imageID = $imageID;
        return $this;
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
        return isset($this->imageID);
    }

    /**
     * @return int
     */
    protected function getPrimaryKey(): int{
        return $this->getImageID();
    }

    /**
     * @param int $id
     * @return DatabaseObject
     */
    protected function setPrimaryKey(int $id): DatabaseObject{
        return $this->setImageID($id);
    }

    /**
     * @return PDOStatement
     */
    protected function prepareUpdate(): PDOStatement{
        return DB::getInstance()->prepare('UPDATE images SET imageName = ?, deleted = ?, gameID = ?, imageID = ? WHERE imageID = ?');
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