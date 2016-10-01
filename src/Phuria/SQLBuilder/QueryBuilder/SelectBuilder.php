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
    Clause\WhereClauseInterface,
    Component\JoinComponentInterface,
    Component\TableComponentInterface
{
    use Clause\GroupByClauseTrait;
    use Clause\HavingClauseTrait;
    use Clause\LimitClauseTrait;
    use Clause\OrderByClauseTrait;
    use Clause\WhereClauseTrait;
    use Component\JoinComponentTrait;
    use Component\ParameterComponentTrait;
    use Component\TableComponentTrait;

    /**
     * @var array $selectClauses
     */
    private $selectClauses = [];

    /**
     * @return $this
     */
    public function addSelect()
    {
        foreach (func_get_args() as $clause) {
            $this->doAddSelect($clause);
        }

        return $this;
    }

    /**
     * @param string $clause
     */
    private function doAddSelect($clause)
    {
        $this->selectClauses[] = $clause;
    }

    /**
     * @return array
     */
    public function getSelectClauses()
    {
        return $this->selectClauses;
    }

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