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
class DeleteBuilder extends AbstractBuilder implements
    Clause\LimitClauseInterface,
    Clause\OrderByClauseInterface,
    Clause\WhereClauseInterface,
    Component\JoinComponentInterface,
    Component\TableComponentInterface
{
    use Clause\LimitClauseTrait;
    use Clause\OrderByClauseTrait;
    use Clause\WhereClauseTrait;
    use Component\JoinComponentTrait;
    use Component\TableComponentTrait;

    /**
     * @var array $deleteClauses
     */
    private $deleteClauses = [];

    /**
     * @return $this
     */
    public function addDelete()
    {
        foreach (func_get_args() as $clause) {
            $this->doAddDelete($clause);
        }

        return $this;
    }

    /**
     * @param mixed $clause
     */
    private function doAddDelete($clause)
    {
        $this->deleteClauses[] = $clause;
    }

    /**
     * @return array
     */
    public function getDeleteClauses()
    {
        return $this->deleteClauses;
    }

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