<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder\Clause;

use Phuria\UnderQuery\JoinType;
use Phuria\UnderQuery\Language\Expression\RelativeClause;
use Phuria\UnderQuery\Table\JoinMetadata;
use Phuria\UnderQuery\Table\TableInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait JoinTrait
{
    /**
     * @var array $joinTables
     */
    private $joinTables = [];

    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return TableInterface
     */
    abstract public function createTable($table, $alias = null);

    /**
     * @param string      $joinType
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function doJoin($joinType, $table, $alias = null, $joinOn = null)
    {
        $this->joinTables[] = $tableObject = $this->createTable($table, $alias);

        $joinMetadata = new JoinMetadata();
        $joinMetadata->setJoinType($joinType);

        if ($joinOn) {
            $relativeOn = new RelativeClause($tableObject, $joinOn, RelativeClause::SELF_DIRECTIVE);
            $joinMetadata->setJoinOn($relativeOn);
        }

        $tableObject->setJoinMetadata($joinMetadata);
        is_callable($table) && $table($tableObject, $joinMetadata);

        return $tableObject;
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function join($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function straightJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::STRAIGHT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function crossJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::CROSS_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function leftJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::LEFT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function rightJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::RIGHT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function innerJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::INNER_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @return array
     */
    public function getJoinTables()
    {
        return $this->joinTables;
    }
}