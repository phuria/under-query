<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\AliasManager;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AliasManager
{
    /**
     * @var int $tableCounter
     */
    private $tableCounter = 0;

    /**
     * @var int $columnCounter
     */
    private $columnCounter = 0;

    /**
     * @var int $parameterCounter
     */
    private $parameterCounter = 0;

    /**
     * @return string
     */
    public function generateNextTableAlias()
    {
        return sprintf('_t%d', $this->columnCounter++);
    }

    /**
     * @return string
     */
    public function generateNextColumnAlias()
    {
        return sprintf('_v%d', $this->tableCounter++);
    }

    /**
     * @return string
     */
    public function generateNextParameterAlias()
    {
        return sprintf('?%d', $this->parameterCounter++);
    }
}