<?php

namespace GameZone;

use PDOStatement;

abstract class DatabaseObject{

	private $deleted = false;

    /**
     * @return bool
     */
    abstract protected function primaryKeyIsset(): bool;

    /**
     * @return int|string
     */
    abstract protected function getPrimaryKey();

    /**
     * @param int|string $id
     * @return self
     */
    abstract protected function setPrimaryKey($id): self;

    /**
     * @return array
     */
    abstract protected function getInsertParams(): array;

    /**
     * @return PDOStatement
     */
    abstract protected function prepareUpdate(): PDOStatement;

    /**
     * @return PDOStatement
     */
    abstract protected function prepareInsert(): PDOStatement;

    /**
     * @return self[]
     */
    abstract public static function getAll(): array;

	abstract public function populate(array $data): self;

	/**
	 * @return bool
	 */
	public function isDeleted():bool {
		return $this->deleted;
	}

	/**
	 * @param bool $deleted
	 * @return DatabaseObject
	 */
	public function setDeleted(bool $deleted):self {
		$this->deleted = $deleted;
		return $this;
	}

    protected function update(){
        $this->prepareUpdate()->execute($this->getUpdateParams());
    }

    protected function insert(){
		$this->prepareInsert()->execute($this->getInsertParams());
        $this->setPrimaryKey(DB::getInstance()->lastInsertId());
    }

    /**
     * @return array
     */
    protected function getUpdateParams(): array{
        $params = $this->getInsertParams();
        $params[] = $this->getPrimaryKey();
        return $params;
    }

    public function save(){
        $this->primaryKeyIsset() ? $this->update() : $this->insert();
    }

    public function delete(){
		$this
			->setDeleted(true)
			->save();
    }

    public function recover(){
        $this
            ->setDeleted(false)
            ->save();
    }

}