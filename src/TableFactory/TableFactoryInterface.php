<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\TableFactory;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\Table\AbstractTable;

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