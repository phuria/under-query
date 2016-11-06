<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\DependencyInjection;

use Interop\Container\ContainerInterface;
use Phuria\UnderQuery\Connection\ConnectionManager;
use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Query\QueryFactory;
use Phuria\UnderQuery\QueryBuilder\QueryBuilderFacade;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\DeleteCompiler;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\InsertCompiler;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\SelectCompiler;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\UpdateCompiler;
use Phuria\UnderQuery\QueryCompiler\QueryCompiler;
use Phuria\UnderQuery\Reference\ReferenceCollection;
use Phuria\UnderQuery\TableFactory\TableFactory;
use Phuria\UnderQuery\TableRegistry;
use Pimple\Container;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ContainerFactory
{
    /**
     * @return ContainerInterface
     */
    public function create()
    {
        $pimple = new Container();
        $container = new PimpleContainer($pimple);

        $container->setParameter('phuria.under_query.parameter_collection.class', ParameterCollection::class);
        $container->setParameter('phuria.under_query.reference_collection.class', ReferenceCollection::class);

        $container->setServiceFromCallback('phuria.under_query.table_registry', [$this, 'createTableRegistry']);
        $container->setServiceFromCallback('phuria.under_query.table_factory', [$this, 'createTableFactory']);
        $container->setServiceFromCallback('phuria.under_query.query_compiler', [$this, 'createTableCompiler']);

        return $container;
    }

    /**
     * @internal
     * @return TableRegistry
     */
    public function createTableRegistry()
    {
        return new TableRegistry();
    }

    /**
     * @internal
     * @param Container $container
     *
     * @return TableFactory
     */
    public function createTableFactory(Container $container)
    {
        return new TableFactory($container['phuria.under_query.table_registry']);
    }

    /**
     * @internal
     * @return QueryCompiler
     */
    public function createTableCompiler()
    {
        $queryCompiler = new QueryCompiler();
        $queryCompiler->addConcreteCompiler(new SelectCompiler());
        $queryCompiler->addConcreteCompiler(new InsertCompiler());
        $queryCompiler->addConcreteCompiler(new DeleteCompiler());
        $queryCompiler->addConcreteCompiler(new UpdateCompiler());

        return $queryCompiler;
    }
}