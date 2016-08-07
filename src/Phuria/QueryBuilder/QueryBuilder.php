<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Reference\ColumnReference;
use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryBuilder
{
    /**
     * @var TableFactory $tableFactory
     */
    private $tableFactory;

    /**
     * @var array $selectClauses
     */
    private $selectClauses;


    public function __construct(TableFactory $tableFactory = null)
    {
        $this->tableFactory = $tableFactory ?: new TableFactory();
        $this->selectClauses = [];
    }

    /**
     * @param mixed $clause
     *
     * @return $this
     */
    public function addSelect($clause)
    {
        $this->selectClauses[] = $clause;

        return $this;
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function from($table)
    {
        $table = $this->tableFactory->createNewTable($table, $this);



        $this->rootTable = $table;

        return $table;
    }

    public function setAlias($alias)
    {
        $this->rootTable .= ' AS ' . $alias;
    }

    public function buildQuery()
    {
        $selectClauses = array_map(function ($clause) {
            if ($clause instanceof ColumnReference) {
                return $clause->getFullName();
            }

            return $clause;
        }, $this->selectClauses);

        return new Query(implode(', ', $selectClauses), $this->rootTable);
    }
}