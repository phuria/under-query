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
class SelectBuilder extends AbstractBuilder implements
    Clause\GroupByClauseInterface,
    Clause\HavingClauseInterface,
    Clause\LimitClauseInterface,
    Clause\OrderByClauseInterface,
    Clause\SelectClauseInterface,
    Clause\WhereClauseInterface,
    Component\JoinComponentInterface,
    Component\TableComponentInterface
{
    use Clause\GroupByClauseTrait;
    use Clause\HavingClauseTrait;
    use Clause\LimitClauseTrait;
    use Clause\OrderByClauseTrait;
    use Clause\SelectClauseTrait;
    use Clause\WhereClauseTrait;
    use Component\JoinComponentTrait;
    use Component\ParameterComponentTrait;
    use Component\TableComponentTrait;

    /**
     * @param mixed  $table
     * @param string $alias
     *
     * @return AbstractTable
     */
    public function from($table, $alias = null)
    {
        return $this->addFrom($table, $alias);
    }

    /**
     * @param mixed  $table
     * @param string $alias
     *
     * @return AbstractTable
     */
    public function addFrom($table, $alias = null)
    {
        return $this->addRootTable($table, $alias);
    }
}