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

use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;
use Phuria\SQLBuilder\Query\Query;
use Phuria\SQLBuilder\Query\QueryFactoryInterface;
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
     * @var QueryFactoryInterface
     */
    private $queryFactory;

    /**
     * @param TableFactoryInterface     $tableFactory
     * @param QueryCompilerInterface    $queryCompiler
     * @param ParameterManagerInterface $parameterManager
     * @param QueryFactoryInterface     $queryFactory
     */
    public function __construct(
        TableFactoryInterface $tableFactory,
        QueryCompilerInterface $queryCompiler,
        ParameterManagerInterface $parameterManager,
        QueryFactoryInterface $queryFactory
    ) {
        $this->tableFactory = $tableFactory;
        $this->queryCompiler = $queryCompiler;
        $this->parameterManager = $parameterManager;
        $this->queryFactory = $queryFactory;
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
     * @inheritdoc
     */
    public function setParameter($name, $value)
    {
        $parameter = $this->getParameterManager()->getParameter($name);
        $parameter->setValue($value);

        return $this;
    }

    /**
     * @param mixed $connectionHint
     *
     * @return Query
     */
    public function buildQuery($connectionHint = null)
    {
        return $this->queryFactory->buildQuery($this->buildSQL(), $this->getParameterManager(), $connectionHint);
    }
}