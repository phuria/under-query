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

use Phuria\SQLBuilder\Connection\ConnectionInterface;
use Phuria\SQLBuilder\Parameter\ParameterManager;
use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;
use Phuria\SQLBuilder\Query;
use Phuria\SQLBuilder\QueryCompiler\QueryCompiler;
use Phuria\SQLBuilder\QueryCompiler\QueryCompilerInterface;
use Phuria\SQLBuilder\ReferenceManager;
use Phuria\SQLBuilder\TableFactory\TableFactory;
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
     * @var ReferenceManager
     */
    private $referenceManager;

    public function __construct()
    {
        $this->tableFactory = new TableFactory();
        $this->queryCompiler = new QueryCompiler();
        $this->parameterManager = new ParameterManager();
        $this->referenceManager = new ReferenceManager();
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
     * @return ReferenceManager
     */
    public function getReferenceManager()
    {
        return $this->referenceManager;
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
        return $this->getReferenceManager()->register($object);
    }

    /**
     * @param ConnectionInterface $connection
     *
     * @return Query
     */
    public function buildQuery(ConnectionInterface $connection = null)
    {
        return new Query(
            $this->buildSQL(),
            $this->getParameterManager(),
            $connection
        );
    }
}