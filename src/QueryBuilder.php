<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ExpressionInterface;
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

    /**
     * @var array $whereClauses
     */
    private $whereClauses;

    /**
     * @var array $orderByClauses
     */
    private $orderByClauses;

    /**
     * @var AbstractTable[] $tables
     */
    private $tables = [];

    /**
     * @param TableFactory $tableFactory
     */
    public function __construct(TableFactory $tableFactory = null)
    {
        $this->tableFactory = $tableFactory ?: new TableFactory();
        $this->selectClauses = [];
        $this->whereClauses = [];
        $this->orderByClauses = [];
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
        $table = $this->tableFactory->createNewTable($table, $this);
        $table->setFrom(true);

        $this->tables[] = $table;

        return $table;
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
     * @return string
     */
    public function buildSQL()
    {
        $compiler = new ExpressionCompiler();

        $rootTables = array_filter($this->tables, function (AbstractTable $table) {
            return $table->isFrom();
        });

        $joinTables = array_filter($this->tables, function (AbstractTable $table) {
            return $table->isJoin();
        });

        $select = $compiler->compileSelect($this->selectClauses);
        $where = $compiler->compileWhere($this->whereClauses);
        $from = $compiler->compileFrom($rootTables);
        $join = $compiler->compileJoin($joinTables);
        $orderBy = $compiler->compileOrderBy($this->orderByClauses);

        $sql = "SELECT $select FROM $from";

        if ($join) {
            $sql .= ' ' . $join;
        }

        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        return $sql;
    }

    /**
     * @return Query
     */
    public function buildQuery()
    {
        return new Query($this->buildSQL());
    }
}