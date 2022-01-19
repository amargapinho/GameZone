<?php

namespace GameZone;

use PDOStatement;

class Category extends DatabaseObject {

    private $categoryID;
    private $categoryName = '';
	private $deleted = false;

	/**
	 * @return bool
	 */
	public function isDeleted():bool {
		return $this->deleted;
	}

	/**
	 * @param bool $deleted
	 * @return Category
	 */
	public function setDeleted(bool $deleted):self {
		$this->deleted = $deleted;
		return $this;
	}

    /**
     * @param array $data
     * @return self
     */
    public function populate(array $data): self{
        return $this
			->setCategoryID((int)$data['categoryID'])
			->setCategoryName($data['categoryName'])
			->setDeleted((bool)$data['deleted']);
    }

    /**
     * Get the value of categoryId
     * 
     * @return int
     */ 
    public function getCategoryID(): int{
        return $this->categoryID;
    }

    /**
     * Set the value of categoryId
     *
     * @param int $categoryID
     * @return  self
     */
    public function setCategoryID(int $categoryID): self{
        $this->categoryID = $categoryID;
        return $this;
    }

    /**
     * Get the value of categoryName
     * 
     * @return string
     */ 
    public function getCategoryName(): string{
        return $this->categoryName;
    }

    /**
     * Set the value of categoryName
     *
     * @param string $categoryName
     * @return  self
     */
    public function setCategoryName(string $categoryName): self{
        $this->categoryName = $categoryName;
        return $this;
    }

    /**
     * @param Game $game
     * @return Category[]
     */
    public static function getCategoriesByGame(Game $game): array{
        $categories = [];

        $statement = DB::getInstance()->prepare('SELECT * FROM categories INNER JOIN gameCategories ON categories.categorieID ON gameCategories.categorieID WHERE gameCategories.gameID = ? AND categories.deleted = FALSE');
        if($statement->execute([$game->getGameId()])){
            foreach ($statement->fetchAll() as $row){
                $categories[] = (new self())->populate($row);
            }
        }

        return $categories;
    }

    /**
     * @return bool
     */
    public function primaryKeyIsset(): bool{
        return isset($this->categoryID);
    }

    /**
     * @return Category[]
     */
    public static function getAll(): array{
        $categories = [];

        foreach (DB::getInstance()->query('SELECT * FROM categories') as $row){
            $categories[] = (new self())->populate($row);
        }

        return $categories;
    }

    /**
     * @return int
     */
    public function getPrimaryKey(): int{
        return $this->getCategoryID();
    }

    /**
     * @return string[]
     */
    public function getInsertParams(): array{
        return [
            $this->getCategoryName()
        ];
    }

    /**
     * @param int $id
     * @return DatabaseObject
     */
    protected function setPrimaryKey($id): DatabaseObject{
        return $this->setCategoryID($id);
    }

    /**
     * @return PDOStatement
     */
    protected function prepareUpdate(): PDOStatement{
        return DB::getInstance()->prepare('UPDATE categories SET categoryName = ? WHERE categoryID = ?');
    }

    /**
     * @return PDOStatement
     */
    protected function prepareInsert(): PDOStatement{
        return DB::getInstance()->prepare('INSERT INTO categories (categoryName) VALUES (?)');
    }

    /**
     * @return PDOStatement
     */
    protected function prepareDelete(): PDOStatement{
        return DB::getInstance()->prepare('DELETE FROM categories WHERE categorieID = ?');
    }

    /**
     * @param array $names
     * @return array
     */
    public static function getCategoriesByNames(array $names): array{
        $categories = [];

        $sql = 'SELECT * FROM categories WHERE categoryName IN(' . DB::getInstance()->prepareArray($names) . ')';
        $statement = DB::getInstance()->prepare($sql);
        if($statement->execute($names)){
            foreach ($statement->fetchAll() as $row){
                $categories[] = (new self())->populate($row);
            }
        }

        return $categories;
    }
}
