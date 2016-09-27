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
class QB
{
    /**
     * @var ContainerInterface $container
     */
    private static $container;

    /**
     * @return ContainerInterface
     */
    public static function getContainer()
    {
        if (null === static::$container) {
            static::$container = new InternalContainer();
        }

        return static::$container;
    }

    /**
     * @return SelectBuilder
     */
    public static function select()
    {
        return new SelectBuilder(static::getContainer());
    }

    /**
     * @return UpdateBuilder
     */
    public static function update()
    {
        return new UpdateBuilder(static::getContainer());
    }

    /**
     * @return DeleteBuilder
     */
    public static function delete()
    {
        return new DeleteBuilder(static::getContainer());
    }

    /**
     * @return InsertBuilder
     */
    public static function insert()
    {
        return new InsertBuilder(static::getContainer());
    }

    /**
     * @return InsertSelectBuilder
     */
    public static function insertSelect()
    {
        return new InsertSelectBuilder(static::getContainer());
    }
}