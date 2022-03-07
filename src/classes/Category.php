<?php

namespace GameZone;

use PDOStatement;

class Category extends DatabaseObject {

	public $categoryID;

	public $categoryName='';

	/**
	 * @param array $data
	 * @return self
	 */
	public function populate(array $data):DatabaseObject {
		return $this->setCategoryID((int) $data['categorieID'])->setCategoryName($data['categoryName']);
	}

	/**
	 * Get the value of categoryId
	 *
	 * @return int
	 */
	public function getCategoryID():int {
		return $this->categoryID;
	}

	/**
	 * Set the value of categoryId
	 *
	 * @param int $categoryID
	 * @return  self
	 */
	public function setCategoryID(int $categoryID):self {
		if ($categoryID!==0) {
			$this->categoryID=$categoryID;
		}

		return $this;
	}

	/**
	 * Get the value of categoryName
	 *
	 * @return string
	 */
	public function getCategoryName():string {
		return $this->categoryName;
	}

	/**
	 * Set the value of categoryName
	 *
	 * @param string $categoryName
	 * @return  self
	 */
	public function setCategoryName(string $categoryName):self {
		$this->categoryName=$categoryName;

		return $this;
	}

	/**
	 * @param Game $game
	 * @return Category[]
	 */
	public static function getCategoriesByGame(Game $game):array {
		$categories=[];

		$statement=DB::getInstance()->prepare('SELECT categories.* FROM categories INNER JOIN gameCategories ON categories.categorieID = gameCategories.categorieID WHERE gameCategories.gameID = ? ORDER BY categories.categoryName');
		if ($statement->execute([$game->getGameID()])) {
			foreach ($statement->fetchAll() as $row) {
				$categories[]=(new self())->populate($row);
			}
		}

		return $categories;
	}

	/**
	 * @return bool
	 */
	public function primaryKeyIsset():bool {
		return isset($this->categoryID);
	}

	/**
	 * @return Category[]
	 */
	public static function getAll():array {
		$categories=[];

		foreach (DB::getInstance()->query('SELECT * FROM categories') as $row) {
			$categories[]=(new self())->populate($row);
		}

		return $categories;
	}

	/**
	 * @return int
	 */
	public function getPrimaryKey():int {
		return $this->getCategoryID();
	}

	/**
	 * @return string[]
	 */
	public function getInsertParams():array {
		return [$this->getCategoryName()];
	}

	/**
	 * @param int $id
	 * @return DatabaseObject
	 */
	protected function setPrimaryKey($id):DatabaseObject {
		return $this->setCategoryID($id);
	}

	/**
	 * @return PDOStatement
	 */
	protected function prepareUpdate():PDOStatement {
		return DB::getInstance()->prepare('UPDATE categories SET categoryName = ? WHERE categorieID = ?');
	}

	/**
	 * @return PDOStatement
	 */
	protected function prepareInsert():PDOStatement {
		return DB::getInstance()->prepare('INSERT INTO categories (categoryName) VALUES (?)');
	}

	/**
	 * @param array $names
	 * @return array
	 */
	public static function getCategoriesByNames(array $names):array {
		$categories=[];

		$db=DB::getInstance();
		$prepare=$db->prepareArray($names);
		$sql="SELECT * FROM categories WHERE categoryName IN($prepare)";

		$statement=$db->prepare($sql);
		if ($statement->execute($names)) {
			foreach ($statement->fetchAll() as $row) {
				$categories[]=(new self())->populate($row);
			}
		}

		return $categories;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	public static function getCategory(int $id):self {
		$category=new self();

		$statement=DB::getInstance()->prepare('SELECT * FROM categories WHERE categorieID = ?');
		if ($statement->execute([$id])) {
			$category->populate($statement->fetch());
		}

		return $category;
	}

	public function delete() {
		$params=[$this->getCategoryID()];
		$db=DB::getInstance();
		$db->prepare('DELETE FROM gameCategories WHERE categorieID = ?')->execute($params);
		$db->prepare('DELETE FROM categories WHERE categorieID = ?')->execute($params);
	}

	public static function import(string $name) {
		$categories=Category::getCategoriesByNames([$name]);

		if (empty($categories)) {
			$category=new Category();
			$category->setCategoryName($name)->save();

			return $category;
		}

		return $categories[0];
	}

}
