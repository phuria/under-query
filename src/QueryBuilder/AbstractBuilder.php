<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder;

use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Parameter\ParameterCollectionInterface;
use Phuria\UnderQuery\Query\Query;
use Phuria\UnderQuery\Query\QueryFactoryInterface;
use Phuria\UnderQuery\QueryCompiler\QueryCompilerInterface;
use Phuria\UnderQuery\Reference\ReferenceCollection;
use Phuria\UnderQuery\Reference\ReferenceCollectionInterface;
use Phuria\UnderQuery\TableFactory\TableFactoryInterface;

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
     * @var ParameterCollectionInterface
     */
    private $parameterCollection;

    /**
     * @var ReferenceCollectionInterface
     */
    private $referenceCollection;

    /**
     * @param TableFactoryInterface     $tableFactory
     * @param QueryCompilerInterface    $queryCompiler
     */
    public function __construct(TableFactoryInterface $tableFactory, QueryCompilerInterface $queryCompiler)
    {
        $this->tableFactory = $tableFactory;
        $this->queryCompiler = $queryCompiler;
        $this->parameterCollection = new ParameterCollection();
        $this->referenceCollection = new ReferenceCollection();
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
     * @return ParameterCollectionInterface
     */
    public function getParameters()
    {
        return $this->parameterCollection;
    }

    /**
     * @return ReferenceCollectionInterface
     */
    public function getReferences()
    {
        return $this->referenceCollection;
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
        return $this->getReferences()->createReference($object);
    }

    /**
     * @inheritdoc
     */
    public function setParameter($name, $value)
    {
        $parameter = $this->getParameters()->getParameter($name);
        $parameter->setValue($value);

        return $this;
    }

    /**
     * @return Query
     */
    public function buildQuery()
    {
        return new Query($this->buildSQL(), $this->parameterCollection->toArray());
    }
}