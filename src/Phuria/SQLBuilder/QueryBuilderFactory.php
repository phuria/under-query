<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder;

use Phuria\SQLBuilder\Connection\ConnectionInterface;
use Phuria\SQLBuilder\DependencyInjection\ContainerFactory;
use Phuria\SQLBuilder\QueryBuilder\DeleteBuilder;
use Phuria\SQLBuilder\QueryBuilder\InsertBuilder;
use Phuria\SQLBuilder\QueryBuilder\InsertSelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\UpdateBuilder;
use Phuria\SQLBuilder\QueryCompiler\QueryCompilerInterface;
use Pimple\Container;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryBuilderFactory
{
    /**
     * @var Container $container
     */
    private $container;

    /**
     * @param Container|null $container
     */
    public function __construct(Container $container = null)
    {
        $this->container = $container ?: (new ContainerFactory())->create();
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ConnectionInterface $connection
     * @param string              $name
     */
    public function registerConnection(ConnectionInterface $connection, $name = 'default')
    {
        $this->container['phuria.sql_builder.connection_manager']->registerConnection(
            $connection, $name
        );
    }

    /**
     * @param string $class
     *
     * @return QueryCompilerInterface
     */
    private function createQueryBuilder($class)
    {
        $parameterClass = $this->container['phuria.sql_builder.parameter_manager.class'];

        return new $class(
            $this->container['phuria.sql_builder.table_factory'],
            $this->container['phuria.sql_builder.query_compiler'],
            new $parameterClass,
            $this->container['phuria.sql_builder.query_factory']
        );
    }

    /**
     * @return SelectBuilder
     */
    public function createSelect()
    {
        return $this->createQueryBuilder(SelectBuilder::class);
    }

    /**
     * @return UpdateBuilder
     */
    public function createUpdate()
    {
        return $this->createQueryBuilder(UpdateBuilder::class);
    }

    /**
     * @return DeleteBuilder
     */
    public function createDelete()
    {
        return $this->createQueryBuilder(DeleteBuilder::class);
    }

    /**
     * @return InsertBuilder
     */
    public function createInsert()
    {
        return $this->createQueryBuilder(InsertBuilder::class);
    }

    /**
     * @return InsertSelectBuilder
     */
    public function createInsertSelect()
    {
        return $this->createQueryBuilder(InsertSelectBuilder::class);
    }
}