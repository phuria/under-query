<?php
/**
 * Created by PhpStorm.
 * User: phuria
 * Date: 07.08.16
 * Time: 18:32
 */

namespace Phuria\QueryBuilder\Table;

class UnknownTable
{
    /**
     * @var string $tableName
     */
    private $tableName;

    /**
     * @var string $tableAlias
     */
    private $tableAlias;

    /**
     * @var array $selectParts
     */
    private $selectParts = [];

    /**
     * @param string $tableName
     *
     * @return $this
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->tableAlias = $alias;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->tableAlias;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addSelect($clause)
    {
        $this->selectParts[] = $clause;

        return $this;
    }

    /**
     * @return array
     */
    public function getSelectParts()
    {
        return $this->selectParts;
    }
}