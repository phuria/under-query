<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\DependencyInjection;

use Phuria\SQLBuilder\Parameter\ParameterManager;
use Phuria\SQLBuilder\QueryCompiler\ConcreteCompiler\DeleteCompiler;
use Phuria\SQLBuilder\QueryCompiler\ConcreteCompiler\InsertCompiler;
use Phuria\SQLBuilder\QueryCompiler\ConcreteCompiler\SelectCompiler;
use Phuria\SQLBuilder\QueryCompiler\ConcreteCompiler\UpdateCompiler;
use Phuria\SQLBuilder\QueryCompiler\QueryCompiler;
use Phuria\SQLBuilder\TableFactory\TableFactory;
use Phuria\SQLBuilder\TableRegistry;
use Pimple\Container;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ContainerFactory
{
    /**
     * @return Container
     */
    public function create()
    {
        $container = new Container();

        $container['phuria.sql_builder.parameter_manager.class'] = ParameterManager::class;

        $container['phuria.sql_builder.table_registry'] = function () {
            return new TableRegistry();
        };

        $container['phuria.sql_builder.table_factory'] = function (Container $c) {
            return new TableFactory($c['phuria.sql_builder.table_registry']);
        };

        $container['phuria.sql_builder.query_compiler'] = function () {
            $queryCompiler = new QueryCompiler();
            $queryCompiler->addConcreteCompiler(new SelectCompiler());
            $queryCompiler->addConcreteCompiler(new InsertCompiler());
            $queryCompiler->addConcreteCompiler(new DeleteCompiler());
            $queryCompiler->addConcreteCompiler(new UpdateCompiler());

            return $queryCompiler;
        };

        return $container;
    }
}