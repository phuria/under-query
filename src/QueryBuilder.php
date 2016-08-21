<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\EmptyExpression;
use Phuria\QueryBuilder\Expression\ExpressionCollection;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\QueryClauseExpression;
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
     * @var QueryClauses
     */
    private $queryClauses;

    /**
     * @var AbstractTable[] $tables
     */
    private $tables = [];

    /**
     * @var ExpressionInterface $limit
     */
    private $limit;

    /**
     * @param TableFactory    $tableFactory
     * @param CompilerManager $compilerManager
     */
    public function __construct(TableFactory $tableFactory = null, CompilerManager $compilerManager = null)
    {
        $this->tableFactory = $tableFactory ?: new TableFactory();
        $this->compilerManager = $compilerManager ?: new CompilerManager();
        $this->queryClauses = new QueryClauses();
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
        $this->queryClauses->addSelect(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function andWhere()
    {
        $this->queryClauses->andWhere(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function andHaving()
    {
        $this->queryClauses->andHaving(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addOrderBy()
    {
        $this->queryClauses->addOrderBy(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addSet()
    {
        $this->queryClauses->addSet(...func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addGroupBy()
    {
        $this->queryClauses->addGroupBy(...func_get_args());

        return $this;
    }

    /**
     * @return QueryClauses
     */
    public function getQueryClauses()
    {
        return $this->queryClauses;
    }

    /**
     * @param string $hint
     *
     * @return $this
     */
    public function addHint($hint)
    {
        $this->queryClauses->addHint(...func_get_args());

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
    public function limit()
    {
        $this->limit = ExprNormalizer::normalizeExpression(func_get_args());

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
     * @return AbstractTable[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @return ExpressionCollection
     */
    public function getRootTables()
    {
        return new ExpressionCollection(array_filter($this->getTables(), function (AbstractTable $table) {
            return $table->isRoot();
        }), ', ');
    }

    /**
     * @return ExpressionCollection
     */
    public function getJoinTables()
    {
        return new ExpressionCollection(array_filter($this->getTables(), function (AbstractTable $table) {
            return $table->isJoin();
        }), ' ');
    }

    /**
     * @return ExpressionInterface
     */
    public function getLimitExpression()
    {
        $expr = $this->limit;

        if (!$expr) {
            return new EmptyExpression();
        }

        if ($expr instanceof ExpressionCollection) {
            $expr = $expr->changeSeparator(', ');
        }

        return new QueryClauseExpression(
            QueryClauseExpression::CLAUSE_LIMIT,
            $expr
        );
    }
}