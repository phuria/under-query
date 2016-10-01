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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InternalContainer implements ContainerInterface
{
    /**
     * @var array
     */
    private $services = [];

    /**
     * @var array
     */
    private $parameters = [];

    public function __construct()
    {
        $this->parameters['phuria.sql_builder.parameter_manager.class'] = ParameterManager::class;

        $tableRegistry = new TableRegistry();
        $this->services['phuria.sql_builder.table_registry'] = $tableRegistry;

        $tableFactory = new TableFactory($tableRegistry);
        $this->services['phuria.sql_builder.table_factory'] = $tableFactory;

        $queryCompiler = new QueryCompiler();
        $queryCompiler->addConcreteCompiler(new SelectCompiler());
        $queryCompiler->addConcreteCompiler(new InsertCompiler());
        $queryCompiler->addConcreteCompiler(new DeleteCompiler());
        $queryCompiler->addConcreteCompiler(new UpdateCompiler());
        $this->services['phuria.sql_builder.query_compiler'] = $queryCompiler;
    }

    /**
     * @inheritdoc
     */
    public function set($id, $service)
    {
        $this->services[$id] = $service;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE)
    {
        if ($this->has($id)) {
            return $this->services[$id];
        }

        if (self::EXCEPTION_ON_INVALID_REFERENCE === $invalidBehavior) {
            throw new ServiceNotFoundException($id);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function has($id)
    {
        return array_key_exists($id, $this->services);
    }

    /**
     * @inheritdoc
     */
    public function initialized($id)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getParameter($name)
    {
        return $this->parameters[$name];
    }

    /**
     * @inheritdoc
     */
    public function hasParameter($name)
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * @inheritdoc
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }
}