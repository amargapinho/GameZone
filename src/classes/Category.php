<?php

namespace GameZone;

use PDOStatement;

class Category extends DatabaseObject {

    private $categoryId;
    private $categoryName = '';
    /**
     * @param array $data
     * @return self
     */
    public function populate(array $data): self{
        return $this
        ->setCategoryId((int)$data['categoryId'])
        ->setCategoryName($data['categoryName']);
    }

    /**
     * Get the value of categoryId
     * 
     * @return int
     */ 
    public function getCategoryId(): int{
        return $this->categoryId;
    }

    /**
     * Set the value of categoryId
     *
     * @param int $categoryId
     * @return  self
     */
    public function setCategoryId(int $categoryId): self{
        $this->categoryId = $categoryId;
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
        return isset($this->categoryId);
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
        return $this->getCategoryId();
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
    protected function setPrimaryKey(int $id): DatabaseObject{
        return $this->setCategoryId($id);
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
