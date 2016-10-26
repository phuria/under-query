<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler\ConcreteCompiler;

use League\Pipeline\Pipeline;
use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\QueryCompiler\CompilerPayload;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractConcreteCompiler implements ConcreteCompilerInterface
{
    /**
     * @var Pipeline
     */
    private $pipeline;

    /**
     * @param array $stages
     */
    public function __construct(array $stages)
    {
        $this->pipeline = new Pipeline($stages);
    }

    /**
     * @return Pipeline
     */
    public function getPipeline()
    {
        return $this->pipeline;
    }

    /**
     * @inheritdoc
     */
    public function compile(BuilderInterface $builder)
    {
        $payload = new CompilerPayload($builder);

        return $this->process($payload)->getActualSQL();
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    private function process(CompilerPayload $payload)
    {
        return $this->getPipeline()->process($payload);
    }
}