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
    Clause\WhereClauseInterface,
    Component\JoinComponentInterface,
    Component\QueryComponentInterface,
    Component\TableComponentInterface
{
    use Clause\WhereClauseTrait;
    use Component\JoinComponentTrait;
    use Component\ParameterComponentTrait;
    use Component\QueryComponentTrait;
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