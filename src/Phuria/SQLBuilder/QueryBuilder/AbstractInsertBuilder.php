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
abstract class AbstractInsertBuilder extends AbstractBuilder implements
    Clause\InsertColumnsClauseInterface,
    Component\TableComponentInterface
{
    use Clause\InsertColumnsClauseTrait;
    use Component\TableComponentTrait;

    /**
     * @param mixed $table
     * @param array $columns
     *
     * @return AbstractTable
     */
    public function into($table, array $columns = [])
    {
        if (count($columns)) {
            $this->setColumns($columns);
        }

        return $this->addRootTable($table);
    }
}