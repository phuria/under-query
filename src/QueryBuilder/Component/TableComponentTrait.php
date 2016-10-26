<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder\Component;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\Table\AbstractTable;
use Phuria\UnderQuery\TableFactory\TableFactoryInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait TableComponentTrait
{
    /**
     * @var AbstractTable[] $tables
     */
    private $rootTables = [];

    /**
     * @return TableFactoryInterface
     */
    abstract protected function getTableFactory();

    /**
     * @return BuilderInterface
     */
    abstract public function getQueryBuilder();

    /**
     * @param mixed  $table
     * @param string $alias
     *
     * @return AbstractTable
     */
    public function addRootTable($table, $alias = null)
    {
        $this->rootTables[] = $table = $this->getTableFactory()->createNewTable($table, $this->getQueryBuilder());

        if ($alias) {
            $table->setAlias($alias);
        }

        return $table;
    }

    /**
     * @return AbstractTable[]
     */
    public function getRootTables()
    {
        return $this->rootTables;
    }
}