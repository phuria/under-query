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
    Component\TableComponentInterface
{
    use Clause\SetClauseTrait;
    use Clause\WhereClauseTrait;
    use Clause\OrderByClauseTrait;
    use Clause\LimitClauseTrait;
    use Component\TableComponentTrait;

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
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function update($table)
    {
        return $this->addUpdate($table);
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function addUpdate($table)
    {
        return $this->addRootTable($table);
    }
}