<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Compiler\CompilerManager;
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
     * @var CompilerManager $compilerManager
     */
    private $compilerManager;

    /**
     * @var array $selectClauses
     */
    private $selectClauses;

    /**
     * @var array $whereClauses
     */
    private $whereClauses;

    /**
     * @var array $orderByClauses
     */
    private $orderByClauses;

    /**
     * @var array $setClauses
     */
    private $setClauses;

    /**
     * @var array $groupByClauses
     */
    private $groupByClauses;

    /**
     * @var AbstractTable[] $tables
     */
    private $tables = [];

    /**
     * @param TableFactory    $tableFactory
     * @param CompilerManager $compilerManager
     */
    public function __construct(TableFactory $tableFactory = null, CompilerManager $compilerManager = null)
    {
        $this->tableFactory = $tableFactory ?: new TableFactory();
        $this->compilerManager = $compilerManager ?: new CompilerManager();
        $this->selectClauses = [];
        $this->whereClauses = [];
        $this->orderByClauses = [];
        $this->groupByClauses = [];
        $this->setClauses = [];
    }

    /**
     * @return $this
     */
    public function addSelect()
    {
        $this->selectClauses[] = Expr::implode(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function andWhere()
    {
        $this->whereClauses[] = Expr::implode(...func_get_args());

        return $this;
    }

    /**
     * @param $table
     *
     * @return AbstractTable
     */
    private function addRootTable($table)
    {
        $table = $this->tableFactory->createNewTable($table, $this);
        $table->setRoot(true);

        $this->tables[] = $table;

        return $table;
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function from($table)
    {
        return $this->addFrom($table);
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function addFrom($table)
    {
        return $this->addRootTable($table);
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function update($table)
    {
        return $this->addRootTable($table);
    }

    /**
     * @param string $joinType
     * @param mixed  $table
     *
     * @return AbstractTable
     */
    public function join($joinType, $table)
    {
        $table = $this->tableFactory->createNewTable($table, $this);
        $table->setJoinType($joinType);

        $this->tables[] = $table;

        return $table;
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function crossJoin($table)
    {
        return $this->join(AbstractTable::CROSS_JOIN, $table);
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function leftJoin($table)
    {
        return $this->join(AbstractTable::LEFT_JOIN, $table);
    }

    /**
     * @param string $table
     *
     * @return AbstractTable
     */
    public function innerJoin($table)
    {
        return $this->join(AbstractTable::INNER_JOIN, $table);
    }

    /**
     * @return $this
     */
    public function addOrderBy()
    {
        $this->orderByClauses[] = Expr::implode(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addSet()
    {
        $this->setClauses[] = Expr::implode(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addGroupBy()
    {
        $this->groupByClauses[] = Expr::implode(...func_get_args());

        return $this;
    }

    /**
     * @return string
     */
    public function buildSQL()
    {
        return $this->compilerManager->compile($this);
    }

    /**
     * @return Query
     */
    public function buildQuery()
    {
        return new Query($this->buildSQL());
    }

    /**
     * @return array
     */
    public function getSelectClauses()
    {
        return $this->selectClauses;
    }

    /**
     * @return array
     */
    public function getWhereClauses()
    {
        return $this->whereClauses;
    }

    /**
     * @return array
     */
    public function getOrderByClauses()
    {
        return $this->orderByClauses;
    }

    /**
     * @return array
     */
    public function getSetClauses()
    {
        return $this->setClauses;
    }

    /**
     * @return array
     */
    public function getGroupByClauses()
    {
        return $this->groupByClauses;
    }

    /**
     * @return AbstractTable[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @return AbstractTable[]
     */
    public function getRootTables()
    {
        return array_filter($this->getTables(), function (AbstractTable $table) {
            return $table->isRoot();
        });
    }

    /**
     * @return AbstractTable[]
     */
    public function getJoinTables()
    {
        return array_filter($this->getTables(), function (AbstractTable $table) {
            return $table->isJoin();
        });
    }
}