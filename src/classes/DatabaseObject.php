<?php

namespace GameZone;

use PDOStatement;

abstract class DatabaseObject{

    /**
     * @return bool
     */
    abstract protected function primaryKeyIsset(): bool;

    /**
     * @return int
     */
    abstract protected function getPrimaryKey(): int;

    /**
     * @param int $id
     * @return self
     */
    abstract protected function setPrimaryKey(int $id): self;

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
     * @return PDOStatement
     */
    abstract protected function prepareDelete(): PDOStatement;

    /**
     * @return self[]
     */
    abstract public static function getAll(): array;

    protected function update(){
        $this->prepareUpdate()->execute($this->getUpdateParams());
    }

    protected function insert(){
        $this->prepareUpdate()->execute($this->getInsertParams());
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

    /**
     * @return int[]
     */
    protected function getDeleteParams(): array{
        return [$this->getPrimaryKey()];
    }

    public function delete(){
        $this->prepareDelete()->execute($this->getDeleteParams());
    }

}