<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Table;

use Phuria\UnderQuery\JoinType;
use Phuria\UnderQuery\Language\Expression\RelativeClause;
use Phuria\UnderQuery\QueryBuilder\Clause as Clause;
use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\QueryBuilder\Clause\OrderByInterface;
use Phuria\UnderQuery\QueryBuilder\Clause\SetInterface;
use Phuria\UnderQuery\QueryBuilder\Clause\WhereInterface;
use Phuria\UnderQuery\Utils\RecursiveArgs;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class RelativeQueryBuilder implements
    Clause\GroupByInterface,
    Clause\HavingInterface,
    Clause\JoinInterface,
    Clause\LimitInterface,
    Clause\OrderByInterface,
    Clause\SelectInterface,
    Clause\SetInterface,
    Clause\WhereInterface
{
    /**
     * @var BuilderInterface
     */
    private $wrappedBuilder;

    /**
     * @var TableInterface
     */
    private $wrappedTable;

    /**
     * @param BuilderInterface $builder
     * @param TableInterface   $table
     */
    public function __construct(BuilderInterface $builder, TableInterface $table)
    {
        $this->wrappedBuilder = $builder;
        $this->wrappedTable = $table;
    }

    /**
     * @inheritdoc
     */
    public function __destruct()
    {
        unset($this->wrappedBuilder, $this->wrappedTable);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function replaceSelfReference(array $args)
    {
        return RecursiveArgs::map($args, function ($arg) {
            return $this->createRelativeClause($arg);
        });
    }

    /**
     * @param mixed $clause
     *
     * @return RelativeClause
     */
    private function createRelativeClause($clause)
    {
        return new RelativeClause($this->wrappedTable, $clause, RelativeClause::RELATIVE_DIRECTIVE);
    }

    /**
     * @param callable $callback
     *
     * @return mixed
     */
    private function getQueryBuilder(callable $callback)
    {
        return $callback($this->wrappedBuilder);
    }

    /**
     * @inheritdoc
     */
    public function addSelect($_)
    {
        $args = $this->replaceSelfReference(func_get_args());
        $this->getQueryBuilder(function (Clause\SelectInterface $qb) use ($args) {
            $qb->addSelect($args);
        });

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSelectClauses()
    {
        return $this->getQueryBuilder(function (Clause\SelectInterface $qb) {
            return $qb->getSelectClauses();
        });
    }

    /**
     * @inheritdoc
     */
    public function getGroupByClauses()
    {
        return $this->getQueryBuilder(function (Clause\GroupByInterface $qb) {
            return $qb->getGroupByClauses();
        });
    }

    /**
     * @inheritdoc
     */
    public function isGroupByWithRollUp()
    {
        return $this->getQueryBuilder(function (Clause\GroupByInterface $qb) {
            return $qb->isGroupByWithRollUp();
        });
    }

    /**
     * @inheritdoc
     */
    public function addGroupBy($_)
    {
        $args = $this->replaceSelfReference(func_get_args());
        $this->getQueryBuilder(function (Clause\GroupByInterface $qb) use ($args) {
            $qb->addGroupBy($args);
        });

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setGroupByWithRollUp($groupByWithRollUp)
    {
        $this->getQueryBuilder(function (Clause\GroupByInterface $qb) use ($groupByWithRollUp) {
            $qb->setGroupByWithRollUp($groupByWithRollUp);
        });

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getHavingClauses()
    {
        return $this->getQueryBuilder(function (Clause\HavingInterface $qb) {
            return $qb->getHavingClauses();
        });
    }

    /**
     * @inheritdoc
     */
    public function andHaving($_)
    {
        $args = $this->replaceSelfReference(func_get_args());
        $this->getQueryBuilder(function (Clause\HavingInterface $qb) use ($args) {
            $qb->andHaving($args);
        });

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLimitClause()
    {
        return $this->getQueryBuilder(function (Clause\LimitInterface $qb) {
            return $qb->getLimitClause();
        });
    }

    /**
     * @inheritdoc
     */
    public function setLimit($limitClause)
    {
        $this->getQueryBuilder(function (Clause\LimitInterface $qb) use ($limitClause) {
            $qb->setLimit($limitClause);
        });

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getOrderByClauses()
    {
        return $this->getQueryBuilder(function (Clause\OrderByInterface $qb) {
            return $qb->getOrderByClauses();
        });
    }

    /**
     * @inheritDoc
     */
    public function addOrderBy($_)
    {
        $args = $this->replaceSelfReference(func_get_args());
        $this->getQueryBuilder(function (Clause\OrderByInterface $qb) use ($args) {
            $qb->addOrderBy($args);
        });

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSetClauses()
    {
        return $this->getQueryBuilder(function (Clause\SetInterface $qb) {
            return $qb->getSetClauses();
        });
    }

    /**
     * @inheritDoc
     */
    public function addSet($_)
    {
        $args = $this->replaceSelfReference(func_get_args());
        $this->getQueryBuilder(function (Clause\SetInterface $qb) use ($args) {
            $qb->addSet($args);
        });

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getWhereClauses()
    {
        return $this->getQueryBuilder(function (Clause\WhereInterface $qb) {
            return $qb->getWhereClauses();
        });
    }

    /**
     * @inheritDoc
     */
    public function andWhere($_)
    {
        $args = $this->replaceSelfReference(func_get_args());
        $this->getQueryBuilder(function (Clause\WhereInterface $qb) use ($args) {
            $qb->andWhere($args);
        });

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getJoinTables()
    {
        return $this->getQueryBuilder(function (Clause\JoinInterface $qb) {
            return $qb->getJoinTables();
        });
    }

    /**
     * @inheritDoc
     */
    public function doJoin($joinType, $table, $alias = null, $joinOn = null)
    {
        return $this->getQueryBuilder(function (Clause\JoinInterface $qb) use ($joinType, $table, $alias, $joinOn) {
            $relativeJoin = $this->createRelativeClause($joinOn);
            return $qb->doJoin($joinType, $table, $alias, $relativeJoin);
        });
    }

    /**
     * @inheritDoc
     */
    public function join($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::JOIN, $table, $alias, $joinOn);
    }

    /**
     * @inheritDoc
     */
    public function straightJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::STRAIGHT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @inheritDoc
     */
    public function crossJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::CROSS_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @inheritDoc
     */
    public function leftJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::LEFT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @inheritDoc
     */
    public function rightJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::RIGHT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @inheritDoc
     */
    public function innerJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::INNER_JOIN, $table, $alias, $joinOn);
    }
}