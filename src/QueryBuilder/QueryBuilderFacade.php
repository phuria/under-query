<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder;

use Phuria\UnderQuery\Connection\ConnectionInterface;
use Phuria\UnderQuery\QueryCompiler\QueryCompilerInterface;
use Phuria\UnderQuery\Statement\StatementInterface;
use Phuria\UnderQuery\Table\AbstractTable;
use Phuria\UnderQuery\TableFactory\TableFactoryInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryBuilderFacade
{
    /**
     * @var TableFactoryInterface
     */
    private $tableFactory;

    /**
     * @var QueryCompilerInterface
     */
    private $queryCompiler;

    /**
     * @var ConnectionInterface|null
     */
    private $connection;

    /**
     * @param TableFactoryInterface    $tableFactory
     * @param QueryCompilerInterface   $queryCompiler
     * @param ConnectionInterface|null $connection
     */
    public function __construct(
        TableFactoryInterface  $tableFactory,
        QueryCompilerInterface $queryCompiler,
        ConnectionInterface    $connection = null
    ) {
        $this->tableFactory = $tableFactory;
        $this->queryCompiler = $queryCompiler;
        $this->connection = $connection;
    }

    /**
     * @param mixed $builder
     *
     * @return string
     */
    public function buildSQL($builder)
    {
        return $this->queryCompiler->compile($builder);
    }

    /**
     * @param mixed $builder
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function createTable($builder, $table)
    {
        return $this->tableFactory->createNewTable($table, $builder);
    }

    /**
     * @return ConnectionInterface|null
     */
    public function getConnection()
    {
        return $this->connection;
    }
}