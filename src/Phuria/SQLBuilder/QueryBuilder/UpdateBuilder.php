<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder;

use Phuria\SQLBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UpdateBuilder extends AbstractBuilder implements
    Clause\LimitClauseInterface,
    Clause\OrderByClauseInterface,
    Clause\SetClauseInterface,
    Clause\WhereClauseInterface,
    Component\TableComponentInterface,
    Component\JoinComponentInterface
{
    use Clause\SetClauseTrait;
    use Clause\WhereClauseTrait;
    use Clause\OrderByClauseTrait;
    use Clause\LimitClauseTrait;
    use Component\TableComponentTrait;
    use Component\JoinComponentTrait;

    /**
     * @var boolean
     */
    private $ignore = false;

    /**
     * @return boolean
     */
    public function isIgnore()
    {
        return $this->ignore;
    }

    /**
     * @param boolean $ignore
     */
    public function setIgnore($ignore)
    {
        $this->ignore = $ignore;
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return AbstractTable
     */
    public function update($table, $alias = null)
    {
        return $this->addUpdate($table, $alias);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     *
     * @return AbstractTable
     */
    public function addUpdate($table, $alias = null)
    {
        return $this->addRootTable($table, $alias);
    }
}