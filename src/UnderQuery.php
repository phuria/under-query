<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery;

use Interop\Container\ContainerInterface;
use Phuria\UnderQuery\Connection\ConnectionInterface;
use Phuria\UnderQuery\DependencyInjection\ContainerFactory;
use Phuria\UnderQuery\QueryBuilder\DeleteBuilder;
use Phuria\UnderQuery\QueryBuilder\InsertBuilder;
use Phuria\UnderQuery\QueryBuilder\InsertSelectBuilder;
use Phuria\UnderQuery\QueryBuilder\QueryBuilderFacade;
use Phuria\UnderQuery\QueryBuilder\SelectBuilder;
use Phuria\UnderQuery\QueryBuilder\UpdateBuilder;
use Phuria\UnderQuery\QueryCompiler\QueryCompilerInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UnderQuery
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * @param ConnectionInterface|null $connection
     * @param ContainerInterface|null  $container
     */
    public function __construct(ConnectionInterface $connection = null, ContainerInterface $container = null)
    {
        $this->container = $container ?: (new ContainerFactory())->create();
        $this->connection = $connection;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param string $class
     *
     * @return QueryCompilerInterface
     */
    private function createQueryBuilder($class)
    {
        return new $class(new QueryBuilderFacade(
            $this->getContainer()->get('phuria.under_query.table_factory'),
            $this->getContainer()->get('phuria.under_query.query_compiler'),
            $this->connection
        ));
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