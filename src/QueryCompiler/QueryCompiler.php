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
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\ConcreteCompilerInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryCompiler implements QueryCompilerInterface
{
    /**
     * @var TableCompiler
     */
    private $tableCompiler;

    /**
     * @var ReferenceCompiler
     */
    private $referenceCompiler;

    /**
     * @var ConcreteCompilerInterface[]
     */
    private $concreteCompilers = [];

    public function __construct()
    {
        $this->tableCompiler = new TableCompiler();
        $this->referenceCompiler = new ReferenceCompiler();
    }

    /**
     * @param ConcreteCompilerInterface $compiler
     */
    public function addConcreteCompiler(ConcreteCompilerInterface $compiler)
    {
        $this->concreteCompilers[] = $compiler;
    }

    /**
     * @inheritdoc
     */
    public function compile(BuilderInterface $builder)
    {
        foreach ($this->concreteCompilers as $compiler) {
            if ($compiler->supportsBuilder($builder)) {
                return $compiler->compile($builder);
            }
        }

        throw new \Exception();
    }
}