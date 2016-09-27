<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\TableFactory;

use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;
use Phuria\SQLBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface TableFactoryInterface
{
    /**
     * @param mixed            $table
     * @param BuilderInterface $qb
     *
     * @return AbstractTable
     */
    public function createNewTable($table, BuilderInterface $qb);
}