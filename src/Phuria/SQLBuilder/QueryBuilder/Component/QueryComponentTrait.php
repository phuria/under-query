<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder\Component;

use Phuria\SQLBuilder\Connection\ConnectionInterface;
use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;
use Phuria\SQLBuilder\Query;
use Phuria\SQLBuilder\QueryBuilder\AbstractBuilder;
use Phuria\SQLBuilder\QueryCompiler\QueryCompilerInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait QueryComponentTrait
{
    /**
     * @return AbstractBuilder
     */
    abstract public function getQueryBuilder();

    /**
     * @return QueryCompilerInterface
     */
    abstract public function getQueryCompiler();

    /**
     * @return ParameterManagerInterface
     */
    abstract public function getParameterManager();

    /**
     * @return string
     */
    public function buildSQL()
    {
        return $this->getQueryCompiler()->compile($this->getQueryBuilder());
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