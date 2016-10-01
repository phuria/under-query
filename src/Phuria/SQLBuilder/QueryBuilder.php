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
class QueryBuilder
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
            new $parameterClass
        );
    }

    /**
     * @return SelectBuilder
     */
    public function select()
    {
        return $this->createQueryBuilder(SelectBuilder::class);
    }

    /**
     * @return UpdateBuilder
     */
    public function update()
    {
        return $this->createQueryBuilder(UpdateBuilder::class);
    }

    /**
     * @return DeleteBuilder
     */
    public function delete()
    {
        return $this->createQueryBuilder(DeleteBuilder::class);
    }

    /**
     * @return InsertBuilder
     */
    public function insert()
    {
        return $this->createQueryBuilder(InsertBuilder::class);
    }

    /**
     * @return InsertSelectBuilder
     */
    public function insertSelect()
    {
        return $this->createQueryBuilder(InsertSelectBuilder::class);
    }
}