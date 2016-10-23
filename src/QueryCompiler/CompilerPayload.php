<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class CompilerPayload
{
    /**
     * @var string
     */
    private $actualSQL;

    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @param BuilderInterface $builder
     * @param string|null      $actualSQL
     */
    public function __construct(BuilderInterface $builder, $actualSQL = null)
    {
        $this->actualSQL = $actualSQL;
        $this->builder = $builder;
    }

    /**
     * @return string
     */
    public function getActualSQL()
    {
        return $this->actualSQL;
    }

    /**
     * @return BuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param string $newSQL
     *
     * @return CompilerPayload
     */
    public function updateSQL($newSQL)
    {
        return new CompilerPayload($this->builder, $newSQL);
    }

    /**
     * @param string $newSQL
     *
     * @return CompilerPayload
     */
    public function appendSQL($newSQL)
    {
        if ($newSQL) {
            return $this->updateSQL($this->actualSQL . ' ' . $newSQL);
        }

        return $this;
    }
}