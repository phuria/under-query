<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder\Component;

use Phuria\UnderQuery\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait FromComponentTrait
{
    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return AbstractTable
     */
    abstract public function addRootTable($table, $alias = null);

    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return AbstractTable
     */
    public function from($table, $alias = null)
    {
        return $this->addFrom($table, $alias);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return AbstractTable
     */
    public function addFrom($table, $alias = null)
    {
        return $this->addRootTable($table, $alias);
    }
}