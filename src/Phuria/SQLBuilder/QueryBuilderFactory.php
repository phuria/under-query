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

use Interop\Container\ContainerInterface;
use Phuria\SQLBuilder\DependencyInjection\InternalContainer;
use Phuria\SQLBuilder\QueryBuilder\DeleteBuilder;
use Phuria\SQLBuilder\QueryBuilder\InsertBuilder;
use Phuria\SQLBuilder\QueryBuilder\InsertSelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\UpdateBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryBuilderFactory
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container ?: new InternalContainer();
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return SelectBuilder
     */
    public function select()
    {
        return new SelectBuilder($this->container);
    }

    /**
     * @return UpdateBuilder
     */
    public function update()
    {
        return new UpdateBuilder($this->container);
    }

    /**
     * @return DeleteBuilder
     */
    public function delete()
    {
        return new DeleteBuilder($this->container);
    }

    /**
     * @return InsertBuilder
     */
    public function insert()
    {
        return new InsertBuilder($this->container);
    }

    /**
     * @return InsertSelectBuilder
     */
    public function insertSelect()
    {
        return new InsertSelectBuilder($this->container);
    }
}