<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder;

use Phuria\SQLBuilder\Connection\ConnectionManagerInterface;
use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;
use Phuria\SQLBuilder\Query;
use Phuria\SQLBuilder\QueryCompiler\QueryCompilerInterface;
use Phuria\SQLBuilder\TableFactory\TableFactoryInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractBuilder implements BuilderInterface
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
     * @var ParameterManagerInterface
     */
    private $parameterManager;

    /**
     * @var ConnectionManagerInterface
     */
    private $connectionManager;

    /**
     * @param TableFactoryInterface     $tableFactory
     * @param QueryCompilerInterface    $queryCompiler
     * @param ParameterManagerInterface $parameterManager
     */
    public function __construct(
        TableFactoryInterface $tableFactory,
        QueryCompilerInterface $queryCompiler,
        ParameterManagerInterface $parameterManager,
        ConnectionManagerInterface $connectionManager
    ) {
        $this->tableFactory = $tableFactory;
        $this->queryCompiler = $queryCompiler;
        $this->parameterManager = $parameterManager;
        $this->connectionManager = $connectionManager;
    }

    /**
     * @return BuilderInterface
     */
    public function getQueryBuilder()
    {
        return $this;
    }

    /**
     * @return TableFactoryInterface
     */
    public function getTableFactory()
    {
        return $this->tableFactory;
    }

    /**
     * @return QueryCompilerInterface
     */
    public function getQueryCompiler()
    {
        return $this->queryCompiler;
    }

    /**
     * @return ParameterManagerInterface
     */
    public function getParameterManager()
    {
        return $this->parameterManager;
    }

    /**
     * @inheritdoc
     */
    public function buildSQL()
    {
        return $this->getQueryCompiler()->compile($this->getQueryBuilder());
    }

    /**
     * @inheritdoc
     */
    public function objectToString($object)
    {
        return $this->getParameterManager()->createReference($object);
    }

    /**
     * @param string|null $connectionName
     *
     * @return Query
     */
    public function buildQuery($connectionName = null)
    {
        return new Query(
            $this->buildSQL(),
            $this->getParameterManager(),
            $this->connectionManager->getConnection($connectionName)
        );
    }
}