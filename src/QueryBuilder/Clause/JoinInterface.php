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

use Phuria\UnderQuery\Table\TableInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface JoinInterface
{
    /**
     * @return array
     */
    public function getJoinTables();

    /**
     * @param string      $joinType
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function doJoin($joinType, $table, $alias = null, $joinOn = null);

    /**
     * @param mixed       $table
     * @param null|string $alias
     * @param null|string $joinOn
     *
     * @return mixed
     */
    public function join($table, $alias = null, $joinOn = null);

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function straightJoin($table, $alias = null, $joinOn = null);

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function crossJoin($table, $alias = null, $joinOn = null);


    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function leftJoin($table, $alias = null, $joinOn = null);

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function rightJoin($table, $alias = null, $joinOn = null);

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return TableInterface
     */
    public function innerJoin($table, $alias = null, $joinOn = null);
}