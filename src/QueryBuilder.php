<?php

namespace Phuria\QueryBuilder;

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
     * @var array $havingClauses
     */
    private $havingClauses;

    /**
     * @var AbstractTable[] $tables
     */
    private $tables = [];

    /**
     * @var bool $highPriority
     */
    private $highPriority;

    /**
     * @var int $maxStatementTime
     */
    private $maxStatementTime;

    /**
     * @var bool $straightJoin
     */
    private $straightJoin;

    /**
     * @var bool $sqlSmallResult
     */
    private $sqlSmallResult;

    /**
     * @var bool $sqlBigResult
     */
    private $sqlBigResult;

    /**
     * @var bool $sqlBufferResult
     */
    private $sqlBufferResult;

    /**
     * @var bool $sqlNoCache
     */
    private $sqlNoCache;

    /**
     * @var bool $sqlCalcFoundRows
     */
    private $sqlCalcFoundRows;

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
        $this->havingClauses = [];
    }

    /**
     * @return ExprBuilder
     */
    public function expr()
    {
        return new ExprBuilder(func_get_args());
    }

    /**
     * @return $this
     */
    public function addSelect()
    {
        $this->selectClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function andWhere()
    {
        $this->whereClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function andHaving()
    {
        $this->havingClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

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
        $this->orderByClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addSet()
    {
        $this->setClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addGroupBy()
    {
        $this->groupByClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

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
     * @return array
     */
    public function getHavingClauses()
    {
        return $this->havingClauses;
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

    /**
     * @return boolean
     */
    public function isHighPriority()
    {
        return $this->highPriority;
    }

    /**
     * @param boolean $highPriority
     *
     * @return $this
     */
    public function setHighPriority($highPriority)
    {
        $this->highPriority = $highPriority;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxStatementTime()
    {
        return $this->maxStatementTime;
    }

    /**
     * @param integer $maxStatementTime
     *
     * @return $this
     */
    public function setMaxStatementTime($maxStatementTime)
    {
        $this->maxStatementTime = $maxStatementTime;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isStraightJoin()
    {
        return $this->straightJoin;
    }

    /**
     * @param boolean $straightJoin
     *
     * @return $this
     */
    public function setStraightJoin($straightJoin)
    {
        $this->straightJoin = $straightJoin;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSqlSmallResult()
    {
        return $this->sqlSmallResult;
    }

    /**
     * @param boolean $sqlSmallResult
     *
     * @return $this
     */
    public function setSqlSmallResult($sqlSmallResult)
    {
        $this->sqlSmallResult = $sqlSmallResult;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSqlBigResult()
    {
        return $this->sqlBigResult;
    }

    /**
     * @param boolean $sqlBigResult
     *
     * @return $this
     */
    public function setSqlBigResult($sqlBigResult)
    {
        $this->sqlBigResult = $sqlBigResult;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSqlBufferResult()
    {
        return $this->sqlBufferResult;
    }

    /**
     * @param boolean $sqlBufferResult
     *
     * @return $this
     */
    public function setSqlBufferResult($sqlBufferResult)
    {
        $this->sqlBufferResult = $sqlBufferResult;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSqlNoCache()
    {
        return $this->sqlNoCache;
    }

    /**
     * @param boolean $sqlNoCache
     *
     * @return $this
     */
    public function setSqlNoCache($sqlNoCache)
    {
        $this->sqlNoCache = $sqlNoCache;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSqlCalcFoundRows()
    {
        return $this->sqlCalcFoundRows;
    }

    /**
     * @param boolean $sqlCalcFoundRows
     *
     * @return $this
     */
    public function setSqlCalcFoundRows($sqlCalcFoundRows)
    {
        $this->sqlCalcFoundRows = $sqlCalcFoundRows;

        return $this;
    }
}